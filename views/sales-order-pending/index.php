<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Pending Sales Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-salesorderhead-index">

    <?= GridView::widget([
        'dataProvider' => $model->searchs(),
        'filterModel' => $model,
        'panel'=>[
            'heading'=>$this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'summary' => '',
         'toolbar' => [
            '{export}',
            '{toggleData}',
            [
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
                'exportConfig' => [
                    GridView::PDF => ['label' => 'Export as PDF',
                                      'filename' => 'PendingGoodsReceipt-'.date('d-M-Y'),
                                      'config' => [
                                            'methods' => [
                                                'SetHeader' => ['Pending Sales Order'],
                                                'SetFooter' => ['PT.Qwinjaya Aditama ' . '||Page {PAGENO}'],
                                            ]
                                        ],
                                     ],
                    GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'PendingSalesOrder-'.date('d-M-Y')],
        ],
        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'salesOrderDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => AppHelper::getDatePickersRangeConfig(),
                'hAlign' => 'center',
                'filterInputOptions' => [
                    'class' => 'text-center form-control'
                ],
                'width' => '13%'
            ],
            [
                'attribute' => 'salesOrderNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'customerName',
                'value' => 'customer.customerName',
                'width' => '10%',
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],
            [
                'attribute' => 'productName',
                'width' => '10%',
                'value' => function ($data) {
                    return implode(', ', array_map(function($x){
                        $product = $x->product;
                        return "$product->productName  ({$product->origin}) ";
                    }, $data->salesOrderDetails));
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'qtySO',
                'width' => '5%',
                'format' => 'raw',
                'value' => function ($data) {
                    return implode(', ', array_map(function($x){
                        $product = $x->product;
                        $result = "$x->qty ({$product->uom->uomName}),";
                        $result = str_replace(",","<br>","$result");
                        return $result;
                    }, $data->salesOrderDetails));
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'dueDate',
                'format' => ['date', 'php:d-m-Y'],
                'hAlign' => 'center',
                'filterInputOptions' => [
                    'class' => 'text-center form-control'
                ],
                'width' => '13%'
            ],
            [
                'attribute' => 'qtyAvailable',
                'width' => '5%',
                'value' => function ($model) {
                    return $model->qtyAvailable ;
                },    
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],
            [
                'attribute' => 'deliveryDestination',
                'width' => '5%',
                'value' => function ($model) {
                    return $model->deliveryDestination ? $model->deliveryDestination : '';
                },    
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],
            [
                'attribute' => 'shipmentDate',
                'width' => '5%',
                'value' => function ($model) {
                    return  $model->shipmentDate ?  date('d-m-Y',strtotime($model->shipmentDate)) : '';
                },   
                'filterInputOptions' => [
                    'class' => 'form-control text-center',
                   
                ],
            ],
            [
                'attribute' => 'purchaseOrderNum',
                'width' => '5%',
                'value' => function ($model) {
                    return $model->purchaseOrderNum ? $model->purchaseOrderNum : '';
                },    
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],
            [
                'attribute' => 'customerOrderNum',
                'width' => '5%',
                'value' => function ($model) {
                    return $model->customerOrderNum ? $model->customerOrderNum : '';
                },    
                'headerOptions' => [
                    'class' => 'text-left'
                ],
                'label' => 'PO Customer'
            ],
            [
                'attribute' => 'notes',
                'width' => '10%',
                'value' => function ($model) {
                    
                    return  '';
                },  
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],  
           
            
        ],
    ]); ?>
</div>
<?php
$js = <<< SCRIPT
$(document).ready(function () {
    $("<tr style='visibility: collapse'><td colspan='12'; style='text-align: center; font-size: 16px;  font-weight: bold;'>Pending Sales Order</td></tr>").prependTo('#w0-container thead'); 
    $(document).on('pjax:success', function(e){
        $("<tr style='visibility: collapse'><td colspan='12'; style='text-align: center; font-size: 16px;  font-weight: bold;'>Pending Sales Order</td></tr>").prependTo('#w0-container thead'); 
    });
});
    
SCRIPT;
$this->registerJs($js);

?>
