<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\MsProduct;
use app\models\MsWarehouse;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Inquiry';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-hpp-index">

    <?= GridView::widget([
        'dataProvider' => $model->search(),
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
                'attribute' => 'warehouseID',
                'width'=>'250px',
                'value' => 'parentWarehouse.warehouseName',
                'filter' => ArrayHelper::map(MsWarehouse::find()->where('flagActive = 1')->all(), 'warehouseID', 'warehouseName'),
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'group'=>true,
                'groupOddCssClass'=>'table-striped',  
                'groupEvenCssClass'=>'table-striped',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'productID',
                'width'=>'250px',
                'value' => 'parentProduct.productName',
                'filter' => ArrayHelper::map(MsProduct::find()->where('flagActive = 1')->all(), 'productID', 'productName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'group'=>true,  
                'groupOddCssClass'=>'table-striped',  
                'groupEvenCssClass'=>'table-striped',
                'subGroupOf'=>1,
                'headerOptions' => ['style' => 'text-align: left']
            ],
            
            [
                'attribute' => 'expiredDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                'width' => '110px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'qtyStock',
                'value' => function ($data) {
                    return number_format($data->qtyStock,2,",",".");
                },
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'view' => function ($url, $model) {
                            return Html::a("<span class='glyphicon glyphicon-eye-open action-icon'></span>&nbsp;&nbsp;",
                                ['view', 'id' => $model->warehouseID, 'id2' => $model->productID],
                                [
                                    'title' => 'View',
                                    'class' => 'open-modal-btn WindowDialogBrowse'
                                ]);
                         }
                ]
            ]
        ],
    ]); ?>
</div>
