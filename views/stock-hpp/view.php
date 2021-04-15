<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TrSupplierpayablehead */

$this->params['breadcrumbs'][] = ['label' => 'Supplier Payable', 'url' => ['index']];

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
                'attribute' => 'stockDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                        'width' => '110px'
            ],
            [
                'attribute' => 'manufactureDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                        'width' => '110px'
            ],
            [
                'attribute' => 'expiredOrRetestDate',
                'format' => ['date', 'php:d-m-Y'],
                'value' => function ($data) {
                    return is_null($data->expiredDate)? $data->retestDate : $data->expiredDate;
                },
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                        'width' => '110px'
            ],
            [
                'attribute' => 'HPP',
                'value' => function ($data) {
                    return number_format($data->HPP,2,",",".");
                },
                'contentOptions' => ['class'=>'text-center'],
            ],
			[
                'attribute' => 'batchNumber'
            ],
            [
                'attribute' => 'qtyStock',
                'value' => function ($data) {
                    return number_format($data->qtyStock,2,",",".");
                },
                'contentOptions' => ['class'=>'text-center'],
            ],
        ],
    ]); ?>

</div>
