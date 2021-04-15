<?php

use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\models\MsCoa;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\TrSupplieradvancepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-supplieradvancepayment-form">

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
                                        'content' => Html::a('...', ['purchase/browseincomplete'], [
                                            'title' => 'Purchase Order Code',
                                            'data-target-value' => '.refNum',
                                            'data-target-text' => '.refInput',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse purchaseOrderBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refNum refInput-0', 'readonly' => 'readonly']) ?>
                        </div>
                        <?= Html::hiddenInput('supplierID', '', [
                            'class' => 'form-control hiddenInputTxtProduct refInput-1'
                        ]) ?>
                        <div class="col-md-4">
                            <?= $form->field($model, 'supplierName')->textInput([
                                    'maxlength' => true, 
                                    'readonly' => true,
                                    'class' => 'supplierName refInput-2',
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
                                        'class' => 'form-control outstandingAmount refInput-4 text-right',
                                        'readonly' => true
                                    ],
                                    
                                ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'currencyID')->textInput([
                                'maxlength' => true, 
                                'class' => 'currencyID refInput-5',
                                'readonly' => 'readonly'
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'rate')
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
                                        'class' => 'form-control currencyRate refInput-3'
                                    ],
                            ])?>

                            
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
                        <!--<div class="col-md-4">
                            
                                $form->field($model, 'treasuryCOA')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 AND coaNo LIKE "1120.%"')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Treasury COA',
                                        'class' => 'form-control'],
                                ]);
                            
                        </div>-->
                        <div class="col-md-4">
                            <?php
                                $paymentCoas = MsCoa::find ()->where('coaLevel = 4 AND (coaNo LIKE "1110.%" OR coaNo LIKE "1111.%") AND flagActive = 1')->orderBy('description')->all();
                                $paymentCoaOptions = [];
                                foreach ($paymentCoas AS $paymentCoa)
                                {
                                    $paymentCoaOptions[$paymentCoa->coaNo] = [
                                        'data-currencyid' => $paymentCoa->currencyID
                                    ];
                                }
                                
                                echo $form->field($model, 'paymentCOA')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map($paymentCoas, 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Payment COA',
                                        'class' => 'form-control',
                                        'options' => $paymentCoaOptions
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'supplierAdvancePaymentDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isView)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'giroNum')->textInput([
                                    'class' => 'giroNum',
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Admin Fee</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'adminFeePaymentCoa')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map($paymentCoas, 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Payment COA',
                                        'class' => 'form-control adminFeePaymentCoa',
                                        'options' => $paymentCoaOptions
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'adminFeeCurrency')->textInput([
                                'maxlength' => true, 
                                'class' => 'adminFeeCurrency',
                                'readonly' => 'readonly'
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'adminFeeRate')->widget(\yii\widgets\MaskedInput::classname(), [
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
                                            'class' => 'form-control adminFeeRate'
                                        ],
                            ])?>
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
                <div class="panel-heading">Provision Fee</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                        <?php
                                $paymentCoas = MsCoa::find ()->where('coaLevel = 4 AND coaNo = "6111.0010" AND flagActive = 1')->orderBy('description')->all();
                                $paymentCoaOptions = [];
                                foreach ($paymentCoas AS $paymentCoa)
                                {
                                    $paymentCoaOptions[$paymentCoa->coaNo] = [
                                        'data-currencyid' => $paymentCoa->currencyID
                                    ];
                                }
                                
                                echo $form->field($model, 'provisionFeePaymentCoa')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map($paymentCoas, 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Provision COA',
                                        'class' => 'form-control',
                                        'options' => $paymentCoaOptions
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'provisionFeeCurrency')->textInput([
                                'maxlength' => true, 
                                'class' => 'provisionFeeCurrency',
                                'readonly' => 'readonly'
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'provisionFeeRate')->widget(\yii\widgets\MaskedInput::classname(), [
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
                                            'class' => 'form-control provisionFeeRate'
                                        ],
                            ])?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'provisionFeeAmount')->widget(\yii\widgets\MaskedInput::classname(), [
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
$refNumAjaxURL = Yii::$app->request->baseUrl. '/supplier-advance-payment/checkrefnum';

$js = <<< SCRIPT
$(document).ready(function () {     
    $('.adminFeePaymentCoa').change(function(){
        var adminFeePaymentCoa = $('.adminFeePaymentCoa');
        var adminFeeCurrency = $('.adminFeeCurrency');
        
        
        getCurrencyId(adminFeePaymentCoa.val(), function(currencyId){
            currencyId = replaceAll(currencyId, ".", ",");
            currencyId = replaceAll(currencyId, '"', "");
            adminFeeCurrency.val(currencyId);
        
            var adminFeeRate = $('.adminFeeRate');
        
            getCurrencyRate(adminFeeCurrency.val(), function(currencyRate){
                currencyRate = replaceAll(currencyRate, ".", ",");
                currencyRate = replaceAll(currencyRate, '"', "");
                adminFeeRate.val(formatNumber(currencyRate));
            });
        });

    });

    $('.provisionFeePaymentCoa').change(function(){
        var provisionFeePaymentCoa = $('.provisionFeePaymentCoa');
        var provisionFeeCurrency = $('.provisionFeeCurrency');
        
        
        getCurrencyId(provisionFeePaymentCoa.val(), function(currencyId){
            currencyId = replaceAll(currencyId, ".", ",");
            currencyId = replaceAll(currencyId, '"', "");
            provisionFeeCurrency.val(currencyId);
        
            var provisionFeeRate = $('.provisionFeeRate');
        
            getCurrencyRate(provisionFeeCurrency.val(), function(currencyRate){
                currencyRate = replaceAll(currencyRate, ".", ",");
                currencyRate = replaceAll(currencyRate, '"', "");
                provisionFeeRate.val(formatNumber(currencyRate));
            });
        });

    });
    
    $('.adminFeeCurrency').change(function(){
        var adminFeeCurrency = $('.adminFeeCurrency');
        var adminFeeRate = $('.adminFeeRate');
        
        getCurrencyRate(adminFeeCurrency.val(), function(currencyRate){
            currencyRate = replaceAll(currencyRate, ".", ",");
            currencyRate = replaceAll(currencyRate, '"', "");
            adminFeeRate.val(formatNumber(currencyRate));
        });
    });

    $('.provisionFeeCurrency').change(function(){
        var provisionFeeCurrency = $('.provisionFeeCurrency');
        var provisionFeeRate = $('.provisionFeeRate');
        
        getCurrencyRate(provisionFeeCurrency.val(), function(currencyRate){
            currencyRate = replaceAll(currencyRate, ".", ",");
            currencyRate = replaceAll(currencyRate, '"', "");
            provisionFeeRate.val(formatNumber(currencyRate));
        });
    });

    function getCurrencyId(coaNo, onFinish){
        var currencyId = '0.0';
        $.ajax({
            url: '$getCurrencyIdUrl',
            async: true,
            type: 'POST',
            data: { coaNo: coaNo }
        }).done(function(data){
            currencyId = data;
            onFinish(currencyId);
        });
    }     
        
    function getCurrencyRate(currencyID, onFinish){
        var currencyRate = '0.00';
        $.ajax({
            url: '$checkCurrencyRateAjaxURL',
            async: true,
            type: 'POST',
            data: { currencyID: currencyID }
        }).done(function(data){
            currencyRate = data;
            onFinish(currencyRate);
        });
    }
        
        
    $('.outstandingAmountt').change(function(){
        var refNum = $('.refNum').val();
        var POTotal = $('.outstandingAmount').val();

        POTotal = replaceAll(POTotal, ".", "");
        POTotal = replaceAll(POTotal, ",", ".");
        POTotal = parseFloat(POTotal);
        var result = getPaymentDetails(refNum,POTotal);
        $('.outstandingAmount').val(result);
    });
        
    function getPaymentDetails(refNum,POTotal){
        var salesDetail = [];
        $.ajax({
            url: '$refNumAjaxURL',
            async: false,
            type: 'POST',
            data: { refNum: refNum, POTotal: POTotal },
            success: function(result) {
                var result = JSON.parse(result);
                salesDetail = result;
            }
         });
        return salesDetail;
    }

    $('.amount').change(function(){
        var outstandingAmount = $('.refInput-4').val();
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

    $('form').on("beforeValidate", function(){
        var refNum = $('.refNum').val();
        if (refNum)
        {
            var currencyID = $('.currencyID').val();
            var paymentCoaCurrency = $('#trsupplieradvancepayment-paymentcoa option:selected').data('currencyid');
           
            if (paymentCoaCurrency != currencyID && paymentCoaCurrency != 'IDR')
            {
                bootbox.alert('Purchase Order ' + refNum + ' can only be paid using COA in IDR or ' + currencyID);
                return false;
            }
        }
        
        
        
        var outstandingAmount = $('.refInput-4').val();
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
