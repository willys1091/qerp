<?php

use app\components\AppHelper;
use app\models\MsProduct;
use app\models\MsUom;
use app\models\StockHpp;
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
				'attribute' => 'productName',
				'label' => 'Product Name',
			],
            [
                'attribute' => 'uomName',
            ],
            [
                'attribute' => 'qtyStock',
                'label' => 'Qty in Stock',
                'value' => function ($model) {
                    return number_format($model->qtyStock, 4, ',', '.');
                },
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'headerOptions' => [
                    'class' => 'text-right'
                ],
            ],
            [
                'attribute' => 'HPP',
                'label' => 'HPP',
                'value' => function ($model) {
                    return number_format($model->HPP, 2, ',', '.');
                },
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'headerOptions' => [
                    'class' => 'text-right'
                ],
            ],
            [
                'attribute' => 'batchNumber',
            ],
            [
                'attribute' => 'manufactureDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                'width' => '150px'
            ],
            [
                'attribute' => 'expiredDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                'width' => '150px'
            ],
            [
                'attribute' => 'retestDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                'width' => '150px'
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
                            'data-return-text' => \yii\helpers\Json::encode([
                                $model->productName, //0
                                $model->productID, //1
                                $model->uomID, //2
                                $model->uomName, //3
                                AppHelper::convertDateTimeFormat($model->manufactureDate, 'Y-m-d H:i:s', 'd-m-Y'), //4
                                AppHelper::convertDateTimeFormat($model->expiredDate, 'Y-m-d H:i:s', 'd-m-Y'), //5
                                number_format($model->qtyStock, 4, ',', '.'), //6
                                number_format($model->HPP, 2, ',', '.'), //7
                                AppHelper::convertDateTimeFormat($model->retestDate, 'Y-m-d H:i:s', 'd-m-Y'), //8
                                $model->batchNumber //9
                                ])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>
