<?php

use app\components\AppHelper;
use app\models\LkPaymentmethod;
use app\models\MsCoa;
use app\models\MsCurrency;
use app\models\MsSupplier;
use app\models\MsTax;
use app\models\TrPurchaseorderhead;
use app\models\TrSupplierpaymenthead;
use endrikexe\ClientScript;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\widgets\MaskedInput;

/* @var $this View */
/* @var $model TrSupplierpaymenthead */
/* @var $form ActiveForm2 */
?>

<div class="tr-supplierpaymenthead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Supplier Payment Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'supplierPaymentDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'supplierID')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(MsSupplier::find(['flagActive' => 1])->orderBy(new yii\db\Expression("REPLACE(supplierName, ' ', '') ASC"))->all(), 'supplierID', 'supplierName'),
                                    'options' => [
                                        'prompt' => 'Select Supplier',
                                        'class' => 'selectSupplier'
                                    ],
                                ])

                            ?>
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
                                    'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 AND (coaNo LIKE "1110.%" OR coaNo LIKE "1111.%")')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'class' => 'selectCoa',
                                        'prompt' => 'Select Account'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'currencyID')->textInput([
                                'maxlength' => true, 
                                'class' => 'currencyID',
                                'readonly' => 'readonly'
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'rate')
                            ->widget(MaskedInput::classname(), [
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
                                        'class' => 'form-control currencyRate',
                                    ],
                            ])?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'giroNum')->textInput([
                                'maxlength' => true
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'provisiCost')
                            ->widget(MaskedInput::classname(), [
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
                                        'class' => 'form-control provisiCost',
                                    ],
                            ])?>
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
                                    'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 AND (coaNo LIKE "1110.%" OR coaNo LIKE "1111.%")')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Payment COA',
                                        'class' => 'form-control adminFeePaymentCoa'],
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
                            <?= $form->field($model, 'adminFeeRate')->widget(MaskedInput::classname(), [
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
                            <?= $form->field($model, 'adminFeeAmount')->widget(MaskedInput::classname(), [
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
                <div class="panel-heading">Supplier Payment Detail</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-bordered detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%;">Reference</th>
                                        <th style="width: 15%;">Amount Before Tax</th>
                                        <th style="width: 15%;">
                                            <div class="row">
                                                Tax Amount
                                            </div>
                                            <div class="row">
                                                WHT Amount
                                            </div>
                                        </th>
                                        <th style="width: 15%;">
                                            <div class="row">
                                                Sub Total
                                            </div>
                                            <div class="row">
                                                Paid
                                            </div>
                                        </th>
                                        <th style="width: 15%;">Outstanding</th>
                                        <th style="width: 20%;">Payment</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <?php if (!isset($isView)): ?>
                                                                        <tfoot>
                                    <tr>
                                        <td>
                                            <div class = "newinput-group">
                                                <?= Html::textInput('refNum', '', [
                                                        'class' => 'form-control refDetailInput-0',
                                                        'readonly' => 'readonly'
                                                ]) ?>
                                                <div class="input-group-btn">
                                                <?= Html::a("...", ['supplier-payment/browsebysupplier'], [
                                                        'title' => 'Browse Reference',
                                                        'data-filter-input' => '.selectSupplier',
                                                        'data-filter-input2' => '.currencyID',
                                                        'data-target-text' => '.refDetailInput',
                                                        'data-target-width' => '1000',
                                                        'data-target-height' => '600',
                                                        'class' => 'btn btn-primary btn-sm WindowDialogBrowse'
                                                    ])?>
                                                </div>
                                            </div>         
                                        </td>
                                        <td>
                                            <?= MaskedInput::widget([
                                                'name' => 'POBeforeTax',
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
                                                'options' =>[
                                                    'class' => 'form-control detailTransBeforeTax text-right',
                                                    'readonly' => 'readonly'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= MaskedInput::widget([
                                                        'name' => 'taxAmount',
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
                                                        'options' =>[
                                                            'class' => 'form-control detailTax text-right',
                                                            'readonly' => 'readonly'
                                                        ],
                                                        
                                                    ]) ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= MaskedInput::widget([
                                                        'name' => 'WHTAmount',
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
                                                        'options' =>[
                                                            'class' => 'form-control detailWHTAmount text-right',
                                                            'readonly' => 'readonly'
                                                        ],
                                                        
                                                    ]) ?>
                                                </div>
                                            </div>     
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= MaskedInput::widget([
                                                        'name' => 'subTotal',
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
                                                        'options' =>[
                                                            'class' => 'form-control detailSubTotal text-right',
                                                            'readonly' => 'readonly'
                                                        ],
                                                        
                                                    ]) ?>
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= MaskedInput::widget([
                                                        'name' => 'paidAmount',
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
                                                        'options' =>[
                                                            'class' => 'form-control detailPaidAmount text-right',
                                                            'readonly' => 'readonly'
                                                        ],
                                                        
                                                    ]) ?>
                                                </div>
                                            </div>  
                                            
                                        </td>
                                        <td>
                                            <?= MaskedInput::widget([
                                                'name' => 'outstandingAmount',
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
                                                    'class' => 'form-control detailOutstandingAmount text-right',
                                                    'readonly' => 'readonly'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td>  
                                            <?= MaskedInput::widget([
                                                'name' => 'paymentAmount',
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
                                                    'class' => 'form-control detailPaymentAmount text-right',
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td class="visibility: hidden">  
                                            <?= MaskedInput::widget([
                                                'name' => 'advancedPayment',
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
                                                    'class' => 'form-control detailAdvancedPayment text-right',
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= Html::a('<i class="glyphicon glyphicon-plus">Add</i>', '#', ['class' => 'btn btn-primary btn-sm btnAdd']) ?>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Supplier Payment Summary</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'transactionAmount')
                            ->widget(MaskedInput::classname(), [
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
                                    'class' => 'form-control transactionAmountSummary',
                                    'readonly' => true
                                ],
                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'whtAmount')
                            ->widget(MaskedInput::classname(), [
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
                                    'class' => 'form-control whtAmountSummary',
                                    'readonly' => true
                                ],
                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'outstandingAmount')->widget(MaskedInput::classname(), [
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
                                                'class' => 'form-control outstandingAmountSummary',
                                                'readonly' => 'readonly'
                                            ],
                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4" style="font-size: 18px; font-weight: bold;">
                            <?= $form->field($model, 'paymentAmount')
                            ->widget(MaskedInput::classname(), [
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
                                                    'class' => 'form-control paymentAmountSummary',
                                                    'readonly' => 'readonly'
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
$paymentDetail = Json::encode($model->joinPaymentDetail);
$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/coa/checkcurrency';
$refNumAjaxURL = Yii::$app->request->baseUrl. '/supplier-payment/checkrefnum';

$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/currency/check';
$getCurrencyIdUrl = Yii::$app->request->baseUrl. '/coa/getcurrencyid';


$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "   <td class='text-center'>" +
            "       <a class='btn btn-danger btn-sm btnDelete' href='#'><i class='glyphicon glyphicon-remove'></i>Delete</a>" +
            "   </td>" +
DELETEROW;
}

ClientScript::singleton()->beginScript('js'); ?>
<script>
var initValue = <?=$paymentDetail?>;
console.log(initValue);
var errorMessages = <?= Json::encode($model->errorMessages) ?>;
if (errorMessages)
{
    errorMessages.forEach(function(item, index){
        bootbox.alert(item);
    });
}


var rowTemplate = "" +
    "<tr>" +
    "   <td class='text-left'>" +
    "       <input type='text' class='form-control tableDetailRefNum' readonly='true' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][refNum]' value='{{refNum}}' data-key='{{Count}}'>" +
    "   </td>" +
    "   <td>" +
    "       <input type='text' class='form-control text-right tableDetailPrice' readonly='true' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][priceBeforeTax]' value='{{priceBeforeTax}}' >" +
    "   </td>" +
    "   <td>" +
    "       <div class='row'><div class='col-md-12'>" +   
    "           <input type='text' class='form-control text-right tableDetailTaxRate' readonly='true' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][taxRate]' value='{{taxRate}}'>" +
    "       </div></div>" + 
    "       <div class='row'><div class='col-md-12'>" +  
    "           <input type='text' class='form-control text-right tableDetailWHTAmount' readonly='true' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][WHTAmount]' value='{{WHTAmount}}'>" +
    "       </div></div>" + 
    "   </td>" +
    "   <td>" +
    "       <div class='row'><div class='col-md-12'>" +   
    "           <input type='text' class='form-control text-right tableDetailSubTotal' readonly='true' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][subTotal]' value='{{subTotal}}'>" +
    "       </div></div>" + 
    "       <div class='row'><div class='col-md-12'>" +  
    "           <input type='text' class='form-control text-right tableDetailPaid' readonly='true' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][paid]' value='{{paid}}'>" +
    "       </div></div>" + 
    "   </td>" +
    "   <td>" +
    "       <input type='text' class='form-control text-right maskedInput tableDetailOutstanding' readonly='true' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][outstanding]' value='{{outstanding}}' >" +
    "   </td>" +
    "   <td class='text-right'>" +
    "       <input type='text' class='form-control tableDetailPayment' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][payment]' value='{{payment}}' >" +
    "   </td>" +
    "       <input type='hidden' class='form-control tableDetailAdvancedPayment' name='TrSupplierpaymenthead[joinPaymentDetail][{{Count}}][advancedPayment]' value='{{advancedPayment}}' >" +
        <?=$deleteRow?>
    "</tr>";

initValue.forEach(function(entry) {
    addRow(entry.refNum.toString(), entry.priceBeforeTax.toString(), entry.taxRate.toString(), entry.WHTAmount.toString(), entry.subTotal.toString(), entry.paid.toString(), entry.outstanding.toString(), entry.advancedPayment.toString(), entry.payment.toString());
    //function addRow(refNum, priceBeforeTax, taxRate, WHTAmount, subTotal, paid, outstanding, advancedPayment, payment)
        
    calculateSummary();
});

$('.detail-table').on('click', '.btnDelete', function (e) {
    var self = this;
    e.preventDefault();
    yii.confirm('Are you sure you want to delete this data ?',deleteRow);
    function deleteRow(){
        $(self).parents('tr').remove();
    }
});

$('.selectCoa').change(function(){
    var coaNo = $('.selectCoa').val();

    var currencyId = getCurrencyId(coaNo);
    currencyId = replaceAll(currencyId, '"', "");
    $('.currencyID').val(currencyId);

    var currencyRate = getCurrencyRateById(currencyId);
    currencyRate = replaceAll(currencyRate, ".", ",");
    currencyRate = replaceAll(currencyRate, '"', "");

    $('.currencyID').val(currencyId);
    $('.currencyRate').val(currencyRate);

});

$('.refDetailInput-0').change(function(){
    var refNum = $('.refDetailInput-0').val();
    var supplierID = $('.selectSupplier').val();
    var result = getDetailReference(refNum, supplierID);
    
    var WHTAmount = parseFloat(result['whtAmount']);
    var priceBeforeTax = parseFloat(result['price']);
    var taxRate = parseFloat(result['taxRate']);
    var advancedPayment = parseFloat(result['advancedPayment']);
    var previousPayment = parseFloat(result['previousPayment']);
    var subTotal = priceBeforeTax * (100+taxRate)/100;
    var outstanding = subTotal - previousPayment - advancedPayment;

    console.log("tax rate: "+taxRate);
    console.log("tax rate: "+priceBeforeTax);
    $('.detailTransBeforeTax').val(priceBeforeTax);
    $('.detailTax').val(taxRate);
    $('.detailWHTAmount').val(WHTAmount);
    $('.detailSubTotal').val(subTotal);
    $('.detailPaidAmount').val(previousPayment + advancedPayment);
    $('.detailOutstandingAmount').val(outstanding);
    $('.detailAdvancedPayment').val(advancedPayment);
});

$('.detail-table .btnAdd').on('click', function (e) {
    e.preventDefault();
    
    
    var priceBeforeTax =  convertStringtoDecimal($('.detailTransBeforeTax').val());  
    console.log(priceBeforeTax);
    var refNum = $('.refDetailInput-0').val();
    var taxRate = $('.detailTax').val();
    var WHTAmount = $('.detailWHTAmount').val();
    var subTotal = convertStringtoDecimal($('.detailSubTotal').val());  
    var paid = $('.detailPaidAmount').val();
    var outstanding = convertStringtoDecimal($('.detailOutstandingAmount').val());
    var advancedPayment = $('.detailAdvancedPayment').val();
    var payment = convertStringtoDecimal($('.detailPaymentAmount').val());

    if (!validateQuantity(payment, 'Payment Amount', '.detailPaymentAmount', false, false)) {
        return false;
    }

    addRow(refNum, priceBeforeTax, taxRate, WHTAmount, subTotal, paid, outstanding, advancedPayment, payment);
    calculateSummary();
    $('.refDetailInput-0').val('');
    $('.detailTransBeforeTax').val('0,00');
    $('.detailTax').val('0,00');
    $('.detailWHTAmount').val('0,00');
    $('.detailSubTotal').val('0,00');
    $('.detailPaidAmount').val('0,00');
    $('.detailOutstandingAmount').val('0,00');
    $('.detailPaymentAmount').val('0,00');
});

function addRow(refNum, priceBeforeTax, taxRate, WHTAmount, subTotal, paid, outstanding, advancedPayment, payment){
    var template = rowTemplate;
    payment = replaceAll(payment, ".", ",");
    
    
    
    priceBeforeTax = replaceAll(priceBeforeTax, ".", ",");
    outstanding = replaceAll(outstanding, ".", ",");
    subTotal = replaceAll(subTotal, ".", ",");
    
    
    
    template = replaceAll(template, '{{refNum}}', refNum);
    template = replaceAll(template, '{{priceBeforeTax}}', formatNumber(priceBeforeTax));
    template = replaceAll(template, '{{taxRate}}', formatNumber(taxRate));
    template = replaceAll(template, '{{WHTAmount}}', formatNumber(WHTAmount));
    template = replaceAll(template, '{{subTotal}}', formatNumber(subTotal));
    template = replaceAll(template, '{{paid}}', formatNumber(paid));
    template = replaceAll(template, '{{outstanding}}', formatNumber(outstanding));
    template = replaceAll(template, '{{advancedPayment}}', formatNumber(advancedPayment));
    template = replaceAll(template, '{{payment}}', formatNumber(payment));
    template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
    $('.detail-table tbody').append(template);

    $('.maskedInput').inputmask('decimal', {digits:2, digitsOptional:false, radixPoint:',', groupSeparator: '.', autoGroup:true, removeMaskOnSubmit:true});
    $('.tableDetailPayment').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
}

function calculateSummary()
{
    var subTotalAmount = 0;
    var whtTotalAmount = 0;
    var outstandingTotal = 0;
    var paymentTotal = 0;

    $('.detail-table tbody').each(function() {
        $('tr', this).each(function () {
            var subTotal = convertStringtoDecimal($(this).find(".tableDetailSubTotal").val(), true);
            var whtTotal = convertStringtoDecimal($(this).find(".tableDetailWHTAmount").val(), true);
            var outstanding = convertStringtoDecimal($(this).find(".tableDetailOutstanding").val(), true);
            var payment = convertStringtoDecimal($(this).find(".tableDetailPayment").val(), true);

            subTotalAmount = subTotalAmount + subTotal;
            whtTotalAmount = whtTotalAmount + whtTotal;
            outstandingTotal = outstandingTotal + outstanding;
            paymentTotal = paymentTotal + payment;
        })
    });

    $('.transactionAmountSummary').val(subTotalAmount);
    $('.whtAmountSummary').val(whtTotalAmount);
    $('.outstandingAmountSummary').val(outstandingTotal);
    $('.paymentAmountSummary').val(paymentTotal);
}

function getCurrencyRate(coaNo){
    var result = [];
    $.ajax({
        url: '<?=$checkCurrencyRateAjaxURL?>',
        async: false,
        type: 'POST',
        data: { coaNo: coaNo },
        success: function(data) {
            result = JSON.parse(data);
        }
     });
    return result;
}

function getDetailReference(refNum,supplierID){
    var result = [];
    $.ajax({
        url: '<?=$refNumAjaxURL?>',
        async: false,
        type: 'POST',
        data: { refNum: refNum, supplierID: supplierID },
        success: function(data) {
            result = JSON.parse(data);
            
        }
     });
    return result;
}

$('.detailPaymentAmount').change(function(){
    var amount = $('.detailPaymentAmount').val();
    var outstanding = $('.detailOutstandingAmount').val();

    if(amount > outstanding){
        bootbox.alert("Amount can not be larger than Outstanding");
    }
});

function getMaximumCounter() {
    var maximum = 0;
     $('.tableDetailRefNum').each(function(){
        value = parseInt($(this).attr('data-key'));
        if(value > maximum){
            maximum = value;
        }
    });
        //console.log(maxium);
        return maximum;
    
}

$('form').on("beforeValidate", function(){
    var amount = $('.amount').val();
    var outstanding = $('.outstandingAmount').val();

    if(amount > outstanding){
        bootbox.alert("Amount can not be larger than Outstanding");
        return false;
    }
});


$('.adminFeePaymentCoa').change(function(){
    var adminFeePaymentCoa = $('.adminFeePaymentCoa');
    var adminFeeCurrency = $('.adminFeeCurrency');

    var currencyId = getCurrencyId(adminFeePaymentCoa.val());
    currencyId = replaceAll(currencyId, '"', "");
    adminFeeCurrency.val(currencyId);

    var adminFeeRate = $('.adminFeeRate');

    var currencyRate = getCurrencyRateById(adminFeeCurrency.val());
    currencyRate = replaceAll(currencyRate, ".", ",");
    currencyRate = replaceAll(currencyRate, '"', "");
    adminFeeRate.val(formatNumber(currencyRate));
});

$('.adminFeeCurrency').change(function(){
    var adminFeeCurrency = $('.adminFeeCurrency');
    var adminFeeRate = $('.adminFeeRate');

    var currencyRate = getCurrencyRateById(adminFeeCurrency.val());
    currencyRate = replaceAll(currencyRate, ".", ",");
    currencyRate = replaceAll(currencyRate, '"', "");
    adminFeeRate.val(formatNumber(currencyRate));
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

function getCurrencyRateById(currencyID){
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