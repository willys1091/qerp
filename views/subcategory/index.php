<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Product Sub Category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-subcategory-index">

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
                'attribute' => 'subcategoryName',
                'headerOptions' => ['style' => 'text-align: left'],
            ],
            AppHelper::getIsActiveColumn(),
            AppHelper::getMasterActionColumn()
        ],
    ]); ?>
</div>
