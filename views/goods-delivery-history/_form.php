<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use app\models\MsWarehouse;
use app\models\MsCustomer;
use app\models\MsCustomerdetail;
use app\models\LkStatus;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsdeliveryhead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-goodsdeliveryhead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Goods Delivery Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'refNum')->textInput(['class' => 'refNum', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'transType')->textInput(['maxlength' => true, 'class' => 'refInput-1', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'invoiceNum')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'goodsDeliveryDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'goodsDeliveryTime')->widget(TimePicker::classname(), [
                                    'pluginOptions' => [
                                        'showMeridian' => false,
                                        'minuteStep' => 1
                                    ]
                                ]) 
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'sendTo')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'deliveryNum')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'deliveryStatus')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(LkStatus::find ()->distinct()->all(), 'statusID', 'statusName' ),
                                    'options' => [
                                        'class' => 'form-control',
                                        ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'customerDetailID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCustomerdetail::find()->where('customerID = '.$model->customerID)->all(), 'customerDetailID', 'addressType' ),
                                    'options' => [
                                        'class' => 'form-control',
                                        ],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'warehouseID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsWarehouse::find()->where('flagActive = 1')->all(), 'warehouseID', 'warehouseName'),
                                    'options' => [
                                        'prompt' => 'Select Warehouse',
                                        'id' => 'selectWarehouse',
                                        'class' => 'form-control selectWarehouse'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'shipmentBy')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Goods Delivery Detail</div>
                <div class="panel-body">
                    <div class="row goodsDetailLayout">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table table-bordered goods-detail-table" style="border-collapse: inherit;">
                                    <thead>
                                        <tr id="table1">
                                            <th style="width: 20%;">Product Name</th>
                                            <th style="text-align: center; width: 20%;">
                                                <div class="row">
                                                    <div class="col-md-6">Unit</div>
                                                    <div class="col-md-6">Qty Outstanding</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">Pack</div>
                                                    <div class="col-md-6">Pack Qty</div>
                                                </div>
                                            </th>
                                            <th style="width: 10%;">
                                                Qty
                                            </th>
                                            <th style="text-align: center; width: 15%;">
                                                Batch Number
                                            </th>
                                            <th style="text-align: center; width: 15%;">
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
                                            <th style="text-align: center; min-width: 20%;">
                                                Notes
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <?php if (!isset($isView) ): ?>
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
$goodsDetail = \yii\helpers\Json::encode($model->joinGoodsDeliveryDetail);
$batchNumberDetail = \yii\helpers\Json::encode($model->joinStockDetail);
$getStockDetailAjax = Yii::$app->request->baseUrl. '/goods-delivery/get-stock-detail';
$refNumAjaxURL = Yii::$app->request->baseUrl. '/sales-order/checkdelivery';
if(!$isUpdate){
    $isUpdate = 0;
}
//var_dump($goodsDetail);
//yii::$app->end();
$deleteRow = '';
if (!isset($isUpdate)) {
$deleteRow = <<< DELETEROW
            "       <a class='btn btn-danger btn-sm btnDelete' style='width:100%;' href='#'><i class='glyphicon glyphicon-remove'></i>Delete</a>" +
DELETEROW;

$duplicateRow = <<< DUPLICATEROW
            "       <a class='btn btn-primary btn-sm btnAdd' style='width:100%;' data-toggle='tooltip' title='Duplicate Product' href='#'><i class='glyphicon glyphicon-plus'></i>Add</a>" +
DUPLICATEROW;
}
$js = <<< SCRIPT

$(document).ready(function () {

    var initValue = $goodsDetail;
    console.log(initValue);
    var dataBatchNumber = $batchNumberDetail;
    var updates = $isUpdate ;
    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='goodsDetailProductID' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <input type='text' class='form-control goodsDetailProductName' readonly='true' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][productName]' value='{{productName}}'>" +
        "   </td>" +
        "       <input type='hidden' class='goodsDetailUomID' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-6'>" +   
        "           <input type='text' class='form-control goodsDetailUomName' readonly='true' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][uomName]' value='{{uomName}}' style=' margin-right:10px;'>" +
        "       </div>" + 
        "       <div class='col-md-6'>" +
        "           <input type='text' class='form-control goodsDetailQtyOutstanding' readonly='true' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][qtyOutstanding]' value='{{qtyOutstanding}}' style='width:80%;'>" +
        "       </div></div>" + 
        "       <input type='hidden' class='goodsDetailPackID' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][packID]' value='{{packID}}' >" +
        "       <div class='row'><div class='col-md-6'>" +   
        "       <input type='text' class='form-control goodsDetailPackName' readonly='true' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][packName]' value='{{packName}}' style='margin-right:10px;'>" +
        "       </div>" + 
        "       <div class='col-md-6'>" +
        "       <input type='text' class='form-control goodsDetailPackQty' readonly='true' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][packQty]' value='{{packQty}}' style='width:80%;'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-left'>" +
        "       <input type='text' class='form-control goodsDetailQty' $isUpdate ? readonly='true' : ''  name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][qty]' value='{{qty}}'>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "           <select id='selectBatch' class='js-example-data-array-selected form-control goodsDetailBatchNum' style='width: 100%;' id='batch[{{Count}}]'  name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][batchNumber]' value='{{batchNumber}}'  disable='true'> " +
        "               <option value='{{batchNumberID}}' selected='selected'>{{batchNumber}}</option> " +
        "           </select> " +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control goodsDetailManDate' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][manufactureDate]' value='{{manufactureDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control goodsDetailExpiredDate' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][expiredDate]' value='{{expiredDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control goodsDetailRetestDate' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][retestDate]' value='{{retestDate}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-left'>" +
        "       <textarea rows='5' maxlength='100' class='form-control goodsDetailNotes' name='TrGoodsdeliveryheadhistory[joinGoodsDeliveryDetail][{{Count}}][notes]'>{{notes}}</textarea>" +
        "   </td>" +
        "</tr>";

    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qtyOutstanding.toString(), entry.packID.toString(), entry.packName.toString(), entry.packQty.toString(), entry.qty.toString(), entry.batchNumberID.toString(), entry.batchNumber.toString(), entry.manufactureDate.toString(), entry.expiredDate.toString(), entry.retestDate.toString(),  entry.notes.toString());
    });
        
    $('.selectWarehouse').change(function (e) {
        var warehouseID = $(this).val();
        var count = 1;
        $('.goods-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var productID = $(this).find("input.goodsDetailProductID").val();
                $.ajax({
                    url: '$getStockDetailAjax',
                    async: false,
                    type: 'POST',
                    data: { warehouseID: warehouseID, productID: productID },
                    success: function(data) {
                        refillDataSelect2(data, "[name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][" + count + "][batchNumber]']");
                    }
                });
                var arr = $("[name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][" + count + "][batchNumber]']").val().split('|');
                $(this).find("input.goodsDetailQtyOutstanding").val(convertDecimaltoString(arr[1]));
                $(this).find("input.goodsDetailManDate").val(arr[2]);
                $(this).find("input.goodsDetailExpiredDate").val(arr[3]);
                $(this).find("input.goodsDetailRetestDate").val(arr[4]);
                count = count + 1;
            })
        });

        
    });
    
    $('.goods-detail-table .btnAdd').on('click', function (e) {   
        e.preventDefault();
        var productID = $(this).parents('tr').find('.goodsDetailProductID').val();
        var productName = $(this).parents('tr').find('.goodsDetailProductName').val();
        var uomID = $(this).parents('tr').find('.goodsDetailUomID').val();
        var uomName = $(this).parents('tr').find('.goodsDetailUomName').val();
        var qtyOutstanding = $(this).parents('tr').find('.goodsDetailQtyOutstanding').val();
        var qty = $(this).parents('tr').find('.goodsDetailQty').val();
        var packID = $(this).parents('tr').find('.goodsDetailPackID').val();
        var packName = $(this).parents('tr').find('.goodsDetailPackName').val();
        var packQty = $(this).parents('tr').find('.goodsDetailPackQty').val();
        var batchNumberID = $(this).parents('tr').find('.goodsDetailBatchNum').val();
        var batchNumber = $(this).parents('tr').find('.goodsDetailBatchNum option:selected').text();
        var manufactureDate = $(this).parents('tr').find('.goodsDetailManDate').val();
        var expiredDate = $(this).parents('tr').find('.goodsDetailExpiredDate').val();
        var retestDate = $(this).parents('tr').find('.goodsDetailRetestDate').val();
        
        qtyOutstanding = convertStringtoDecimal(qtyOutstanding);
        
        var qtyOutstandingStr = qtyOutstanding;

        qty = convertStringtoDecimal(qty);
        
        var qtyStr = qty;
        
        if(productID=="" || productID==undefined){
            bootbox.alert("Select Product");
            $('.productDetailInput-0').focus();
            return false;
        }

        addRow(productID, productName, uomID, uomName, qtyOutstandingStr, packID, packName, packQty, qtyStr, batchNumberID, batchNumber, manufactureDate, expiredDate, retestDate);

        var copiedOptions = $(this).parents('tr').find('.goodsDetailBatchNum > option').clone();
        $("[name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][" + getMaximumCounter() + "][batchNumber]']").find('option').remove().end();
        $("[name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][" + getMaximumCounter() + "][batchNumber]']").append(copiedOptions);
    });

    $('.goods-detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
            calculateSummary();
        }
    });

    $('.goods-detail-table').on('change', '.goodsDetailQty', function (e) {
        var qtyOutstanding = $(this).parents('tr').find('.goodsDetailQtyOutstanding').val();
        var qty = $(this).parents('tr').find('.goodsDetailQty').val();
        
      
    
        qtyOutstanding = replaceAll(qtyOutstanding, ".", "");
        qtyOutstanding = replaceAll(qtyOutstanding, ",", ".");
        qtyOutstanding = parseFloat(qtyOutstanding);
        if (isNaN(qtyOutstanding)){
            qtyOutstanding = parseFloat(0);
        }
        if(qty > qtyOutstanding){
            bootbox.alert("Sent qty is larger than remaining qty");
        }
        if(qty < 0){
            bootbox.alert("Sent qty must not be less than 0");
        }
    });

    $('.goods-detail-table').on('change', '.goodsDetailBatchNum', function (e) {
        var batchNumberVal = $(this).parents().parents('tr').find('.goodsDetailBatchNum').val();
        var arr = batchNumberVal.split('|');
        $(this).parents().parents('tr').find(".goodsDetailQtyOutstanding").val(convertDecimaltoString(arr[1]));
        $(this).parents().parents('tr').find(".goodsDetailManDate").val(arr[2]);
        $(this).parents().parents('tr').find(".goodsDetailExpiredDate").val(arr[3]);
        $(this).parents().parents('tr').find(".goodsDetailRetestDate").val(arr[4]);
    });

    function addRow(productID, productName, uomID, uomName, qtyOutstanding, packID, packName, packQty, qty, batchNumberID, batchNumber, manufactureDate, expiredDate, retestDate, notes){
        var template = rowTemplate;
        qtyOutstanding = convertDecimaltoString(qtyOutstanding);
        //qty = "0,00";
        console.log("test");
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{qtyOutstanding}}', formatNumber(qtyOutstanding));
        template = replaceAll(template, '{{packID}}', packID);
        template = replaceAll(template, '{{packName}}', packName);
        template = replaceAll(template, '{{packQty}}', formatNumber(packQty));
        template = replaceAll(template, '{{qty}}', formatNumber(qty));
        template = replaceAll(template, '{{batchNumberID}}', batchNumberID);
        template = replaceAll(template, '{{batchNumber}}', batchNumber);
        template = replaceAll(template, '{{manufactureDate}}', manufactureDate);
        template = replaceAll(template, '{{expiredDate}}', expiredDate);
        template = replaceAll(template, '{{retestDate}}', retestDate);
        template = replaceAll(template, '{{notes}}', notes);
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        $('.goods-detail-table tbody').append(template);

        $(".js-example-data-array-selected").select2({
            theme: "krajee"
        })
        if(updates != 0)
        {
         document.getElementById("selectBatch").disabled = true;
         document.getElementById("selectWarehouse").disabled = true;
        }

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

    $('.goodsDetailManDate').kvDatepicker(kvDatepicker_6f38f609);
    $('.goodsDetailExpiredDate').kvDatepicker(kvDatepicker_6f38f609);
    $('.goodsDetailRetestDate').kvDatepicker(kvDatepicker_6f38f609);

    $('form').on("beforeValidate", function(){
        var countData = $('.goods-detail-table tbody tr').length;

        if(countData == 0){
            bootbox.alert("Minimum 1 detail must be filled");
            return false;
            
        }
    });
        
});
SCRIPT;
$this->registerJs($js);
?>
