<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsCoa;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Reason';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-reason-index">
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
                'attribute' => 'mapReasonName',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'coaNo',
                'value' => function ($data) {
                    return $data->coaNos->description;
                },
                'filter' => ArrayHelper::map(MsCoa::find()->where('coaLevel = 4')->orderBy('description')->all(), 
                'coaNo', 'description'),
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            AppHelper::getIsActiveColumn(),
            AppHelper::getMasterActionColumn()
        ],
    ]); ?>
    
</div>
