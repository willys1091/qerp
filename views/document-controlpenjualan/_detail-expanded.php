<?php
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use app\models\TrJournalHead;
use app\models\TrJournalDetail;
use yii\helpers\Json;

$refID = $model['refID'];

$sql = "SELECT 
            a.productID,
            b.productName,
            c.supplierID,
            d.supplierName,
            d.country
        FROM 
            tr_salesorderdetail as a
        INNER JOIN ms_product as b
        ON b.productID = a.productID
        INNER JOIN ms_productsupplier as c
        ON c.productID = a.productID
        INNER JOIN ms_supplier as d
        ON d.supplierID = c.supplierID
        WHERE
            a.salesOrderNum = '$refID'";

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