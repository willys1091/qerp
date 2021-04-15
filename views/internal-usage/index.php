<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;
use app\models\MsWarehouse;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Internal Usage';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-internalusagehead-index">

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
                'attribute' => 'internalUsageDate',
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
                'attribute' => 'internalUsageNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'warehouseID',
                'width'=>'250px',
                'value' => 'warehouse.warehouseName',
                'filter' => ArrayHelper::map(MsWarehouse::find()->all(), 'warehouseID', 'warehouseName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'notes',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'internalUsageStatus',
                'value' => function($model) { return $model->internalUsageStatus == '0'? 'Not Approved' : 'Approved';},
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}'.' '.'{update}'.'{print}'.'{delete}',
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
                                            'title' => 'View',
                                            'class' => 'btnPrint'
                            ]);
                     },
                    'update' => function ($url, $model) {
                    return $model->internalUsageStatus == '0'? Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model->primaryKey],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]) : '';
                    },
                    'delete' => function ($url, $model) {
                            $url = ['delete', 'id' => $model->primaryKey];
                            $icon = 'trash';
                            $label = 'Delete';
                            $confirm = 'Are you sure you want to delete this data ?';
                        return $model->internalUsageStatus == '0'? Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                            'title' => $label,
                            'aria-label' => $label,
                            'data-confirm' => $confirm,
                            'data-method' => 'post',
                            'data-pajax' => '0'
                        ]) : '';
                    }
                ]
            ]
        ],
    ]); ?>
</div>
<?php
$js = <<< SCRIPT
//$(document).ready(function(){
//    $('.btnPrint').click(function(e){
//        e.preventDefault();
//        var newWindow = window.open($(this).attr('href'),'print','height=600,width=1024');
//    console.log(newWindow);
//        if (window.focus) {
//            newWindow.focus();
//        }
//    });
//   
//});

$(document).on('pjax:end',function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'print','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
     });
});
SCRIPT;
$this->registerJs($js);