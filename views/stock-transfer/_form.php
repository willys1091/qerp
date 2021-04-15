<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\MsWarehouse;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrStocktransferhead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-stocktransferhead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Stock Transfer Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'stockTransferDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'sourceWarehouseID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsWarehouse::find()->where('flagActive = 1')->all(), 'warehouseID', 'warehouseName' ),
                                    'options' => [
                                        'prompt' => 'Select Warehouse Source',
                                        'class' => 'form-control sourceWarehouseID refDetail-0',
                                        'disabled' => $update ? true : false
                                        ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'destinationWarehouseID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsWarehouse::find()->where('flagActive = 1')->all(), 'warehouseID', 'warehouseName' ),
                                    'options' => [
                                        'prompt' => 'Select Warehouse Destination',
                                        'class' => 'form-control',
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
                                        <th style="width: 25%;">Product Name</th>
                                        <th style="width: 10%;">Unit</th>
                                        <th style="width: 15%;">Batch Number</th>
                                        <th style="width: 15%;">Manufacture Date</th>
                                        <th style="width: 15%;">Expired Date</th>
                                        <th style="width: 10%;">Stock Qty</th>
                                        <th style="width: 10%;">Transfered Qty</th>
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
                                                'readonly' => 'readonly',
                                            ]) ?>
                                            <div class="input-group-btn">
                                                    <?= Html::a("...", ['product/browsebywarehouse'], [
                                                        'data-filter-input' => '.sourceWarehouseID',
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
                                            <?= 
                                                DatePicker::widget([
                                                    'name' => 'manufactureDate',
                                                    'type' => DatePicker::TYPE_INPUT,
                                                    'pluginOptions' => [
                                                        'format' => 'dd-mm-yyyy',
                                                        'autoWidget' => true,
                                                        'autoclose' => true,
                                                        'todayBtn' => true,
                                                        'startDate' => '-150y',
                                                        'todayHighlight' => true
                                                    ],
                                                    'options' => [
                                                        'class' => 'productDetailInput-4 text-center',
                                                        'readonly' => 'readonly'
                                                    ],
                                                ])
                                            ?>
                                        </td>
                                        <td>
                                            <?= 
                                                DatePicker::widget([
                                                    'name' => 'expiredDate',
                                                    'type' => DatePicker::TYPE_INPUT,
                                                    'pluginOptions' => [
                                                        'format' => 'dd-mm-yyyy',
                                                        'autoWidget' => true,
                                                        'autoclose' => true,
                                                        'todayBtn' => true,
                                                        'startDate' => '-150y',
                                                        'todayHighlight' => true
                                                    ],
                                                    'options' => [
                                                        'class' => 'productDetailInput-5 text-center',
                                                        'readonly' => 'readonly'
                                                    ],
                                                ])
                                            ?>
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
                                                'options' => [
                                                    'class' => 'form-control productDetailInput-6 text-center',
                                                    'readonly' => 'readonly'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= \yii\widgets\MaskedInput::widget([
                                                'name' => 'transferedQty',
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
                                                    'class' => 'form-control productDetailTransferedQty text-center'
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
        
    var initValue = $stockDetail;
    console.log(initValue);
    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='salesDetailBarcodeNumber' name='TrStocktransferhead[joinStockDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
     
        "       <input type='hidden' class='stockTransferDetailID' name='TrStocktransferhead[joinStockDetail][{{Count}}][stockTransferDetailID]' value='{{stockTransferDetailID}}' > {{stockTransferDetailID}}" +
      
        "   <td class='text-left'>" +
        "       <input type='hidden' class='salesDetailProductName' name='TrStocktransferhead[joinStockDetail][{{Count}}][productName]' value='{{productName}}' > {{productName}}" +
        "   </td>" +
        "       <input type='hidden' class='salesDetailUomID' name='TrStocktransferhead[joinStockDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='salesDetailUomID' name='TrStocktransferhead[joinStockDetail][{{Count}}][uomName]' value='{{uomName}}' > {{uomName}}" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='form-control tableDetailBatchNumber' name='TrStocktransferhead[joinStockDetail][{{Count}}][batchNumber]' value='{{batchNumber}}' > {{batchNumber}}" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='form-control tableDetailManDate' name='TrStocktransferhead[joinStockDetail][{{Count}}][manufactureDate]' value='{{manufactureDate}}' > {{manufactureDate}}" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='form-control tableDetailExpiredDate' name='TrStocktransferhead[joinStockDetail][{{Count}}][expiredDate]' value='{{expiredDate}}' > {{expiredDate}}" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='tableDetailQty' name='TrStocktransferhead[joinStockDetail][{{Count}}][qty]' value='{{qty}}' > {{qty}}" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control text-center tableDetailTransferedQty' name='TrStocktransferhead[joinStockDetail][{{Count}}][transferedQty]' value='{{transferedQty}}' >" +
        "   </td>" +
            $deleteRow
        "</tr>";

    $(function() {
        $('.tableDetailQty').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
    });
  
    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(),entry.batchNumber.toString(), entry.manufactureDate.toString(), entry.expiredDate.toString(), entry.qty.toString(), entry.transferedQty.toString(),  entry.stockTransferDetailID.toString());
    });
    
    
    $('form').keypress(function(e) {
      if (e.which == 13) {
        return false;
      }
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
        var batchNumber = $('.productDetailInput-9').val();
        var uomName = $('.productDetailInput-3').val();
        var manufactureDate = $('.productDetailInput-4').val();
        var expiredDate = $('.productDetailInput-5').val();
        var qty = $('.productDetailInput-6').val();
        var transferedQty = $('.productDetailTransferedQty').val();
         
       
        
        var Qty = parseFloat(qty);
        var TransferedQty = parseFloat(transferedQty);
        
    
    
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");

        transferedQty = replaceAll(transferedQty, ".", "");
        transferedQty = replaceAll(transferedQty, ",", ".");
        
        var qtyStr = qty;
        var transferedQtyStr = transferedQty;
        
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
        
       if(TransferedQty > Qty ){
            bootbox.alert("Transfered Qty must not be larger than Stock Qty ");
            $('.productIDInput').focus();
            return false;
        }

        if(!$.isNumeric(transferedQty)){
            bootbox.alert("Qty must be numeric");
            $('.productDetailTransferedQty').focus();
            return false;
        }

        transferedQty = parseFloat(transferedQty);
  
        addRow(productID, productName, uomID, uomName, batchNumber, manufactureDate, expiredDate, qtyStr, transferedQtyStr, '');

        $('.productIDInput').val('');
        $('.productDetailInput-0').val('');
        $('.productDetailInput-1').val('');
        $('.productDetailInput-2').val('');
        $('.productDetailInput-3').val('');
        $('.productDetailInput-4').val('');
        $('.productDetailInput-5').val('');
        $('.productDetailInput-6').val('0,00');
        $('.productDetailInput-9').val('');
        $('.productDetailTransferedQty').val('0,00');
        $('.stockTransferDetailID').val('');
    });

    $('.detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
        }
    });

    function addRow(productID, productName, uomID, uomName,batchNumber, manufactureDate, expiredDate, qty, transferedQty, stockTransferDetailID , HPP){
        var template = rowTemplate;
        qty = replaceAll(qty, ".", ",");
        transferedQty = replaceAll(transferedQty, ".", ",");
        
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{batchNumber}}', batchNumber);
        template = replaceAll(template, '{{manufactureDate}}', manufactureDate);
        template = replaceAll(template, '{{expiredDate}}', expiredDate);
        template = replaceAll(template, '{{qty}}', formatNumber(qty));
        template = replaceAll(template, '{{transferedQty}}', formatNumber(transferedQty));
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        template = replaceAll(template, '{{stockTransferDetailID}}', stockTransferDetailID);
        
        $('.detail-table tbody').append(template);
        
        $(function() {
        $('.tableDetailQty').inputmask('decimal', {digits: 2, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
        });
    }
    
    $('.detail-table').on('change', '.tableDetailTransferedQty', function (e) {
        var self = this;
        var qty = $(self).parents().parents('tr').find('.tableDetailTransferedQty').val();
        var subTotal = 0;
        
        qty = replaceAll(qty, ".", "");
        qty = replaceAll(qty, ",", ".");
        qty = parseFloat(qty);
        if (isNaN(qty)){
            qty = parseFloat(0);
        }
        
        qty = qty.toFixed(2);
        qty = replaceAll(qty, ".", ",");
        $(self).parents().parents('tr').find('.tableDetailTransferedQty').val(formatNumber(qty));
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

    $('.tableDetailManDate').kvDatepicker();
    $('.tableDetailExpiredDate').kvDatepicker();

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