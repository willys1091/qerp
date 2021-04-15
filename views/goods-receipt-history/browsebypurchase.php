<?php

use app\components\AppHelper;
use app\models\MsProduct;
use app\models\MsProductdetail;
use app\models\MsPackingtype;
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
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
		'filterUrl' => Url::to(['goods-receipt-history/browse']),
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
            [
               
            ],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
			[
				'attribute' => 'goodsReceiptNum',
				'label' => 'Goods Receipt Number',
			],
			[
				'attribute' => 'goodsReceiptDate',
				'label' => 'Goods Receipt Date',
			],
                        [
				'attribute' => 'refNum',
				'label' => 'Purchase Order Number',
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
                            'data-return-value' => $model->goodsReceiptNum,
                            'data-return-text' => \yii\helpers\Json::encode([$model->goodsReceiptNum])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>


