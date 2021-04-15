<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TrSupplierpayablehead */

$this->title = $model->supplierID;
$this->params['breadcrumbs'][] = ['label' => 'Supplier Payable', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-supplierpayablehead-view">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
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
            ['class' => 'yii\grid\SerialColumn'],
            'refNum',
            [
                'attribute' => 'payableDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                        'width' => '110px'
            ],
            [
                'attribute' => 'currency',
                'value' => function($model) { return $model->currency . " (Rate: " . number_format($model->rate,2,",",".") . ")";},
            ],
            [
                'attribute' => 'amount',
                'value' => function ($data) {
                    return number_format($data->amount,2,",",".");
                },
                'contentOptions' => ['class'=>'text-center'],
            ],
        ],
    ]); ?>

</div>
