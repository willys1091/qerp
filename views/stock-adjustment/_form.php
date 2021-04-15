<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\MsWarehouse;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrStockopnamehead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-stockopnamehead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Lost Stock Adjustment Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'stockOpnameDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'warehouseID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsWarehouse::find()->where('flagActive = 1')->all(), 'warehouseID', 'warehouseName' ),
                                    'options' => [
                                        'prompt' => 'Select Warehouse',
                                        'class' => 'form-control warehouseID',
                                        'disabled' => $update ? true : false
                                        ],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'notes')->textArea(['maxlength' => true]) ?>
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
                                <table class="table table-bordered detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%;">Product Name</th>
                                        <th style="width: 10%;">Unit</th>
                                        <th style="width: 15%;">Batch Number</th>
                                        <th style="width: 15%;">
                                            <div class="row">
                                                Manufacture Date
                                            </div>
                                            <div class="row">
                                                Expired Date
                                            </div>
                                            <div class="row">
                                                Retest Date
                                            </div>
                                        </th>
                                        <th style="width: 10%;">Stock Qty</th>
                                        <th style="width: 10%;">Real Stock Qty</th>
                                        <th style="text-align: right; width: 20%;">HPP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                     <?php if (!isset($update)): ?>
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
                                                    <?= Html::a("...", ['product/browsebywarehouse'], [
                                                        'data-filter-input' => '.warehouseID',
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
                                                'class' => 'form-control productDetailInput-2',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= Html::textInput('uomName', '', [
                                                'class' => 'form-control productDetailInput-3 text-center',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= Html::textInput('batchNumber', '', [
                                                'class' => 'form-control productDetailInput-9 text-center',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="row"><div class="col-md-12">
                                                <?= Html::textInput('manufactureDate', '', [
                                                    'class' => 'form-control productDetailInput-4 text-center',
                                                    'readonly' => 'readonly'
                                                ]) ?>
                                            </div></div>
                                            <div class="row"><div class="col-md-12">
                                                <?= Html::textInput('expiredDate', '', [
                                                    'class' => 'form-control productDetailInput-5 text-center',
                                                    'readonly' => 'readonly'
                                                ]) ?>
                                            </div></div>
                                            <div class="row"><div class="col-md-12">
                                                <?= Html::textInput('retestDate', '', [
                                                    'class' => 'form-control productDetailInput-8 text-center',
                                                    'readonly' => 'readonly'
                                                ]) ?>
                                            </div></div>
                                            
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'stockQty',
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
                                                    'class' => 'form-control productDetailInput-6 text-center',
                                                    'readonly' => 'readonly'
                                                ],
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'realQty',
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
                                                    'class' => 'form-control productDetailRealQty text-center'
                                                ],
                                            ]) ?>
                                        </td>
                                        <td class="visibility: hidden">
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'stockHPP',
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
                                                    'class' => 'form-control productDetailInput-7 productDetailStockHPP'
                                                ],
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'HPP',
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
                                                    'class' => 'form-control productDetailInput-7 productDetailHPP text-right',
                                                     'readonly' => 'readonly'
                                                    
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
$stockDetail = \yii\helpers\Json::encode($model->joinStockDetail);
$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "   <td class='text-center'>" +
            "       <a class='btn btn-danger btn-sm btnDelete' href='#'><i class='glyphicon glyphicon-remove'></i>Delete</a>" +
            "   </td>" +
DELETEROW;
}

$js = <<< SCRIPT

$(document).ready(function () {
    console.log($stockDetail);
    var initValue = $stockDetail;
    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='salesDetailBarcodeNumber' name='TrStockopnamehead[joinStockDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "       <input type='hidden' class='stockOpnameDetailID' name='TrStockopnamehead[joinStockDetail][{{Count}}][stockOpnameDetailID]' value='{{stockOpnameDetailID}}' > {{stockOpnameDetailID}}" +
        "   <td class='text-left'>" +
        "       <input type='hidden' class='salesDetailProductName' name='TrStockopnamehead[joinStockDetail][{{Count}}][productName]' value='{{productName}}' > {{productName}}" +
        "   </td class='text-center'>" +
        "       <input type='hidden' class='salesDetailUomID' name='TrStockopnamehead[joinStockDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='salesDetailUomID' name='TrStockopnamehead[joinStockDetail][{{Count}}][uomName]' value='{{uomName}}' > {{uomName}}" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='text' readonly='true' class='form-control tableDetailBatchNumber' name='TrStockopnamehead[joinStockDetail][{{Count}}][batchNumber]' value='{{batchNumber}}' >" +
        "   </td>" +
        "   <td>" +
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control tableDetailManDate' name='TrStockopnamehead[joinStockDetail][{{Count}}][manufactureDate]' value='{{manufactureDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control tableDetailExpiredDate' name='TrStockopnamehead[joinStockDetail][{{Count}}][expiredDate]' value='{{expiredDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control tableDetailRetestDate' name='TrStockopnamehead[joinStockDetail][{{Count}}][retestDate]' value='{{retestDate}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='tableDetailQty' name='TrStockopnamehead[joinStockDetail][{{Count}}][qty]' value='{{qty}}' > {{qty}}" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-center tableDetailRealQty' name='TrStockopnamehead[joinStockDetail][{{Count}}][realQty]' value='{{realQty}}' >" +
        "   </td>" +
        "       <input type='hidden' class='tableDetailStockHPP' name='TrStockopnamehead[joinStockDetail][{{Count}}][stockHPP]' data-key='{{Count}}' value='{{stockHPP}}' >" +
        "   <td>" +
        "       <input type='text' readonly='true'  class='form-control text-right tableDetailHPP' name='TrStockopnamehead[joinStockDetail][{{Count}}][HPP]' value='{{HPP}}' >" +
        "   </td>" +
            $deleteRow
        "</tr>";

    window.addRow = function (productID, productName, uomID, uomName, batchNumber, manufactureDate, expiredDate, retestDate, qty, realQty, stockHPP, HPP, stockOpnameDetailID){
        var template = rowTemplate;
        qty = replaceAll(qty, ".", ",");
        realQty = replaceAll(realQty, ".", ",");
        stockHPP = replaceAll(stockHPP, ".", ",");
        HPP = replaceAll(HPP, ".", ",");
        
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{batchNumber}}', batchNumber);
        template = replaceAll(template, '{{manufactureDate}}', manufactureDate);
        template = replaceAll(template, '{{expiredDate}}', expiredDate);
        template = replaceAll(template, '{{retestDate}}', retestDate);
        template = replaceAll(template, '{{qty}}', formatNumber(qty));
        template = replaceAll(template, '{{realQty}}', formatNumber(realQty));
        template = replaceAll(template, '{{stockHPP}}', formatNumber(stockHPP));
        template = replaceAll(template, '{{HPP}}', formatNumber(HPP));
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        template = replaceAll(template, '{{stockOpnameDetailID}}', stockOpnameDetailID);
        
        console.log(template);
    
        $('.detail-table tbody').append(template);
        
        $(function() {
            $('.tableDetailQty').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
            $('.tableDetailHPP').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
        });
    };
    var addRow = window.addRow;
    
    $(function() {
        $('.tableDetailQty').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
    });
    window.initData = initValue;
    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.batchNumber.toString(), entry.manufactureDate.toString(), entry.expiredDate.toString(), entry.retestDate.toString(), entry.qty.toString(), entry.realQty.toString(), entry.stockHPP.toString(), entry.HPP.toString(),entry.stockOpnameDetailID.toString());
    });
    
    $('.btnSave').keypress(function(e) {
        if(e.which == 13) {
        $('.btnSave').click();
        }
    });

    

    $('.detail-table .btnAdd').on('click', function (e) {
        e.preventDefault();
        var productID = $('.productIDInput').val();
        var productName = $('.productDetailInput-0').val();
        var uomID = $('.productDetailInput-2').val();
        var uomName = $('.productDetailInput-3').val();
        var batchNumber = $('.productDetailInput-9').val();
        var manufactureDate = $('.productDetailInput-4').val();
        var expiredDate = $('.productDetailInput-5').val();
        var retestDate = $('.productDetailInput-8').val();
        var qty = $('.productDetailInput-6').val();
        var realQty = $('.productDetailRealQty').val();
        var stockHPP = $('.productDetailStockHPP').val();
        var HPP = $('.productDetailHPP').val();
        
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");

        realQty = replaceAll(realQty, ".", "");
        realQty = replaceAll(realQty, ",", ".");

        stockHPP = replaceAll(stockHPP, ".", "");
        stockHPP = replaceAll(stockHPP, ",", ".");

        HPP = replaceAll(HPP, ".", "");
        HPP = replaceAll(HPP, ",", ".");
        
        var qtyStr = qty;
        var realQtyStr = realQty;
        var stockHPPStr = stockHPP;
        var HPPStr = HPP;
        
    
        var Qty = parseFloat(qty);
        var RealQty = parseFloat(realQty);
    
        if(RealQty > Qty ){
            bootbox.alert("Real Qty must not be larger than Stock Qty ");
            $('.productIDInput').focus();
            return false;
        }
    
    
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

        if(!$.isNumeric(realQty)){
            bootbox.alert("Qty must be numeric");
            $('.productDetailRealQty').focus();
            return false;
        }

        realQty = parseFloat(realQty);
        
        if(HPP=="" || HPP==undefined){
            bootbox.alert("Price must be greater than or equal to 0");
            $('.productDetailInput-6').focus();
            return false;
        }

        if(!$.isNumeric(HPP)){
            bootbox.alert("Price must be numeric");
            $('.productDetailInput-6').focus();
            return false;
        }

        HPP = parseFloat(HPP);

        if(HPP < 0){
            bootbox.alert("HPP must be greater than or equal to 0");
            $('.productDetailInput-6').focus();
            return false;
        }
  
        addRow(productID, productName, uomID, uomName, batchNumber, manufactureDate, expiredDate, retestDate, qtyStr, realQtyStr, stockHPPStr, HPPStr, null);

        $('.productIDInput').val('');
        $('.productDetailInput-0').val('');
        $('.productDetailInput-1').val('');
        $('.productDetailInput-2').val('');
        $('.productDetailInput-3').val('');
        $('.productDetailInput-4').val('');
        $('.productDetailInput-8').val('');
        $('.productDetailInput-9').val('');
        $('.productDetailInput-5').val('');
        $('.productDetailInput-6').val('0,00');
        $('.productDetailStockHPP').val('0,00');
        $('.productDetailHPP').val('0,00');
        $('.productDetailRealQty').val('0,00');
        //$('.stockOpnameDetailID').val('');
    
    
    
    });

    $('.detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
        }
    });
    
    function barcodeNumberExistsInTable(barcode){
        var exists = false;
        $('.salesDetailBarcodeNumber').each(function(){
            if($(this).val() == barcode){
                exists = true;
            }
        });
        return exists;
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

    $('.tableDetailManDate').kvDatepicker(kvDatepicker_6f38f609);
    $('.tableDetailExpiredDate').kvDatepicker(kvDatepicker_6f38f609);
    $('.tableDetailRetestDate').kvDatepicker(kvDatepicker_6f38f609);

    $('form').on("beforeValidate", function(){
        var countData = $('.detail-table tbody tr').length;
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
});
SCRIPT;
$this->registerJs($js);
?>