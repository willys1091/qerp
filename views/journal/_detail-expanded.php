<?php
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use app\models\TrJournalHead;
use app\models\TrJournalDetail;
use yii\helpers\Json;

$detailProvider = new ArrayDataProvider([
    'allModels' => $model->trJournalDetails,
    'pagination' => false
]);
?>

<?=
    GridView::widget([
        'id' => 'detailGrid'.$model->journalHeadID,
        'dataProvider' => $detailProvider,
        'panel' => [
            'heading' => 'Journal Detail',
            'headingOptions' => ['class' => 'panel-heading qwinjaya-header'],
            'footerOptions' => [
                'class' => 'panel-footer',
                'style' => 'display: none;'
            ],
        ],
        'options' => [
            'class' => 'detailgrid'
        ],
        'toolbar' => false,
        'pjax' => true,
        'striped' => false,
        'hover' => true,
        'showPageSummary' => true,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                //'width' => '36px',
                'header' => '',
                'headerOptions' => ['class' => 'kartik-sheet-style']
            ],
            [
                'label' => 'Description',
                'value' => function ($model, $key, $index, $column) {
                    return $model->coa->description;
                },
                'pageSummary' => 'Balance',
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
        ],
    ]);
    ?>