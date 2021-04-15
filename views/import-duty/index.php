<?php

use yii\helpers\Html;
use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Import Duty';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsdeliveryheadhistory-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'summary' => '',
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
                'attribute' => 'goodsReceiptDate',
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
                'attribute' => 'goodsReceiptNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],            
            [
                'attribute' => 'refNum',
                'label' => 'PO Number',
                'headerOptions' => ['style' => 'text-align: left']
            ],    
            [
                'attribute' => 'supplierID',
                'value' => function ($data) {
                   $supplier = \app\models\MsSupplier::findOne($data->supplierID);
                   return $supplier->supplierName;
                },
                'filter' => ArrayHelper::map(\app\models\MsSupplier::find()->where('flagActive = 1')->orderBy('supplierName')->all(), 'supplierID', 'supplierName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'importDutyStatus',
                'filter' => ['Pending' => 'Pending', 'Done' => 'Done'],
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-eye-open action-icon'></span>&nbsp;&nbsp;",
                            ['view', 'id' => $model->primaryKey],
                            [
                                'title' => 'View'
                            ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                            ['update', 'id' => $model->primaryKey, 'done' => $model->importDutyStatus == 'Pending' ? 0 : 1],
                            [
                                'title' => 'Update',
                                'class' => 'open-modal-btn'
                            ]);
                     },
                ],
            ]
        ],
    ]); ?>
</div>
