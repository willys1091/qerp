<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Sample Delivery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-delivery-index">
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
                'attribute' => 'sampleDeliveryDate',
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
                'attribute' => 'sampleDeliveryNum',
                'width' => '15%'
            ],
            [
                'attribute' => 'customerID',
                'value' => 'customer.customerName',
                'width' => '25%'
            ],
            'notes',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{print}'.' '.'{update}'.' '.'{delete}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'print' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-print action-icon'></span>&nbsp;&nbsp;",
                        ['print', 'id' => $model->primaryKey],
                        [
                            'title' => 'Print',
                            'data-pjax' => '0',
                            'class' => 'btnPrint'
                        ]);
                     },
                    'update' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                            ['update', 'id' => $model->primaryKey],
                            [
                                'title' => 'Edit',
                                'class' => 'open-modal-btn'
                            ]);
                    },
                    'delete' => function ($url, $model) {
                            $url = ['delete', 'id' => $model->primaryKey];
                            $icon = 'trash';
                            $label = 'Delete';
                            $confirm = 'Are you sure you want to delete this data ?';
                        return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                            'title' => $label,
                            'aria-label' => $label,
                            'data-confirm' => $confirm,
                            'data-method' => 'post',
                            'data-pajax' => '0'
                        ]);
                    }
                ]
            ]
        ],
    ]);
    ?>
</div>
