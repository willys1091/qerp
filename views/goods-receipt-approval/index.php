<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods Receipt Approval';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsreceipthead-index">
    <?= GridView::widget([
        'dataProvider' => $model->search(Yii::$app->request->get()),
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
                'contentOptions' => ['style' => 'text-align: center']
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
                'attribute' => 'sources',
                'headerOptions' => ['style' => 'text-align: left']
            ], 
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'update' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-save action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model['goodsReceiptNum']],
                        [
                            'title' => 'Approve',
                            'class' => 'open-modal-btn'
                        ]);
                    },                            
                ]
            ]
        ],
    ]); ?>
</div>
