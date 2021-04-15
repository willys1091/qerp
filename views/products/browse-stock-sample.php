<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $model \app\models\Product
 */

$this->title = Yii::t('app', 'Sample Stock List');
$this->params['breadcrumbs'][] = $this->title;
?>

<?=

GridView::widget([
    'id' => 'browse-stock-sample',
    'pjaxSettings' => [
        'options' => [
            'id' => 'grid-pjax-' . uniqid(),
            'enablePushState' => false
        ]
    ],
    'dataProvider' => $model->searchSampleStock(false),
    'filterModel' => $model,
    'filterUrl' => Url::to(['product/browse-stock-sample?warehouseID='. $warehouseID]),
    'panel' => [
        'heading' => $this->title,
    ],
    'toolbar' => [
        [
            'content' =>
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::to(['product/browse-stock-sample?warehouseID=' . $warehouseID]), [
                'class' => 'btn btn-default',
                'title' => Yii::t('app', 'Reset Grid')
            ]),
        ],
    ],
    'columns' => [
        [
            'class' => 'kartik\grid\SerialColumn',
            'width' => Yii::$app->params['serialColumnWidth'],
        ],
        [
            'attribute' => 'productName',
        ],
        [
            'attribute' => 'uomName',
            'width' => '10%'
        ],
        [
            'attribute' => 'batchNumber',
            'width' => '15%'
        ],
        [
            'attribute' => 'manufactureDate',
            'format' => ['date', 'php:d-m-Y'],
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => AppHelper::getDatePickerRangeConfig('startSearchManufactureDate','endSearchManufactureDate'),
            'hAlign' => 'center',
            'filterInputOptions' => [
                'class' => 'text-center form-control'
            ],
            'width' => '15%'
        ],
        [
            'attribute' => 'stock',
            'hAlign' => 'right',
            'width' => '15%',
            'filterInputOptions' => [
                'class' => 'text-right form-control'
            ]
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{select}',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'header' => '',
            'buttons' => [
                'select' => function ($url, $model) {
                                Yii::info(floatval($model['stock']));
    
                                return Html::a("<span class='glyphicon glyphicon-ok'></span>", "#", [
                                'class' => 'ModalDialogSelect',
                                'data-return-productid' => $model['productID'],
                                'data-return-productname' => $model['productName'],
                                'data-return-uomname' => $model['uomName'],
                                'data-return-batchnumber' => $model['batchNumber'],
                                'data-return-manufacturedate' => AppHelper::convertDateTimeFormat($model['manufactureDate'],'Y-m-d H:i:s','d-m-Y'),
                                'data-return-expireddate' => AppHelper::convertDateTimeFormat($model['expiredDate'],'Y-m-d H:i:s','d-m-Y'),
                                'data-return-retestdate' => AppHelper::convertDateTimeFormat($model['retestDate'],'Y-m-d H:i:s','d-m-Y'),
                                'data-return-stock' => $model['stock'],
                    ]);
                },
            ],
            'width' => Yii::$app->params['serialColumnWidth'],
        ],
    ],
]);

$this->registerJsFile("@web/assets_b/js/js_browse.js");
$this->registerJs("initBrowse('#browse-stock-sample');");


