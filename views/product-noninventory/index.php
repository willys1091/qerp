<?php

use yii\helpers\Html;
use app\components\AppHelper;
use app\models\MsProductcategory;
use app\models\MsSupplier;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Product Non Inventory';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-product-index">

    <?= GridView::widget([
    'dataProvider' => $model->searchNoninv(),
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
                'attribute' => 'productName',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'productCategoryID',
                'width'=>'250px',
                'value' => 'parentCategory.ProductCategoryName',
                'filter' => ArrayHelper::map(MsProductcategory::find()->andWhere(['<>', 'productCategoryID', '1'])->andWhere(['<>', 'productCategoryID', '2'])->andWhere(['<>', 'productCategoryID', '3'])->andWhere(['<>', 'productCategoryID', '5'])->andWhere(['<>', 'productCategoryID', '6'])->andWhere(['<>', 'productCategoryID', '8'])->all(), 'productCategoryID', 'ProductCategoryName'),
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
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
            [
                'attribute' => 'origin',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'hsCode',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            AppHelper::getIsActiveColumn(),
            AppHelper::getMasterActionColumn()
        ],
]); ?>
</div>
