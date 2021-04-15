<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\MsWarehouse;
use app\models\MsTax;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-goodsreceipthead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Goods Receipt Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'refNum')->textInput(['class' => 'refInput-0', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'transType')->textInput(['maxlength' => true, 'class' => 'refInput-1', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'goodsReceiptDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove), 'readonly' => 'readonly'])) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'deliveryNum')->textInput(['maxlength' => true]) ?>
                        </div>
                        <?= Html::activeHiddenInput($model, 'warehouseID', ['class' => '']) ?>
                        <div class="col-md-4">
                            <?= $form->field($model, 'warehouseName')->textInput(['readonly' => 'readonly', 'value' => $model->warehouse->warehouseName]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'currency')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'invoiceNum')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'invoiceDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig([
                                            'disabled' => isset($isApprove),
                                            'options' => [
                                                    'class' => ''
                                                ],
                                            ])) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default importPanel">
                <div class="panel-heading">Import Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 pibNumber">
                            <?= $form->field($model, 'pibNumber')->textInput([
                                            'maxlength' => true,
                                            'class' => '',
                                            'readonly' => 'readonly'
                                            ]) ?>
                        </div>
                        <div class="col-md-4 pibDate">
                            <?= $form->field($model, 'pibDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig([
                                            'disabled' => true,
                                            'options' => [
                                                    'class' => ''
                                                ],
                                            ])) ?>
                        </div>
                        <div class="col-md-4 pibRate">
                            <?= $form->field($model, 'pibRate')
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
                                                    'class' => 'form-control',
                                                    'readonly' => 'readonly'
                                                ],
                                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 pibSubmitCode">
                            <?= $form->field($model, 'pibSubmitCode')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4 pibRate">
                            <?= $form->field($model, 'pibAmount')
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
                                                    'class' => 'form-control',
                                                    'readonly' => 'readonly'
                                                ],
                                            ])?>

                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Goods Receipt Detail</div>
                <div class="panel-body">
                    <div class="row goodsDetailLayout">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table table-bordered goods-detail-table" style="border-collapse: inherit;">
                                    <thead>
                                        <tr id="table1">
                                            <th style="width: 25%;">Product Name</th>
                                            <th style="text-align: center; width: 20%;">
                                                <div class="row">
                                                    <div class="col-md-6">Unit</div>
                                                    <div class="col-md-6">Qty</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">Pack</div>
                                                    <div class="col-md-6">Pack Qty</div>
                                                </div>
                                            </th>
                                            <th style="text-align: center; width: 10%;">Good Condition?</th>
                                            <th style="text-align: center; width: 15%;">Price</th>
                                            <th style="text-align: center; width: 5%;">Discount</th>
                                            <th style="text-align: center; width: 5%;">VAT</th>
                                            <th style="text-align: center; width: 15%;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <?php if (!isset($isView)): ?>
                                    <tfoot class="tfoot">
                                    
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
                        </div>
                        <div class="col-md-6">
                            <label class="control-label text-right">Sub Total</label>
                            <?= Html::textInput('subTotal', '0,00', [
                                    'class' => 'form-control subTotalSummary text-right',
                                    'readonly' => 'readonly'
                                ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!--?= $form->field($model, 'whtPercentage')->textInput([
                                'maxlength' => true, 
                                'class' => 'whtPercentage',
                            ]) ?-->
                        </div>
                        <div class="col-md-6">
                            <label class="control-label text-right">Total Discount</label>
                            <?= Html::textInput('subTotal', '0,00', [
                                    'class' => 'form-control discTotalSummary text-right',
                                    'readonly' => 'readonly'
                                ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label text-right">Tax Total</label>
                            <?= Html::textInput('taxTotal', '0,00', [
                                    'class' => 'form-control taxTotalSummary text-right',
                                    'readonly' => 'readonly'
                                ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
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
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'advancePaymentNum')
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
                                                    'class' => 'form-control text-right advancePayment',
                                                    'readonly' => 'readonly'
                                                ],
                                            ])?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'outstanding')
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
                                                    'class' => 'form-control text-right outstandingSummary',
                                                    'readonly' => 'readonly'
                                                ],
                                            ])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group text-right">
                <?php if (!isset($isView)): ?>
                    <?= Html::submitButton('<i class="glyphicon glyphicon-save"> Approve </i>', ['class' => 'btn btn-primary btnSave']) ?>
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
$rate = $model->rate;
$goodsDetail = \yii\helpers\Json::encode($model->joinGoodsReceiptDetail);
if($model->isImport == false) {
    $isImport = 0;
} else {
    $isImport = 1;
}

//if($model->whtID != null){
  //  $whtDisplay = 0;
//}
//else
    $whtDisplay = 1;
$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "       <a class='btn btn-danger btn-sm btnDelete' href='#' style='width:80px;'><i class='glyphicon glyphicon-remove'></i> Delete</a>" +
DELETEROW;
$editRow = <<< EDITROW
            "       <a class='btn btn-danger btn-sm btnEdit' href='#' style='width:80px;'><i class='glyphicon glyphicon-pencil'></i> Edit</a>" +
EDITROW;
}
$js = <<< SCRIPT
$(document).ready(function () {
    var rate = $rate;
    var initValue = $goodsDetail;
    var isImport = $isImport;
    var whtDisplay = $whtDisplay;
    isImport == 0? displayPIB(0) : displayPIB(1);
    whtDisplay == 0? disableWHT(0) : disableWHT(1);

    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='purchaseDetailproductID' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <input type='hidden' class='goodsDetailProductName' readonly='true' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][productName]' value='{{productName}}' style='background-color:#DEDEDE;'> {{productName}}" +
        "   </td>" +
        "       <input type='hidden' class='goodsDetailUomID' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-6'>" +   
        "           <input type='hidden' class='goodsDetailUomName' readonly='true' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][uomName]' value='{{uomName}}' style='background-color:#DEDEDE; margin-right:10px;'> {{uomName}}" +
        "       </div>" + 
        "       <div class='col-md-6'>" +
        "           <input type='hidden' class='goodsDetailQty' readonly='true' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][qty]' value='{{qty}}' style='background-color:#DEDEDE; width:80%;'> {{qty}}" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-6'>" +   
        "       <input type='hidden' class='goodsDetailPackName' readonly='true' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][packName]' value='{{packName}}' style='background-color:#DEDEDE; margin-right:10px;'> {{packName}}" +
        "       </div>" + 
        "       <div class='col-md-6'>" +
        "       <input type='hidden' class='goodsDetailPackQty' readonly='true' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][packQty]' value='{{packQty}}' style='background-color:#DEDEDE; width:80%;'> {{packQty}}" +
        "       </div></div>" + 
        "   </td>" +
        "       <input type='hidden' class='goodsDetailPackID' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][packID]' value='{{packID}}' >" +
        "   <td class='text-center'>" +
        "       <input type='checkbox' class='goodsDetailCondition' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][condition]' onclick='return false' {{condition}} >" +
        "   </td>" +
        "   <td class='text-right'>" +
        "       <input type='hidden' class='goodsDetailPrice' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][price]' value='{{price}}' > {{price}} " +
        "   </td>" +
        "   <td class='text-right'>" +
        "       <input type='hidden' class='goodsDetailDiscount' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][discount]' value='{{discount}}' > {{discount}} %" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='goodsDetailTaxValue' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][taxValue]' value='{{taxValue}}' >" +
        "       <input type='checkbox' class='purchaseDetailTax' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][tax]' onclick='return false' {{tax}} >" +
        "   </td>" +
        "   <td class='text-right'>" +
        "       <input type='hidden' class='goodsDetailSubTotal' name='TrGoodsreceiptheadapproval[joinGoodsReceiptDetail][{{Count}}][subTotal]' value='{{subTotal}}' > {{subTotal}} " +
        "   </td>" +
        "</tr>";

    console.log("test");
    initValue.forEach(function(entry) {
        console.log(entry);
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qty.toString(), entry.packID.toString(), entry.packName.toString(), entry.packQty.toString(),entry.price.toString(), entry.discount.toString(), entry.taxValue.toString(), entry.tax.toString(), entry.subTotal.toString(), entry.condition.toString());
        calculateSummary();
    });

    function displayPIB(isImport){
        if(isImport == 0){
            $(".importPanel").hide();
            $(".pibNumber").hide();
            $(".pibDate").hide();
            $(".pibRate").hide();
            $(".pibSubmitCode").hide();
            $(".pibAmount").hide();
        }
        else{
            $(".importPanel").show();
            $(".pibNumber").show();
            $(".pibDate").show();
            $(".pibRate").show();
            $(".pibSubmitCode").show();
            $(".pibAmount").show();
        }
    }
    
    function disableWHT(displayWHT){
        if(displayWHT == 0){
            $(".whtID").attr('disabled','disabled');
            $(".whtPercentage").attr('disabled','disabled');
        }
    }

    $('.goods-detail-table .btnDelete').on('click', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
        }
    });
   

    function addRow(productID, productName, uomID, uomName, qty, packID, packName, packQty, price, discount, taxValue, tax, subTotal, condition){
        var template = rowTemplate;
        qty = replaceAll(qty, ".", ",");
        packQty = replaceAll(packQty, ".", ",");
        price = replaceAll(price, ".", ",");
        discount = replaceAll(discount, ".", ",");
        subTotal = replaceAll(subTotal, ".", ",");
        taxValue = replaceAll(taxValue, ".", ",");
        
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{qty}}', formatNumber(qty));
        template = replaceAll(template, '{{packID}}', packID);
        template = replaceAll(template, '{{packName}}', packName);
        template = replaceAll(template, '{{packQty}}', formatNumber(packQty));
        template = replaceAll(template, '{{price}}', formatNumber(price));
        template = replaceAll(template, '{{discount}}', formatNumber(discount));
        template = replaceAll(template, '{{subTotal}}', formatNumber(subTotal));
        template = replaceAll(template, '{{taxValue}}', formatNumber(taxValue));
        template = replaceAll(template, '{{tax}}', tax);
        template = replaceAll(template, '{{condition}}', condition);
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        
        $('.goods-detail-table tbody').append(template);
    }

    function calculateSummary()
    {
        var subTotal = 0;
        var discTotal = 0;
        var taxTotal = 0;
        var grandTotal = 0;
        var outstandingTotal = 0;
        var advancePayment = $('.advancePayment').val();
        advancePayment = replaceAll(advancePayment, ".", "");
        advancePayment = replaceAll(advancePayment, ",", ".");
        advancePayment = parseFloat(advancePayment);
        
        $('.goods-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var qtyValue = $(this).find("input.goodsDetailQty").val();
                var priceValue = $(this).find("input.goodsDetailPrice").val();
                var discValue = $(this).find("input.goodsDetailDiscount").val();
                var taxValue = $(this).find("input.goodsDetailTaxValue").val();
                
                qtyValue = replaceAll(qtyValue, ".", "");
                qtyValue = replaceAll(qtyValue, ",", ".");
                qtyValue = parseFloat(qtyValue);

                priceValue = replaceAll(priceValue, ".", "");
                priceValue = replaceAll(priceValue, ",", ".");
                priceValue = parseFloat(priceValue);

                discValue = replaceAll(discValue, ".", "");
                discValue = replaceAll(discValue, ",", ".");
                discValue = parseFloat(discValue);
                
                taxValue = replaceAll(taxValue, ".", "");
                taxValue = replaceAll(taxValue, ",", ".");
                taxValue = parseFloat(taxValue);

                discTotal = discTotal + qtyValue*priceValue*(discValue/100);
                
                subTotal = subTotal + (qtyValue*priceValue);
                taxTotal = taxTotal + ((qtyValue*priceValue)-(qtyValue*priceValue*(discValue/100)))*taxValue/100;
            })
        });
        
        grandTotal = (subTotal + taxTotal)/rate;
        outstandingTotal = grandTotal - advancePayment;
        
        subTotal = subTotal / rate;
        subTotal = subTotal.toFixed(2);
        subTotal = replaceAll(subTotal, ".", ",");

        discTotal = discTotal / rate;
        discTotal = discTotal.toFixed(2);
        discTotal = replaceAll(discTotal, ".", ",");
        
        taxTotal = taxTotal / rate;
        taxTotal = taxTotal.toFixed(2);
        taxTotal = replaceAll(taxTotal, ".", ",");
        
        grandTotal = grandTotal.toFixed(2);
        grandTotal = replaceAll(grandTotal, ".", ",");

        outstandingTotal = outstandingTotal.toFixed(2);
        outstandingTotal = replaceAll(outstandingTotal, ".", ",");
        
        $('.subTotalSummary').val(formatNumber(subTotal));
        $('.discTotalSummary').val(formatNumber(discTotal));
        $('.taxTotalSummary').val(formatNumber(taxTotal));
        $('.grandTotalSummary').val(formatNumber(grandTotal));
        $('.outstandingSummary').val(formatNumber(outstandingTotal));
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
         $('.purchaseDetailproductID').each(function(){
            value = parseInt($(this).attr('data-key'));
            if(value > maximum){
                maximum = value;
            }
        });
        return maximum;
    }
});
SCRIPT;
$this->registerJs($js);
?>