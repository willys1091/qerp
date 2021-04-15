<?php

use yii\helpers\Html;
use app\components\AppHelper;
use app\models\MsProductcategory;
use app\models\MsSupplier;
use app\models\MapProductsupplier;
use app\models\MsProduct;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mapping Product Supplier';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-product-index">

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
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [
                        'class' => 'btn toolbar-icon',
                        'title' => Yii::t('app', 'Create')
                    ]).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'productID',
                'width'=>'250px',
                'value' => 'parentProduct.productName',
                'filter' => ArrayHelper::map(MsProduct::find()->all(), 'productID', 'productName'),
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'Origin',
                'value' => 'parentProduct.origin',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'supplierID',
                'width'=>'250px',
                'value' => 'parentSupplier.supplierName',
                'filter' => ArrayHelper::map(MsSupplier::find()->all(), 'supplierID', 'supplierName'),
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'Country',
                'value' => 'parentSupplier.country',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            // [
            //     'attribute' => 'productCategoryID',
            //     'width'=>'250px',
            //     'value' => 'parentCategory.ProductCategoryName',
            //     'filter' => ArrayHelper::map(MsProductcategory::find()->all(), 'productCategoryID', 'ProductCategoryName'),
            //     'filterInputOptions' => [
            //         'prompt' => 'All'
            //     ],
            //     'headerOptions' => ['style' => 'text-align: left']
            // ],
            // [
            //     'attribute' => 'supplierID',
            //     'width'=>'250px',
            //     'value' => 'parentSupplier.supplierName',
            //     'filter' => ArrayHelper::map(MsSupplier::find()->all(), 'supplierID', 'supplierName'),
            //     'filterInputOptions' => [
            //         'prompt' => 'All'
            //     ],
            //     'headerOptions' => ['style' => 'text-align: left']
            // ],
            // [
            //     'attribute' => 'origin',
            //     'headerOptions' => ['style' => 'text-align: left']
            // ],
            // [
            //     'attribute' => 'hsCode',
            //     'headerOptions' => ['style' => 'text-align: left']
            // ],
            // AppHelper::getIsActiveColumn(),
            AppHelper::getMasterActionColumn()
        ],
]); ?>
</div>
