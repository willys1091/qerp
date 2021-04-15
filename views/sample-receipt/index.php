<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Sample Receipt';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-receipt-index">
    <?=
    GridView::widget([
        'dataProvider' => $model->search(),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
            [
                'content' =>
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [
                    'class' => 'btn btn-warning toolbar-icon',
                    'title' => Yii::t('app', 'Create')
                ]) .
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                    'class' => 'btn btn-default',
                    'title' => Yii::t('app', 'Reset')
                ])
            ],
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'width' => Yii::$app->params['serialColumnWidth'],
            ],
            [
                'attribute' => 'sampleReceiptDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => AppHelper::getDatePickerRangeConfig(),
                'hAlign' => 'center',
                'filterInputOptions' => [
                    'class' => 'text-center form-control'
                ],
                'width' => '18%'
            ],
            [
                'attribute' => 'sampleReceiptNum',
                'width' => '15%'
            ],
            [
                'attribute' => 'refNum',
                'width' => '15%',
            ],
            [
                'attribute' => 'supplierID',
                'value' => 'supplier.supplierName',
                'width' => '25%'
            ],
            'notes',
            AppHelper::getActionColumn(true,true,false)
        ],
    ]);
    ?>
</div>
