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
use dosamigos\ckeditor\CKEditor;
use endrikexe\ClientScript;

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
                            <div class="form-group" style="overflow-x:scroll;">
                                <table class="table table-bordered goods-detail-table" style="border-collapse: inherit; width: unset !important; max-width: none !important;">
                                    <thead>
                                        <tr id="table1">
                                            <th style="min-width: 200px;">Product Name</th>
                                            <th style="text-align: center; min-width: 250px;">
                                                <div class="row">
                                                    <div class="col-md-6">Unit</div>
                                                    <div class="col-md-6">Available Qty</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">Pack</div>
                                                    <div class="col-md-6">Pack Qty</div>
                                                </div>
                                            </th>
                                            <th style="min-width: 120px;">
                                                <div class="row">
                                                    Qty Outstanding
                                                </div>
                                                <div class="row">
                                                    Qty
                                                </div>
                                            </th>
                                            <th style="min-width: 150px; text-align: center;">
                                                Batch Number
                                            </th>
                                            <th style="min-width: 120px; text-align: center;">
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
                                            <th style="text-align: center; min-width: 200px;">
                                                Notes
                                            </th>
                                            <th style="text-align: center; min-width: 150px;">
                                                
                                            </th>
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
            <div class="panel panel-default">
                <div class="panel-heading">Transaction Summary</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'additionalInfo')->widget(CKEditor::className(), [
                                'options' => ['rows' => 6],
                                'preset' => 'standard'
                            ]) ?>
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
<script>
function testBatchNum ()
{
    result = true;
    $('.goodsDetailBatchNum').each(function(index, element)
    {
        if ($(this).val() == null || $(this).val() == '')
        {
            bootbox.alert('Batch Number cannot be blank');
            result = false;
            return;
        }
    });
    
    $('.goodsDetailQty').each(function(index, element)
    {
        if ($(this).val() <= 0 || $(this).val() == '0,00')
        {
            bootbox.alert('Qty must be large to 0');
            result = false;
            return;
        }
    });
    
    
    return result;
}
</script>
<?php
$goodsDetail = \yii\helpers\Json::encode($model->joinGoodsDeliveryDetail);
$batchNumberDetail = \yii\helpers\Json::encode($model->joinStockDetail);
$getStockDetailAjax = Yii::$app->request->baseUrl. '/goods-delivery/get-stock-detail';
$refNumAjaxURL = Yii::$app->request->baseUrl. '/sales-order/checkdelivery';
$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "       <a class='btn btn-danger btn-sm btnDelete' style='width:100%;' href='#'><i class='glyphicon glyphicon-remove'></i>Delete</a>" +
DELETEROW;

$duplicateRow = <<< DUPLICATEROW
            "       <a class='btn btn-primary btn-sm btnAdd' style='width:100%;' data-toggle='tooltip' title='Duplicate Product' href='#'><i class='glyphicon glyphicon-plus'></i>Add</a>" +
DUPLICATEROW;
}
ClientScript::singleton()->beginScript('js'); ?>
<script>
$(document).ready(function () {

    var initValue = <?=$goodsDetail?>;
    var dataBatchNumber = <?=$batchNumberDetail?>;

    var rowTemplate = "" +
        "<tr>" +
        "       <input type='hidden' class='goodsDetailProductID' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <input type='text' class='form-control goodsDetailProductName' readonly='true' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][productName]' value='{{productName}}'>" +
        "   </td>" +
        "       <input type='hidden' class='goodsDetailUomID' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-6'>" +   
        "           <input type='text' class='form-control goodsDetailUomName' readonly='true' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][uomName]' value='{{uomName}}' style=' margin-right:10px;'>" +
        "       </div>" + 
        "       <div class='col-md-6'>" +
        "           <input type='text' class='form-control goodsDetailAvailableQty' readonly='true' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][availableQty]' value='{{availableQty}}' style='width:80%;'>" +
        "       </div></div>" + 
        "       <input type='hidden' class='goodsDetailPackID' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][packID]' value='{{packID}}' >" +
        "       <div class='row'><div class='col-md-6'>" +   
        "       <input type='text' class='form-control goodsDetailPackName' readonly='true' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][packName]' value='{{packName}}' style='margin-right:10px;'>" +
        "       </div>" + 
        "       <div class='col-md-6'>" +
        "       <input type='text' class='form-control goodsDetailPackQty' readonly='true' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][packQty]' value='{{packQty}}' style='width:80%;'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-left'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control goodsDetailQtyOutstanding' readonly='true' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][qtyOutstanding]' value='{{qtyOutstanding}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "       <input type='text' class='form-control goodsDetailQty' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][qty]' value='{{qty}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-center'>" +
        "           <select class='js-example-data-array-selected form-control goodsDetailBatchNum' style='width: 100%;' id='batch[{{Count}}]' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][batchNumber]' value='{{batchNumber}}'> " +
        "               <option value='{{batchNumberID}}' selected='selected'>{{batchNumber}}</option> " +
        "           </select> " +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control goodsDetailManDate' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][manufactureDate]' value='{{manufactureDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control goodsDetailExpiredDate' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][expiredDate]' value='{{expiredDate}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' readonly='true' class='form-control goodsDetailRetestDate' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][retestDate]' value='{{retestDate}}'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td class='text-left'>" +
        "       <textarea rows='5' maxlength='100' class='form-control goodsDetailNotes' name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][{{Count}}][notes]'>{{notes}}</textarea>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        <?=$duplicateRow?>
        <?=$deleteRow?>
        "       </div></div>" + 
        "   </td>" +
        "</tr>";

    initValue.forEach(function(entry) {
        addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), 
            entry.availableQty.toString(), entry.qtyOutstanding.toString(), entry.packID.toString(), entry.packName.toString(), 
            entry.packQty.toString(), entry.qty.toString(), entry.batchNumberID.toString(), entry.batchNumber.toString(), 
            entry.manufactureDate.toString(), entry.expiredDate.toString(), entry.retestDate.toString(), entry.notes.toString());
    });
        
    $('.selectWarehouse').change(function (e) {
        var warehouseID = $(this).val();
        var count = 1;
        $('.goods-detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var productID = $(this).find("input.goodsDetailProductID").val();
                $.ajax({
                    url: '<?=$getStockDetailAjax?>',
                    async: false,
                    type: 'POST',
                    data: { warehouseID: warehouseID, productID: productID },
                    success: function(data) {
                        console.log("data: "+data);
                        refillDataSelect2(data, "[name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][" + count + "][batchNumber]']");
                    }
                });
                var defBatch = $("[name='TrGoodsdeliveryhead[joinGoodsDeliveryDetail][" + count + "][batchNumber]']").val();
                var availableQty = 0, mfgDate = null, expDate = null, retestDate = null;
                if (defBatch)
                {
                    var arr = defBatch.split('|');
                    if (arr.length > 1)
                    {
                        availableQty = convertDecimaltoString(arr[1]);
                        mfgDate = arr[2];
                        expDate = arr[3];
                        retestDate = arr[4];
                    }
                }
                
                $(this).find("input.goodsDetailAvailableQty").val(availableQty);
                $(this).find("input.goodsDetailManDate").val(mfgDate);
                $(this).find("input.goodsDetailExpiredDate").val(expDate);
                $(this).find("input.goodsDetailRetestDate").val(retestDate);
                count = count + 1;
            })
        });

        
    });
    
    $('.btnSave').on('click', function (e)
    {
        if (!testBatchNum())
        {
            return false;
        }
    });
        
    $('.goods-detail-table .btnAdd').on('click', function (e) {   
        e.preventDefault();
        var productID = $(this).parents('tr').find('.goodsDetailProductID').val();
        var productName = $(this).parents('tr').find('.goodsDetailProductName').val();
        var uomID = $(this).parents('tr').find('.goodsDetailUomID').val();
        var uomName = $(this).parents('tr').find('.goodsDetailUomName').val();
        var availableQty = $(this).parents('tr').find('.goodsDetailAvailableQty').val();
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
        
        var availableQtyStr = availableQty;
        availableQty = availableQty.currencyToFloat();
        
        var qtyOutstandingStr = qtyOutstanding;
        qtyOutstanding = qtyOutstanding.currencyToFloat();

        var qtyStr = qty;
        qty = qty.currencyToFloat();
        
        qtyOutstanding = qtyOutstanding - qty;
        qty = 0;
        
        if(productID=="" || productID == undefined){
            bootbox.alert("Select Product");
            $('.productDetailInput-0').focus();
            return false;
        }
        
        if (!testBatchNum())
        {
            return false;
        }

        addRow(productID, productName, uomID, uomName, availableQtyStr, qtyOutstanding, packID, packName, packQty, 0, batchNumberID, batchNumber, manufactureDate, expiredDate, retestDate, '');

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
        var availableQty = $(this).parents('tr').find('.goodsDetailAvailableQty').val().currencyToFloat();
        var qtyOutstanding = $(this).parents('tr').find('.goodsDetailQtyOutstanding').val().currencyToFloat();
        var qty = $(this).val();

        console.log("available: "+availableQty);
        console.log("outstanding: "+qtyOutstanding);
        console.log("current: "+qty);

        if(qty > qtyOutstanding){
            bootbox.alert("Sent qty is larger than remaining qty");
            $(this).parents('tr').find('.goodsDetailQty').val(0);
        }
        if (qty > availableQty) {
            bootbox.alert("Sent qty is larger than available stock qty");
            $(this).parents('tr').find('.goodsDetailQty').val(0);
        }
        if(qty <= 0){
            bootbox.alert("Sent qty must not be less than 0");
        }
    });

    $('.goods-detail-table').on('change', '.goodsDetailBatchNum', function (e) {
        var batchNumberVal = $(this).parents().parents('tr').find('.goodsDetailBatchNum').val();
        var availableQty = 0, mfgDate = null, expDate = null, retestDate = null;
        if (batchNumberVal)
        {
            var arr = batchNumberVal.split('|');
            if (arr.length > 1)
            {
                availableQty = convertDecimaltoString(arr[1]);
                mfgDate = arr[2];
                expDate = arr[3];
                retestDate = arr[4];
            }
        }
        
        $(this).parents().parents('tr').find(".goodsDetailAvailableQty").val(availableQty);
        $(this).parents().parents('tr').find(".goodsDetailManDate").val(mfgDate);
        $(this).parents().parents('tr').find(".goodsDetailExpiredDate").val(expDate);
        $(this).parents().parents('tr').find(".goodsDetailRetestDate").val(retestDate);
    });

    function addRow(productID, productName, uomID, uomName, availableQty, qtyOutstanding, packID, packName, packQty, qty, batchNumberID, batchNumber, manufactureDate, expiredDate, retestDate, notes){
        var template = rowTemplate;
        //availableQty = convertDecimaltoString(availableQty);
        //qtyOutstanding = convertDecimaltoString(qtyOutstanding);
        //qty = "0,00";
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{availableQty}}', formatNumber(availableQty));
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
</script>
<?php ClientScript::singleton()->endScript(); ?>