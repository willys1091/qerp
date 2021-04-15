<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\TrJournalhead;
use app\models\TrJournaldetail;
use app\models\MsCoa;
use kartik\daterange\DateRangePicker;
use app\components\AppHelper;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Journal';
$this->params['breadcrumbs'][] = $this->title;

TrJournalhead::$totalDebit = 0;
TrJournalhead::$totalCredit = 0;
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
<div class="tr-journaldetail-index">

    <?=
    $this->render('_search', [
        'model' => $model
    ])
    ?>

    <?=
    GridView::widget([
        'id' => 'gridview1',
        'dataProvider' => $model->search(),
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class' => 'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
            '{export}'
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'pjax' => true,
        'striped' => false,
        'hover' => true,
        'showPageSummary' => true,
        'rowOptions' => [
            'class' => 'journal-grouped-row'
        ],
        'floatHeader'=>false,
        'floatHeaderOptions'=>
        [
            'top' => 0,
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                //'width' => '36px',
                'header' => '',
                'headerOptions' => ['class' => 'kartik-sheet-style']
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                //'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    TrJournalhead::$totalDebit += $model->getTotalDebit();
                    TrJournalhead::$totalCredit += $model->getTotalCredit();
                    return Yii::$app->controller->renderPartial('_detail-expanded', ['model' => $model]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            [
                'attribute' => 'journalDate',
                'width' => '130px',
                'pageSummary' => 'Total Balance',
                'pageSummaryOptions' => ['class' => 'text-right kv-page-summary h5 warning']
            ],
            [
                'attribute' => 'transactionType',
                'hAlign' => 'center',
                'width' => '150px'
            ],
            [
                'attribute' => 'refNum',
                'width' => '150px'
            ],
            [
                'attribute' => 'notes',
                'value' => function ($model, $key, $index, $column) {
                    return strip_tags($model->notes);
                },
                'pageSummaryOptions' => [
                    'class' => 'kv-page-summary h5 warning',
                    'style' => 'display: flex; margin: 0',
                ],
                'pageSummary' => function () {
                    $totalDebit = AppHelper::formatNumberTwoDecimalConfig(TrJournalhead::$totalDebit);
                    $totalCredit = AppHelper::formatNumberTwoDecimalConfig(TrJournalhead::$totalCredit);
                    return "<div style='width: 50%'>Debit : &nbsp; $totalDebit</div> <div style='width: 50%'>Credit : &nbsp; $totalCredit</div>";
                }
            ]
        ],
    ]);
    ?>
    
    
    <?=/*
    GridView::widget([
        'id' => 'gridview1',
        'dataProvider' => $model->search(),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class' => 'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
            [
                'content' =>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                    'class' => 'btn btn-default',
                    'title' => 'Reset Grid'
                ]),
            ],
        ],
        'pjax' => true,
        'striped' => false,
        'hover' => true,
        'showPageSummary' => true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'width' => '250px',
                'value' => function ($data) {
                    return $data->journalHeads->transactionType . ' : ' . $data->journalHeads->refNum;
                },
                'group' => true,
                'groupedRow' => true,
                'groupOddCssClass' => 'kv-grouped-row',
                'groupEvenCssClass' => 'kv-grouped-row'
            ],
            [
                'attribute' => 'journalDate',
                'value' => function ($data) {
                    return $data->journalHeads->journalDate;
                },
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE_RANGE,
            ],
            [
                'attribute' => 'transactionType',
                'width' => '250px',
                'label' => 'Transaction Type',
                'value' => function ($data) {
                    return $data->journalHeads->transactionType;
                }
            ],
            [
                'attribute' => 'refNum',
                'value' => function ($data) {
                    return $data->journalHeads->refNum;
                },
                'label' => 'Reference Number',
                'width' => '250px'
            ],
            [
                'attribute' => 'coaNo',
                'width' => '300px',
                'value' => function ($data) {
                    return $data->coaNos->description;
                },
                'filter' => ArrayHelper::map(MsCoa::find()->orderBy('description')->all(), 'coaNo', 'description'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => '- All -'
                ],
                'pageSummary' => 'Total Balance',
                'pageSummaryOptions' => ['class' => 'text-right kv-page-summary h5 warning']
            ],
            [
                'attribute' => 'drAmount',
                'width' => '200px',
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'pageSummaryOptions' => ['class' => 'text-right kv-page-summary h5 warning'],
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'headerOptions' => [
                    'class' => 'text-right'
                ],
            ],
            [
                'attribute' => 'crAmount',
                'width' => '200px',
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'pageSummaryOptions' => ['class' => 'text-right kv-page-summary h5 warning'],
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'headerOptions' => [
                    'class' => 'text-right'
                ],
            ],
            [
                'width' => '250px',
                'label' => 'Transaction Type',
                'value' => function ($data) {
                    return $data->journalHeads->transactionType;
                },
                'group' => true,
                'subGroupOf' => 1,
                'groupFooter' => function ($model) {
                    return [
                        'mergeColumns' => [[0, 2]],
                        'content' => [
                            0 => 'Balance',
                            6 => GridView::F_SUM,
                            7 => GridView::F_SUM,
                        ],
                        'contentFormats' => [
                            6 => ['format' => 'number', 'decimals' => 2],
                            7 => ['format' => 'number', 'decimals' => 2],
                        ],
                        'contentOptions' => [
                            0 => ['style' => 'font-variant:small-caps'],
                            6 => ['style' => 'text-align:right'],
                            7 => ['style' => 'text-align:right'],
                        ],
                        'options' => ['class' => 'danger', 'style' => 'font-weight:bold;']
                    ];
                },
                        'hidden' => true
                    ],
                ],
            ]);
            */''?>
</div>
