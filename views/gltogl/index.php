<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Gltogl;
use app\models\MsCoa;
use app\models\MsCurrency;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'GL to GL Information';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gltogl-index">

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
                'attribute' => 'gltoglDate',
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
                'attribute' => 'gltoglNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'voucherNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'notes',
                'headerOptions' => ['style' => 'text-align: left'],
                'format' => 'ntext',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'header' => '',
                'width' => '90px',
            ],
        ],
    ]); ?>
</div>
