<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-salesorderhead-index">

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
                'attribute' => 'salesOrderDate',
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
                'attribute' => 'salesOrderNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'refNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'customerName',
                'value' => 'customer.customerName',
                'headerOptions' => [
                    'class' => 'text-left'
                ],
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
    var newWindow = window.open($(this).attr('href'),'report_view_sales_order','height=600,width=1024');
    if (window.focus) {
        newWindow.focus();
    }
    });
});
$(document).on('pjax:end',function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_view_sales_order','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
     });
});
SCRIPT;
$this->registerJs($js);

?>
