<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tax Payable';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-taxinhead-index">

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
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center']
            ],
            [
                'attribute' => 'taxPeriode',
                'format' => ['date', 'php:m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getMonthYearPickerConfig(),
                'width' => '110px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'taxInTotal',
                'value' => function ($data) {
                    return AppHelper::formatNumberTwoDecimalConfig($data->taxInTotal);
                },
                'contentOptions' => ['class'=>'text-right'],
                'headerOptions' => ['class'=>'text-right'],
            ],
            [
                'attribute' => 'taxOutTotal',
                'value' => function ($data) {
                    return AppHelper::formatNumberTwoDecimalConfig($data->taxOutTotal);
                },
                'contentOptions' => ['class'=>'text-right'],
                'headerOptions' => ['class'=>'text-right'],
            ],
            [
                'attribute' => 'taxPayable',
                'value' => function ($data) {
                    return AppHelper::formatNumberTwoDecimalConfig($data->taxPayable);
                },
                'contentOptions' => ['class'=>'text-right'],
                'headerOptions' => ['class'=>'text-right'],
            ],
            AppHelper::getMasterActionColumnNoActive()
        ],
    ]); ?>
</div>
