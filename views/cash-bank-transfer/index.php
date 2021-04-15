<?php

use yii\helpers\Html;
use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsCoa;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cash/Bank Transfer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-bank-transfer-index">

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
                'attribute' => 'transferDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => AppHelper::getDatePickersRangeConfig(),
                'hAlign' => 'center',
                'filterInputOptions' => [
                    'class' => 'text-center form-control'
                ],
                'width' => '18%'
            ],
            [
                'attribute' => 'transferID',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'voucherNum'
            ],
            [
                'attribute' => 'sourceCurrency',
                'value' => 'sourcecurrency.description',
                'filter' => ArrayHelper::map(MsCoa::find()->where('coaLevel = 4 and coaNo like "1110.%"')->orderBy('description')->all(), 
                'coaNo', 'description'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'width' => '150px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'destinationCurrency',
                'value' => 'destinationcurrency.description',
                'filter' => ArrayHelper::map(MsCoa::find()->where('coaLevel = 4 and coaNo like "1110.%"')->orderBy('description')->all(), 
                'coaNo', 'description'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                 'headerOptions' => ['style' => 'text-align: left']
            ],      
            [
                'attribute' => 'destinationRate',
                'value' => function ($data) {
                    return number_format($data->destinationRate,2,",",".");
                },
                'contentOptions' => ['class'=>'text-right'],
                'headerOptions' => ['class'=>'text-right'],
            ],
            [
                'attribute' => 'sourceAmount',
                'value' => function ($data) {
                    return number_format($data->sourceAmount,2,",",".");
                },
                'contentOptions' => ['class'=>'text-right'],
                'headerOptions' => ['class'=>'text-right'],
            ],
            AppHelper::getMasterActionColumnNoActive()
        ],
    ]); ?>
</div>
