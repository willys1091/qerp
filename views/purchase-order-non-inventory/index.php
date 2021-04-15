<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsSupplier;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Order Non Inventory';
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
        'summary' => '',
        'toolbar' => [
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
        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'purchaseOrderNonInventoryDate',
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
                'attribute' => 'purchaseOrderNonInventoryNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'supplierID',
                'value' => function ($data) {
                    return $data->supplier->supplierName;
                },
                'filter' => ArrayHelper::map(MsSupplier::find()->where('flagActive = 1')->orderBy('supplierName')->all(), 
                'supplierID', 'supplierName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'width' => '180px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'grandTotal',
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
                'template' => '{view}'.' '.'{update}'.' '.'{delete}'.' '.'{print}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'width' => '8%',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-eye-open action-icon'></span>&nbsp;&nbsp;",
                            ['view', 'id' => $model->purchaseOrderNonInventoryNum],
                            [
                                            'title' => 'View',
                                            'class' => 'open-modal-btn'
                            ]);
                     },
                     'print' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-print action-icon'></span>&nbsp;&nbsp;",
                        ['print', 'id' => $model->purchaseOrderNonInventoryNum],
                        [
                            'title' => 'Print',
                            'class' => 'btnPrint'
                        ]);
                     },
                    'delete' => function ($url, $model) {
                            $url = ['delete', 'id' => $model->purchaseOrderNonInventoryNum];
                            $icon = 'trash';
                            $label = 'Delete';
                            $confirm = 'Are you sure you want to delete this data ?';
                        return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                            'title' => $label,
                            'aria-label' => $label,
                            'data-confirm' => $confirm,
                            'data-method' => 'post',
                            'data-pajax' => '0'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                            ['update', 'id' => $model->purchaseOrderNonInventoryNum],
                            [
                                'title' => 'Edit',
                                'class' => 'open-modal-btn'
                            ]);
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
    var newWindow = window.open($(this).attr('href'),'report_view_poni','height=600,width=1024');
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
