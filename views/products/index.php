<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Master Product';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <?=
    GridView::widget([
        'dataProvider' => $model->search(),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
        ],
        'toolbar' => [
            [
                'content' =>
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [
                    'class' => 'btn btn-warning toolbar-icon',
                    'title' => Yii::t('app', 'Create')
                ]) .
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                    'class' => 'btn btn-default',
                    'title' => Yii::t('app', 'Reset')
                ])
            ],
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'width' => Yii::$app->params['serialColumnWidth'],
            ],
            [
                'attribute' => 'productName',
                'hAlign' => 'left',
            ],
            [
                'attribute' => 'productCategoryID',
                'value' => 'category.productCategoryName',
                'hAlign' => 'left',
                'width' => '15%'
            ],
            [
                'attribute' => 'productSubCategoryID',
                'value' => 'subCategory.productSubCategoryName',
                'hAlign' => 'left',
                'width' => '15%'
            ],
            [
                'attribute' => 'origin',
                'hAlign' => 'left',
                'width' => '15%'
            ],
            [
                'attribute' => 'supplierID',
                'value' => 'supplier.supplierName',
                'hAlign' => 'left',
                'width' => '15%'
            ],
            [
                'attribute' => 'hsCodeID',
                'value' => 'hsCode.hsCode',
                'hAlign' => 'left',
                'width' => '8%'
            ],
            AppHelper::getStatusColumn(),
            AppHelper::getActionColumn()
        ],
    ]);
    ?>
</div>
