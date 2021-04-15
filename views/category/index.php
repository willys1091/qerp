<?php
use app\components\AppHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsCoa;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Product Category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-productcategory-index">
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
                'attribute' => 'ProductCategoryName',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'notes',
                'headerOptions' => ['style' => 'text-align: left']
            ],
                AppHelper::getIsActiveColumn(),
                AppHelper::getMasterActionColumn()
        ],
    ]); ?>
</div>
