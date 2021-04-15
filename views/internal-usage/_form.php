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
                            <?= $form->field($model, 'internalUsageDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'warehouseID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsWarehouse::find()->where('flagActive = 1')->all(), 'warehouseID', 'warehouseName' ),
                                    'options' => [
                                        'prompt' => 'Select Warehouse',
                                        'class' => 'form-control warehouseID'
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
                                            <div class="row">
                                                <div class="col-md-12">
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
                                            <?= Html::textInput('batchNumber', '', [
                                                'class' => 'form-control productDetailInput-9 text-center',
                                                'readonly' => 'readonly'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
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
                                                                'readonly' => true
                                                            ],
                                                        ])
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
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
                                                                'readonly' => true
                                                            ],
                                                        ])
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= 
                                                        DatePicker::widget([
                                                            'name' => 'retestDate',
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
                                                                'class' => 'productDetailInput-8 text-center',
                                                                'readonly' => true
                                                            ],
                                                        ])
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= \yii\widgets\MaskedInput::widget([
                                                        'name' => 'qtyInStock',
                                                        'value' => '0,0000',
                                                        'clientOptions' => [
                                                            'alias' => 'decimal',
                                                             'digits' => 4,
                                                             'digitsOptional' => false,
                                                             'radixPoint' => ',',
                                                            'groupSeparator' => '.',
                                                            'autoGroup' => true,
                                                            'removeMaskOnSubmit' => false
                                                        ],
                                                        'options' => [
                                                            'class' => 'form-control productDetailInput-6 text-center',
                                                            'readonly' => true
                                                        ],
                                                    ]) ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= \yii\widgets\MaskedInput::widget([
                                                        'name' => 'qty',
                                                        'value' => '0,0000',
                                                        'clientOptions' => [
                                                            'alias' => 'decimal',
                                                             'digits' => 4,
                                                             'digitsOptional' => false,
                                                             'radixPoint' => ',',
                                                            'groupSeparator' => '.',
                                                            'autoGroup' => true,
                                                            'removeMaskOnSubmit' => false
                                                        ],
                                                        'options' => [
                                                            'class' => 'form-control productDetailQty text-center'
                                                        ],
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?=
                                                Select2::widget([
                                                    'name' => 'purpose',
                                                    'data' => ArrayHelper::map(MsReason::find()->where('flagActive = 1')->all(), 'mapReasonID', 'mapReasonName'),
                                                    'options' => [
                                                        'prompt' => 'Select Reason',
                                                        'class' => 'form-control purposeID'
                                                    ],
                                                ])
                                            ?>
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
$purposeDetail = \yii\helpers\Json::encode($model->joinPurposeDetail);

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
    var dataPurpose = $purposeDetail;

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
        "           <input type='text' class='form-control text-center tableDetailQty' name='TrInternalusagehead[joinStockDetail][{{Count}}][qty]' value='{{qty}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td>" +
        "           <select class='js-example-data-array-selected' style='width: 100%;' id='coaNoPIV{{Count}}' class='form-control' name='TrInternalusagehead[joinStockDetail][{{Count}}][purposeID]' value='{{purposeID}}'> " +
        "               <option value='{{purposeID}}' selected='selected'>{{purposeName}}</option> " +
        "           </select> " +
        "   </td>" +
            $deleteRow
        "</tr>";

    $(function() {
        $('.tableDetailQtyInStock').inputmask('decimal', {digits: 4, digitsOptional : false, autoGroup: true, groupSeparator: '.', radixPoint: ',', removeMaskOnSubmit : false});
    });
  
    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.batchNumber.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.manufactureDate.toString(), entry.expiredDate.toString(), entry.retestDate.toString(), entry.qtyInStock.toString(), entry.qty.toString(), entry.purposeID.toString(), entry.purposeName.toString());
    });

    $('.detail-table .btnAdd').on('click', function (e) {
        e.preventDefault();
        var productID = $('.productIDInput').val();
        var productName = $('.productDetailInput-0').val();
        var batchNumber = $('.productDetailInput-9').val();
        var uomID = $('.productDetailInput-2').val();
        var uomName = $('.productDetailInput-3').val();
        var manufactureDate = $('.productDetailInput-4').val();
        var expiredDate = $('.productDetailInput-5').val();
        var retestDate = $('.productDetailInput-8').val();
        var qtyInStock = convertStringtoDecimal($('.productDetailInput-6').val());
        var qty = convertStringtoDecimal($('.productDetailQty').val());
        var purposeID = $('.purposeID').val();
        var purposeName = $('.purposeID option:selected').text();
        
        if(productID=="" || productID==undefined){
            bootbox.alert("Select Product");
            $('.barcodeNumberInput').focus();
            return false;
        }

        if(parseFloat(qty) > parseFloat(qtyInStock)){
            bootbox.alert("Used qty must not be larger than qty in stock");
            return false;
        }
        
        if(parseFloat(qty) < 0){
            bootbox.alert("Qty must be greater than 0");
            $('.productDetailQty').focus();
            return false;
        }
  
        addRow(productID, productName, batchNumber, uomID, uomName, manufactureDate, expiredDate, retestDate, qtyInStock, qty, purposeID, purposeName);

    
    
        $('.productIDInput').val('');
        $('.productDetailInput-0').val('');
        $('.productDetailInput-1').val('');
        $('.productDetailInput-2').val('');
        $('.productDetailInput-3').val('');
        $('.productDetailInput-4').val('');
        $('.productDetailInput-5').val('');
        $('.productDetailInput-6').val('');
        $('.productDetailInput-7').val('');
        $('.productDetailInput-8').val('');
        $('.productDetailInput-9').val('');
        $('.productDetailQty').val('0,00');
        $('.purposeID').val('');
    
    });

    $('.detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
        }
    });

    function addRow(productID, productName, batchNumber, uomID, uomName, manufactureDate, expiredDate, retestDate, qtyInStock, qty, purposeID, purposeName){
        var template = rowTemplate;
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
        template = replaceAll(template, '{{purposeID}}', purposeID);
        template = replaceAll(template, '{{purposeName}}', purposeName);
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        
        $('.detail-table tbody').append(template);

        $(".js-example-data-array-selected").select2({
                theme: "krajee"
        })
        
        $("[name='TrInternalusagehead[joinStockDetail][" + (getMaximumCounter()) + "][purposeID]']").select2({
            data: dataPurpose,
            theme: "krajee"
        })
        
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