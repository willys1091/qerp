<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\MsWarehouse;
use app\models\MsSupplier;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;

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
                            <?= $form->field($model, 'from')->textInput(['class' => '', 'readonly' => 'readonly']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'goodsReceiptDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'goodsReceiptTime')->widget(TimePicker::classname(), [
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'minuteStep' => 1
                                    ]
                                ]) 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'PPJK')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsSupplier::find()->where('isForwarder = 1')->all(), 'supplierID', 'supplierName' ),
                                    'options' => [
                                        'prompt' => 'Select Forwarder'],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'AWBNum')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'AWBDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'deliveryNum')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'warehouseID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsWarehouse::find()->where('flagActive = 1')->all(), 'warehouseID', 'warehouseName' ),
                                    'options' => [
                                        'prompt' => 'Select Warehouse'],
                                ]);
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Goods Receipt Detail</div>
                <div class="panel-body">
                    <div class="row goodsDetailLayout">
                        <div class="col-md-12">
                            <div class="form-group table-responsive" style="overflow-x: scroll;">
                                <table class="table table-bordered goods-detail-table" style="border-collapse: inherit;">
                                    <thead>
                                        <tr id="table1">
                                            <th style="width: 200px;">Product Name</th>
                                            <th style="text-align: center; width: 200px;">
                                                <div class="row">
                                                    <div class="col-md-6">Unit</div>
                                                    <div class="col-md-6">Qty Outstanding</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">Pack</div>
                                                    <div class="col-md-6">Pack Qty</div>
                                                </div>
                                            </th>
                                            <th style="width: 100px;">Qty Received</th>
                                            <th style="text-align: center; width: 150px;">
                                                <div class="row">
                                                    Batch Number
                                                </div>
                                                <div class="row">
                                                    HS Code
                                                </div>
                                            </th>
                                            <th style="text-align: center; width: 150px;">
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
                                            <th style="width: 100px;">Temperature</th>
                                            <th style="width: 250px;">Notes</th>
                                            <th style="text-align: center; width: 90px;">Good Condition?</th>
                                            <th style="width: 90px;"></th>
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
$goodsDetail = \yii\helpers\Json::encode($model->joinGoodsReceiptDetail);
$hsCodeDetail = \yii\helpers\Json::encode($model->joinHsCodeDetail);
$getHsCodeAjax = Yii::$app->request->baseUrl. '/goods-receipt/get-hscode';

$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "       <a class='btn btn-danger btn-sm btnDelete' href='#' style='width:80px;'><i class='glyphicon glyphicon-remove'></i> Delete</a>" +
DELETEROW;

$duplicateRow = <<< DUPLICATEROW
            "       <a class='btn btn-primary btn-sm btnAdd' style='width:100%;' data-toggle='tooltip' title='Duplicate Product' href='#'><i class='glyphicon glyphicon-plus'></i>Add</a>" +
DUPLICATEROW;
}

$js = <<< SCRIPT

$(document).ready(function () {   
   
   
   
   
    var initValue = $goodsDetail;
    var dataHsCode = $hsCodeDetail;
    console.log(initValue);
    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='goodsDetailProductID' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <input type='text' class='form-control goodsDetailProductName' readonly='true' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][productName]' value='{{productName}}'>" +
        "   </td>" +
        "       <input type='hidden' class='goodsDetailUomID' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-6'>" +   
        "           <input type='text' class='form-control goodsDetailUomName' readonly='true' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][uomName]' value='{{uomName}}' style=' margin-right:10px;'>" +
        "       </div>" + 
        "       <div class='col-md-6'>" +
        "           <input type='text' class='form-control goodsDetailQty' readonly='true' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][qty]' value='{{qty}}' style='width:80%;'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-6'>" +   
        "       <input type='text' class='form-control goodsDetailPackName' readonly='true' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][packName]' value='{{packName}}' style='margin-right:10px;'>" +
        "       </div>" + 
        "       <div class='col-md-6'>" +
        "       <input type='text' class='form-control goodsDetailPackQty input-decimal' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][packQty]' value='{{packQty}}' style='width:80%;'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-left'>" +
        "       <input type='text' class='form-control goodsDetailQtyReceived input-decimal' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][qtyReceived]' value='{{qtyReceived}}'>" +
        "   </td>" +
        "       <input type='hidden' class='goodsDetailPackID' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][packID]' value='{{packID}}' >" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +   
        "           <input type='text' class='form-control goodsDetailBatchNumber' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][batchNumber]' value='{{batchNumber}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <select class='js-example-data-array-selected form-control goodsDetailHsCode' style='width: 100%;' id='hsCode[{{Count}}]' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][hsCode]' value='{{hsCode}}'> " +
        "               <option value='{{hsCode}}' selected='selected'>{{hsCode}}</option> " +
        "           </select> " +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control goodsDetailManDate' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][manufactureDate]' value='{{manufactureDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control goodsDetailExpiredDate' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][expireDate]' value='{{expireDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control goodsDetailRetestDate' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][retestDate]' value='{{retestDate}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='text' class='form-control goodsDetailTemperature' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][temperature]' value='{{temperature}}' >" +
        "   </td>" +
        "   <td class='text-left'>" +
        "       <textarea rows='5' maxlength='250' class='form-control goodsDetailNotes' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][notes]'>{{notes}}</textarea>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='checkbox' class='goodsDetailCondition' name='TrGoodsreceipthead[joinGoodsReceiptDetail][{{Count}}][condition]' {{condition}} >" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        $duplicateRow
        $deleteRow
        "       </div></div>" + 
        "   </td>" +
        "</tr>";

    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qty.toString(), entry.packID.toString(), entry.packName.toString(), entry.packQty.toString(),entry.qtyReceived.toString(),entry.batchNumber.toString(), entry.hsCode.toString(), entry.manufactureDate.toString(), entry.expireDate.toString(), entry.retestDate.toString(), entry.condition.toString());
        $(".btnDelete").hide();
    });
        
    $('.goods-detail-table').on('change', '.goodsDetailQtyReceived', function (e) {
        var qtyOutstanding = $(this).parents().parents('tr').find('.goodsDetailQty').val();
        var qtyReceived = $(this).parents().parents('tr').find('.goodsDetailQtyReceived').val();

       qtyOutstanding = replaceAll(qtyOutstanding, ".", "");
       qtyOutstanding = replaceAll(qtyOutstanding, ",", ".");
       qtyOutstanding = parseFloat(qtyOutstanding);
    
    
        qtyReceived = replaceAll(qtyReceived, ".", "");
        qtyReceived = replaceAll(qtyReceived, ",", ".");
        qtyReceived = parseFloat(qtyReceived);
    
//        if (isNaN(qtyOutstanding)){
//            qtyOutstanding = parseFloat(0);
//        }
    
        console.log(qtyOutstanding);
        console.log(qtyReceived);
        if(qtyReceived > qtyOutstanding){
            bootbox.alert("Received qty is larger than remaining qty");
        }
        if(qtyReceived < 0){
            bootbox.alert("Received qty must not be less than 0");
        }
    });
        
    $('.goods-detail-table').on('change', '.goodsDetailExpiredDate', function (e) {
        var expiredDate = $(this).parents('tr').find('.goodsDetailExpiredDate').val();
        var retestDate = $(this).parents('tr').find('.goodsDetailRetestDate').val();

        if(expiredDate != ""){
            $(this).parents('tr').find('.goodsDetailRetestDate').val("");
        }
    });
        
    $('.goods-detail-table').on('change', '.goodsDetailRetestDate', function (e) {
        var expiredDate = $(this).parents('tr').find('.goodsDetailExpiredDate').val();
        var retestDate = $(this).parents('tr').find('.goodsDetailRetestDate').val();

        if(retestDate != ""){
            $(this).parents('tr').find('.goodsDetailExpiredDate').val("");
        }
    });

    $('.goods-detail-table').on('click', '.btnAdd', function (e) {   
        e.preventDefault();
        var productID = $(this).parents('tr').find('.goodsDetailProductID').val();
        var productName = $(this).parents('tr').find('.goodsDetailProductName').val();
        var uomID = $(this).parents('tr').find('.goodsDetailUomID').val();
        var uomName = $(this).parents('tr').find('.goodsDetailUomName').val();
        
        var qtyOutstanding = $(this).parents('tr').find('.goodsDetailQty').val().currencyToFloat();
        var qtyReceived = $(this).parents('tr').find('.goodsDetailQtyReceived').val().currencyToFloat();
        var packID = $(this).parents('tr').find('.goodsDetailPackID').val();
        var packName = $(this).parents('tr').find('.goodsDetailPackName').val();
        var packQty = $(this).parents('tr').find('.goodsDetailPackQty').val();
        var batchNumber = $(this).parents('tr').find('.goodsDetailBatchNumber').val();
        var hsCodeID = $(this).parents('tr').find('.goodsDetailHsCode').val();
        var hsCode = $(this).parents('tr').find('.goodsDetailHsCode option:selected').text();
        var manufactureDate = $(this).parents('tr').find('.goodsDetailManDate').val();
        var expiredDate = $(this).parents('tr').find('.goodsDetailExpiredDate').val();
        var retestDate = $(this).parents('tr').find('.goodsDetailRetestDate').val();
        var condition = $(this).parents('tr').find('.goodsDetailCondition').is(':checked');

        if(condition) var conditionValue = "checked";
        addRow(productID, productName, uomID, uomName, qtyOutstanding - qtyReceived, packID, packName, packQty, 0, batchNumber, hsCode, manufactureDate, expiredDate, retestDate, conditionValue);

        var copiedOptions = $(this).parents('tr').find('.goodsDetailHsCode > option').clone();
        $("[name='TrGoodsreceipthead[joinGoodsReceiptDetail][" + getMaximumCounter() + "][hsCode]']").find('option').remove().end();
        $("[name='TrGoodsreceipthead[joinGoodsReceiptDetail][" + getMaximumCounter() + "][hsCode]']").append(copiedOptions);
    });

    $('.btnSave').on('click', function (e) {
        var qtyReceivedError = 0;
        var batchNumError = 0;
        var manDateError = 0;
        var expiredDateError = 0;
        var countRow = 0;

        $('.goods-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var qtyReceived = $(this).find("input.goodsDetailQtyReceived").val();
                var qtyOutstanding = $(this).find("input.goodsDetailQty").val();
                qtyReceived = replaceAll(qtyReceived, ".", "");
                qtyReceived = replaceAll(qtyReceived, ",", ".");
                qtyReceived = parseFloat(qtyReceived);
                if (isNaN(qtyReceived)){
                    qtyReceived = parseFloat(0);
                }

                if(qtyReceived == 0){
                    qtyReceivedError = qtyReceivedError+1;
                }
        
                if ($(this).find("input.goodsDetailBatchNumber").val().length === 0){
                    batchNumError = batchNumError+1;
                }
                if ($(this).find("input.goodsDetailManDate").val().length === 0 && $(this).find("input.goodsDetailRetestDate").val().length === 0){
                    manDateError = manDateError+1;
                }
                if ($(this).find("input.goodsDetailExpiredDate").val().length === 0 && $(this).find("input.goodsDetailRetestDate").val().length === 0){
                    expiredDateError = expiredDateError+1;
                }
                countRow = countRow + 1;
    
                



                if (isNaN(qtyOutstanding)){
                    qtyOutstanding = parseFloat(0);
                }

                console.log(qtyOutstanding);
                console.log(qtyReceived);
                if(qtyReceived > qtyOutstanding){
                    bootbox.alert("Received qty is larger than remaining qty");
                    return false;
                }
                if(qtyReceived < 0){
                    bootbox.alert("Received qty must not be less than 0");
                    return false;
                }
            });            
        });
        
        if(qtyReceivedError == countRow){
            bootbox.alert("Minimal one product must be filled with received qty larger than 0");
            return false;
        }
        
        if(countRow == 1) {
            if(batchNumError > 0){
                bootbox.alert("Batch Number is empty!");
                return false;
            }
            if(manDateError > 0){
                bootbox.alert("Manufacture Date is empty!");
                return false;
            }
            if(expiredDateError > 0){
                bootbox.alert("Expired date or retest date is empty!");
                return false;
            }
        }
       
    });

    $('.goods-detail-table').on('click','.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
        }
    });
        
    function addRow(productID, productName, uomID, uomName, qty, packID, packName, packQty, qtyReceived, batchNumber, hsCode, manufactureDate, expireDate, retestDate, condition, temperature, notes){
        var template = rowTemplate;
        
        if (temperature == undefined) { temperature = ''; }
        if (notes == undefined) { notes = ''; }
        
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{qty}}', formatNumber(qty));
        template = replaceAll(template, '{{packID}}', packID);
        template = replaceAll(template, '{{packName}}', packName);
        template = replaceAll(template, '{{packQty}}', formatNumber(packQty));
        template = replaceAll(template, '{{qtyReceived}}', formatNumber(qtyReceived));
        template = replaceAll(template, '{{batchNumber}}', batchNumber);
        template = replaceAll(template, '{{hsCode}}', hsCode);
        template = replaceAll(template, '{{manufactureDate}}', manufactureDate);
        template = replaceAll(template, '{{expireDate}}', expireDate);
        template = replaceAll(template, '{{retestDate}}', retestDate);
        template = replaceAll(template, '{{condition}}', condition);
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        template = replaceAll(template, '{{temperature}}', temperature);
        template = replaceAll(template, '{{notes}}', notes);
        
        $('.goods-detail-table tbody').append(template);

        $(".js-example-data-array-selected").select2({
            theme: "krajee"
        })

        $.ajax({
            url: '$getHsCodeAjax',
            async: false,
            type: 'POST',
            data: { productID: productID },
            success: function(data) {
                refillDataSelect2(data, "[name='TrGoodsreceipthead[joinGoodsReceiptDetail][" + getMaximumCounter() + 1 + "][hsCode]']");
            }
        });
    
        initInput();
    }
    
    function productIDExistsInTable(barcode){
        var exists = false;
        $('.goodsDetailProductID').each(function(){
            if($(this).val() == barcode){
                exists = true;
            }
        });
        return exists;
    }

    function getMaximumCounter() {
        var maximum = 0;
         $('.goodsDetailProductID').each(function(){
            value = parseInt($(this).attr('data-key'));
            if(value > maximum){
                maximum = value;
            }
        });
        return maximum;
    }

    $('.goods-detail-table tbody').each(function() {
        $('tr', this).each(function () {
            $(this).find("input.goodsDetailManDate").kvDatepicker(kvDatepicker_6f38f609);
            $(this).find("input.goodsDetailExpiredDate").kvDatepicker(kvDatepicker_6f38f609);
            $(this).find("input.goodsDetailRetestDate").kvDatepicker(kvDatepicker_6f38f609);
        })
    });
    
});
SCRIPT;
$this->registerJs($js);
?>