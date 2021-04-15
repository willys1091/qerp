<?php

use yii\helpers\Html;
use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsCustomer;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Payment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-customerpayment-index">

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
                'attribute' => 'paymentTransactionDate',
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
                'attribute' => 'customerPaymentNum',
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],
            [
                'attribute' => 'voucherNum'
            ],
            [
                'attribute' => 'customerID',
                'value' => 'customer.customerName',
                'headerOptions' => [
                    'class' => 'text-left'
                ],
            ],
            [
                'attribute' => 'paymentAmount',
                'value' => function ($model) {
                    return number_format($model->paymentAmount,2,",",".");
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
                'attribute' => 'additionalInfo',
                'headerOptions' => [
                    'class' => 'text-left'
                ],
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