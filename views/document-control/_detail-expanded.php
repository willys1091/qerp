<?php
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use app\models\TrJournalHead;
use app\models\TrJournalDetail;
use yii\helpers\Json;

$refID = $model['refID'];

$sql = "SELECT 
            a.refNum,
            b.productID,
            c.productName,
            d.supplierID,
            e.supplierName,
            e.country
        FROM 
            tr_documentcontrolhead as a
        INNER JOIN tr_purchaseorderdetail as b
        ON b.purchaseOrderNum = a.refNum
        INNER JOIN ms_product as c
        ON c.productID = b.productID
        INNER JOIN ms_productsupplier as d
        ON d.productID = b.productID
        INNER JOIN ms_supplier as e
        ON e.supplierID = d.supplierID
        WHERE
            a.refNum = '$refID'";

$dataProvider = new SqlDataProvider([
    'sql' => $sql,
    'key' => 'refNum',
]);
?>

<?=
    GridView::widget([
        'id' => 'detailGrid'.$refNum,
        'dataProvider' => $dataProvider,
        'panel' => [
            'heading' => 'Document Controller Detail',
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
        'showPageSummary' => false,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                //'width' => '36px',
                'header' => '',
                'headerOptions' => ['class' => 'kartik-sheet-style']
            ],
            [
                'label' => 'Product',
                'hAlign' => 'left',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    return $model['productName'];
                },
            ],
            [
                'label' => 'Origin',
                'hAlign' => 'left',
                'vAlign' => 'middle',
                'value' => function ($model, $key, $index, $column) {
                    return $model['country'];
                },
            ],
        ],
    ]);
    ?>