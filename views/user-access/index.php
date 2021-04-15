<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\LkAccesscontrol;
use app\models\MsUseraccess;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master User Access Control';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userAccess-index">

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
                'attribute' => 'userRole',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            AppHelper::getIsActiveColumn(),
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}'.' '.'{delete}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-eye-open action-icon'></span>&nbsp;&nbsp;",
                            ['view', 'id' => $model->userRole],
                            [
                                            'title' => 'View',
                                            'class' => 'open-modal-btn'
                            ]);
                     },
                    'delete' => function ($url, $model) {
                        if ($model->flagActive == 0) {
                            $url = ['restore', 'id' => $model->userRole];
                            $icon = 'repeat';
                            $label = 'Cancel Delete';
                            $confirm = 'Are you sure you want to activate this data ?';
                        } else {
                            $url = ['delete', 'id' => $model->userRole];
                            $icon = 'trash';
                            $label = 'Delete';
                            $confirm = 'Are you sure you want to delete this data ?';
                        }
                        return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                            'title' => $label,
                            'aria-label' => $label,
                            'data-confirm' => $confirm,
                            'data-method' => 'post',
                            'data-pajax' => '0'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                            ['update', 'id' => $model->userRole],
                            [
                                'title' => 'Edit',
                                'class' => 'open-modal-btn'
                            ]);
                    }
                ]
            ]
        ],
    ]); ?>

</div>
