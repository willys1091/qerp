<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View
 * @var $model \app\models\TrSalesOrderHead
 */

$this->title = 'Sales Order List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-order-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
          
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'salesOrderDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'salesOrderNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'customerName',
                'value' => 'parentCustomer.customerName',
                'width' => '150px',
            ],
            [
                'attribute' => 'grandTotal',
                'width'=>'200px',
                'value' => function ($model) {
                    return number_format($model->grandTotal,2,",",".");
                },
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'headerOptions' => [
                    'class' => 'text-right'
                ],
                'filterInputOptions' => [
                    'class' => 'text-right form-control'
                ]
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{select}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'select' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-ok'></span>", "#", [
                            'class' => 'WindowDialogSelect',
                            'data-return-value' => $model->salesOrderNum,
                            'data-return-text' => \yii\helpers\Json::encode([
                                $model->salesOrderNum,
                                $model->customerID,
                                $model->parentCustomer->customerName,
                                $model->grandTotal
                            ])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>