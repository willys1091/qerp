<?php

use app\models\MsCategory;
use app\models\MsUom;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $model \app\models\Product
 */

$this->title = Yii::t('app', 'Product List');
$this->params['breadcrumbs'][] = $this->title;
?>

<?=

GridView::widget([
    'id' => 'browse-product',
    'pjaxSettings' => [
        'options' => [
            'id' => 'grid-pjax-' . uniqid(),
            'enablePushState' => false
        ]
    ],
    'dataProvider' => $model->searchBrowse($supplierID),
    'filterModel' => $model,
    'filterUrl' => Url::to(['product/browse?supplierID='. $supplierID]),
    'panel' => [
        'heading' => $this->title,
    ],
    'toolbar' => [
        [
            'content' =>
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::to(['product/browse?supplierID=' . $supplierID]), [
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
            'attribute' => 'supplierID',
            'value' => 'supplier.supplierName',
            'width' => '20%'
        ],
        [
            'attribute' => 'origin',
            'width' => '30%'
        ],
        [
            'attribute' => 'uomID',
            'value' => 'uom.uomName',
            'width' => '15%'
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{select}',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'header' => '',
            'buttons' => [
                'select' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-ok'></span>", "#", [
                                'class' => 'ModalDialogSelect',
                                'data-return-productid' => $model->productID,
                                'data-return-productname' => $model->productName,
                                'data-return-uomName' => $model->uom->uomName,
                    ]);
                },
            ],
            'width' => Yii::$app->params['serialColumnWidth'],
        ],
    ],
]);

$this->registerJsFile("@web/assets_b/js/js_browse.js");
$this->registerJs("initBrowse('#browse-product');");


