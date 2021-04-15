<?php

use yii\helpers\Html;
use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\MsCoa;
use app\models\MsTax;
use app\models\LkPaymentMethod;


$this->title = 'Cash / Bank - In / Out';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-cashin-index">
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
                'attribute' => 'cashInOutDate',
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
                'attribute' => 'cashInOutNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'voucherNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'checkOrGiroNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'cashAccount',
                'value' => 'coa.description',
                'width' => '200px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'additionalInfo',
                'headerOptions' => ['style' => 'text-align: left'],
				'format' => 'ntext',
            ],
            AppHelper::getActionColumnWithPrint()
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