<?php
use yii\data\SqlDataProvider;
use kartik\grid\GridView;
use app\models\TrSupplierpayablehead;
use yii\helpers\Json;

$supplierID = $model['supplierID'];

$type = $model['isForwarder'] == 1 ? 'FP' : 'SP';

$sql = "SELECT *
FROM (
SELECT refNum AS transactionRefNum, head.payableDate AS transactionDate, detail.currency,
ref.num AS originalRefNum, ref.supplierID, ref.hasVat, 
CAST(IF(ref.hasVat=1, detail.amount/110*100, detail.amount) AS DECIMAL(18,2)) AS subTotal,
CAST(IF(ref.hasVat=1, detail.amount/110*10, 0) AS DECIMAL(18,2)) AS tax,
@grandTotal := detail.amount AS grandTotal,
@advancedPaymentAmount := (
    SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
    FROM tr_supplieradvancebalancedetail AS advPaymentDetail
    LEFT JOIN tr_supplieradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
    WHERE advPaymentDetail.refNum = detail.refNum AND SUBSTR(advPaymentDetail.refNum, 5, 2) = '$type'
) AS advancedPaymentAmount,
@previousPayment := (
    SELECT CAST(IFNULL(SUM(paymentDetail.paymentAmount), 0) AS DECIMAL(18, 2))
    FROM tr_supplierpaymenthead AS paymentHead
    LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
    WHERE paymentDetail.refNum = detail.refNum AND SUBSTR(paymentHead.supplierPaymentNum, 5, 2) = '$type'
) AS previousPayment,
CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
FROM tr_supplierpayabledetail AS detail
LEFT JOIN tr_supplierpayablehead AS head ON detail.payableNum = head.payableNum
INNER JOIN (
    SELECT d.payableDetailID,
    CASE 
        WHEN poHead.supplierID IS NOT NULL THEN poHead.supplierID
        WHEN poni.supplierID IS NOT NULL THEN poni.supplierID
        ELSE '-'
    END AS supplierID,
    CASE 
        WHEN poHead.purchaseOrderNum IS NOT NULL THEN poHead.purchaseOrderNum
        WHEN poni.purchaseOrderNonInventoryNum IS NOT NULL THEN poni.purchaseOrderNonInventoryNum
        ELSE '-'
        END AS num,
    CASE
        WHEN poHead.hasVat IS NOT NULL THEN poHead.hasVat
        WHEN poni.hasVat IS NOT NULL THEN poni.hasVat
        ELSE 0
    END AS hasVat,
    CASE 
        WHEN poHead.grandTotal IS NOT NULL THEN poHead.grandTotal
        WHEN poni.grandTotal IS NOT NULL THEN poni.grandTotal
        ELSE 0
    END AS grandTotal
    FROM tr_supplierpayabledetail AS d
    LEFT JOIN tr_goodsreceipthead AS receiptHead ON receiptHead.goodsReceiptNum = d.refNum
    LEFT JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = receiptHead.refNum
    LEFT JOIN tr_purchaseordernoninventoryhead AS poni ON poni.purchaseOrderNonInventoryNum = d.refNum
) AS ref ON ref.payableDetailID = detail.payableDetailID
) x
WHERE  x.outstandingAmount > 0 AND supplierID = $supplierID";
 
$dataProvider = new SqlDataProvider([
    'sql' => $sql,
    'key' => 'supplierID',
    'pagination' => false,
]);
TrSupplierpayablehead::$payableTotal = 0;

?>

<?=
    GridView::widget([
        'id' => 'detailGrid'.$supplierID,
        'dataProvider' => $dataProvider,
        'panel' => [
            'heading' => 'Payable Detail',
            'headingOptions' => ['class' => 'panel-heading qwinjaya-header'],
            'footerOptions' => [
                'class' => 'panel-footer',
                'style' => 'display: none;'
            ],
        ],
        'options' => [
            'class' => 'detailgrid'
        ],
        'toolbar' => false,
        'pjax' => true,
        'striped' => false,
        'hover' => true,
        'showPageSummary' => true,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                //'width' => '36px',
                'header' => '',
                'headerOptions' => ['class' => 'kartik-sheet-style']
            ],
            [
                'label' => 'Reference Number',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    return $model['transactionRefNum'];
                }
            ],
            [
                'label' => 'Transaction Date',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    return date('d-m-Y H:i:s', strtotime($model['transactionDate']));
                },
            ],
            [
                'label' => 'Origin Reference Number',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    return $model['originalRefNum'];
                }
            ],
            [
                'label' => 'Grand Total',
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    return $model['currency'].' '.number_format($model['grandTotal'], 2, ',', '.');
                },
            ],
                        [
                'label' => 'Paid',
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    return $model['currency'].' '
                        .number_format(floatVal($model['advancedPaymentAmount'])
                            + floatVal($model['previousPayment']), 2, ',', '.');
                },
                'pageSummary' => 'Total',
                'pageSummaryOptions' => ['class' => 'text-right kv-page-summary h5 warning']
            ],
            [
                'attribute' => 'outstandingAmount',
                'width' => '200px',
                'hAlign' => 'right',
                //'format' => ['decimal', 2],
                'pageSummary' => function ($model, $key, $index) {
                    return number_format(TrSupplierpayablehead::$payableTotal / 2, 2, ',', '.');
                },
                'pageSummaryOptions' => ['class' => 'text-right kv-page-summary h5 warning'],
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'headerOptions' => [
                    'class' => 'text-right'
                ],
                'value' => function ($model, $key, $index, $column) {
                    TrSupplierpayablehead::$payableTotal += $model['outstandingAmount'];
                    return $model['currency'].' '.number_format($model['outstandingAmount'], 2, ',', '.');
                },
            ]
        ],
    ]);
?>