<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;
use app\models\MsWarehouse;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Internal Usage Approval';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-internalusagehead-index">

    <?= GridView::widget([
        'dataProvider' => $model->searchApprove(),
        'filterModel' => $model,
        'panel'=>[
            'heading'=>$this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'summary' => '',
        'toolbar' => [
            [
                'content'=>
              
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'internalUsageDate',
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
                'attribute' => 'internalUsageNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'warehouseID',
                'width'=>'250px',
                'value' => 'warehouse.warehouseName',
                'filter' => ArrayHelper::map(MsWarehouse::find()->all(), 'warehouseID', 'warehouseName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'notes',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            AppHelper::getApproveButton()
        ],
    ]); ?>
</div>
