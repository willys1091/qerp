<?php

use app\components\AppHelper;
use app\models\MsProduct;
use app\models\MsUom;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\db\Expression;

/* @var $this yii\web\View
 * @var $model \app\models\ProductDetail
 */

$this->title = 'Product List';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ms-user-index">
    <?= GridView::widget([
        'dataProvider' => $model->search(),
        'pjaxSettings' => [
            'options' => [
                'id' => 'grid-pjax-' . uniqid(),
                'enablePushState' => false
            ]
        ],
        'filterModel' => $model,
		'filterUrl' => Url::to(['product/browse_']),
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
            [
                'content' =>
                 Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::to(['product/browse_?mode=' . $mode]), [
                    'class' => 'btn btn-default',
                    'title' => Yii::t('app', 'Reset Grid')
                ]),
            ],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
			[
				'attribute' => 'productName',
				'label' => 'Product Name',
			],
			[
				'attribute' => 'uomName',
				'value' => 'uom.uomName',
                'label' => 'UOM',
			],
			[
				'attribute' => 'qty',
				'label' => 'Min Qty',
				'value' => function ($model) {
                    return number_format($model->minQty, 2, ',', '.');
                },
                'contentOptions' => [
                    'class' => 'text-right'
                ],
				'headerOptions' => [
					'class' => 'text-right'
				],
			],
			[
				'attribute' => 'supplierID',
				'value' => 'parentSupplier.supplierName',
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
                            'class' => 'WindowDialogSelect',
                            'data-return-value' => $model->productID,
                            'data-return-text' => \yii\helpers\Json::encode([$model->productName,$model->uom->uomName,number_format($model->minQty, 2, ',', '.'),number_format($model->productDetails->sellPrice, 2, ',', '.'),$model->uom->uomID])
                        ]);
                    },
                ]
            ],
            AppHelper::getIsActiveColumn(),
        ],
    ]); 
    $this->registerJsFile("@web/assets_b/js/js_browse.js");
    $this->registerJs("initBrowse('#tblBrowseProduct');");

    ?>

</div>
