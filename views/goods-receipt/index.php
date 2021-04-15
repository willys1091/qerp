<?php

use app\components\AppHelper;
use app\models\MsWarehouse;
use app\models\TrGoodsreceipthead;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Pending Goods Receipt';
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->controller->id;
?>

<div class="tr-goodsreceipthead-index">

    <?= GridView::widget([
        'dataProvider' => $model->search(Yii::$app->request->get()),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'summary'=>'',
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
                    GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'PendingGoodsReceipt-'.date('d-M-Y')],
                    GridView::HTML => ['label' => 'Export as HTML', 'filename' => 'PendingGoodsReceipt -'.date('d-M-Y')],
                    GridView::PDF => ['label' => 'Export as PDF',
                                      'filename' => 'PendingGoodsReceipt-'.date('d-M-Y'),
                                      'config' => [
                                            'methods' => [
                                                'SetHeader' => ['Pending Goods Receipt'],
                                                'SetFooter' => ['PT.Qwinjaya Aditama ' . '||Page {PAGENO}'],
                                            ]
                                        ],
                                     ],
                    GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'PendingGoodsReceipt-'.date('d-M-Y')],
                    GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'PendingGoodsReceipt-'.date('d-M-Y')],
                ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center']
            ],
         
            [
                'attribute' => 'refNum',
                'width' => '10%',
                'format' => 'raw',
                'value' => function($model) {
                    $stockCardModel = new TrGoodsreceipthead();
                    $stockCardModel->refNum = $model['refNum'];
                    $stockCardModel->transType = $model['transType'];
                    
                    return $stockCardModel->getRefNum();
                }
            ],
                
             [
                'attribute' => 'shipment',
                'format' => ['date', 'php:d-m-Y'],
                'hAlign' => 'center',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => AppHelper::getDateRangePickerConfig($model,
                [
                    'startAttribute' => 'startDate',
                    'endAttribute' => 'endDate',
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd-m-Y',
                            'separator' => ' to ',
                        ],
                        'autoApply' => true,
                        'filterPostion' => GridView::FILTER_POS_BODY,
                    ],
                ]),
       
            ],    
          
            [
                'attribute' => 'transType',
                'value' => 'transType',
                'filter' => [
                    'Purchase Order' => 'Purchase Order', 
                    'Sales Return' => 'Sales Return',
                    'Stock Transfer' => 'Stock Transfer'
                ],                
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All',
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'allowClear' => true,    
                    ]                     
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ], 
            [
                'attribute' => 'hsCode',
                'headerOptions' => ['style' => 'text-align: left']
            ],    
            [
                'attribute' => 'sources',
                'headerOptions' => ['style' => 'text-align: left'],
            ],
            [
                'attribute' => 'productname',
                'headerOptions' => ['style' => 'text-align: left'],
                'width' => '20%',
                'value' => function ($model) {
                    return nl2br($model['productname']);
                },
                'format' => 'raw'
            ],
           
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => $action == 'site' || $action == 'pending-shipment-report'  ?'' : '{update}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'update' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-save action-icon'></span>&nbsp;&nbsp;",
                        ['update','id' => $model['refNum']],
                        [
                            'title' => 'Save to Goods Receipt',
                            'class' => 'open-modal-btn'
                        ]);
                    },
                            
                ]
            ]
        ],
    ]); ?>
</div>
