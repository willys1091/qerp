<?php

use app\components\AppHelper;
use app\models\MsCurrency;
use app\models\MsCustomer;
use app\models\MsCustomerdetail;
use app\models\MsMarketing;
use dosamigos\ckeditor\CKEditor;
use kartik\money\MaskMoney;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\MaskedInput;

?>

<div class="tr-salesquotationhead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Sales Quotation Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'salesQuotationDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'marketingID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsMarketing::find()->where('flagActive = 1')->all(), 'marketingID', 'marketingName' ),
                                    'options' => [
                                        'prompt' => 'Select Marketing Name'],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'customerID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCustomer::find(['flagActive' => 1])->orderBy(new yii\db\Expression("REPLACE(customerName, ' ', '') ASC"))->all(), 'customerID', 'customerName'),
                                    'options' => [
                                        'prompt' => 'Select Customer Name',
                                        'class' => 'form-control selectCustomer'
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'contactPerson')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCustomerDetail::find()->andWhere(['customerID' => $model->customerID])->all(), 'contactPerson', 'contactPerson' ),
                                    'options' => [
                                        'prompt' => 'Select Contact Person',
                                        'class' => 'contactPerson'
                                    ],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'delivery')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'payment')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'cc')->widget(Select2::classname(), [
                                    'options' => [
                                        'multiple' => true,
                                        'class' => 'cc'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'attachment')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'currencyID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCurrency::find()->where('flagActive = 1')->all(), 'currencyID', 
                                    function($model, $defaultValue) {
                                        return $model['currencyID'].' - '.$model['currencyName'];
                                    } ),
                                    'options' => [
                                        'prompt' => 'Select Currency',
                                        'class' => 'form-control selectCurrency'],
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Quotation Detail</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table table-bordered sales-detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="text-align: left; width: 20%;">Product Name</th>
                                        <th style="width: 10%;">Unit</th>
                                        <th style="text-align: right; width: 10%;">Qty</th>
                                        <th style="text-align: right; width: 15%;">Unit Price </th>
                                        <th style="text-align: right; width: 10%;">Discount (%)</th>
                                        <th class="subTotals" style="text-align: right; width: 20%;">Total Offer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <?php if (!isset($isView)): ?>
                                    <tfoot class="tfoot">
                                    <tr>
                                        <td class="visibility: hidden">
                                            <?= Html::hiddenInput('productID', '', [
                                                'class' => 'form-control productIDInput',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="newinput-group">
                                            <?= Html::textInput('productName', '', [
                                                'class' => 'form-control productDetailInput-0',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                            <div class="input-group-btn">
                                                    <?= Html::a("...", ['product/browse'], [
                                                        'data-filter-input' => '.productDetailInputName',
                                                        'data-target-value' => '.productIDInput',
                                                        'data-target-text' => '.productDetailInput',
                                                        'data-target-width' => '1000',
                                                        'data-target-height' => '600',
                                                        'class' => 'btn btn-primary btn-sm WindowDialogBrowse browseProduct'
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="visibility: hidden">
                                            <?= Html::textInput('uomID', '', [
                                                'class' => 'form-control productDetailInput-4',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= Html::textInput('uomName', '', [
                                                'class' => 'form-control productDetailInput-1 text-center',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= MaskedInput::widget([
                                                'name' => 'qty',
                                                'value' => '0,00',
                                                'clientOptions' => AppHelper::getDecimalClientOptionConfig(),
                                                'options' => [
                                                    'class' => 'form-control productDetailInputQty text-center'
                                                ],

                                            ])
                                            ?>
                                        </td>
                                        <td>
                                            <?= MaskedInput::widget([
                                                'name' => 'price',
                                                'value' => '0,00',
                                                'clientOptions' => AppHelper::getDecimalClientOptionConfig(),
                                                'options' => [
                                                    'class' => 'form-control productDetailInput-3 text-right'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= MaskedInput::widget([
                                                'name' => 'discount',
                                                'value' => '0,00',
                                                'clientOptions' => AppHelper::getDecimalClientOptionConfig(),
                                                'options' => [
                                                    'class' => 'form-control productDetailInputDiscount text-right'
                                                ],
                                                ]) 
                                            ?>
                                        </td>
                                        <td>
                                            <?= MaskMoney::widget([
                                                'name' => 'priceOffer',
                                                'disabled' => true,
                                                'options' => [
                                                    'class' => 'form-control productDetailInputPriceOffer text-right'
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

            <div class="panel panel-default">
                <div class="panel-heading">Transaction Summary</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                           <?= $form->field($model, 'additionalInfo')->widget(CKEditor::className(), [
                                'options' => ['rows' => 6],
                                'preset' => 'standard',
                                'clientOptions'=>[
                                    'enterMode' => 2,
                                    'forceEnterMode'=>false,
                                    'shiftEnterMode'=>1
                                ]
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                <label class="control-label text-right">Sub Total</label>
                                    <?= Html::textInput('subTotal', '0,00', [
                                            'class' => 'form-control subTotalSummary text-right',
                                            'readonly' => 'readonly'
                                        ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label text-right">Discount Total</label>
                                    <?= Html::textInput('discountTotal', '0,00', [
                                            'class' => 'form-control discount discountTotalSummary text-right',
                                            'readonly' => 'readonly'
                                        ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label text-right">Tax Total</label>
                                    <?= Html::textInput('taxTotal', '0,00', [
                                            'class' => 'form-control taxTotalSummary text-right',
                                            'readonly' => 'readonly'
                                        ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="font-size: 18px; font-weight: bold;">
                                    <?= $form->field($model, 'grandTotal')->textInput([
                                            'maxlength' => true, 
                                            'readonly' => true,
                                            'class' => 'grandTotalSummary text-right',
                                            'style' => 'font-size: 18px',
                                    ]) ?>
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
$salesDetail = Json::encode($model->joinSalesQuotationDetail);
$getContactPersonAjaxUrl = Yii::$app->request->baseUrl. '/customer/get-contact-person';
$getContactPersonSalesQuotationAjaxUrl = Yii::$app->request->baseUrl. '/sales-quotation/get-contact-person';

$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "   <td class='text-center'>" +
            "       <a class='btn btn-danger btn-sm btnDelete' href='#'><i class='glyphicon glyphicon-remove'></i></a>" +
            "   </td>" +
DELETEROW;
}

$js = <<< SCRIPT

$(document).ready(function () {
    var initValue = $salesDetail;
    var taxRate = '10.00';
    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='salesDetailBarcodeNumber' name='TrSalesquotationhead[joinSalesQuotationDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <input type='hidden' class='salesDetailProductName' name='TrSalesquotationhead[joinSalesQuotationDetail][{{Count}}][productName]' value='{{productName}}' > {{productName}}" +
        "   </td>" +
        "       <input type='hidden' class='salesDetailUomID' name='TrSalesquotationhead[joinSalesQuotationDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='salesDetailUomID' name='TrSalesquotationhead[joinSalesQuotationDetail][{{Count}}][uomName]' value='{{uomName}}' > {{uomName}}" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-right maskedInput salesDetailQty' name='TrSalesquotationhead[joinSalesQuotationDetail][{{Count}}][qty]' value='{{qty}}' >" + 
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-right maskedInput salesDetailPrice' name='TrSalesquotationhead[joinSalesQuotationDetail][{{Count}}][price]' value='{{price}}' >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-right maskedInput salesDetailDiscount' name='TrSalesquotationhead[joinSalesQuotationDetail][{{Count}}][discount]' value='{{discount}}' >" +
        "   </td>" +
        "   <td class='text-right'>" +
        "       <input type='text' class='form-control salesDetailSubTotal' readonly='true' name='TrSalesquotationhead[joinSalesQuotationDetail][{{Count}}][priceOffer]' value='{{priceOffer}}' >" +
        "   </td>" +
            $deleteRow
        "</tr>";
  
    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qty.toString(), entry.price.toString(), entry.discount.toString(), entry.priceOffer.toString());
        calculateSummary();
    });
    
    $(function() {
        $('.salesDetailSubTotal').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
    });

    $('.salesDetailSubTotal').change(function () {
        calculateSummary();
    });
    
    $('.selectCustomer').change(function (e) {
        var customerID = $(this).val();
        $.ajax({
            url: '$getContactPersonAjaxUrl',
            async: false,
            type: 'POST',
            data: { customerID: customerID },
            success: function(data) {
                refillDataSelect2(data,'.contactPerson');
                refillDataSelect2(data,'.cc');
            }
         });
    });
         
    $('.productDetailInputQty, .productDetailInput-3, .productDetailInputDiscount').change(function(){
        var qty = convertStringtoDecimal($('.productDetailInputQty').val(), true);
        var price = convertStringtoDecimal($('.productDetailInput-3').val(), true);
        var discount = convertStringtoDecimal($('.productDetailInputDiscount').val(), true);
        
        var subTotal = qty*(price*(100-discount)/100);
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        $('.productDetailInputPriceOffer').val(formatNumber(subTotal));
    });
    
    function clearDetails(){
        $('.productIDInput').val('');
        $('.productDetailInput-4').val('');
        $('.productDetailInput-0').val('');
        $('.productDetailInput-1').val('');
        $('.productDetailInput-2').val('0,00');
        $('.productDetailInput-3').val('0,00');
        $('.productDetailInputQty').val('0,00');
        $('.productDetailInputDiscount').val('0,00');
        $('.productDetailInputPriceOffer').val('0,00');
    }
    
    $('.sales-detail-table .btnAdd').on('click', function (e) {
        e.preventDefault();
        var productID = $('.productIDInput').val();
        var productName = $('.productDetailInput-0').val();
        var uomID = $('.productDetailInput-4').val();
        var uomName = $('.productDetailInput-1').val();
        var qty = convertStringtoDecimal($('.productDetailInputQty').val());
        var price = convertStringtoDecimal($('.productDetailInput-3').val());
        var discount = convertStringtoDecimal($('.productDetailInputDiscount').val());
        var subTotal = convertStringtoDecimal($('.productDetailInputPriceOffer').val());
        var taxValue = replaceAll(taxRate, '"', "");
               
        /*if (!validateProductID(productID,'.productDetailInput-0', true, '.salesDetailBarcodeNumber')) {
            return false;
        }*/
        
        if (!validateQuantity(qty, 'Quantity', '.productDetailInputQty', true, false)) {
            return false;
        }
        
        if (!validateQuantity(price, 'Price', '.productDetailInput-3', true, false)) {
            return false;
        }

        if(parseFloat(discount) < 0 || parseFloat(discount) > 100){
            bootbox.alert("Discount must be between 0 and 100");
            return false;
        }  
        
        addRow(productID, productName, uomID, uomName, qty, price, discount, subTotal);
        calculateSummary();
        clearDetails();
    });
    
    $('.sales-detail-table').on('change', '.salesDetailQty, .salesDetailPrice, .salesDetailDiscount', function (e) {
        var self = this;
        var qty = convertStringtoDecimal($(self).parents().parents('tr').find('.salesDetailQty').val(), true);
        var price = convertStringtoDecimal($(self).parents().parents('tr').find('.salesDetailPrice').val(), true);
        var discount = convertStringtoDecimal($(self).parents().parents('tr').find('.salesDetailDiscount').val(), true);
        
        var subTotal = qty*(price*(100-discount)/100);
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        $(self).parents().parents('tr').find('.salesDetailSubTotal').val(formatNumber(subTotal));
    });

    $('.sales-detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
            calculateSummary();
        }
    });
    
    function addRow(productID, productName, uomID, uomName, qty, price, discount, subTotal){
        var template = rowTemplate;
        price = replaceAll(price, ".", ",");
        discount = replaceAll(discount, ".", ",");
        qty = replaceAll(qty, ".", ",");
        subTotal = replaceAll(subTotal, ".", ",");
        
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{qty}}', formatNumber(qty));
        template = replaceAll(template, '{{price}}', formatNumber(price));
        template = replaceAll(template, '{{discount}}', formatNumber(discount));
        template = replaceAll(template, '{{priceOffer}}', formatNumber(subTotal));
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        $('.sales-detail-table tbody').append(template);
        
        $('.maskedInput').inputmask('decimal', {digits:2, digitsOptional:false, radixPoint:',', groupSeparator: '.', autoGroup:true, removeMaskOnSubmit:true});
        $('.salesDetailSubTotal').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
    }
    
    function calculateSummary()
    {
        var subTotal = 0;
        var discTotal = 0;
        var taxTotal = 0;
        var grandTotal = 0;
        var tempDiscTotal = 0;
        
        $('.sales-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var qty = convertStringtoDecimal($(this).find("input.salesDetailQty").val(), true);
                var price = convertStringtoDecimal($(this).find("input.salesDetailPrice").val(), true);
                var discount = convertStringtoDecimal($(this).find("input.salesDetailDiscount").val(), true);
                tempDiscTotal = qty*price*(discount/100);
                
                discTotal = discTotal + tempDiscTotal;
                subTotal = subTotal + (qty*price);
            })
        });
        
        taxTotal = taxTotal + ((subTotal-discTotal)*10/100);
        grandTotal = subTotal - discTotal + taxTotal;
        
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        
        discTotal = discTotal.toFixed(2);
        discTotal = replaceAll(discTotal, ".", ",");

        taxTotal = taxTotal.toFixed(2);
        taxTotal = replaceAll(taxTotal, ".", ",");
        
        grandTotal = grandTotal.toFixed(2);
        grandTotal = replaceAll(grandTotal, ".", ",");
        
        $('.subTotalSummary').val(formatNumber(subTotal));
        $('.discountTotalSummary').val(formatNumber(discTotal));
        $('.taxTotalSummary').val(formatNumber(taxTotal));
        $('.grandTotalSummary').val(formatNumber(grandTotal));
    }
    
    function getMaximumCounter() {
        var maximum = 0;
         $('.salesDetailBarcodeNumber').each(function(){
            value = parseInt($(this).attr('data-key'));
            if(value > maximum){
                maximum = value;
            }
        });
        return maximum;
    }
    
    $('form').on("beforeValidate", function(){
        var countData = $('.sales-detail-table tbody tr').length;
                var grandTotal = $('.grandTotalSummary').val();

        if(countData == 0){
            bootbox.alert("Minimum 1 detail must be filled");
            return false;
        }        
    });
    
    $('form').focusout(function(){
        calculateSummary();
    });
});
SCRIPT;
$this->registerJs($js);
?>
