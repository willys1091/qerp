<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Currency';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-currency-index">
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
                'contentOptions' => ['style' => 'text-align: center'],
            ],
            [
                'attribute' => 'currencyID',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'currencyName',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'currencySign',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'rate',
                'value' => function ($data) {
                    return AppHelper::formatNumberTwoDecimalConfig($data->rate);
                },
                'contentOptions' => ['class'=>'text-right'],
                'headerOptions' => ['class'=>'text-right'],
            ],
            AppHelper::getIsActiveColumn(),
            AppHelper::getMasterActionColumn()
        ],
    ]); ?>
</div>
