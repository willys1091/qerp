<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-purchaseorderhead-index">
  
    <?= GridView::widget([
        'dataProvider' => $model->search(),
        'filterModel' => $model,
        'panel'=>[
            'heading'=>$this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'summary'=>'',
        'toolbar' => [
            '{export}',
            '{toggleData}',
            [
                'content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [
                        'class' => 'btn toolbar-icon',
                        'title' => Yii::t('app', 'Create')
                    ]).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
                'exportConfig' => [
                    GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'Purchase Order-'.date('d-M-Y')],
                    GridView::HTML => ['label' => 'Export as HTML', 'filename' => 'Purchase Order -'.date('d-M-Y')],
                    GridView::PDF => ['label' => 'Export as PDF',
                                      'filename' => 'Purchase Order-'.date('d-M-Y'),
                                      'config' => [
                                            'methods' => [
                                                'SetHeader' => ['Purchase Order'],
                                                'SetFooter' => ['PT.Qwinjaya Aditama ' . '||Page {PAGENO}'],
                                            ]
                                        ],
                                     ],
                    GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'Purchase Order-'.date('d-M-Y')],
                    GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'Purchase Order-'.date('d-M-Y')],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'purchaseOrderDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => AppHelper::getDatePickersRangeConfig(),
                'hAlign' => 'center',
                'filterInputOptions' => [
                    'class' => 'text-center form-control'
                ],
                'width' => '18%'
            ],
            [
                'attribute' => 'purchaseOrderNum',
                'width' => '120px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'productID',
                'value' => function ($data) {
                    return implode(', ', array_map(function($x){
                        $product = $x->product;
                        return "$product->productName $x->qty ({$product->uom->uomName}) ({$product->origin}) ";
                    }, $data->purchaseOrderDetails));
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'supplierID',
                'value' => function ($data) {
                    return $data->supplier->supplierName;
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'currencyID',
                 'width' => '7%',
                'value' => function ($data) {
                    return $data->currencyID;
                   
                },
               'hAlign' => 'left',
            ],
            [
                'attribute' => 'grandTotal',
                'value' => function ($model) {
                    return number_format($model->grandTotal,2,",",".");
                },
                'hAlign' => 'right',
                'headerOptions' => [
                    'class' => 'text-right'
                ],
                'filterInputOptions' => [
                    'class' => 'text-right form-control'
                ]
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}'.' '.'{print}'.' '.'{update}'.' '.'{delete}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'width' => '120px',
                'header' => '',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-eye-open action-icon'></span>&nbsp;&nbsp;",
                            ['view', 'id' => $model->primaryKey],
                            [
                                            'title' => 'View',
                                            'class' => 'open-modal-btn'
                            ]);
                     },
                     'print' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-print action-icon'></span>&nbsp;&nbsp;",
                        ['print', 'id' => $model->primaryKey],
                        [
                            'title' => 'Print',
                            'class' => 'btnPrint'
                        ]);
                     },
                    
                    'delete' => function ($url, $model) {
                        $url = ['delete', 'id' => $model->primaryKey];
                        $icon = 'trash';
                        $label = 'Delete';
                        $confirm = 'Are you sure you want to delete this data ?';

                        return $model->orderStatus == '0'? Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                            'title' => $label,
                            'aria-label' => $label,
                            'data-confirm' => $confirm,
                            'data-method' => 'post',
                            'data-pajax' => '0'
                        ]) : '';
                            
                        
                    },
                    'update' => function ($url, $model) {
                       
                        return $model->orderStatus == '0'? Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model->primaryKey],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]) : '';
                        
                       
                    }
                ]
            ],
        ],
    ]); ?>
</div>
<?php
$js = <<< SCRIPT
$(document).ready(function(){
    $('.btnPrint').click(function(e){
    e.preventDefault();
    var newWindow = window.open($(this).attr('href'),'report_view_purchase_order','height=600,width=1024');
    if (window.focus) {
        newWindow.focus();
    }
    });
    
    appear({
        init: function init(){
            console.log('dom is ready');
        },
        elements: function elements(){
            return $('table fthfoot');
        },
        appear: function appear(el){
            //console.log('visible', el);
            $('.ias-trigger a').click();
            $('.ias-trigger a').click();
            setTimeout(function() {
                $('.ias-trigger a').click();
                $('.ias-trigger a').click();
            }, 200);
            setTimeout(function() {
                $('.ias-trigger a').click();
                $('.ias-trigger a').click();
            }, 500);
            setTimeout(function() {
                $('.ias-trigger a').click();
                $('.ias-trigger a').click();
            }, 800);
            
        },
        disappear: function disappear(el){
            //console.log('no longer visible', el);
        },
        bounds: 200,
        reappear: true
    });
});
$(document).on('pjax:end',function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_view_purchase_order','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
     });
});
SCRIPT;
$this->registerJs($js);

?>
