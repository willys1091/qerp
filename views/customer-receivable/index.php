<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\MsCustomer;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Receivable';
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
<div class="tr-customerreceivablehead-index">

    <?= GridView::widget([
        'dataProvider' => $model->searchUnpaid(),
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
                'width'=>'250px',
                'value' => 'customerName',
                'filter' => ArrayHelper::map(MsCustomer::find()->orderBy(new yii\db\Expression("REPLACE(customerName, ' ', '') ASC"))->all(), 'customerID', 'customerName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' =>'contactPerson',
                'hAlign' => 'center',
                'vAlign' => 'middle',
            ],
            [
                'attribute' =>'street',
                'hAlign' => 'center',
                'vAlign' => 'middle',
            ],
            [
                'attribute' =>'phone',
                'hAlign' => 'center',
                'vAlign' => 'middle',
            ],
            [
                'attribute' => 'receivableTotal',
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'value' => function ($data) {
                    return /*$data['currency'].*/' '.number_format($data['receivableTotal'],2,",",".");
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
                        ['print-receivable', 'customerID' => $model['customerID']],
                        [
                            'title' => 'Print',
                            'class' => 'btnPrint'
                        ]);
                     },
                ],
            ],
            
//            [
//                'attribute' => 'outstandingAmount',
//                'value' => function ($data) {
//                    return number_format($data->outstandingAmount,2,",",".");
//                },
//                'contentOptions' => ['class'=>'text-right'],
//                'headerOptions' => ['class'=>'text-right']
//            ],
//            [
//                'class' => 'kartik\grid\ActionColumn',
//                'template' => '{view}',
//                'hAlign' => 'center',
//                'vAlign' => 'middle',
//                'header' => '',
//                'buttons' => [
//                        'view' => function ($url, $model) {
//                            return Html::a("<span class='glyphicon glyphicon-eye-open action-icon'></span>&nbsp;&nbsp;",
//                                ['view', 'id' => $model->customerID],
//                                [
//                                                'title' => 'View',
//                                                'class' => 'open-modal-btn WindowDialogBrowse'
//                                ]);
//                         }
//                ]
//            ]
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

