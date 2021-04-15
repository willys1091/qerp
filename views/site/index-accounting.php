<?php

use app\components\AppHelper;
use app\models\MsCustomer;
use app\models\MsSupplier;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.detailgrid .kv-panel-before, .detailgrid .kv-panel-after
{
    display: none;
}
.detailgrid .qwinjaya-header
{
    background-color: #6e946f !important;
}
.journal-grouped-row
{
    background-color: #e3f1c7 !important;
}
.journal-grouped-row:hover
{
    background-color: #d3ff7b !important;
}
</style>
<div class="container-fluid">
    <div class="row">
       
        <div class="col-md-6">
            <?= GridView::widget([
                'dataProvider' => $payable->searchUnpaid(),
                'filterModel' => $payable,
                'panel' => [
                    'heading' => 'Payable',
                    'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
                ],
                'summary' => '',
                'toolbar' => false,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style text-center'],
                        'headerOptions' => ['class' => 'kartik-sheet-style text-center']
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        //'width' => '50px',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index, $column) {
                            //return 'Hello World';
                            return Yii::$app->controller->renderPartial('_payable-detail', ['model' => $model]);

                        },
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'expandOneOnly' => true
                    ],
                    [
                        'attribute' => 'supplierID',
                        'width'=>'250px',
                        'hAlign' => 'center',
                        'vAlign' => 'middle',
                        'value' => 'supplierName',
                        'filter' => ArrayHelper::map(MsSupplier::find()->orderBy(new yii\db\Expression("REPLACE(supplierName, ' ', '') ASC"))->all(), 'supplierID', 'supplierName'),
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterInputOptions' => [
                            'prompt' => 'All'
                        ]
                    ],
                    [
                        'attribute' =>'officeNumber',
                        'hAlign' => 'right',
                        'vAlign' => 'middle',
                    ],
                    [
                        'attribute' => 'payableTotal',
                        'hAlign' => 'right',
                        'vAlign' => 'middle',
                        'value' => function ($data) {
                            return /*$data['currency'].*/' '.number_format($data['payableTotal'],2,",",".");
                        },
                    ]
                ],
            ]); ?>
        </div>
       
        <div class="col-md-6">
            <?=
            GridView::widget([
                'dataProvider' => $receivable->searchDue(),
                'filterModel' => $receivable,
                'panel' => [
                    'heading' => 'Receivable Due',
                    'headingOptions' => ['class' => 'panel-heading qwinjaya-header'],
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
                        'contentOptions' => [
                            'style' => 'text-align: center',
                        ]
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        //'width' => '50px',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('_detail-expanded', ['model' => $model]);
                        },
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'expandOneOnly' => true
                    ],
                    [
                        'attribute' => 'customerID',
                        'width' => '250px',
                        'value' => 'customerName',
                        'filter' => ArrayHelper::map(MsCustomer::find()->orderBy(new yii\db\Expression("REPLACE(customerName, ' ', '') ASC"))->all(), 'customerID', 'customerName'),
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterInputOptions' => [
                            'prompt' => 'All'
                        ],
                        'headerOptions' => ['style' => 'text-align: left']
                    ],
                   
                    [
                        'attribute' => 'phone',
                        'hAlign' => 'center',
                        'vAlign' => 'middle',
                    ],
                    [
                        'attribute' => 'receivableTotal',
                        'hAlign' => 'right',
                        'vAlign' => 'middle',
                        'value' => function ($data) {
                            return /* $data['currency']. */' ' . number_format($data['receivableTotal'], 2, ",", ".");
                        },
                    ],
                    
                ],
            ]);

            ?>
        </div>
           <div class="col-md-6">
             <?=
            GridView::widget([
                'dataProvider' => $ppjk->searchUnpaidPPJK(),
                'filterModel' => $ppjk,
                'panel' => [
                     'heading' => 'Payable PPJK',
                    'headingOptions' => ['class' => 'panel-heading qwinjaya-header'],
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
                        'contentOptions' => ['class' => 'kartik-sheet-style text-center'],
                        'headerOptions' => ['class' => 'kartik-sheet-style text-center']
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        //'width' => '50px',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('_detail-expandedppjk', ['model' => $model]);
                        },
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'expandOneOnly' => true
                    ],
                    [
                        'attribute' => 'supplierID',
                        'width' => '250px',
                        'hAlign' => 'center',
                        'vAlign' => 'middle',
                        'value' => 'supplierName',
                        'filter' => ArrayHelper::map(MsSupplier::find()->where('isForwarder = 1')->orderBy(new yii\db\Expression("REPLACE(supplierName, ' ', '') ASC"))->all(), 'supplierID', 'supplierName'),
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterInputOptions' => [
                            'prompt' => 'All'
                        ]
                    ],
                   
                    [
                        'attribute' => 'officeNumber',
                        'hAlign' => 'right',
                        'vAlign' => 'middle',
                    ],
                    [
                        'attribute' => 'payableTotal',
                        'hAlign' => 'right',
                        'vAlign' => 'middle',
                        'value' => function ($data) {
                            return /* $data['currency']. */' ' . number_format($data['payableTotal'], 2, ",", ".");
                        },
                    ],
                ],
            ]);

            ?>
        </div>
     
    </div>
</div>