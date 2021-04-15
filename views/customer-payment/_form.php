<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\LkPaymentmethod;
use app\models\MsCustomer;
use app\models\MsCoa;
use app\models\MsTax;
use app\models\TrSalesorderhead;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use endrikexe\ClientScript;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\TrCustomerpayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-customerpayment-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Customer Payment Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'paymentTransactionDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'refNum', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['goods-delivery/browsepayment'], [
                                            'title' => 'Reference Number',
                                            'data-target-value' => '.refID',
                                            'data-target-text' => '.refInput',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse supplierBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refID', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'voucherNum')->textInput([
                                'maxlength' => true
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'coaNo')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find()->where('coaLevel = 4')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Account'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'customerName')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCustomer::find()->distinct()->all(), 'customerID', 'customerName'),
                                    'options' => [
                                        'prompt' => 'Select Customer',
                                        'class' => 'form-control customerName'],
                                        'disabled' => true,
                                ]);
                            ?>
                        </div>
                         <div class="col-md-4">
                            <?= $form->field($model, 'giroNum')->textInput([
                                'maxlength' => true
                            ]) ?>
                        </div>
                        <?= $form->field($model, 'customerID')->hiddenInput([
                                'maxlength' => true, 
                                'class' => 'customerID',
                                'readonly' => 'readonly'
                            ])->label(false) ?>
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
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Customer Payment Detail</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Transaction Amount (Before Tax)</label>
                            <?= \yii\widgets\MaskedInput::widget([
                                'name' => 'transAmount',
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
                                        'class' => 'form-control transAmount text-right',
                                        'readonly' => true
                                    ],
                                    
                                ]) ?>
                        </div>
                        <div class="col-md-4">
                        <label class="control-label">Tax Amount</label>
                            <?= \yii\widgets\MaskedInput::widget([
                                'name' => 'transTaxAmount',
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
                                        'class' => 'form-control transTax text-right',
                                        'readonly' => true
                                    ],
                                    
                                ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'transactionAmount')
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
                                    'class' => 'form-control transGrandTotal',
                                    'readonly' => true
                                ],
                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'advancedPayment')
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
                                                'class' => 'form-control advancedPayment',
                                                'readonly' => 'readonly'
                                            ],
                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'outstandingAmount')
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
                                                'class' => 'form-control outstandingAmount',
                                                'readonly' => 'readonly'
                                            ],
                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4" style="font-size: 18px; font-weight: bold;">
                            <?= $form->field($model, 'downpayment')
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
                                                    'class' => 'form-control downpayment'
                                                ],
                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4" style="font-size: 18px; font-weight: bold;">
                            <?= $form->field($model, 'paymentAmount')
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
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4" style="font-size: 18px; font-weight: bold;">
                            <?= $form->field($model, 'adjustment')
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
                                                    'class' => 'form-control adjustment'
                                                ],
                            ])?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Additional Info</div>
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
$refNumAjaxURL = Yii::$app->request->baseUrl. '/customer-payment/checkrefnum';

$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/currency/check';
$getCurrencyIdUrl = Yii::$app->request->baseUrl. '/coa/getcurrencyid';

ClientScript::singleton()->beginScript('js'); ?>
<script>
$(".giroNumClass").hide();
$(".giroDueDateClass").hide();

var errorMessages = <?= Json::encode($model->errorMessages) ?>;
if (errorMessages)
{
    errorMessages.forEach(function(item, index){
        bootbox.alert(item);
    });
}

function getPaymentDetails(refNum){
    var salesDetail = [];

    $.ajax({
        url: '<?=$refNumAjaxURL?>',
        async: false,
        type: 'POST',
        data: { refNum: refNum },
        success: function(result) {
            var result = JSON.parse(result);
            salesDetail = result;
        }
     });
    return salesDetail;
}

$('.refID').change(function(){
    var refNum = $('.refID').val();

    var result = getPaymentDetails(refNum);
    //console.log(result);
    var customerID = result['customerID'];
    var advancedPayment = result['advancedPayment'];
    var previousPayment = result['previousPayment'];
    var price = result['price'];
    var taxRate = result['taxRate'];
    var transTax = parseFloat(price) * parseInt(taxRate)/100;
    var transGrandTotal = parseFloat(price) + parseFloat(transTax);
    var originalOutstanding = parseFloat(transGrandTotal) - parseFloat(advancedPayment) - parseFloat(previousPayment);

    $('.customerID').val(customerID);
    $('.customerName').val(customerID).change();

    
    $('.transAmount').val(parseFloat(price));

    $('.transTax').val(transTax);
    $('.transGrandTotal').val(Math.round(transGrandTotal));
   
    $('.advancedPayment').val(advancedPayment);
    $('.outstandingAmount').val(Math.round(originalOutstanding));
});

$('.amount').change(function(){
    var amount = $('.amount').val().currencyToFloat();
    var outstanding = $('.outstandingAmount').val().currencyToFloat();
    console.log(amount);
    console.log(outstanding);
    if(amount > outstanding){
        bootbox.alert("Amount can not be larger than Outstanding");
    }
});

function replaceAll(string, find, replace) {
    return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function escapeRegExp(string) {
    return string.replace(/([.*+?^=!:\${}()|\[\]\/\\\\])/g, "\\\\$1");
}

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


$('.downpayment').change(function(){
    var downpayment = $('.downpayment').val().currencyToFloat();
    var advancedPayment = $('.advancedPayment').val().currencyToFloat();

    if(downpayment > advancedPayment){
         bootbox.alert("Downpayment can not be larger than Advanced Payment");
        
    }
    
});

$('.amount').change(function(){
    var downpayment = $('.downpayment').val().currencyToFloat();
    var transGrandTotal = $('.transGrandTotal').val().currencyToFloat();
    var amount = $('.amount').val().currencyToFloat();
    var range = transGrandTotal - downpayment;
 
    if(amount > range){
         bootbox.alert("Payment Amount invalid");
        
    }
    
});


function getCurrencyId(coaNo){
    var currencyId = '0.0';
    $.ajax({
        url: '<?=$getCurrencyIdUrl?>',
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
        url: '<?=$checkCurrencyRateAjaxURL?>',
        async: false,
        type: 'POST',
        data: { currencyID: currencyID },
        success: function(data) {
            currencyRate = data;
        }
     });


    return currencyRate;
}
</script>
<?php ClientScript::singleton()->endScript(); ?>