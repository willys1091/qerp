<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\MsSupplier;
use app\models\MsCoa;
use app\models\MsCurrency;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrPurchasereturnhead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-purchasereturnhead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Basic Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'purchaseReturnDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'supplierID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsSupplier::find(['flagActive' => 1])->orderBy(['supplierName'=>SORT_ASC])->all(), 'supplierID', 'supplierName'),
                                    'options' => [
                                        'prompt' => 'Select Supplier',
                                        'class' => 'form-control selectSupplier'
                                        ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'coaNo')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find ()->where('coano like "1110%" or coano like "1111%"')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Reason',
                                        'class' => 'selectCoaNo'],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'currencyID')->textInput([
                                    'class' => 'form-control selectCurrency',
                                    'readonly' => 'readonly'])
                            ?>
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
                                    'class' => 'form-control currencyRate'
                                ],
                            ])?>                           
                        </div>
                        <div class="col-md-4">
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Product Detail</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-bordered detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%;">
                                            <div class="row">
                                                Product Name
                                            </div>
                                            <div class="row">
                                                Unit
                                            </div>
                                        </th>
                                        <th style="width: 10%;">
                                            <div class="row">
                                                Qty
                                            </div>
                                            </th>
                                        <th style="width: 10%;">Price</th>
                                        <th style="width: 5%;">Tax</th>
                                        <th style="width: 10%;">Subtotal</th>
                                        <th style="width: 20%;">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <?php if (!isset($isView)): ?>
                                                                        <tfoot>
                                    <tr>
                                        <td class="visibility: hidden">
                                            <?= Html::hiddenInput('productID', '', [
                                                'class' => 'form-control productIDInput'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class = "newinput-group">
                                                        <?= Html::textInput('productName', '', [
                                                            'class' => 'form-control productDetailInput-0'
                                                        ]) ?>
                                                        <div class="input-group-btn">
                                                        <?= Html::a("...", ['product/browsebysupplier'], [
                                                                 'title' => 'Browse product',
                                                                'data-filter-input' => '.selectSupplier',
                                                                'data-target-value' => '.productIDInput',
                                                                'data-target-text' => '.productDetailInput',
                                                                'data-target-width' => '1000',
                                                                'data-target-height' => '600',
                                                                'class' => 'btn btn-primary btn-sm WindowDialogBrowse productBrowse'
                                                            ])?>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= Html::textInput('uomName', '', [
                                                        'class' => 'form-control productDetailInput-3 text-center',
                                                        'readonly' => 'readonly'
                                                    ]) ?>
                                                </div>
                                            </div>   
                                        </td>
                                        <td class="visibility: hidden">
                                            <?= Html::textInput('uomID', '', [
                                                'class' => 'form-control productDetailInput-2',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= \yii\widgets\MaskedInput::widget([
                                                        'name' => 'returnedQty',
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
                                                        'class' => 'form-control productDetailReturnedQty text-right'
                                                        ],
                                                        
                                                    ]) ?>
                                                </div>
                                            </div>                                          
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'Price',
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
                                                    'class' => 'form-control priceUnit text-right',
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td style="text-align: center;">
                                          <?= Html::checkbox("tax", 0, ['class' => 'text-center taxInput']) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'subtotal',
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
                                                    'class' => 'form-control productDetailSubtotal text-right',
                                                    'readonly' => 'readonly'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= Html::textArea('notes', '', [
                                                'class' => 'form-control productDetailNotes',
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
                <div class="panel-heading">Transaction Summary</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'additionalInfo')->textArea(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label text-right">Sub Total</label>
                                    <?= Html::textInput('subtotal', '0,00', [
                                        'class' => 'form-control subTotalSummary text-right',
                                        'readonly' => 'readonly'
                                    ]) ?>
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label text-right">Tax Total</label>
                                    <?= Html::textInput('taxTotal', '0,00', [
                                        'class' => 'form-control taxTotalSummary text-right',
                                        'readonly' => 'readonly'
                                    ]) ?>
                                </div>
                                <div class="col-md-12">
                                    <?= $form->field($model, 'grandTotal')
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
                                                    'class' => 'form-control text-right grandTotalSummary',
                                                    'readonly' => 'readonly'
                                                ],
                                            ])?>
                                </div>
                            </div>
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
$tableDetail = \yii\helpers\Json::encode($model->joinPurchaseReturnDetail);
//var_dump($tableDetail);
//yii::$app->end();
$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/currency/check';
$checkCurrencyAjaxURL = Yii::$app->request->baseUrl. '/coa/checkcurrency';
$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "       <a class='btn btn-danger btn-sm btnDelete' href='#' style='width:80px;'><i class='glyphicon glyphicon-remove'></i> Delete</a>" +
DELETEROW;
}
$js = <<< SCRIPT

$(document).ready(function () {
    var initValue = $tableDetail;
    var taxValue = '0';

    var rowTemplate = "" +
        "<tr>" +
        "   <input type='hidden' class='tableDetailProductID' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' > " +
        "   <td class='text-left'>" +
        "       <div class='row'><div class='col-md-12'>" +   
        "           <input type='text' class='form-control tableDetailProductName' readonly='true' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][productName]' value='{{productName}}'> " +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control tableDetailUomName' readonly='true' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][uomName]' value='{{uomName}}' style=' margin-right:10px;'>" +
        "       </div></div>" + 
        "   </td>" +
        "       <input type='hidden' class='tableDetailUomID' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +
        "           <input type='text' class='form-control tableDetailReturnedQty' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][returnedQty]' value='{{returnedQty}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control tableDetailPrice text-right' readonly='true' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][Price]' value='{{Price}}'>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='tableDetailTaxValue' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][taxValue]' value='{{taxValue}}' > " +
        "       <input type='checkbox' class='tableDetailTax' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][tax]' onclick='return false' {{tax}} >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control tableDetailSubtotal text-right' readonly='true' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][subtotal]' value='{{subtotal}}'>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='text' class='form-control tableDetailNotes' name='TrPurchasereturnhead[joinPurchaseReturnDetail][{{Count}}][notes]' value='{{notes}}'>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        $deleteRow
        "       </div></div>" + 
        "   </td>" +
        "</tr>";

    initValue.forEach(function(entry) {
            addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qty.toString(), entry.Price.toString(),entry.tax.toString(),entry.taxValue.toString(), entry.totalAmount.toString(), entry.notes.toString());
    });
        
    calculateSummary();

    $('.selectSupplier').change(function(){
        $('.detail-table tbody').each(function() {
            $('tr', this).each(function () {
                $(this).remove();
            })
        });
    });
        
    $('.selectCoaNo').change(function(){
        var coaNo = $('.selectCoaNo').val();
        currencyID = getCurrency(coaNo);
        $('.selectCurrency').val(currencyID.currencyID);
    });

    $('.taxInput').change(function(){
        var subtotal = 0;
        var price = convertStringtoDecimal($('.priceUnit').val(), true);
        var returnedQty = convertStringtoDecimal($('.productDetailReturnedQty').val(), true);

        if($(this).is(":checked")) {
            subtotal = price*returnedQty*1.1;
            $('.productDetailSubtotal').val(subtotal);
        }
        else{
            subtotal = price*returnedQty;
            $('.productDetailSubtotal').val(subtotal);
        }
    });

    $('.productDetailReturnedQty').change(function(){
        var subtotal = 0;
        var price = convertStringtoDecimal($('.priceUnit').val(), true);
        var returnedQty = convertStringtoDecimal($('.productDetailReturnedQty').val(), true);

        if($('.taxInput').is(":checked")) {
            subtotal = price*returnedQty*1.1;
            $('.productDetailSubtotal').val(subtotal);
        }
        else{
            subtotal = price*returnedQty;
            $('.productDetailSubtotal').val(subtotal);
        }
    });
        
    $('.priceUnit').change(function(){
        var subtotal = 0;
        var price = convertStringtoDecimal($('.priceUnit').val(), true);
        var returnedQty = convertStringtoDecimal($('.productDetailReturnedQty').val(), true);

        if($('.taxInput').is(":checked")) {
            subtotal = price*returnedQty*1.1;
            $('.productDetailSubtotal').val(subtotal);
        }
        else{
            subtotal = price*returnedQty;
            $('.productDetailSubtotal').val(subtotal);
        }
    });

    $('.detail-table .btnAdd').on('click', function (e) {
        e.preventDefault();
        var productID = $('.productIDInput').val();
        var productName = $('.productDetailInput-0').val();
        var uomID = $('.productDetailInput-2').val();
        var uomName = $('.productDetailInput-3').val();
        var returnedQty = $('.productDetailReturnedQty').val();
        var price = $('.priceUnit').val();
        var tax = '';
        var subtotal = $('.productDetailSubtotal').val();
        var notes = $('.productDetailNotes').val();

        if($('.taxInput').is(':checked')){
            tax = 'checked';
            taxValue = '10';
        }else{
            taxValue = '0';
            tax = '';
        }               
        returnedQty = replaceAll(returnedQty, ".", "");
        returnedQty = replaceAll(returnedQty, ",", ".");
        
        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        
        subtotal = replaceAll(subtotal, ".", "");
        subtotal = replaceAll(subtotal, ",", ".");

        var returnedQtyStr = returnedQty;
        var priceStr = price;
        var subtotalStr = subtotal;
        
        if(productID=="" || productID==undefined){
            bootbox.alert("Select Product");
            $('.productDetailInput-0').focus();
            return false;
        }
        
        if (!validateProductID(productID,'.productDetailInput-0', true, '.tableDetailProductID')) {
            return false;
        }

        if(returnedQty=="" || returnedQty==undefined || returnedQty=="0"){
            bootbox.alert("Qty must be greater than 0");
            $('.productDetailReturnedQty').focus();
            return false;
        }

        if(!$.isNumeric(returnedQty)){
            bootbox.alert("Qty must be numeric");
            $('.productDetailReturnedQty').focus();
            return false;
        }

        returnedQty = parseFloat(returnedQty);

        if(returnedQty < 1){
            bootbox.alert("Qty must be greater than 0");
            $('.productDetailReturnedQty').focus();
            return false;
        }
        addRow(productID, productName, uomID, uomName, returnedQtyStr, priceStr, tax, taxValue,subtotalStr, notes);
        calculateSummary();
        $('.productIDInput').val('');
        $('.productDetailInput-0').val('');
        $('.productDetailInput-2').val('');
        $('.productDetailInput-3').val('');
        $('.priceUnit').val('0,00');
        $('.productDetailReturnedQty').val('0,00');
        $('.productDetailSubtotal').val('0,00');
        $('.productDetailNotes').val('');
        $('.taxInput').prop("checked", false);
    });

    $('.btnSave').on('click', function (e) {
        var taxInvoice = $('.taxInvoiceNum').val();
        var taxValue = 0;
        var qtyReceivedError = 0;
        var countRow = 0;

        $('.detail-table tbody').each(function() {
            $('tr', this).each(function () { 
                var tax = $(this).find("input.tableDetailTaxValue").val();
                tax = replaceAll(tax, ".", "");
                tax = replaceAll(tax, ",", ".");
                tax = parseFloat(tax);
                if (isNaN(tax)){
                    tax = parseFloat(0);
                }
                if(tax == 0){
                    taxValue = 0;
                } else {
                    taxValue = 1;
                }
                
                
        
                var qtyReceived = $(this).find("input.tableDetailReturnedQty").val();                 
                qtyReceived = replaceAll(qtyReceived, ".", "");
                qtyReceived = replaceAll(qtyReceived, ",", ".");
                qtyReceived = parseFloat(qtyReceived);
                if (isNaN(qtyReceived)){
                    qtyReceived = parseFloat(0);
                }

                if(qtyReceived == 0){
                    qtyReceivedError = qtyReceivedError+1;
                }
                countRow = countRow + 1;
            });
            
        });        
        if(qtyReceivedError == countRow){
            bootbox.alert("Minimal one product must be filled with received qty larger than 0");
            return false;
        }
        taxInvoice = replaceAll(taxInvoice, ".", "");
        taxInvoice = replaceAll(taxInvoice, ",", ".");
        taxInvoice = parseFloat(taxInvoice);
        if(taxInvoice == 0){
            taxInvoice = 0;
        }else{
            taxInvoice = 1;
        }
        
        if(taxInvoice == 0 && taxValue == 1 ){
            bootbox.alert("Tax Invoice is a must if there is tax value");
            $('.taxInvoiceNum').focus();
            return false;
        }

    });

    $('.detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
            calculateSummary();
        }
    });

    function addRow(productID, productName, uomID, uomName, returnedQty, Price, tax, taxValue, subtotal, notes){
        var template = rowTemplate;
        returnedQty = replaceAll(returnedQty, ".", ",");
        Price = replaceAll(Price, ".", ",");
        subtotal = replaceAll(subtotal, ".", ",");
        
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{returnedQty}}', formatNumber(returnedQty));
        template = replaceAll(template, '{{Price}}', formatNumber(Price));        
        template = replaceAll(template, '{{tax}}', tax);
        template = replaceAll(template, '{{taxValue}}', formatNumber(taxValue));
        template = replaceAll(template, '{{subtotal}}', formatNumber(subtotal));
        template = replaceAll(template, '{{notes}}', notes);
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        
        $('.detail-table tbody').append(template);
    }
    
    function calculateSummary()
    {
        var tempPrice = 0;
        var tempTax = 0;
        var tempSubtotal = 0;
        var grandTotal = 0;

        $('.detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var qty = $(this).find("input.tableDetailReturnedQty").val();
                var price = $(this).find("input.tableDetailPrice").val();
                var taxValue = $(this).find("input.tableDetailTaxValue").val();
                var subtotal = $(this).find("input.tableDetailSubtotal").val();
                        
                qty = replaceAll(qty, ".", "");
                qty = replaceAll(qty, ",", ".");
                qty = parseFloat(qty);
        
                price = replaceAll(price, ".", "");
                price = replaceAll(price, ",", ".");
                price = parseFloat(price);

                taxValue = parseFloat(taxValue);

                subtotal = replaceAll(subtotal, ".", "");
                subtotal = replaceAll(subtotal, ",", ".");
                subtotal = parseFloat(subtotal);
                
                tempPrice = tempPrice + price * qty;

                tempTax = tempTax + ((price * qty) * taxValue/100);

                tempSubtotal = tempPrice;
            })
        });
        
        grandTotal = tempSubtotal + tempTax;
        
        tempSubtotal = tempSubtotal.toFixed(2);
        tempSubtotal = replaceAll(tempSubtotal, ".", ",");
        
        tempTax = tempTax.toFixed(2);
        tempTax = replaceAll(tempTax, ".", ",");

        grandTotal = grandTotal.toFixed(2);
        grandTotal = replaceAll(grandTotal, ".", ",");
        
        $('.subTotalSummary').val(formatNumber(tempSubtotal));
        $('.taxTotalSummary').val(formatNumber(tempTax));
        $('.grandTotalSummary').val(formatNumber(grandTotal));
    }
        
    function getCurrency(coaNo){
        var currencyID = '';
        $.ajax({
            url: '$checkCurrencyAjaxURL',
            async: false,
            type: 'POST',
            dataType: 'json',
            data: { coaNo: coaNo },
            success: function(data) {
                currencyID = data;
            }
         });
        return currencyID;
    }

    function productIDExistsInTable(barcode){
        var exists = false;
        $('.purchaseDetailproductID').each(function(){
            if($(this).val() == barcode){
                exists = true;
            }
        });
        return exists;
    }

    function getMaximumCounter() {
        var maximum = 0;
         $('.tableDetailProductID').each(function(){
            value = parseInt($(this).attr('data-key'));
            if(value > maximum){
                maximum = value;
            }
        });
        return maximum;
    }

    $('form').on("beforeValidate", function(){
        
    });
});
SCRIPT;
$this->registerJs($js);
?>