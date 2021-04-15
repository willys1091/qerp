<?php

use yii\helpers\Html;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\ActiveForm;
use app\models\MsCoa;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TrCustomeradvancepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-customeradvancepayment-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Transaction Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'refNum', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['sales-order/browse-empty-payment'], [
                                            'title' => 'Sales Order Code',
                                            'data-target-value' => '.refNum',
                                            'data-target-text' => '.refInput',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse salesOrderBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refNum refInput-0', 'readonly' => 'readonly']) ?>
                        </div>
                        <?= Html::hiddenInput('custID', '', [
                            'class' => 'form-control hiddenInputTxtProduct refInput-1'
                        ]) ?>
                        <div class="col-md-4">
                            <?= $form->field($model, 'customerName')->textInput([
                                    'maxlength' => true, 
                                    'readonly' => true,
                                    'class' => 'customerName refInput-2',
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Outstanding Amount</label>
                            <?= \yii\widgets\MaskedInput::widget([
                                'name' => 'refAmount',
                                'value' => '0,00',
                                'clientOptions' => [
                                    'alias' => 'decimal',
                                    'digits' => 2,
                                    'digitsOptional' => false,
                                    'radixPoint' => ',',
                                    'groupSeparator' => '.',
                                    'autoGroup' => true,
                                    'removeMaskOnSubmit' => false
                                    ],
                                    'options' => [
                                        'class' => 'form-control outstandingAmount refInput-3 text-right',
                                        'disabled' => true
                                    ],
                                    
                                ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <?= Html::activeHiddenInput($model, 'currencyID', [
                                'maxlength' => true, 
                                'class' => 'currencyID',
                                'readonly' => 'readonly']) ?>
                        
                        <?= Html::activeHiddenInput($model, 'rate',
                                [
                                    'class' => 'form-control currencyRate',
                                    'readonly' => 'readonly'
                                ]) ?>
                        
                        <div class="col-md-4">
                            <?= $form->field($model, 'custAdvancePaymentDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isView)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'paymentCOA')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 AND (coaNo LIKE "1110.%" OR coaNo LIKE "1111.%") AND currencyID = "IDR"')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Payment COA',
                                        'class' => 'form-control'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'amount')
                            ->widget(\yii\widgets\MaskedInput::classname(), [
                                            'clientOptions' => [
                                            'alias' => 'decimal',
                                            'digits' => 2,
                                            'digitsOptional' => false,
                                            'radixPoint' => ',',
                                            'groupSeparator' => '.',
                                            'autoGroup' => true,
                                            'removeMaskOnSubmit' => false
                                                                ],
                                                'options' => [
                                                    'class' => 'form-control amount'
                                                ],
                                            ])?>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                                <?= $form->field($model, 'giroNum')->textInput([

                                        'class' => 'giroNum ',
                                ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Admin Fee</div>
                <div class="panel-body">
                    <div class="row">
                        <?= Html::activeHiddenInput($model, 'adminFeeCurrency', [
                            'maxlength' => true, 
                            'class' => 'adminFeeCurrency',
                            'readonly' => 'readonly'
                        ]) ?>
                        <?= Html::activeHiddenInput($model, 'adminFeeRate', [
                            'class' => 'form-control adminFeeRate',
                            'disabled' => true
                        ]) ?>
                        
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'adminFeePaymentCoa')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 AND (coaNo LIKE "1110.%" OR coaNo LIKE "1111.%") AND currencyID = "IDR"')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Payment COA',
                                        'class' => 'form-control adminFeePaymentCoa'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'adminFeeAmount')->widget(\yii\widgets\MaskedInput::classname(), [
                                'clientOptions' => [
                                    'alias' => 'decimal',
                                    'digits' => 2,
                                    'digitsOptional' => false,
                                    'radixPoint' => ',',
                                    'groupSeparator' => '.',
                                    'autoGroup' => true,
                                    'removeMaskOnSubmit' => false
                                                        ],
                                        'options' => [
                                            'class' => 'form-control adminFeeAmount'
                                        ],
                            ])?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Transaction Summary</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'additionalInfo')->textArea(['maxlength' => true, 'rows' => '10']) ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="box-footer">
            <div class="form-group text-right">
                <?php if (!isset($isView)): ?>
                    <?= Html::submitButton('<i class="glyphicon glyphicon-save"> Save </i>', ['class' => 'btn btn-primary btnSave']) ?>
                <?php endif; ?>
                
                <?php if (!isset($isView)){ ?>
                    <?= AppHelper::getCancelButton() ?>
                <?php } else { ?>
                    <?= Html::a('<i class="glyphicon glyphicon-remove"> Cancel </i>', ['index'], ['class'=>'btn btn-danger']) ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/currency/check';
$getCurrencyIdUrl = Yii::$app->request->baseUrl. '/coa/getcurrencyid';
$refNumAjaxURL = Yii::$app->request->baseUrl. '/customer-advance-payment/checkrefnum';

$js = <<< SCRIPT
$(document).ready(function () {
    $('.adminFeePaymentCoa').change(function(){
        var adminFeePaymentCoa = $('.adminFeePaymentCoa');
        var adminFeeCurrency = $('.adminFeeCurrency');
        
        var currencyId = getCurrencyId(adminFeePaymentCoa.val());
        currencyId = replaceAll(currencyId, '"', "");
        adminFeeCurrency.val(currencyId);
        
        var adminFeeRate = $('.adminFeeRate');
        
        var currencyRate = getCurrencyRate(adminFeeCurrency.val());
        currencyRate = replaceAll(currencyRate, ".", ",");
        currencyRate = replaceAll(currencyRate, '"', "");
        adminFeeRate.val(formatNumber(currencyRate));
    });
    
    $('.adminFeeCurrency').change(function(){
        var adminFeeCurrency = $('.adminFeeCurrency');
        var adminFeeRate = $('.adminFeeRate');
        
        var currencyRate = getCurrencyRate(adminFeeCurrency.val());
        currencyRate = replaceAll(currencyRate, ".", ",");
        currencyRate = replaceAll(currencyRate, '"', "");
        adminFeeRate.val(formatNumber(currencyRate));
    });
        
        
    function getCurrencyId(coaNo){
        var currencyId = '0.0';
        $.ajax({
            url: '$getCurrencyIdUrl',
            async: false,
            type: 'POST',
            data: { coaNo: coaNo },
            success: function(data) {
                currencyId = data;
            }
         });
        
        
        return currencyId;
    }     
        
    function getCurrencyRate(currencyID){
        var currencyRate = '0.00';
        $.ajax({
            url: '$checkCurrencyRateAjaxURL',
            async: false,
            type: 'POST',
            data: { currencyID: currencyID },
            success: function(data) {
                currencyRate = data;
            }
         });
        
        
        return currencyRate;
    }
        
    $('.outstandingAmount').change(function(){
        var refNum = $('.refNum').val();
        var transTotal = $('.outstandingAmount').val();

        transTotal = replaceAll(transTotal, ".", "");
        transTotal = replaceAll(transTotal, ",", ".");
        transTotal = parseFloat(transTotal);
        var result = getPaymentDetails(refNum,transTotal);
        $('.outstandingAmount').val(result);
    });

    function getPaymentDetails(refNum,transTotal){
        var salesDetail = [];
        $.ajax({
            url: '$refNumAjaxURL',
            async: false,
            type: 'POST',
            data: { refNum: refNum, transTotal: transTotal },
            success: function(result) {
                var result = JSON.parse(result);
                salesDetail = result;
            }
         });
        return salesDetail;
    }

$('form').focusout(function(){
     
});
    $('.amount').change(function(){
        var outstandingAmount = $('.outstandingAmount').val();
        var amount = $('.amount').val();
        
        outstandingAmount = replaceAll(outstandingAmount, ".", "");
        outstandingAmount = replaceAll(outstandingAmount, ",", ".");
        outstandingAmount = parseFloat(outstandingAmount);
        if (isNaN(outstandingAmount)){
            outstandingAmount = parseFloat(0);
        }
        amount = replaceAll(amount, ".", "");
        amount = replaceAll(amount, ",", ".");
        amount = parseFloat(amount);
        if (isNaN(amount)){
            amount = parseFloat(0);
        }
        
        if(amount > outstandingAmount){
            bootbox.alert("Advanced payment amount must not be larger than transaction amount");
        }
    });
                
    function formatNumber(nStr){
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
    function replaceAll(string, find, replace) {
        return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }

    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:\${}()|\[\]\/\\\\])/g, "\\\\$1");
    }
    $('form').on("beforeValidate", function(){
        var outstandingAmount = $('.outstandingAmount').val();
        var amount = $('.amount').val();
        
        outstandingAmount = replaceAll(outstandingAmount, ".", "");
        outstandingAmount = replaceAll(outstandingAmount, ",", ".");
        outstandingAmount = parseFloat(outstandingAmount);
        if (isNaN(outstandingAmount)){
            outstandingAmount = parseFloat(0);
        }
        amount = replaceAll(amount, ".", "");
        amount = replaceAll(amount, ",", ".");
        amount = parseFloat(amount);
        if (isNaN(amount)){
            amount = parseFloat(0);
        }
        
        if(amount > outstandingAmount){
            bootbox.alert("Advanced payment amount must not be larger than transaction amount");
            return false;
        }
    });
});
SCRIPT;
$this->registerJs($js);
?>
