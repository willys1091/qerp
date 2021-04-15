<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;
use app\models\MsCurrency;
use app\models\MsTax;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TrPurchaseordernoninventoryhead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-purchaseorderhead-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

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
                                            'title' => 'Purchase order Number',
                                            'data-filter-Input' => '',
                                            'data-target-value' => '.refNum',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse purchaseOrderBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refNum', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= Html::activeHiddenInput($model, 'supplierID', ['class' => 'supplierID']) ?>
                            <?= $form->field($model, 'supplierName', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['supplier/browse'], [
                                            'title' => 'Supplier Name',
                                            'data-target-value' => '.supplierID',
                                            'data-target-text' => '.supplierInput',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse supplierBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'supplierInput', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'purchaseOrderNonInventoryDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isView)])) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
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
                    </div>
                    <div class="row">               
                        <div class="col-md-4">
                            <?= $form->field($model, 'hasVAT')->widget(SwitchInput::classname(), [
                                'type' => SwitchInput::CHECKBOX,
                                'pluginOptions' => [
                                    'labelText' => '',
                                    'onText' => 'YES',
                                    'offText' => 'NO',
                                ],
                                'options' => [
                                    'class' => 'isVAT'
                                ], 
                                'pluginEvents' => [
                                    'switchChange.bootstrapSwitch' => 'function() { 
                                                                        if($(".isVAT").is(":checked")){
                                                                            $(".isVATValue").val(1);
                                                                            $(".isVATValue").change();
                                                                        }
                                                                        else{
                                                                            $(".isVATValue").val(0);
                                                                            $(".isVATValue").change();
                                                                        }                                                                                
                                                                    }'
                                ] 
                            ]); ?>
                            <?= Html::hiddenInput('isVATValue', 0, [
                                'class' => 'form-control isVATValue'
                            ]) ?>
                           
                        </div>
                        <div class="col-md-4 taxInvoiceGroup">
                            <?= $form->field($model, 'taxInvoice')->textInput([
                                    'maxlength' => true, 
                                    'class' => 'taxInvoice'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Purchase Order Non Inventory Detail</div>
                <div class="panel-body">
                    <div class="row" id="divPurchaseDetail">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-bordered purchase-detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="width: 25%;">Product Name</th>
                                        <th style="width: 10%;">Unit</th>
                                        <th style="width: 10%;">Qty</th>
                                        <th style="text-align: right; width: 15%;">Price</th>
                                        <th style="width: 10%;">Discount (%)</th>
                                        <th style="text-align: right; width: 20%;">Sub Total</th>
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
                                            <?= Html::hiddenInput('productID', '', [
                                                'class' => 'form-control hiddenInputTxtProduct'
                                            ]) ?>
                                            <div class = "newinput-group">
                                                <?= Html::textInput('productName', '', [
                                                    'class' => 'form-control productDetailInput-0'
                                                ]) ?>
                                                <div class="input-group-btn">
                                                    <?= Html::a("...",['product/browse-non-inventory'], [
                                                        'title' => 'Browse Product',
                                                        'data-filter-Input' => '',
                                                        'data-target-value' => '.productIDInput',
                                                        'data-target-text' => '.productDetailInput',
                                                        'data-target-width' => '1000',
                                                        'data-target-height' => '600',
                                                        'class' => 'btn btn-primary btn-sm WindowDialogBrowse',
                                                        'disabled' => isset($isView)
                                                    ]);?>
                                                </div>
                                            </div>         
                                        </td>
                                        <td class="visibility: hidden">
                                            <?= Html::textInput('uomID', '', [
                                                'class' => 'form-control productDetailInput-1',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= Html::textInput('uomName', '', [
                                                'class' => 'form-control productDetailInput-2 text-center',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'qty',
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
                                                'class' => 'form-control productDetailInput-3 text-right'
                                                ],                                                
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
                                                    'class' => 'form-control productDetailInput-4 text-right'
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
                                                'name' => 'subtotal',
                                                'disabled' => true,
                                                'options' => [
                                                'class' => 'form-control productDetailInputSubtotal text-right'
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
                <div class="panel-heading">Transaction Summary</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'additionalInfo')->textArea(['maxlength' => true]) ?>
                        </div>                  
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                   <?= $form->field($model, 'subtotal')->textInput([
                                            'maxlength' => true, 
                                            'readonly' => true,
                                            'class' => 'subtotalSummary text-right',
                                    ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                     <?= $form->field($model, 'discountTotal')->textInput([
                                            'maxlength' => true, 
                                            'readonly' => true,
                                            'class' => 'discountTotalSummary text-right',
                                    ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label text-right">VAT Tax</label>
                                    <?= Html::textInput('VATAmount', '0,00', [
                                            'class' => 'form-control VATAmountSummary text-right',
                                            'readonly' => 'readonly',
                                            'maxlength' => true, 
                                        ]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <?=
                                        $form->field($model, 'whtID')->widget(Select2::classname(),[
                                            'data' => ArrayHelper::map(MsTax::find()->where('flagActive = 1')->all(), 'taxID', 
                                            function($model, $defaultValue) {
                                                return $model['taxID'].' - '.$model['taxName'];
                                            } ),
                                            'options' => [
                                                'prompt' => 'Select Tax',
                                                'class' => 'form-control selectTax'],
                                        ]);
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'whtRate')->textInput([
                                            'maxlength' => true, 
                                            'class' => 'rate text-right',
                                    ]) ?>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'amount')->textInput([
                                            'maxlength' => true, 
                                            'class' => 'amount text-right',
                                            'readonly' => true,
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
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$purchaseDetail = \yii\helpers\Json::encode($model->joinPurchaseOrderDetail);
$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/currency/check';
$checkTaxRateAjaxURL = Yii::$app->request->baseUrl. '/tax/check';
$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "       <a class='btn btn-danger btn-sm btnDelete' href='#'><i class='glyphicon glyphicon-remove'></i>Delete</a>" +
DELETEROW;
}
$js = <<< SCRIPT
    $(document).ready(function () {
        
        var initValue = $purchaseDetail;

    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='purchaseDetailProductID' name='TrPurchaseordernoninventoryhead[joinPurchaseOrderDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <input type='hidden' class='purchaseDetailProductName' name='TrPurchaseordernoninventoryhead[joinPurchaseOrderDetail][{{Count}}][productName]' value='{{productName}}' > {{productName}}" +
        "   </td>" +
        "       <input type='hidden' class='purchaseDetailUomID' name='TrPurchaseordernoninventoryhead[joinPurchaseOrderDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='purchaseDetailUomID' name='TrPurchaseordernoninventoryhead[joinPurchaseOrderDetail][{{Count}}][uomName]' value='{{uomName}}' > {{uomName}}" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-center purchaseDetailQty' name='TrPurchaseordernoninventoryhead[joinPurchaseOrderDetail][{{Count}}][qty]' value='{{qty}}' >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='text-right form-control purchaseDetailPrice' name='TrPurchaseordernoninventoryhead[joinPurchaseOrderDetail][{{Count}}][price]' value='{{price}}' >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-center purchaseDetailDiscount' name='TrPurchaseordernoninventoryhead[joinPurchaseOrderDetail][{{Count}}][discount]' value='{{discount}}' >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='text-right form-control purchaseDetailSubTotal' name='TrPurchaseordernoninventoryhead[joinPurchaseOrderDetail][{{Count}}][subtotal]' value='{{subtotal}}' readonly>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        $deleteRow
        "       </div></div>" + 
        "   </td>" +
        "</tr>";

    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qty.toString(), entry.price.toString(), entry.discount.toString(), entry.subtotal.toString());
        calculateSummary();
    });
    
    $('.btnAdd').on('click', function (e) {
        e.preventDefault();
           $('.productDetailInput-0').focus();
     });

    $('.selectCurrency').change(function(){
        var currencyID = $('.selectCurrency').val();
        currencyRate = getCurrencyRate(currencyID);
        currencyRate = replaceAll(currencyRate, ".", ",");
        currencyRate = replaceAll(currencyRate, '"', "");
        $('.currencyRate').val(formatNumber(currencyRate));
    });
        
    $('.productDetailInput-3').change(function(){
        var qty = $('.productDetailInput-3').val();
        var price = $('.productDetailInput-4').val();
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
        
        var subtotal = qty*price*(100-discount)/100;
        subtotal = subtotal.toFixed(2);
        subtotal = replaceAll(subtotal, ".", ",");
        $('.productDetailInputSubtotal').val(formatNumber(subtotal));
    });
    
    $('.productDetailInput-4').change(function(){
        var qty = $('.productDetailInput-3').val();
        var price = $('.productDetailInput-4').val();
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

        var subtotal = qty*price*(100-discount)/100;
        subtotal = subtotal.toFixed(2);
        subtotal = replaceAll(subtotal, ".", ",");
        $('.productDetailInputSubtotal').val(formatNumber(subtotal));
    });
    
    $('.productDetailInputDiscount').change(function(){
        var qty = $('.productDetailInput-3').val();
        var price = $('.productDetailInput-4').val();
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
        
        var subtotal = qty*price*(100-discount)/100;
        subtotal = subtotal.toFixed(2);
        subtotal = replaceAll(subtotal, ".", ",");
        $('.productDetailInputSubtotal').val(formatNumber(subtotal));
    });

    $('.purchase-detail-table .btnAdd').on('click', function (e) {
        e.preventDefault();
        var productID = $('.productIDInput').val();
        var productName = $('.productDetailInput-0').val();
        var uomID = $('.productDetailInput-1').val();
        var uomName = $('.productDetailInput-2').val();
        var qty = $('.productDetailInput-3').val();
        var price = $('.productDetailInput-4').val();
        var discount = $('.productDetailInputDiscount').val();
        var subtotal = $('.productDetailInputSubtotal').val();

        price = replaceAll(price, ".", "");
        price = replaceAll(price, ",", ".");
        
        subtotal = replaceAll(subtotal, ".", "");
        subtotal = replaceAll(subtotal, ",", ".");
        
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");
        
        discount = replaceAll(discount, ".", "");
        discount = replaceAll(discount, ",", ".");
        
        console.log("format decimals");
        
        var qtyStr = qty;
        var priceStr = price;
        var discountStr = discount;
        var subtotalStr = subtotal;
        
        if(productID=="" || productID==undefined){
            bootbox.alert("Select Product");
            $('.productDetailInput-0').focus();
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

        if(discount=="" || discount==undefined){
            bootbox.alert("Discount must be between 0 and 100");
            return false;
        }

        if(!$.isNumeric(discount)){
            bootbox.alert("Discount must be numeric");
            return false;
        }

        discount = parseFloat(discount);
        
        if(discount < 0 || discount > 100){
            bootbox.alert("Discount must be between 0 and 100");
            return false;
        }   
        addRow(productID, productName, uomID, uomName, qtyStr, priceStr, discountStr, subtotalStr);
        calculateSummary();
        clearDetails();
    });
        
    function clearDetails(){
        $('.productIDInput').val('');
        $('.productDetailInput-0').val('');
        $('.productDetailInput-1').val('');
        $('.productDetailInput-2').val('');
        $('.productDetailInput-3').val('0,00');
        $('.productDetailInput-4').val('0,00');
        $('.productDetailInputDiscount').val('0,00');
        $('.productDetailInputSubtotal').val('0,00');
    }

    $('.purchase-detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
            calculateSummary();
        }
    });

    $('.purchase-detail-table').on('change', '.purchaseDetailQty', function (e) {
        var self = this;
        var qty = $(self).parents().parents('tr').find('.purchaseDetailQty').val();
        var price = $(self).parents().parents('tr').find('.purchaseDetailPrice').val();
        var discount = $(self).parents().parents('tr').find('.purchaseDetailDiscount').val();
        var subtotal = 0;
        
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
        
        subtotal = qty*price*(100-discount)/100;
        
        subtotal = subtotal.toFixed(2);
        subtotal = replaceAll(subtotal, ".", ",");
        qty = qty.toFixed(2);
        qty = replaceAll(qty, ".", ",");
        $(self).parents().parents('tr').find('.purchaseDetailQty').val(formatNumber(qty));
        $(self).parents().parents('tr').find('.purchaseDetailSubTotal').val(formatNumber(subtotal));
        calculateSummary();
    });
        
    $('.purchase-detail-table').on('change', '.purchaseDetailPrice', function (e) {
        var self = this;
        var qty = $(self).parents().parents('tr').find('.purchaseDetailQty').val();
        var price = $(self).parents().parents('tr').find('.purchaseDetailPrice').val();
        var discount = $(self).parents().parents('tr').find('.purchaseDetailDiscount').val();
        var subtotal = 0;
        
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
        subtotal = qty*price*(100-discount)/100;
        
        subtotal = subtotal.toFixed(2);
        subtotal = replaceAll(subtotal, ".", ",");
        price = price.toFixed(2);
        price = replaceAll(price, ".", ",");
        $(self).parents().parents('tr').find('.purchaseDetailPrice').val(formatNumber(price));
        $(self).parents().parents('tr').find('.purchaseDetailSubTotal').val(formatNumber(subtotal));
        calculateSummary();
    });
        
    $('.purchase-detail-table').on('change', '.purchaseDetailDiscount', function (e) {
        var self = this;
        var qty = $(self).parents().parents('tr').find('.purchaseDetailQty').val();
        var price = $(self).parents().parents('tr').find('.purchaseDetailPrice').val();
        var discount = $(self).parents().parents('tr').find('.purchaseDetailDiscount').val();
        var subtotal = 0;
        
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
        subtotal = qty*price*(100-discount)/100;
        
        subtotal = subtotal.toFixed(2);
        subtotal = replaceAll(subtotal, ".", ",");
        discount = discount.toFixed(2);
        discount = replaceAll(discount, ".", ",");
        $(self).parents().parents('tr').find('.purchaseDetailDiscount').val(formatNumber(discount));
        $(self).parents().parents('tr').find('.purchaseDetailSubTotal').val(formatNumber(subtotal));
        calculateSummary();
    });
        
    if($(".isVAT").is(":checked")){
        $(".isVATValue").val(1);
        $(".isVATValue").change();
        calculateSummary();
    }
    else{
        $(".isVATValue").val(0);
        $(".isVATValue").change();
        calculateSummary();
    }
        
    $('.isVATValue').change(function(){
        calculateSummary();
    });
        
    function addRow(productID, productName, uomID, uomName, qty, price, discount, subtotal){
        var template = rowTemplate;
        price = replaceAll(price, ".", ",");
        discount = replaceAll(discount, ".", ",");
        qty = replaceAll(qty, ".", ",");
        subtotal = replaceAll(subtotal, ".", ",");
        
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{qty}}', formatNumber(qty));
        template = replaceAll(template, '{{price}}', formatNumber(price));
        template = replaceAll(template, '{{discount}}', formatNumber(discount));
        template = replaceAll(template, '{{subtotal}}', formatNumber(subtotal));
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        $('.purchase-detail-table tbody').append(template);
        
        $('.maskedInput').inputmask('decimal', {digits:2, digitsOptional:false, radixPoint:',', groupSeparator: '.', autoGroup:true, removeMaskOnSubmit:true});
        $('.salesDetailSubTotal').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
    }
        
    function getMaximumCounter() {
        var maximum = 0;
         $('.purchaseDetailProductID').each(function(){
            value = parseInt($(this).attr('data-key'));
            if(value > maximum){
                maximum = value;
            }
        });
        return maximum;
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
        
    function calculateSummary()
    {
        var subTotal = 0;
        var discTotal = 0;
        var total = 0;
        var grandTotal = 0;
        var tempDiscTotal = 0;
        var taxRate = $('.rate').val(); taxRate = replaceAll(taxRate, ",", "."); taxRate = parseFloat(taxRate);
        var amount = 0;
        var VAT = $('.isVATValue').val();        
        var VATRate = 0;
        var VATAmount = 0;
        
        if(VAT == 1) {
            VATRate = 0.1;
        } else {
            VATRate = 0;
        }
        
        $('.purchase-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var qty = $(this).find("input.purchaseDetailQty").val();
                var price = $(this).find("input.purchaseDetailPrice").val();
                var discount = $(this).find("input.purchaseDetailDiscount").val();
                qty = replaceAll(qty, ".", ""); qty = replaceAll(qty, ",", "."); qty = parseFloat(qty);
                price = replaceAll(price, ".", ""); price = replaceAll(price, ",", "."); price = parseFloat(price);
                discount = replaceAll(discount, ".", ""); 
                discount = replaceAll(discount, ",", "."); 
                discount = parseFloat(discount);        
                tempDiscTotal = qty*price*(discount/100); 
                discTotal = discTotal + tempDiscTotal;
                subTotal = (subTotal + (qty*price));
                VATAmount = VATRate * (subTotal-discTotal); 
                
            })        
        });
        
        total = total + (subTotal-discTotal);
        amount = (taxRate/100) * total;
        if (isNaN(amount)){
            amount = parseFloat(0);
            amount = amount.toFixed(2);
            amount = replaceAll(amount, ".", ",");
            
        } else {        
        amount = parseFloat(amount);
        amount = amount.toFixed(2);
        amount = replaceAll(amount, ".", ",");
        }
        
        amount = parseFloat(amount);
        
        grandTotal = (subTotal - discTotal +  VATAmount) - amount;
        
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");
        
        discTotal = discTotal.toFixed(2);
        discTotal = replaceAll(discTotal, ".", ",");
        
        VATAmount = VATAmount.toFixed(2);
        VATAmount = replaceAll(VATAmount, ".", ",");
        
        amount = amount.toFixed(2);
        amount = replaceAll(amount, ".", ",");
        
        grandTotal = grandTotal.toFixed(2);
        grandTotal = replaceAll(grandTotal, ".", ",");
        
        $('.subtotalSummary').val(formatNumber(subTotal));
        $('.discountTotalSummary').val(formatNumber(discTotal));
        $('.amount').val(formatNumber(amount));
        $('.VATAmountSummary').val(formatNumber(VATAmount));   
        $('.grandTotalSummary').val(formatNumber(grandTotal));
    }
       
    $('.selectTax').change(function(){
        var taxID = $('.selectTax').val();
        taxRate = getTaxRate(taxID);
        taxRate = replaceAll(taxRate, ".", ",");
        taxRate = replaceAll(taxRate, '"', "");
        $('.rate').val(formatNumber(taxRate));
        calculateSummary();
    });
        
        function getTaxRate(taxID){
        var taxRate = '0.00';
        $.ajax({
            url: '$checkTaxRateAjaxURL',
            async: false,
            type: 'POST',
            data: { taxID: taxID },
            success: function(data) {
                taxRate = data;
            }
         });
        return taxRate;
    }
});
        

SCRIPT;
$this->registerJs($js);
?>
