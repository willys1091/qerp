<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\MsSupplier;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supplier Payable PPJK';
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
<div class="tr-supplierpayablehead-index">

    <?= GridView::widget([
        'dataProvider' => $model->searchUnpaidPPJK(),
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
                    return Yii::$app->controller->renderPartial('_detail-expanded', ['model' => $model]);
                    
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
                'filter' => ArrayHelper::map(MsSupplier::find()->where('isForwarder = 1')->orderBy(new yii\db\Expression("REPLACE(supplierName, ' ', '') ASC"))->all(), 'supplierID', 'supplierName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ]
            ],
            [
                'attribute' =>'country',
                'hAlign' => 'center',
                'vAlign' => 'middle',
            ],
            [
                'attribute' =>'street',
                'hAlign' => 'center',
                'vAlign' => 'middle',
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
            ],
            [            
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{print}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'print' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-print action-icon'></span>&nbsp;&nbsp;",
                        ['print', 'supplierID' => $model['supplierID'], 'isForwarder' => $model['isForwarder']],
                        [
                            'title' => 'Print',
                            'class' => 'btnPrint'
                        ]);
                     },
                ],
            ],
        ],
    ]); ?>
</div>

<?php
$js = <<< SCRIPT
$(document).ready(function(){
    $('.btnPrint').click(function(e){
    e.preventDefault();
    var newWindow = window.open($(this).attr('href'),'report_payable','height=600,width=1024');
    if (window.focus) {
        newWindow.focus();
    }
    });
});
$(document).on('pjax:end',function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_payable','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
     });
});
SCRIPT;
$this->registerJs($js);

?>
