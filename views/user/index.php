<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsUseraccess;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MsUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
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
                'attribute' => 'username', 
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'fullName',
                'label' => 'Full Name',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'userRole',
                'filter' => ArrayHelper::map(MsUseraccess::find()->distinct()->all(), 'userRole', 'userRole'),
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
