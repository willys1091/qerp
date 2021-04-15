<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\MsCustomer;
use app\models\MsCustomerdetail;
use app\models\MsMarketing;
use app\models\MsCurrency;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use endrikexe\ClientScript;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\TrSalesquotationhead */
/* @var $form yii\widgets\ActiveForm */

$destination = [
        'Gudang' => 'Gudang',
        'Kantor' => 'Kantor',
];
?>

<div class="tr-salesquotationhead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Sales Order Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'refNum', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['sales-quotation/browse'], [
                                            'title' => 'Sales Quotation Code',
                                            'data-target-value' => '.refNum',
                                            'data-target-text' => '.salesDetail',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse supplierBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refNum', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'salesOrderDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'customerOrderNum')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'customerID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCustomer::find(['flagActive' => 1])->orderBy(new yii\db\Expression("REPLACE(customerName, ' ', '') ASC"))->all(), 'customerID', 'customerName'),
                                    'options' => [
                                        'prompt' => 'Select Customer',
                                        'class' => 'form-control selectCustomer salesDetail-1'
                                        ],
                                ]);
                            ?>
                            <?= $form->field($model, 'tax')->hiddenInput(['maxlength' => true, 'id'=>'tax'])->label(false) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'contactPerson')->widget(Select2::classname(),[
                                    'initValueText' => 'No Data',
                                    'options' => [
                                        'prompt' => 'Select Contact Person',
                                        'class' => 'contactPerson'
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'dueDate')->widget(DatePicker::className(), 
                                    AppHelper::getDatePickerConfig(['disabled' => isset($isView),
                                'options' => [
                                    'class' => 'form-control',
                                    'id' => 'dueDates'
                                ]])) 
                            ?>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'deliveryDestination')->widget(Select2::classname(),[
                                    'data' => $destination,
                                    'options' => [
                                        'prompt' => 'Select Destination',
                                        'class' => 'form-control'
                                        ],
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Order Detail</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table table-bordered sales-detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%;">Product Name</th>
                                        <th style="width: 10%;">Unit</th>
                                        <th style="width: 10%;">Qty</th>
                                        <th style="text-align: right; width: 15%;">Unit Price</th>
                                        <th style="width: 10%;">Discount (%)</th>
                                        <th class="subTotals" style="text-align: right; width: 20%;">Total Price</th>
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
                                            <?= Html::textInput('qty', '', [
                                                'class' => 'form-control productDetailInput-2 text-center',
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'price',
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
                                                    'class' => 'form-control productDetailInput-3 text-right'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'discount',
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
                                                    'class' => 'form-control productDetailInputDiscount text-right'
                                                ],
                                                                                        ]) ?>
                                        </td>
                                        <td>
                                            <?= \kartik\money\MaskMoney::widget([
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
                            <?= $form->field($model, 'additionalInfo')->textArea(['maxlength' => true]) ?>
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
$salesDetail = \yii\helpers\Json::encode($model->joinSalesOrderDetail);
$checkDueDateAjaxURL = Yii::$app->request->baseUrl. '/customer/check';
$checkProductAjaxURL = Yii::$app->request->baseUrl. '/product/get';
$getContactPersonAjaxUrl = Yii::$app->request->baseUrl. '/customer/get-contact-person';
$refNumAjaxURL = Yii::$app->request->baseUrl. '/sales-order/check';
$urlGetProductByQty = Url::to('getproductbyqty');
$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "   <td class='text-center'>" +
            "       <a class='btn btn-danger btn-sm btnDelete' href='#'><i class='glyphicon glyphicon-remove'></i>Delete</a>" +
            "   </td>" +
DELETEROW;
}

ClientScript::singleton()->beginScript('js');
?>
<script>
$(document).ready(function () {
    var initValue = <?= $salesDetail ?>;
    var taxRate = '10.00';
    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='salesDetailBarcodeNumber' name='TrSalesorderhead[joinSalesOrderDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <input type='hidden' class='salesDetailProductName' name='TrSalesorderhead[joinSalesOrderDetail][{{Count}}][productName]' value='{{productName}}' > {{productName}}" +
        "   </td>" +
        "       <input type='hidden' class='salesDetailUomID' name='TrSalesorderhead[joinSalesOrderDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='salesDetailUomID' name='TrSalesorderhead[joinSalesOrderDetail][{{Count}}][uomName]' value='{{uomName}}' > {{uomName}}" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-center salesDetailQty' name='TrSalesorderhead[joinSalesOrderDetail][{{Count}}][qty]' value='{{qty}}' >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-right salesDetailPrice' name='TrSalesorderhead[joinSalesOrderDetail][{{Count}}][price]' value='{{price}}' >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-center salesDetailDiscount' name='TrSalesorderhead[joinSalesOrderDetail][{{Count}}][discount]' value='{{discount}}' >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-right salesDetailSubTotal' readonly='true' name='TrSalesorderhead[joinSalesOrderDetail][{{Count}}][priceOffer]' value='{{priceOffer}}' >" +
        "   </td>" +
            <?= $deleteRow ?>
        "</tr>";

        $(function() {
        $('.salesDetailSubTotal').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
        });
  
    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qty.toString(), entry.price.toString(), entry.discount.toString(), entry.priceOffer.toString());
        calculateSummary();
              
    });
    
    $(function() {
        $('.salesDetailSubTotal').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
    });
    
    $('.selectCustomer').change(function (e) {
        var customerID = $(this).val();
        $.ajax({
            url: '<?=$getContactPersonAjaxUrl?>',
            async: false,
            type: 'POST',
            data: { customerID: customerID },
            success: function(data) {
                refillDataSelect2(data,'.contactPerson');
            }
         });
         
        var dueDate = '';
        $.ajax({
            url: '<?=$checkDueDateAjaxURL?>',
            async: false,
            type: 'POST',
            data: { customerID: customerID },
            success: function(data) {
               
                var data = $.parseJSON(data);
                //$('#dueDates').val(0).change();
                $('#tax').val(data[1]).change();
                 
            }
         });
        return dueDate;
    });
    
    $('.refNum').change(function(){
        var refNum = $('.refNum').val();
        $('.sales-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                $(this).remove();
            })
        });
        var result = getSalesDetails(refNum);
        
        result.forEach(function(entry) {
            console.log("Menambahkan : " + entry.price.toString());
            addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qty.toString(), entry.price.toString(), entry.discount.toString(), entry.priceOffer.toString());
            calculateSummary();
        });
    });

     $('.salesDetailSubTotal').change(function () {
        calculateSummary();
     });
    
    $('.selectCurrency').change(function(){
        var currencyID = $('.selectCurrency').val();
        currencyRate = getCurrencyRate(currencyID);
        console.log("currency rate: "+currencyRate);
        currencyRate = replaceAll(currencyRate, ".", ",");
        currencyRate = replaceAll(currencyRate, '"', "");

        $('.currencyRate').val(formatNumber(currencyRate));
    });

    $('.productDetailInput-2').change(function(){
        var qty = $('.productDetailInput-2').val();
        var price = $('.productDetailInput-3').val();
        var discount = $('.productDetailInputDiscount').val();
        console.log(price);
        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        price = parseFloat(price);
        if (isNaN(price)){
            price = parseFloat(0);
        }
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");
        qty = parseFloat(qty);
        if (isNaN(qty)){
            qty = parseFloat(0);
        }
        discount = replaceAll(discount, ".", "");
        discount = replaceAll(discount, ",", ".");
        discount = parseFloat(discount);
        if (isNaN(discount)){
            discount = parseFloat(0);
        }
        
        var subTotal = qty*(price*(100-discount)/100);
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        $('.productDetailInputPriceOffer').val(formatNumber(subTotal));
    });
    
    $('.productDetailInput-3').change(function(){
        var qty = $('.productDetailInput-2').val();
        var price = $('.productDetailInput-3').val();
        var discount = $('.productDetailInputDiscount').val();
        
        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        price = parseFloat(price);
        if (isNaN(price)){
            price = parseFloat(0);
        }
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");
        qty = parseFloat(qty);
        if (isNaN(qty)){
            qty = parseFloat(0);
        }
        discount = replaceAll(discount, ".", "");
        discount = replaceAll(discount, ",", ".");
        discount = parseFloat(discount);
        if (isNaN(discount)){
            discount = parseFloat(0);
        }
        
        var subTotal = qty*(price*(100-discount)/100);
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        $('.productDetailInputPriceOffer').val(formatNumber(subTotal));
    });

    $('.productDetailInputDiscount').change(function(){
        var qty = $('.productDetailInput-2').val();
        var price = $('.productDetailInput-3').val();
        var discount = $('.productDetailInputDiscount').val();
        
        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        price = parseFloat(price);
        if (isNaN(price)){
            price = parseFloat(0);
        }
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");
        qty = parseFloat(qty);
        if (isNaN(qty)){
            qty = parseFloat(0);
        }
        discount = replaceAll(discount, ".", "");
        discount = replaceAll(discount, ",", ".");
        discount = parseFloat(discount);
        if (isNaN(discount)){
            discount = parseFloat(0);
        }
        
        var subTotal = qty*(price*(100-discount)/100);
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        $('.productDetailInputPriceOffer').val(formatNumber(subTotal));
    });
    
    $('.sales-detail-table .btnAdd').on('click', function (e) {
        e.preventDefault();
        var productID = $('.productIDInput').val();
        var productName = $('.productDetailInput-0').val();
        var uomID = $('.productDetailInput-4').val();
        var uomName = $('.productDetailInput-1').val();
        var qty = $('.productDetailInput-2').val();
        var price = $('.productDetailInput-3').val();
        var discount = $('.productDetailInputDiscount').val();
        var subTotal = $('.productDetailInputPriceOffer').val();
       
        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        
        subTotal = replaceAll(subTotal, ".", "");
        subTotal = replaceAll(subTotal, ",", ".");
        
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");

        discount = replaceAll(discount, ".", "");
        discount = replaceAll(discount, ",", ".");
        
        var qtyStr = qty;
        var priceStr = price;
        var discountStr = discount;
        var subTotalStr = subTotal;
        
        if(productID=="" || productID==undefined){
            bootbox.alert("Select Product");
            $('.barcodeNumberInput').focus();
            return false;
        }
        
        if(barcodeNumberExistsInTable(productID)){
            bootbox.alert("Product has been registered in table");
            $('.productIDInput').focus();
            return false;
        }

        if(qty=="" || qty==undefined || qty=="0"){
            bootbox.alert("Qty must be greater than 0");
            $('.productDetailInput-2').focus();
            return false;
        }

        if(!$.isNumeric(qty)){
            bootbox.alert("Qty must be numeric");
            $('.productDetailInput-2').focus();
            return false;
        }

        qty = parseFloat(qty);

        if(qty < 1){
            bootbox.alert("Qty must be greater than 0");
            $('.productDetailInput-2').focus();
            return false;
        }
        
        if(price=="" || price==undefined){
            bootbox.alert("Price must be greater than or equal 0");
            $('.productDetailInput-3').focus();
            return false;
        }

        if(!$.isNumeric(price)){
            bootbox.alert("Price must be numeric");
            $('.productDetailInput-3').focus();
            return false;
        }

        price = parseFloat(price);

        if(price < 0){
            bootbox.alert("Price must be positive number");
            $('.productDetailInput-3').focus();
            return false;
        }

        discount = parseFloat(discount);
        
        if(discount < 0 || discount > 100){
            bootbox.alert("Discount must be between 0 and 100");
            return false;
        }  
        addRow(productID, productName, uomID, uomName, qtyStr, priceStr, discountStr, subTotalStr);
        calculateSummary();
        $('.productIDInput').val('');
        $('.productDetailInput-4').val('');
        $('.productDetailInput-0').val('');
        $('.productDetailInput-1').val('');
        $('.productDetailInput-2').val('0,00');
        $('.productDetailInput-3').val('0,00');
        $('.productDetailInputDiscount').val('0,00');
        $('.productDetailInputPriceOffer').val('0,00');
    });

    $('.sales-detail-table').on('change', '.salesDetailQty', function (e) {
        var self = this;
        var refNum = $('#trsalesorderhead-refnum').val();
        var productID = $(self).parents().parents('tr').find('.salesDetailBarcodeNumber').val();
        var qty = $(self).parents().parents('tr').find('.salesDetailQty').val();
        var $price = $(self).parents().parents('tr').find('.salesDetailPrice');
        var $discount = $(self).parents().parents('tr').find('.salesDetailDiscount');

        $.ajax({
            url: '<?=$urlGetProductByQty?>',
            async: false,
            type: 'GET',
            data: { id: refNum, productID: productID, qty: qty.replaceAll('.', '').replaceAll(',', '.') },
            success: function(result) {
                var result = result;
                //$price.val(parseFloat(result.priceOffer).formatMoney());
                $discount.val(parseFloat(result.discount).formatMoney());
            }
        });
        var price = $price.val();
        var discount = $discount.val();
        
        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        price = parseFloat(price);
        if (isNaN(price)){
            price = parseFloat(0);
        }
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");
        qty = parseFloat(qty);
        if (isNaN(qty)){
            qty = parseFloat(0);
        }
        discount = replaceAll(discount, ".", "");
        discount = replaceAll(discount, ",", ".");
        discount = parseFloat(discount);
        if (isNaN(discount)){
            discount = parseFloat(0);
        }
        
        var subTotal = qty*(price*(100-discount)/100);
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        qty = qty.toFixed(2);
        qty = replaceAll(qty, ".", ",");
        $(self).parents().parents('tr').find('.salesDetailQty').val(formatNumber(qty));
        $(self).parents().parents('tr').find('.salesDetailSubTotal').val(formatNumber(subTotal));
    });

    $('.sales-detail-table').on('change', '.salesDetailPrice', function (e) {
        var self = this;
        var qty = $(self).parents().parents('tr').find('.salesDetailQty').val();
        var price = $(self).parents().parents('tr').find('.salesDetailPrice').val();
        var discount = $(self).parents().parents('tr').find('.salesDetailDiscount').val();

        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        price = parseFloat(price);
        if (isNaN(price)){
            price = parseFloat(0);
        }
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");
        qty = parseFloat(qty);
        if (isNaN(qty)){
            qty = parseFloat(0);
        }
        discount = replaceAll(discount, ".", "");
        discount = replaceAll(discount, ",", ".");
        discount = parseFloat(discount);
        if (isNaN(discount)){
            discount = parseFloat(0);
        }
        
        var subTotal = qty*(price*(100-discount)/100);
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        price = price.toFixed(2);
        price = replaceAll(price, ".", ",");
        $(self).parents().parents('tr').find('.salesDetailPrice').val(formatNumber(price));
        $(self).parents().parents('tr').find('.salesDetailSubTotal').val(formatNumber(subTotal));
    });

    $('.sales-detail-table').on('change', '.salesDetailDiscount', function (e) {
        var self = this;
        var qty = $(self).parents().parents('tr').find('.salesDetailQty').val();
        var price = $(self).parents().parents('tr').find('.salesDetailPrice').val();
        var discount = $(self).parents().parents('tr').find('.salesDetailDiscount').val();

        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        price = parseFloat(price);
        if (isNaN(price)){
            price = parseFloat(0);
        }
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");
        qty = parseFloat(qty);
        if (isNaN(qty)){
            qty = parseFloat(0);
        }
        discount = replaceAll(discount, ".", "");
        discount = replaceAll(discount, ",", ".");
        discount = parseFloat(discount);
        if (isNaN(discount)){
            discount = parseFloat(0);
        }
        
        var subTotal = qty*(price*(100-discount)/100);
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        discount = discount.toFixed(2);
        discount = replaceAll(discount, ".", ",");
        $(self).parents().parents('tr').find('.salesDetailDiscount').val(formatNumber(discount));
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
    
    function getSalesDetails(refNum){
        var salesDetail = [];

        $.ajax({
            url: '<?=$refNumAjaxURL?>',
            async: false,
            type: 'POST',
            data: { refNum: refNum },
            success: function(result) {
                var result = result;
                salesDetail = result;
            }
         });
        return salesDetail;
    }

    function getDueDate(customerID){
        var dueDate = '';
        $.ajax({
            url: '<?=$checkDueDateAjaxURL?>',
            async: false,
            type: 'POST',
            data: { customerID: customerID },
            success: function(data) {
                dueDate = data;
                
            }
         });
        return dueDate;
    }

    function addRow(productID, productName, uomID, uomName, qty, price, discount, subTotal){
        var template = rowTemplate;
        price = replaceAll(price, ".", ",");
        qty = replaceAll(qty, ".", ",");
        discount = replaceAll(discount, ".", ",");
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
        
        $(function() {
        $('.salesDetailSubTotal').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
        });
    }
    
    function barcodeNumberExistsInTable(barcode){
        var exists = false;
        $('.salesDetailBarcodeNumber').each(function(){
            if($(this).val() == barcode){
                exists = true;
            }
        });
        return exists;
    }
    
    function calculateSummary()
    {
        var subTotal = 0;
        var taxTotal = 0;
        var grandTotal = 0;
        var discTotal = 0;
        var tempDiscTotal = 0;
        var tax = $('#tax').val();
        console.log(tax);
        $('.sales-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var qty = $(this).find("input.salesDetailQty").val();
                var price = $(this).find("input.salesDetailPrice").val();
                var discount = $(this).find("input.salesDetailDiscount").val();
                
                qty = replaceAll(qty, ".", "");
                qty = replaceAll(qty, ",", ".");
                qty = parseFloat(qty);
                price = replaceAll(price, ".", "");
                price = replaceAll(price, ",", ".");
                price = parseFloat(price);
                discount = replaceAll(discount, ".", "");
                discount = replaceAll(discount, ",", ".");
                discount = parseFloat(discount);
                tempDiscTotal = qty*price*(discount/100);
                
                discTotal = discTotal + tempDiscTotal;
                subTotal = subTotal + qty*price;
                console.log(tax);
                console.log('aoaoao');
                if(tax == 'false'){
                    taxTotal = 0,00;
                     
                } else {
                    taxTotal = taxTotal + ((subTotal-discTotal)*10/100);
                }
            })
        });
        
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
            
        if(grandTotal == '0,00' || grandTotal ==""){
            bootbox.alert("Data cannot be saved because grand total 0");
            return false;
        }
    });
    
    $('.taxInput').change(function(){
        var taxID = $('.selectTax').val();
        taxRate = '10.00';
        taxRate = replaceAll(taxRate, ".", ",");
        taxRate = replaceAll(taxRate, '"', "");
        $('.sales-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var tax = $(this).find("input.salesDetailTax").prop('checked');
                if (tax){
                    $(this).find("input.salesDetailTaxValue").val(formatNumber(taxRate));
                    console.log("tax checkbox: "+$(this).find("input.salesDetailTaxValue").val());
                }
            })
          });
        });
        
    $('form').focusout(function(){
        calculateSummary();
    });
});
</script>

<?php ClientScript::singleton()->endScript(); ?>
