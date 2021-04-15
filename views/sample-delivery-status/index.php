<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use app\models\MsProduct;
use app\models\LkStatus;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Status';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-sampledeliveryhead-index">

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
                'attribute'=>'transactionDate',
                'value'=>'sampleHead.sampleDeliveryDate',                
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => AppHelper::getDateRangePickerConfig($model,
                [
                    'startAttribute' => 'startDate',
                    'endAttribute' => 'endDate',
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd-m-Y',
                            'separator' => ' to ',
                        ],
                        'autoApply' => true
                    ],
                ]),
                'width' => '180px',
                'hAlign' => 'center',
                'filterInputOptions' => [
                    'class' => 'form-control text-center',
                    'readonly' => true
                ],
            ],
            [
                'attribute' => 'sampleDeliveryNum',
                'width'=>'250px',
                'group'=>true,
                'groupOddCssClass'=>'table-striped',  
                'groupEvenCssClass'=>'table-striped',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'productID',
                'width'=>'250px',
                'value' => 'product.productName',
                'filter' => ArrayHelper::map(MsProduct::find()->all(), 'productID', 'productName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'qty',
                'value' => function ($data) {
                    return number_format($data->qty,4,",",".");
                },
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute' => 'statusID',
                'width'=>'250px',
                'value' => 'status.statusName',
                'filter' => ArrayHelper::map(LkStatus::find()->all(), 'statusID', 'statusName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'editableOptions'=>[
                    'header'=>'Status',
                    'inputType'=>\kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => ArrayHelper::map(LkStatus::find()->all(), 'statusID', 'statusName'),
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
        ],
    ]); ?>
</div>
