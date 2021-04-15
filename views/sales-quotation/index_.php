<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Quotation';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-salesquotationhead-index">
    <?= GridView::widget([
        'dataProvider' => $model->search(),
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
                    GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'Sales Quotation-'.date('d-M-Y')],
                    GridView::HTML => ['label' => 'Export as HTML', 'filename' => 'Sales Quotation -'.date('d-M-Y')],
                    GridView::PDF => ['label' => 'Export as PDF',
                                      'filename' => 'Sales Quotation-'.date('d-M-Y'),
                                      'config' => [
                                            'methods' => [
                                                'SetHeader' => ['Sales Quotation'],
                                                'SetFooter' => ['PT.Qwinjaya Aditama ' . '||Page {PAGENO}'],
                                            ]
                                        ],
                                     ],
                    GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'Sales Quotation-'.date('d-M-Y')],
                    GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'Sales Quotation-'.date('d-M-Y')],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'salesQuotationDate',
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
                'attribute' =>'salesQuotationNum',
                'width'=>'50px',
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],
            [
                'attribute' => 'customerID',
                'width' => '15%',
                'value' => 'parentCustomer.customerName',
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],
			[
                'attribute' => 'productID',
                'format' => 'html',
                'value' => function ($data) {
                    return implode('<br>', array_map(function($x){
                        $product = $x->product;
                       
                        return "&#8226 "."$product->productName $x->qty ({$product->uom->uomName}) ({$product->origin})";
                    }, $data->salesQuotationDetails));
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'currencyID',
                'width' => '3%',
                'hAlign' => 'left',
            ],
			[
                'attribute' => 'unitPrice',
                'hAlign' => 'right',
                'width' => '100px',
                'format' => 'html',
                'value' => function ($data) {
                    return implode('<br>', array_map(function($x){
                        return number_format($x->priceOffer,2,",",".");
                    }, $data->salesQuotationDetails));
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'grandTotal',
                'width'=>'200px',
                'value' => function ($model) {
                    return number_format($model->grandTotal,2,",",".");
                },
                'contentOptions' => [
                    'class' => 'text-right'
                ],
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
                ],
                'width' => '120px',
            ],
        ],
    ]); ?>
</div>
<?php
$js = <<< SCRIPT
$(document).ready(function(){
    $('.btnPrint').click(function(e){
    e.preventDefault();
    var newWindow = window.open($(this).attr('href'),'report_view_sales_quotation','height=600,width=1024');
    if (window.focus) {
        newWindow.focus();
    }
    });
});
        
$(document).on('pjax:end',function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_view_sales_quotation','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
     });
});
SCRIPT;
$this->registerJs($js);

?>