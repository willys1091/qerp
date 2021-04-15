<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;
use app\models\MsWarehouse;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lost Stock Adjustments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-stockopnamehead-index">

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
                'attribute' => 'stockOpnameDate',
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
                'attribute' => 'stockOpnameNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'warehouseID',
                'width'=>'250px',
                'value' => 'parentWarehouse.warehouseName',
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
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}'.'{delete} ',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    
                    'update' => function ($url, $model) {
                        return !$model->status ? Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                            ['update', 'id' => $model->primaryKey],
                            [
                                'title' => 'Edit',
                                'class' => 'open-modal-btn'
                            ]) : '';
                    },
                   'delete' => function ($url, $model) {
                        $confirm = 'Are you sure you want to delete this data ?';
                        return !$model->status ? Html::a("<span class='glyphicon glyphicon-trash action-icon'></span>&nbsp;&nbsp;",
                            ['delete', 'id' => $model->primaryKey],
                            [
                                'data-method' => 'post',
                                'title' => 'Edit',
                                'data-confirm' => $confirm,
                                'class' => 'open-modal-btn'
                            ]) : '';
                    }
                ]
            ],
        ],
    ]); ?>
</div>
