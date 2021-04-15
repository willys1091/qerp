<?php
use yii\data\SqlDataProvider;
use kartik\grid\GridView;
use app\models\TrCustomerreceivablehead;
use yii\helpers\Json;

$customerID = $model['customerID'];

$sql = "SELECT x.*
        FROM (
	SELECT detail.receivableNum, refNum AS transactionRefNum, head.receivableDate AS transactionDate, detail.currency,
	ref.num AS originRefNum, ref.customerID, ref.hasVat,ref.dueDate,
        CAST(IF(ref.hasVat=1, detail.amount/110*100, detail.amount) AS DECIMAL(18,2)) AS subTotal,
	CAST(IF(ref.hasVat=1, detail.amount/110*10, 0) AS DECIMAL(18,2)) AS tax,
        @grandTotal := FLOOR(detail.amount) AS grandTotal,
        @advancedPaymentAmount := (
            SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
            FROM tr_customeradvancebalancedetail AS advPaymentDetail
            LEFT JOIN tr_customeradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
            WHERE advPaymentDetail.refNum = detail.refNum
	) AS advancedPaymentAmount,
	@previousPayment := (
		SELECT CAST(IFNULL(SUM(payment.paymentAmount), 0) AS DECIMAL(18, 2))
		FROM tr_customerpayment AS payment
		WHERE payment.refNum = detail.refNum
	) AS previousPayment,
        CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
	FROM tr_customerreceivabledetail AS detail
	LEFT JOIN tr_customerreceivablehead AS head ON detail.receivableNum = head.receivableNum
	INNER JOIN (
		SELECT d.receivableNum,
        sohead.customerID,
        sohead.salesorderNum AS num,
        DATE_ADD(deliveryHead.goodsDeliveryDate, INTERVAL cs.dueDate DAY) AS dueDate,
        IF(sohead.taxRate > 0, 1, 0) AS hasVat,
        sohead.grandTotal
		FROM tr_customerreceivabledetail AS d
		LEFT JOIN tr_goodsdeliveryhead AS deliveryHead ON deliveryHead.goodsDeliveryNum = d.refNum
		LEFT JOIN tr_salesorderhead AS sohead ON sohead.salesOrderNum = deliveryHead.refNum
        LEFT JOIN ms_customer AS cs ON cs.customerID = sohead.customerID
	) AS ref ON ref.receivableNum = detail.receivableNum
        WHERE NOW() > ref.dueDate
        ) AS x
        LEFT JOIN ms_customer AS customer ON customer.customerID = x.customerID
        LEFT JOIN (
	SELECT cust.customerID,
            IFNULL(office.contactPerson, custDetail.contactPerson) AS contactPerson, 
            IFNULL(office.street, custDetail.street) AS street,
            IFNULL(office.phone, custDetail.phone) AS phone
            FROM ms_customer AS cust
            LEFT JOIN ms_customerdetail AS office ON office.customerID = cust.customerID AND office.addressType = 'office'
            LEFT JOIN ms_customerdetail AS custDetail ON custDetail.customerID = cust.customerID
            LIMIT 1
        ) AS pic ON pic.customerID = customer.customerID
        WHERE x.outstandingAmount > 0 AND x.customerID = $customerID "
        . " ORDER BY x.transactionDate";

$dataProvider = new SqlDataProvider([
    'sql' => $sql,
    'key' => 'customerID',
]);
TrCustomerreceivablehead::$receivableTotal = 0;
?>

<?=
    GridView::widget([
        'id' => 'detailGrid'.$customerID,
        'dataProvider' => $dataProvider,
        'panel' => [
            'heading' => 'Receivable Detail',
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
                    return number_format(TrCustomerreceivablehead::$receivableTotal / 2, 2, ',', '.');
                },
                'pageSummaryOptions' => ['class' => 'text-right kv-page-summary h5 warning'],
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'headerOptions' => [
                    'class' => 'text-right'
                ],
                'value' => function ($model, $key, $index, $column) {
                    TrCustomerreceivablehead::$receivableTotal += $model['outstandingAmount'];
                    return $model['currency'].' '.number_format($model['outstandingAmount'], 2, ',', '.');
                },
            ]
        ],
    ]);
?>
