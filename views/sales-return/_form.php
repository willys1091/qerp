<?php

use app\components\AppHelper;
use app\components\JsBlock;
use app\models\MsCoa;
use app\models\MsCustomer;
use app\models\TrSalesreturnhead;
use kartik\money\MaskMoney;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\widgets\MaskedInput;

/* @var $this View */
/* @var $model TrSalesreturnhead */
/* @var $form ActiveForm2 */
?>

<div class="tr-salesreturnhead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Basic Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'salesReturnDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isApprove)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'customerID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCustomer::find(['flagActive' => 1])->orderBy(['customerName'=>SORT_ASC])->all(), 'customerID', 'customerName'),
                                    'options' => [
                                        'prompt' => 'Select Customer',
                                        'class' => 'form-control selectCustomer'
                                        ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'coaNo')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find()->where('coaLevel = 4')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Reason'],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'fakturNum')->textInput(['maxlength' => true]) ?>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered detail-table" style="border-collapse: inherit;">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%;">Reference</th>
                                        <th style="width: 20%;">
                                            <div class="row">
                                                Product Name
                                            </div>
                                            <div class="row">
                                                Unit
                                            </div>
                                        </th>
                                        <th style="width: 10%;">
                                            <div class="row">
                                                Sent Qty
                                            </div>
                                            <div class="row">
                                                Returned Qty
                                            </div>
                                            </th>
                                        <th style="width: 10%;">HPP</th>
                                        <th style="width: 5%;">Tax</th>
                                        <th style="width: 15%;">Subtotal</th>
                                        <th style="width: 15%;">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <?php if (!isset($isView)): ?>
                                                                        <tfoot>
                                    <tr>
                                        <td>
                                            <div class = "newinput-group">
                                                <?= Html::textInput('refNum', '', [
                                                    'class' => 'form-control refDetailInput-0'
                                                ]) ?>
                                                <div class="input-group-btn">
                                                <?= Html::a("...", ['goods-delivery/browsebycustomer'], [
                                                         'title' => 'Browse Goods Receipt',
                                                        'data-filter-input' => '.selectCustomer',
                                                        'data-target-value' => '.refIDInput',
                                                        'data-target-text' => '.refDetailInput',
                                                        'data-target-width' => '1000',
                                                        'data-target-height' => '600',
                                                        'class' => 'btn btn-primary btn-sm WindowDialogBrowse'
                                                    ])?>
                                                </div>
                                            </div>         
                                        </td>
                                        <td class="visibility: hidden">
                                            <?= Html::hiddenInput('productID', '', [
                                                'class' => 'form-control productIDInput'
                                            ]) ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class = "newinput-group">
                                                        <?= Html::textInput('productName', '', [
                                                            'class' => 'form-control productDetailInput-0'
                                                        ]) ?>
                                                        <div class="input-group-btn">
                                                        <?= Html::a("...", ['product/browsebygd'], [
                                                                 'title' => 'Browse product',
                                                                'data-filter-input' => '.refDetailInput-0',
                                                                'data-target-value' => '.productIDInput',
                                                                'data-target-text' => '.productDetailInput',
                                                                'data-target-width' => '1000',
                                                                'data-target-height' => '600',
                                                                'class' => 'btn btn-primary btn-sm WindowDialogBrowse productBrowse'
                                                            ])?>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= Html::textInput('uomName', '', [
                                                        'class' => 'form-control productDetailInput-2 text-center',
                                                        'readonly' => 'readonly'
                                                    ]) ?>
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= Html::textInput('sentQty', '0', [
                                                        'class' => 'form-control productDetailInput-3 text-right',
                                                        'readonly' => 'readonly'
                                                    ]) ?>
                                                
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?= MaskedInput::widget([
                                                        'name' => 'returnedQty',
                                                        'value' => '0',
                                                        'clientOptions' => [
                                                            'alias' => 'decimal',
                                                             'digits' => 4,
                                                             'digitsOptional' => false,
                                                             'radixPoint' => ',',
                                                            'groupSeparator' => '.',
                                                            'autoGroup' => true,
                                                            'removeMaskOnSubmit' => false
                                                        ],
                                                        'options' =>[
                                                        'class' => 'form-control productDetailReturnedQty text-right'
                                                        ],
                                                        
                                                    ]) ?>
                                                </div>
                                            </div>  
                                            
                                        </td>
                                        <td>
                                            <?= MaskedInput::widget([
                                                'name' => 'HPP',
                                                'value' => '0',
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
                                                    'class' => 'form-control productDetailInput-4 text-right',
                                                    'readonly' => 'readonly'
                                                ],
                                                
                                            ]) ?>
                                        </td>
                                        <td style="text-align: center;">
                                          <?= Html::checkbox("tax", 0, ['class' => 'text-center taxInput']) ?>
                                        </td>
                                        <td>
                                            <?= MaskMoney::widget([
                                                'name' => 'subtotal',
                                                'disabled' => true,
                                                'options' => [
                                                'class' => 'form-control productDetailSubtotal text-right'
                                                ],
                                            ]) ?>
                                        </td>
                                        <td>
                                            <?= Html::textArea('notes', '', [
                                                'class' => 'form-control productDetailNotes',
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
                                    <label class="control-label text-right">Sub Total</label>
                                    <?= Html::textInput('subtotal', '0,00', [
                                        'class' => 'form-control subTotalSummary text-right',
                                        'readonly' => 'readonly'
                                    ]) ?>
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label text-right">Tax Total</label>
                                    <?= Html::textInput('taxTotal', '0,00', [
                                        'class' => 'form-control taxTotalSummary text-right',
                                        'readonly' => 'readonly'
                                    ]) ?>
                                </div>
                                <div class="col-md-12">
                                    <?= $form->field($model, 'grandTotal')
                                     ->widget(MaskedInput::classname(), [
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


<?php JsBlock::begin() ?>
<script>
<?php

$deleteRow = '';
if (!isset($isView)) {
$deleteRow = <<< DELETEROW
            "       <a class='btn btn-danger btn-sm btnDelete' href='#' style='width:80px;'><i class='glyphicon glyphicon-remove'></i> Delete</a>" +
DELETEROW;
}
?>

$(document).ready(function () {
    var initValue = <?=Json::encode($model->joinSalesReturnDetail);?>;
    var taxValue = '0';
    console.log(initValue);

    var rowTemplate = "" +
        "<tr>" +
        "   <td class='text-left'>" +
        "       <input type='text' class='form-control tableDetailRefNum' readonly='true' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][refNum]' value='{{refNum}}'>" +
        "   </td>" +
        "       <input type='hidden' class='tableDetailProductID' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][productID]' data-key='{{Count}}' value='{{productID}}' >" +
        "       {{productID}}" +
        "   <td class='text-left'>" +
        "       <div class='row'><div class='col-md-12'>" +   
        "           <input type='text' class='form-control tableDetailProductName' readonly='true' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][productName]' value='{{productName}}'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +  
        "           <input type='text' class='form-control tableDetailUomName' readonly='true' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][uomName]' value='{{uomName}}' style=' margin-right:10px;'>" +
        "       </div></div>" + 
        "   </td>" +
        "       <input type='hidden' class='tableDetailUomID' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][uomID]' value='{{uomID}}' > {{uomID}}" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +
        "           <input type='text' class='form-control tableDetailSentQty' readonly='true' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][sentQty]' value='{{sentQty}}' style='width:80%;'>" +
        "       </div></div>" + 
        "       <div class='row'><div class='col-md-12'>" +
        "           <input type='text' class='form-control tableDetailReturnedQty' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][returnedQty]' value='{{returnedQty}}' style='width:80%;'>" +
        "       </div></div>" + 
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control tableDetailHPP text-right' readonly='true' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][HPP]' value='{{HPP}}'>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <input type='hidden' class='tableDetailTaxValue' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][taxValue]' value='{{taxValue}}' > " +
        "       <input type='checkbox' class='tableDetailTax' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][tax]' onclick='return false' {{tax}} >" +
        "   </td>" +
        "   <td>" +
        "       <input type='text' class='form-control tableDetailSubtotal text-right' readonly='true' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][subtotal]' value='{{subtotal}}'>" +
        "   </td>" +
        "   <td class='text-center' >" +
        "       <input type='text' class='form-control tableDetailNotes' name='TrSalesreturnhead[joinSalesReturnDetail][{{Count}}][notes]' value='{{notes}}'>" +
        "   </td>" +
        "   <td class='text-center'>" +
        "       <div class='row'><div class='col-md-12'>" +  
        <?=$deleteRow?>
        "       </div></div>" + 
        "   </td>" +
        "</tr>";
        
    initValue.forEach(function(entry) {
        addRow(entry.refNum.toString(), entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.sentQty.toString(), entry.qty.toString(), entry.HPP.toString(), entry.VAT.toString(),entry.tax.toString(),entry.totalAmount.toString(), entry.notes.toString());
    });

    $('.detail-table').on('change', '.goodsDetailQtyReceived', function (e) {
        var qtyOutstanding = $(this).parents().parents('tr').find('.goodsDetailQty').val();
        var qtyReceived = $(this).parents().parents('tr').find('.goodsDetailQtyReceived').val();
        console.log('wkwkwk');
        qtyOutstanding = replaceAll(qtyOutstanding, ".", "");
        qtyOutstanding = replaceAll(qtyOutstanding, ",", ".");
        qtyOutstanding = parseFloat(qtyOutstanding);
        if (isNaN(qtyOutstanding)){
            qtyOutstanding = parseFloat(0);
        }
        if(qtyReceived > qtyOutstanding){
            bootbox.alert("Received qty is larger than remaining qty");
        }
        if(qtyReceived < 0){
            bootbox.alert("Received qty must not be less than 0");
        }
    });

    $('.taxInput').change(function(){
        var subtotal = 0;
        var HPP = $('.productDetailInput-4').val();
        var returnedQty = $('.productDetailReturnedQty').val();

        HPP = replaceAll(HPP, ".", "");
        HPP = replaceAll(HPP, ",", ".");
        HPP = parseFloat(HPP);

        returnedQty = replaceAll(returnedQty, ".", "");
        returnedQty = replaceAll(returnedQty, ",", ".");
        returnedQty = parseFloat(returnedQty);

        if($(this).is(":checked")) {
            subtotal = HPP*returnedQty*1.1;
            subtotal = subtotal.toFixed(2);
            subtotal = replaceAll(subtotal, ".", ",");
            $('.productDetailSubtotal').val(formatNumber(subtotal));
        }
        else{
            subtotal = HPP*returnedQty;
            subtotal = subtotal.toFixed(2);
            subtotal = replaceAll(subtotal, ".", ",");
            $('.productDetailSubtotal').val(formatNumber(subtotal));
        }
    });

    $('.productDetailReturnedQty').change(function(){
        var subtotal = 0;
        var HPP = $('.productDetailInput-4').val();
        var returnedQty = $('.productDetailReturnedQty').val();
       
        HPP = replaceAll(HPP, ".", "");
        HPP = replaceAll(HPP, ",", ".");
        HPP = parseFloat(HPP);

        returnedQty = replaceAll(returnedQty, ".", "");
        returnedQty = replaceAll(returnedQty, ",", ".");
        returnedQty = parseFloat(returnedQty);

        if($('.taxInput').is(":checked")) {
            subtotal = Math.round(HPP*returnedQty*1.1);
            subtotal = subtotal.toFixed(2);
            subtotal = replaceAll(subtotal, ".", ",");
            
            $('.productDetailSubtotal').val(formatNumber(subtotal));
        }
        else{
            subtotal = Math.round(HPP*returnedQty);
            subtotal = subtotal.toFixed(2);
            subtotal = replaceAll(subtotal, ".", ",");
          
            $('.productDetailSubtotal').val(formatNumber(subtotal));
        }
    });

    $('.btnAdd').on('click', function (e) {
        e.preventDefault();
         console.log('wikiwkiwkiwki');
        var refNum = $('.refDetailInput-0').val();
        var productID = $('.productIDInput').val();
        var productName = $('.productDetailInput-0').val();
        var uomID = $('.productDetailInput-1').val();
        var uomName = $('.productDetailInput-2').val();
        var sentQty = $('.productDetailInput-3').val();
        var returnedQty = $('.productDetailReturnedQty').val();
        var HPP = $('.productDetailInput-4').val();
        var tax = '';
        var subtotal = $('.productDetailSubtotal').val();
        var notes = $('.productDetailNotes').val();

        if($('.taxInput').is(':checked')){
            tax = 'checked';
            taxValue = '10';
        }else{
            taxValue = '0';
            tax = '';
        }
         console.log('wikiwkiwkiwki');
        console.log(sentQty);
        console.log(returnedQty);
        console.log(HPP);
        console.log(subtotal);
        sentQty = replaceAll(sentQty, ".", "");
        sentQty = replaceAll(sentQty, ",", ".");
        
        returnedQty = replaceAll(returnedQty, ".", "");
        returnedQty = replaceAll(returnedQty, ",", ".");
        
        HPP = replaceAll(HPP, ".", "");
        HPP = replaceAll(HPP, ",", ".");
        
        subtotal = replaceAll(subtotal, ".", "");
        subtotal = replaceAll(subtotal, ",", ".");
//     
        var sentQtyStr = sentQty;
        var returnedQtyStr = returnedQty;
        var HPPStr = HPP;
        var subtotalStr = subtotal;
        
        if(productID=="" || productID==undefined){
            bootbox.alert("Select Product");
            $('.productDetailInput-0').focus();
            return false;
        }

        if(returnedQty=="" || returnedQty==undefined || returnedQty < 0){
            bootbox.alert("Qty must be greater than 0");
            $('.productDetailReturnedQty').focus();
            return false;
        }

        if(!$.isNumeric(returnedQty)){
            bootbox.alert("Qty must be numeric");
            $('.productDetailReturnedQty').focus();
            return false;
        }

        returnedQty = parseFloat(returnedQty);

        if(returnedQty < 0){
            bootbox.alert("Qty must be greater than 0");
            $('.productDetailReturnedQty').focus();
            return false;
        }
  
        addRow(refNum, productID, productName, uomID, uomName, sentQtyStr, returnedQtyStr, HPPStr,taxValue, tax,subtotalStr, notes);
        calculateSummary();
        $('.refDetailInput-0').val('');
        $('.productIDInput').val('');
        $('.productDetailInput-0').val('');
        $('.productDetailInput-1').val('');
        $('.productDetailInput-2').val('');
        $('.productDetailInput-3').val('0,00');
        $('.productDetailInput-4').val('0,00');
        $('.productDetailReturnedQty').val('0,00');
        $('.productDetailSubtotal').val('0,00');
        $('.productDetailNotes').val('');
        $('.taxInput').prop("checked", false);
    });

    $('.btnSave').on('click', function (e) {
        var qtyReceivedError = 0;
        var countRow = 0;

        $('.detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var qtyReceived = $(this).find("input.tableDetailSentQty").val();
                qtyReceived = replaceAll(qtyReceived, ".", "");
                qtyReceived = replaceAll(qtyReceived, ",", ".");
                qtyReceived = parseFloat(qtyReceived);
                if (isNaN(qtyReceived)){
                    qtyReceived = parseFloat(0);
                }

                if(qtyReceived == 0){
                    qtyReceivedError = qtyReceivedError+1;
                }
                countRow = countRow + 1;
            });
            
        });
        if(qtyReceivedError == countRow){
            bootbox.alert("Minimal one product must be filled with received qty larger than 0");
            return false;
        }
    });

    
    
//    $('.btnDelete').on('click', function (e) {
//        var self = this;
//        e.preventDefault();
//         console.log('DELE');
//        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
//        function deleteRow(){
//            $(self).parents('tr').remove();
//        }
//    });
    
    
    $('.detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
            calculateSummary();
        }
    });


    function addRow(refNum, productID, productName, uomID, uomName, sentQty, returnedQty, HPP, taxValue ,tax,subtotal, notes){
        var template = rowTemplate;
        sentQty = replaceAll(sentQty, ".", ",");
        returnedQty = replaceAll(returnedQty, ".", ",");
        HPP = replaceAll(HPP, ".", ",");
        subtotal = replaceAll(subtotal, ".", ",");
       
        template = replaceAll(template, '{{refNum}}', refNum);
        template = replaceAll(template, '{{productID}}', productID);
        template = replaceAll(template, '{{productName}}', productName);
        template = replaceAll(template, '{{uomID}}', uomID);
        template = replaceAll(template, '{{uomName}}', uomName);
        template = replaceAll(template, '{{sentQty}}', formatNumber(sentQty));
        template = replaceAll(template, '{{returnedQty}}', formatNumber(returnedQty));
        template = replaceAll(template, '{{HPP}}', formatNumber(HPP));
        template = replaceAll(template, '{{taxValue}}', formatNumber(taxValue));
        template = replaceAll(template, '{{tax}}', tax);
        template = replaceAll(template, '{{subtotal}}', formatNumber(subtotal));
        template = replaceAll(template, '{{notes}}', notes);
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        
        $('.detail-table tbody').append(template);
         calculateSummary();
    }
    
    function calculateSummary()
    {
        var tempHPP = 0;
        var tempTax = 0;
        var tempSubtotal = 0;
        var grandTotal = 0;

        $('.detail-table tbody').each(function() {
            $('tr', this).each(function () {
                var HPP = $(this).find("input.tableDetailHPP").val();
                var taxValue = $(this).find("input.tableDetailTaxValue").val();
                var subtotal = $(this).find("input.tableDetailSubtotal").val();
                console.log(taxValue);
               
                HPP = replaceAll(HPP, ".", "");
                HPP = replaceAll(HPP, ",", ".");
                HPP = parseFloat(HPP);

                taxValue = parseFloat(taxValue);

                subtotal = replaceAll(subtotal, ".", "");
                subtotal = replaceAll(subtotal, ",", ".");
                subtotal = Math.round(subtotal);
                
                tempHPP = tempHPP + HPP;
                tempTax = tempTax + HPP*taxValue/100
                tempSubtotal = tempSubtotal + subtotal;
            })
        });
        tempHPP = tempHPP.toFixed(2);
        tempHPP = replaceAll(tempHPP, ".", ",");

        tempTax = tempTax.toFixed(2);
        tempTax = replaceAll(tempTax, ".", ",");

        grandTotal = tempSubtotal;
        grandTotal = grandTotal.toFixed(2);
        grandTotal = replaceAll(grandTotal, ".", ",");
        
        $('.subTotalSummary').val(formatNumber(tempHPP));
        $('.taxTotalSummary').val(formatNumber(tempTax));
        $('.grandTotalSummary').val(formatNumber(grandTotal));
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
         $('.tableDetailProductID').each(function(){
            value = parseInt($(this).attr('data-key'));
            if(value > maximum){
                maximum = value;
            }
        });
        return maximum;
    }

    $('form').on("beforeValidate", function(){
        
    });
});
</script>

<?php JsBlock::end() ?>