<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\LkDocumenttype;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Document Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-documenttype-index">
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
                'attribute' => 'lkDocumentTypeID',
                'width'=>'250px',
                'value' => 'parentDocumentType.lkDocumentTypeName',
                'filter' => ArrayHelper::map(LkDocumenttype::find()->all(), 'lkDocumentTypeID', 'lkDocumentTypeName'),
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'documentTypeName',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'ordinal',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center']
            ],
            AppHelper::getIsActiveColumn(),
            AppHelper::getMasterActionColumn()
        ],
    ]); ?>
</div>

