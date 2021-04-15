<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSupplier;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsreceipthead-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'panel' => [
            'heading' => 'Pending Goods Receipt',
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'summary'=>'',
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
                'contentOptions' => ['style' => 'text-align: center']
            ],
            [
                'attribute' => 'purchaseOrderDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'mm-yyyy',
                        'startView'=>'year',
                        'minViewMode'=>'months',
                        'autoWidget' => true,
                        'autoclose' => true,
                        'todayBtn' => true,
                        'startDate' => '-150y',
                        'todayHighlight' => true,
                    ],
                ],
                'width' => '110px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'purchaseOrderNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'supplierID',
                'value' => function ($data) {
                    return $data->supplierName;
                },
                'filter' => ArrayHelper::map(MsSupplier::find()->where('flagActive = 1')->orderBy('supplierName')->all(), 
                'supplierID', 'supplierName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
                        
            [
                'attribute' => 'shipmentDate',
                'value' =>function ($data){ 
                    if ($data->shipmentDate == NULL){
                        return "-";
                    } else{
                        return $data->shipmentDate;
                    }
                
                },
                //'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'mm-yyyy',
                        'startView'=>'year',
                        'minViewMode'=>'months',
                        'autoWidget' => true,
                        'autoclose' => true,
                        'todayBtn' => true,
                        'startDate' => '-150y',
                        'todayHighlight' => true,
                    ],
                ],
                'width' => '110px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            // [
            //     'class' => 'kartik\grid\ActionColumn',
            //     'template' => '{update}',
            //     'hAlign' => 'center',
            //     'vAlign' => 'middle',
            //     'header' => '',
            //     'buttons' => [
            //         'update' => function ($url, $model) {
            //         return Html::a("<span class='glyphicon glyphicon-save action-icon'></span>&nbsp;&nbsp;",
            //             ['update', 'id' => $model['refNum']],
            //             [
            //                 'title' => 'Save to Goods Receipt',
            //                 'class' => 'open-modal-btn'
            //             ]);
            //         },
                            
            //     ]
            // ]
        ],
    ]); ?>
</div>