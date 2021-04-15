<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\MsWarehouse;
use app\models\MsReason;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrInternalusagehead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-internalusagehead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Internal Usage Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'internalUsageDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove),  'readonly' => 'readonly'])) ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'warehouseID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsWarehouse::find()->where('flagActive = 1')->all(), 'warehouseID', 'warehouseName' ),
                                    'options' => [
                                        'prompt' => 'Select Warehouse',
                                        'class' => 'form-control warehouseID',
                                        'disabled' => true
                                        ],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'notes')->textArea(['maxlength' => true,  'readonly' => 'readonly']) ?>
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
                                        <th style="width: 25%;">
                                            <div class="row">
                                                Product Name
                                            </div>
                                            <div class="row">
                                                Unit
                                            </div>
                                        </th>
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
                                        <th style="width: 15%;">
                                            <div class="row">
                                                Qty In Stock
                                            </div>
                                            <div class="row">
                                                Qty Usage
                                            </div>
                                        </th>
                                        <th style="width: 20%;">Purpose</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
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

$js = <<< SCRIPT

$(document).ready(function () {
    var initValue = $stockDetail;
    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='tableDetailProductID' name='TrInternalusagehead[joinStockDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        "       <input type='text' class='form-control tableDetailProductName' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][productName]' value='{{productName}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "       <input type='text' class='form-control tableDetailUomName' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][uomName]' value='{{uomName}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "       <input type='hidden' class='tableDetailUomID' name='TrInternalusagehead[joinStockDetail][{{Count}}][uomID]' value='{{uomID}}'>" +
        "   <td>" +
        "       <input type='text' class='form-control text-center tableDetailBatchNumber' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][batchNumber]' value='{{batchNumber}}' >" +
        "   </td>" +
        "   <td>" +
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control text-center tableDetailManDate' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][manufactureDate]' value='{{manufactureDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control text-center tableDetailExpiredDate' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][expiredDate]' value='{{expiredDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control text-center tableDetailRetestDate' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][retestDate]' value='{{retestDate}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td>" +
        "       <div class='row'><div class='col-md-12'>" +  
        "       <input type='text' class='form-control text-center tableDetailQtyInStock' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][qtyInStock]' value='{{qtyInStock}}' >" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control text-center tableDetailQty' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][qty]' value='{{qty}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td>" +
        "           <input type='text' class='form-control text-center tableDetailPurposeID' readonly='true' name='TrInternalusagehead[joinStockDetail][{{Count}}][purposeName]' value='{{purposeName}}'>" +
        "   </td>" +
        "</tr>";
  
    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.batchNumber.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.manufactureDate.toString(), entry.expiredDate.toString(), entry.retestDate.toString(), entry.qtyInStock.toString(), entry.qty.toString(), entry.purposeName.toString());
    });

    function addRow(productID, productName, batchNumber, uomID, uomName, manufactureDate, expiredDate, retestDate, qtyInStock, qty, purposeName){
        var template = rowTemplate;
        console.log("test");
        qtyInStock = replaceAll(qtyInStock, ".", ",");
        qty = replaceAll(qty, ".", ",");
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{batchNumber}}', batchNumber);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{manufactureDate}}', manufactureDate);
        template = replaceAll(template, '{{expiredDate}}', expiredDate);
        template = replaceAll(template, '{{retestDate}}', retestDate);
        template = replaceAll(template, '{{qtyInStock}}', formatNumber(qtyInStock));
        template = replaceAll(template, '{{qty}}', formatNumber(qty));
        template = replaceAll(template, '{{purposeName}}', purposeName);
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        
        $('.detail-table tbody').append(template);
        
        $(function() {
            $('.tableDetailQtyInStock').inputmask('decimal', {digits: 4, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
        });
    }
    
    function barcodeNumberExistsInTable(barcode){
        var exists = false;
        $('.tableDetailProductID').each(function(){
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

    $('.tableDetailManDate').kvDatepicker();
    $('.tableDetailExpiredDate').kvDatepicker();
    $('.tableDetailRetestDate').kvDatepicker();

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