<?php

use yii\helpers\Html;
use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\LkStatus;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods Delivery History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsdeliveryheadhistory-index">

    <?= GridView::widget([
        'dataProvider' => $model->search(),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
            [
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center'],
            ],
            [
                'attribute' => 'goodsDeliveryDate',
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
                'attribute' => 'goodsDeliveryNum',
                'value' => 'goodsDeliveryNum',
                'headerOptions' => ['style' => 'text-align: left'],
                'class'=>'kartik\grid\EditableColumn',
               
                'editableOptions'=>[
                    'header'=>'GD Number',
                    'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
                   
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'invoiceNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],            
            [
                'attribute' => 'refNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'transType',
                'filter' => [
                    'Purchase Return' => 'Purchase Return', 
                    'Sales Order' => 'Sales Order',
                    'Stock Transfer' => 'Stock Transfer'
                ],                
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
             [
                'class'=>'kartik\grid\EditableColumn',
                'attribute' => 'deliveryStatus',
                'value' => 'lkStatus.statusName',
                'filter' => ArrayHelper::map(LkStatus::find()->all(), 'statusID', 'statusName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'editableOptions'=>[
                    'header'=>'Status',
                    'inputType'=>\kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => ArrayHelper::map(LkStatus::find()->all(), 'statusID', 'statusName'),
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}'.' '.'{print}'.' '.'{printFaktur}'.' '.'{update}'.' '.'{delete}',
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
                            'title' => 'Print Goods Delivery',
                            'class' => 'btnPrint'
                        ]);
                     },
                    'update' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model->primaryKey],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]);
                     },
                    'delete' => function ($url, $model) {
                            $url = ['delete', 'id' => $model->primaryKey];
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
                    'printFaktur' => function ($url, $model) {
                        return $model->transType == 'Sales Order'? Html::a("<span class='glyphicon glyphicon-print action-icon'></span>&nbsp;&nbsp;",
                        ['printfaktur', 'id' => $model->primaryKey],
                        [
                            'title' => 'Print Sales Invoice',
                            'class' => 'btnPrint'
                        ]) : '';
                     },
                ]
            ]
        ],
    ]); ?>
</div>

<?php
$js = <<< SCRIPT
$(document).ready(function(){
    $('.btnPrint').click(function(e){
    e.preventDefault();
    var newWindow = window.open($(this).attr('href'),'report_view_surat_jalan','height=600,width=1024');
    if (window.focus) {
        newWindow.focus();
    }
    });
});
$(document).on('pjax:end',function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_view_surat_jalan','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
     });
});
SCRIPT;
$this->registerJs($js);

?>
