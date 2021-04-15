<?php

use yii\helpers\Html;
use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsCoa;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Goods Delivery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsdeliveryhead-index">
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
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'refNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'poNum',
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
                'attribute' => 'destination',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'productName',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'qty',
                
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'uomName',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'origin',
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
                            ['update', 'id' => $model['refNum']],
                            [
                                'title' => 'Save to Goods Delivery',
                                'class' => 'open-modal-btn'
                            ]);
                    }
                ]
            ]
        ],
    ]); ?>
</div>
