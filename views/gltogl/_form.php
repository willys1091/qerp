<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\MsCoa;
use app\models\MsCurrency;
use kartik\widgets\DatePicker;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Gltogl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gltogl-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">GL to GL Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'gltoglDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig([])) ?>
                            <?= $form->field($model, 'voucherNum')->textInput(); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'notes')->textArea([
                                  'style' => ['height' => '100px;'],
                                
                            ]); ?>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <table class="table table-bordered debit-detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="width: 35%;">Debit Account</th>
                                        <th style="text-align: right; width: 15%;">Currency</th>
                                        <th style="text-align: right; width: 20%;">Rate</th>
                                        <th class="subTotals" style="text-align: right; width: 20%;">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <?php if (!isset($isView)): ?>
                                    <tfoot class="tfoot">
                                    <tr>
                                        <td class="visibility: hidden">
                                            <?= Html::hiddenInput('debitID', '', [
                                                'class' => 'form-control debitInput-0',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="newinput-group">
                                            <?= Html::textInput('debitName', '', [
                                                'class' => 'form-control debitInput-1'
                                            ]) ?>
                                            <div class="input-group-btn">
                                                    <?= Html::a("...", ['coa/browse'], [
                                                        'data-target-value' => '.debitValue',
                                                        'data-target-text' => '.debitInput',
                                                        'data-target-width' => '1000',
                                                        'data-target-height' => '600',
                                                        'class' => 'btn btn-primary btn-sm WindowDialogBrowse browseProduct'
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?= Html::textInput('debitCurrencyID', '', [
                                                'class' => 'form-control debitInput-2 text-center',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'debitRate',
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
                                                    'class' => 'form-control debitRate text-right'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'debitAmount',
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
                                                    'class' => 'form-control debitAmount text-right'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= Html::a('<i class="glyphicon glyphicon-plus">Add</i>', '#', ['class' => 'btn btn-primary btn-sm btnAddDebit']) ?>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <table class="table table-bordered credit-detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="width: 35%;">Credit Account</th>
                                        <th style="text-align: right; width: 15%;">Currency</th>
                                        <th style="text-align: right; width: 20%;">Rate</th>
                                        <th class="subTotals" style="text-align: right; width: 20%;">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <?php if (!isset($isView)): ?>
                                    <tfoot class="tfoot">
                                    <tr>
                                        <td class="visibility: hidden">
                                            <?= Html::hiddenInput('creditID', '', [
                                                'class' => 'form-control creditInput-0',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="newinput-group">
                                            <?= Html::textInput('creditName', '', [
                                                'class' => 'form-control creditInput-1'
                                            ]) ?>
                                            <div class="input-group-btn">
                                                    <?= Html::a("...", ['coa/browse'], [
                                                        'data-target-value' => '.creditValue',
                                                        'data-target-text' => '.creditInput',
                                                        'data-target-width' => '1000',
                                                        'data-target-height' => '600',
                                                        'class' => 'btn btn-primary btn-sm WindowDialogBrowse browseProduct'
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?= Html::textInput('creditCurrencyID', '', [
                                                'class' => 'form-control creditInput-2 text-center',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'creditRate',
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
                                                    'class' => 'form-control creditRate text-right'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'creditAmount',
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
                                                    'class' => 'form-control creditAmount text-right'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= Html::a('<i class="glyphicon glyphicon-plus">Add</i>', '#', ['class' => 'btn btn-primary btn-sm btnAddCredit']) ?>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label text-right">Debit Total</label>
                            <?= Html::textInput('subTotal', '0,00', [
                                'class' => 'form-control debitTotalSummary text-right',
                                'readonly' => 'readonly'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label text-right">Credit Total</label>
                            <?= Html::textInput('subTotal', '0,00', [
                                'class' => 'form-control creditTotalSummary text-right',
                                'readonly' => 'readonly'
                            ]) ?>
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
$debitDetail = \yii\helpers\Json::encode($model->joinDebitDetail);
$creditDetail = \yii\helpers\Json::encode($model->joinCreditDetail);
$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/currency/check';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "   <td class='text-center'>" +
            "       <a class='btn btn-danger btn-sm btnDelete' href='#'><i class='glyphicon glyphicon-remove'></i>Delete</a>" +
            "   </td>" +
DELETEROW;
} else {
    $deleteRow = '';
}


$js = <<< SCRIPT

$(document).ready(function () {
  
    var initDebitValue = $debitDetail;
    var initCreditValue = $creditDetail;

    var rowDebitTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='debitDetailID' name='Gltogl[joinDebitDetail][{{debitCount}}][debitID]' data-key='{{debitCount}}' value='{{debitID}}' >" +
        "   <td class='text-left'>" +
        "       <input type='hidden' class='debitDetailName' name='Gltogl[joinDebitDetail][{{debitCount}}][debitName]' value='{{debitName}}' > {{debitName}}" +
        "   </td>" +
        "   <td>" +
        "       <input type='hidden' class='debitDetailCurrency' name='Gltogl[joinDebitDetail][{{debitCount}}][debitCurrency]' value='{{debitCurrency}}' > {{debitCurrency}}" +
        "   </td>" +
        "   <td class='text-right'>" +
        "       <input type='text' class='form-control debitDetailRate' name='Gltogl[joinDebitDetail][{{debitCount}}][debitRate]' value='{{debitRate}}' >" +
        "   </td>" +
        "   <td class='text-right'>" +
        "       <input type='text' class='form-control debitDetailAmount' name='Gltogl[joinDebitDetail][{{debitCount}}][debitAmount]' value='{{debitAmount}}' >" +
        "   </td>" +
            $deleteRow
        "</tr>";


    var rowCreditTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='creditDetailID' name='Gltogl[joinCreditDetail][{{creditCount}}][creditID]' data-key='{{creditCount}}' value='{{creditID}}' >" +
        "   <td class='text-left'>" +
        "       <input type='hidden' class='creditDetailName' name='Gltogl[joinCreditDetail][{{creditCount}}][creditName]' value='{{creditName}}' > {{creditName}}" +
        "   </td>" +
        "   <td>" +
        "       <input type='hidden' class='creditDetailCurrency' name='Gltogl[joinCreditDetail][{{creditCount}}][creditCurrency]' value='{{creditCurrency}}' > {{creditCurrency}}" +
        "   </td>" +
        "   <td class='text-right'>" +
        "       <input type='text' class='form-control creditDetailRate' name='Gltogl[joinCreditDetail][{{creditCount}}][creditRate]' value='{{creditRate}}' >" +
        "   </td>" +
        "   <td class='text-right'>" +
        "       <input type='text' class='form-control creditDetailAmount' name='Gltogl[joinCreditDetail][{{creditCount}}][creditAmount]' value='{{creditAmount}}' >" +
        "   </td>" +
            $deleteRow
        "</tr>";

    initDebitValue.forEach(function(entry) {
        
        addDebitRow(entry.debitID.toString(), entry.debitName.toString(), entry.debitCurrency.toString(), entry.debitRate.toString(), entry.debitAmount.toString());
        calculateDebitSummary();
    });

    initCreditValue.forEach(function(entry) {
        console.log(entry);
        addCreditRow(entry.creditID.toString(), entry.creditName.toString(), entry.creditCurrency.toString(), entry.creditRate.toString(), entry.creditAmount.toString());
        calculateCreditSummary();
    });

    $('.debitInput-2').change(function(){
        var currencyID = $('.debitInput-2').val();
        currencyRate = getCurrencyRate(currencyID);
        currencyRate = replaceAll(currencyRate, ".", ",");
        currencyRate = replaceAll(currencyRate, '"', "");
        $('.debitRate').val(formatNumber(currencyRate));
    });
    $('.creditInput-2').change(function(){
        var currencyID = $('.creditInput-2').val();
        currencyRate = getCurrencyRate(currencyID);
        currencyRate = replaceAll(currencyRate, ".", ",");
        currencyRate = replaceAll(currencyRate, '"', "");
        $('.creditRate').val(formatNumber(currencyRate));
    });

    $('.debit-detail-table .btnAddDebit').on('click', function (e) {
        e.preventDefault();
        var debitID = $('.debitInput-0').val();
        var debitName = $('.debitInput-1').val();
        var debitCurrency = $('.debitInput-2').val();
        var debitRate = $('.debitRate').val();
        var debitAmount = $('.debitAmount').val();
       
        debitRate = replaceAll(debitRate, ".", "");
        debitRate = replaceAll(debitRate, ",", ".");
        
        debitAmount = replaceAll(debitAmount, ".", "");
        debitAmount = replaceAll(debitAmount, ",", ".");
        
        var debitRateStr = debitRate;
        var debitAmountStr = debitAmount;
        
        if(debitID=="" || debitID==undefined){
            bootbox.alert("Select COA");
            $('.debitInput-1').focus();
            return false;
        }
        
        if(debitIDExistsInTable(debitID)){
            bootbox.alert("COA has been registered in table");
            $('.debitInput-1').focus();
            return false;
        }

        if(debitRate=="" || debitRate==undefined || debitRate=="0"){
            bootbox.alert("Rate must be greater than 0");
            $('.debitRate').focus();
            return false;
        }

        if(!$.isNumeric(debitRate)){
            bootbox.alert("Rate must be numeric");
            $('.debitRate').focus();
            return false;
        }

        debitRate = parseFloat(debitRate);

        if(debitRate < 1){
            bootbox.alert("Rate must be greater than 0");
            $('.debitRate').focus();
            return false;
        }
        
        if(debitAmount=="" || debitAmount==undefined){
            bootbox.alert("Amount must be greater than 0");
            $('.debitAmount').focus();
            return false;
        }

        if(!$.isNumeric(debitAmount)){
            bootbox.alert("Amount must be numeric");
            $('.debitAmount').focus();
            return false;
        }

        debitAmount = parseFloat(debitAmount);

        if(debitAmount < 1){
            bootbox.alert("Amount must be greater than 0");
            $('.debitAmount').focus();
            return false;
        }

        addDebitRow(debitID, debitName, debitCurrency, debitRateStr, debitAmountStr);
        calculateDebitSummary();
        $('.debitID').val('');
        $('.debitName').val('');
        $('.debitCurrency').val('');
        $('.debitRate').val('0,00');
        $('.debitAmount').val('0,00');
    });

    $('.credit-detail-table .btnAddCredit').on('click', function (e) {
        e.preventDefault();
        var creditID = $('.creditInput-0').val();
        var creditName = $('.creditInput-1').val();
        var creditCurrency = $('.creditInput-2').val();
        var creditRate = $('.creditRate').val();
        var creditAmount = $('.creditAmount').val();
       
        creditRate = replaceAll(creditRate, ".", "");
        creditRate = replaceAll(creditRate, ",", ".");
        
        creditAmount = replaceAll(creditAmount, ".", "");
        creditAmount = replaceAll(creditAmount, ",", ".");
        
        var creditRateStr = creditRate;
        var creditAmountStr = creditAmount;
        
        if(creditID=="" || creditID==undefined){
            bootbox.alert("Select COA");
            $('.creditInput-1').focus();
            return false;
        }
        
        if(creditIDExistsInTable(creditID)){
            bootbox.alert("COA has been registered in table");
            $('.creditInput-1').focus();
            return false;
        }

        if(creditRate=="" || creditRate==undefined || creditRate=="0"){
            bootbox.alert("Rate must be greater than 0");
            $('.creditRate').focus();
            return false;
        }

        if(!$.isNumeric(creditRate)){
            bootbox.alert("Rate must be numeric");
            $('.creditRate').focus();
            return false;
        }

        creditRate = parseFloat(creditRate);

        if(creditRate < 1){
            bootbox.alert("Rate must be greater than 0");
            $('.creditRate').focus();
            return false;
        }
        
        if(creditAmount=="" || creditAmount==undefined){
            bootbox.alert("Amount must be greater than 0");
            $('.creditAmount').focus();
            return false;
        }

        if(!$.isNumeric(creditAmount)){
            bootbox.alert("Amount must be numeric");
            $('.creditAmount').focus();
            return false;
        }

        creditAmount = parseFloat(creditAmount);

        if(creditAmount < 1){
            bootbox.alert("Amount must be greater than 0");
            $('.creditAmount').focus();
            return false;
        }

        addCreditRow(creditID, creditName, creditCurrency, creditRateStr, creditAmountStr);
        calculateCreditSummary();
        $('.creditID').val('');
        $('.creditName').val('');
        $('.creditCurrency').val('');
        $('.creditRate').val('0,00');
        $('.creditAmount').val('0,00');
    });

    $('.debit-detail-table').on('change', '.debitDetailRate, .debitDetailAmount', function (e) {
        calculateDebitSummary();
    });
    $('.credit-detail-table').on('change', '.creditDetailRate, .creditDetailAmount', function (e) {
        calculateCreditSummary();
    });

    $('.debit-detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
            calculateDebitSummary();
        }
    });

    $('.credit-detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
            calculateCreditSummary();
        }
    });

    function addDebitRow(debitID, debitName, debitCurrency, debitRate, debitAmount){
        var template = rowDebitTemplate;
        debitRate = replaceAll(debitRate, ".", ",");
        debitAmount = replaceAll(debitAmount, ".", ",");
        
        template = replaceAll(template, '{{debitID}}', debitID);
        template = replaceAll(template, '{{debitName}}', debitName);
        template = replaceAll(template, '{{debitCurrency}}', debitCurrency);
        template = replaceAll(template, '{{debitRate}}', formatNumber(debitRate));
        template = replaceAll(template, '{{debitAmount}}', formatNumber(debitAmount));
        template = replaceAll(template, '{{debitCount}}', getDebitMaximumCounter() + 1);
        $('.debit-detail-table tbody').append(template);
    }

    function addCreditRow(creditID, creditName, creditCurrency, creditRate, creditAmount){
        var template = rowCreditTemplate;
        creditRate = replaceAll(creditRate, ".", ",");
        creditAmount = replaceAll(creditAmount, ".", ",");
        
        template = replaceAll(template, '{{creditID}}', creditID);
        template = replaceAll(template, '{{creditName}}', creditName);
        template = replaceAll(template, '{{creditCurrency}}', creditCurrency);
        template = replaceAll(template, '{{creditRate}}', formatNumber(creditRate));
        template = replaceAll(template, '{{creditAmount}}', formatNumber(creditAmount));
        template = replaceAll(template, '{{creditCount}}', getCreditMaximumCounter() + 1);
        $('.credit-detail-table tbody').append(template);
    }

    function calculateDebitSummary()
    {
        var debitAmount = 0;
        
        $('.debit-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var rate = $(this).find("input.debitDetailRate").val();
                var amount = $(this).find("input.debitDetailAmount").val();
                
                rate = replaceAll(rate, ".", "");
                rate = replaceAll(rate, ",", ".");
                rate = parseFloat(rate);
                amount = replaceAll(amount, ".", "");
                amount = replaceAll(amount, ",", ".");
                amount = parseFloat(amount);
                
                debitAmount = debitAmount + rate * amount;
            })
        });
        
        debitAmount = debitAmount.toFixed(2);
        debitAmount = replaceAll(debitAmount, ".", ",");
        
        $('.debitTotalSummary').val(formatNumber(debitAmount));
    }

    function calculateCreditSummary()
    {
        var creditAmount = 0;
        
        $('.credit-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var rate = $(this).find("input.creditDetailRate").val();
                var amount = $(this).find("input.creditDetailAmount").val();
                
                rate = replaceAll(rate, ".", "");
                rate = replaceAll(rate, ",", ".");
                rate = parseFloat(rate);
                amount = replaceAll(amount, ".", "");
                amount = replaceAll(amount, ",", ".");
                amount = parseFloat(amount);
                
                creditAmount = creditAmount + rate * amount;
            })
        });
        
        creditAmount = creditAmount.toFixed(2);
        creditAmount = replaceAll(creditAmount, ".", ",");
        
        $('.creditTotalSummary').val(formatNumber(creditAmount));
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

    function debitIDExistsInTable(barcode){
        var exists = false;
        $('.debitDetailID').each(function(){
            if($(this).val() == barcode){
                exists = true;
            }
        });
        return exists;
    }

    function creditIDExistsInTable(barcode){
        var exists = false;
        $('.creditDetailID').each(function(){
            if($(this).val() == barcode){
                exists = true;
            }
        });
        return exists;
    }

    function getDebitMaximumCounter() {
        var maximum = 0;
         $('.debitDetailID').each(function(){
            value = parseInt($(this).attr('data-key'));
            if(value > maximum){
                maximum = value;
            }
        });
        return maximum;
    }

    function getCreditMaximumCounter() {
        var maximum2 = 0;
         $('.creditDetailID').each(function(){
            value2 = parseInt($(this).attr('data-key'));
            if(value2 > maximum2){
                maximum2 = value2;
            }
        });
        return maximum2;
    }

    $('form').on("beforeValidate", function(){
        var debitTotal = $('.debitTotalSummary').val();
        var creditTotal = $('.creditTotalSummary').val();

        if(debitTotal != creditTotal){
            bootbox.alert("Debit amount must be same with credit amount");
            return false;
        }
    });
});
SCRIPT;
$this->registerJs($js);
?>