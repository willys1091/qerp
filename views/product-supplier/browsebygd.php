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
                'value' => 'product.productName',
            ],
            [
                'attribute' => 'uomName',
            ],
            [
                'attribute' => 'qtyStock',
                'value' => function ($model) {
                    return number_format($model->qtyStock, 2, ',', '.');
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
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{select}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'select' => function ($url, $model) {
                        $myFloat = $model->qtyStock;
                        $myStr = "$myFloat" * 1;
                        $decimal = strlen(explode('.', $myStr)[1]);
                        $qtyStock = number_format($myStr, $decimal, '.', ',');
                        
                        
                        return Html::a("<span class='glyphicon glyphicon-ok'></span>", "#", [
                            'class' => 'WindowDialogSelect',
                            'data-return-value' => $model->productID,
                            'data-return-text' => \yii\helpers\Json::encode([$model->productName,
                                $model->unitID,
                                $model->uomName,
                                $qtyStock,
                                number_format($model->HPP, 2, ',', '.')])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>

