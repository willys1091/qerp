<?php

use yii\helpers\Html;
use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsSupplier;
use app\models\MsCoa;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supplier Advance Payment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-supplieradvancepayment-index">
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
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [
                        'class' => 'btn toolbar-icon',
                        'title' => Yii::t('app', 'Create')
                    ]).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'supplierAdvancePaymentDate',
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
                'attribute' => 'supplierAdvancePaymentNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            
            [
                'attribute' => 'refNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'supplierID',
                'width'=>'250px',
                'value' => 'parentSupplier.supplierName',
                'filter' => ArrayHelper::map(MsSupplier::find()->where('flagActive = 1')->orderBy('supplierName')->all(), 
                'supplierID', 'supplierName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ], 
            [
                'attribute' => 'amountDisplay',
                'label' => 'Amount',
                'value' => function($model) { return $model->currencyID  . " " . number_format($model->amount,2,",",".") . " (Rate: " . number_format($model->rate,2,",",".") . ")";},
                'headerOptions' => ['class' => 'text-left']
            ],
            AppHelper::getPaymentActionColumn()        
        ],
    ]); ?>
</div>
<?php
$js = <<< SCRIPT
$(document).ready(function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_voucher','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
    });
});
$(document).on('pjax:end',function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_voucher','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
     });
});
SCRIPT;
$this->registerJs($js);
