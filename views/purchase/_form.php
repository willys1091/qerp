<?php

use app\components\AppHelper;
use app\components\JsBlock;
use app\models\LkPaymentmethod;
use app\models\MsCurrency;
use app\models\MsPaymentdue;
use app\models\MsSupplier;
use app\models\MsSuppliercontactdetail;
use app\models\MsTax;
use app\models\TrPurchaseorderhead;
use dosamigos\ckeditor\CKEditor;
use kartik\checkbox\CheckboxX;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\widgets\MaskedInput;
use yii\widgets\MaskedInputAsset;
use yii\widgets\Pjax;
/* @var $this View */
/* @var $model TrPurchaseorderhead */
/* @var $form ActiveForm2 */

MaskedInputAsset::register($this);
?>

<div class="tr-purchaseorderhead-form" id="app">

    <?php $form = ActiveForm::begin([
        
        'options' => [
            'id' => 'form-purchase'
        ]
        
    ]);
        
    ?>

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
                            <?= $form->field($model, 'purchaseOrderDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isView)])) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'refNum', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['sales-order/browse-from-purchase'], [
                                            'title' => 'Sales Order Code',
                                            'data-filter-Input' => '.refNum',
                                            'data-target-value' => '.refNum',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse salesOrderBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refNum', 'readonly' => 'readonly']) ?>
                        </div>
                        <div class="col-md-4">
                           
                            <?=
                            $form->field($model, 'supplierID')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(MsSupplier::find(['flagActive' => 1])->orderBy(new yii\db\Expression("REPLACE(supplierName, ' ', '') ASC"))->all(), 'supplierID', 'supplierName'),
                                'options' => [
                                    'prompt' => 'Select Supplier',
                                    'class' => 'supplierID'
                                ],
                                'pluginEvents' => [
                                    "select2:open" => "function() { this.oldvalue = this.value; }",
                                ]
                            ])

                            ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'contactPerson')->widget(Select2::classname(),[
                                    'options' => [
                                        'prompt' => 'Select Contact Person',
                                        'class' => 'contactPerson'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'contactPersonCC')->widget(Select2::classname(),[
                                    'options' => [ 
                                        'multiple' => true,
                                        'class' => 'contactPersonCC'],
                                ]);
                            ?>
                        </div> 
					    <div class="col-md-4">
                            <?= $form->field($model, 'revitionNotes')->textInput(['maxlength' => true]) ?>
                        </div>
                        <input type="checkbox" id="trpurchaseorderhead-isimport" class="isImport isImportValue hidden " name="TrPurchaseorderhead[isImport]" value="1">
                        <input type="checkbox" id="trpurchaseorderhead-hasvat" class="hasVAT VATValue hidden" name="TrPurchaseorderhead[hasVAT]" value="1">
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
                            <?php /* $form->field($model, 'rate')
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
                                                    'class' => 'form-control currencyRate'
                                                ],
                                            ])*/?>
                            <label class="control-label text-right">Rate</label>
                                <app-decimal name="TrPurchaseorderhead[rate]" v-bind:class="'currencyRate'" v-model="Rate" ></app-decimal>
                        </div>
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'paymentDue')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsPaymentdue::find()->distinct()->all(), 'ID', 'paymentDue'),
                                    'options' => [
                                        'prompt' => 'Select Payment',
                                        'class' => 'form-control'],
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Shipment Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'deliveryType')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'shipmentType')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'shipmentDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isView)])) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'packingType')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="panel panel-default" >
                <div class="panel-heading">Purchase Order Detail</div>
                <div class="panel-body">
                    <div class="row" id="divPurchaseDetail">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered purchase-detail-table" style="border-collapse: inherit;">
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
                                    <tbody id="tBody">
                                        
                                    </tbody>
                                    <tfoot>
                                   <tr v-for="(detail, index) in row">
                                        <td class="visibility: hidden">
                                          <app-input type="text" v-bind:name="'TrPurchaseorderhead[joinPurchaseOrderDetail]['+index+'][productID]]'" v-model="detail.productID" v-bind:class="'productDetailInput'+index+'-1'" ></app-input>
                                        
                                        </td>
                                        <td>
                                            <div class = "newinput-group">
                                                <app-input type="text" v-bind:name="'TrPurchaseorderhead[joinPurchaseOrderDetail]['+index+'][productName]'" v-bind:class="'productDetailInput'+index+'-0'"  v-model="detail.productName" readonly></app-input>
                                                <div class="input-group-btn">
                                                    
                                                    <?php if (!isset($isView)): ?>
                                                    <a class="btn btn-primary btn-sm WindowDialogBrowse productBrowse"
                                                           href ="<?= Url::to(['product/browsebysupplier']) ?>"
                                                           v-bind:data-filter-input ="'.supplierID'"
                                                           v-bind:data-target-value ="'.productIDInput'+index"
                                                           v-bind:data-target-text="'.productDetailInput'+index"
                                                           v-bind:data-target-width="'1000'"
                                                           v-bind:data-target-heigt="600">...</a>
                                                     <?php endif; ?>
                                                   
                                                       
                                                </div>
                                            </div>         
                                        </td>
                                        <td class="visibility: hidden">
                                          <app-input v-bind:name="'TrPurchaseorderhead[joinPurchaseOrderDetail]['+index+'][uomID]]'" v-model="detail.uomID" v-bind:class="'productDetailInput'+index+'-2'"></app-input>
                                        </td>
                                        <td>
                                          <app-input v-bind:name="'TrPurchaseorderhead[joinPurchaseOrderDetail]['+index+'][uomName]]'" v-model="detail.uomName" v-bind:class="'productDetailInput'+index+'-3'" readonly></app-input>
                                        </td>
                                        <td>
                                          <app-decimal v-bind:name="'TrPurchaseorderhead[joinPurchaseOrderDetail]['+index+'][qty]]'" v-model="detail.qty" v-bind:class="'productDetailInput'+index+'-7'"></app-decimal>
                                        </td>
                                        <td>
                                          <app-decimal v-bind:name="'TrPurchaseorderhead[joinPurchaseOrderDetail]['+index+'][price]]'" v-model="detail.price" v-bind:class="'productDetailInput'+index+'-8'"></app-decimal>
                                        </td>
                                        <td>
                                          <app-decimal v-bind:name="'TrPurchaseorderhead[joinPurchaseOrderDetail]['+index+'][discount]]'" v-model="detail.discount"></app-decimal>
                                        </td>
                                        <td>
                                          <app-decimal v-bind:name="'TrPurchaseorderhead[joinPurchaseOrderDetail]['+index+'][subTotal]]'" v-bind:value="(detail.qty.toFloat() * detail.price.toFloat()) * ((100 - detail.discount.toFloat())/100)" readonly></app-decimal>
                                        </td>
                                        <td class="text-center">
                                           <?php if (!isset($isView)): ?>
                                                <a href="#" class="btn btn-sm btn-danger" v-on:click.prevent="onDelete(index)">
                                                    <i class="glyphicon glyphicon-remove" style="margin-top:3px;"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    </tfoot>
                                   
                                    </table>
                                    <?php if (!isset($isView)): ?>
                                        <?=
                                         Html::a('<i class="fa fa-plus"></i> Add', '#', ['class' => 'btn btn-primary', 'v-on:click.prevent' => 'onAdd']);

                                         ?>
                                    <?php endif; ?>
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
                            <?= $form->field($model, 'additionalInfo')->widget(CKEditor::className(), [
                                'options' => ['rows' => 6],
                                'preset' => 'standard'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                <label class="control-label text-right">Sub Total</label>
                                  <app-decimal v-bind:name="'TrPurchaseorderhead[subtotals]'" v-bind:class="'subtotals'" v-model="grandSub" readonly></app-decimal>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label text-right">Discount Total</label>
                                     <app-decimal v-bind:name="'TrPurchaseorderhead[discounts]'" v-bind:class="'discounts'" v-model="grandDisc" readonly></app-decimal>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label text-right">Tax Total</label>
                                     <app-decimal v-bind:name="'TrPurchaseorderhead[taxtotal]'" v-bind:class="'taxtotal'" v-model="TaxTotals" readonly></app-decimal>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-12" style="font-size: 18px; font-weight: bold;">
                                   <label class="control-label text-right">Grand Total</label>
                                    <app-decimal v-bind:name="'TrPurchaseorderhead[grandtotal]'" v-bind:class="'grandtotal'" v-model="grandTotal" readonly></app-decimal>
                                </div>
                            </div> 
                            <div class="row">
                               <div class="col-md-12" style="font-size: 18px; font-weight: bold;">
                                    <label class="control-label text-right">Grand Total (IDR)</label>
                                     <app-decimal v-bind:name="'TrPurchaseorderhead[grandtotalIDR]'" v-bind:class="'grandtotalIDR'" v-model="grandTotalIDR" readonly></app-decimal>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group text-right">
                <?= (!isset($isView) && !isset($isUpdate))? 
                         Html::submitButton('<i class="glyphicon glyphicon-save">Save</i>', ['class' => 'btn btn-primary onSave',  'v-on:click' => 'checkForm'])       
                         :  Html::submitButton('<i class="glyphicon glyphicon-pencil">Edit</i>', ['class' => 'btn btn-primary onSave',  'v-on:click' => 'checkForm'])             

                ?>
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
    if ($model->joinPurchaseOrderDetail) {
        $purchaseDetails = Json::encode(array_values($model->joinPurchaseOrderDetail));
    } else {
        $purchaseDetails= "[{grandTotal:0, price: 0, qty: 0, discount:0, uomID:'', productID:'',subtotal:0, subtotals:0, productName:''}]";
    }
?>


<?php JsBlock::begin() ?>
<script>
  var detailValid = false;
  var vm = new Vue({
        el:'#app',
        data:{
            row:  <?=$purchaseDetails?>,
            grandSub: [{subtotals:0 }],
            grandDisc: [{discounts:0 }],
            grandTotal: [{grandtotal:0 }],
            TaxTotal: 0,
            TaxTotals: [{taxtotal:0 }],
            grandTotalIDR: [{grandtotalIDR:0 }],
            Tax: <?= $model->taxRate ?>,
            Rate: <?= $model->rate ?>,
        },
        methods: {
            onAdd: function () {
                var products = this.$data.row;
                var errorMsg = '';
                
                products.forEach(function (product) {
                    if (product.productName === '') {
                        let products = product.productName;
                        console.log(products)
                        errorMsg = "Minimum 1 detail must be filled";
                    }
                });
                if (errorMsg !== '') {
                    bootbox.alert(errorMsg);
                } else {
                    this.row.push({
                        price: 0, qty: 0, discount:0, productID:'', productName:'', uomName:'' , uomID:'',
                    });
                   
               }
            },
            calculateSubTotal: function () {
               this.grandSub = this.row.map(p => p.price.toFloat() * p.qty.toFloat() * ((100 - p.discount.toFloat())/100)).reduce((x, y) => x + y); 
            },
            calculateDiscount: function () {
               this.grandDisc = this.row.map(p => p.discount.toFloat() * 1 ).reduce((x, y) => x + y);
               
              
            },
            calculateTaxTotal: function () {
               this.TaxTotal =  this.row.map(p => ((p.price.toFloat() * p.qty.toFloat()) - (p.price.toFloat() * p.qty.toFloat() * (p.discount.toFloat()/100)))).reduce((x, y) => x + y);
               this.TaxTotals = this.TaxTotal * this.Tax / 100;
               
            },
            calculateGrandTotal: function () {
               this.grandTotal = (this.grandSub + this.TaxTotals);
              
            },
            calculateGrandTotalIDR: function () {
               this.grandTotalIDR = ((this.grandSub + this.TaxTotals) * this.Rate.toFloat()) ;
             
            },
            checkForm: function() {
            detailValid = true;
            var productRegistered = [];
                this.row.forEach(function(detail, i) {
                    var index = i + 1;
                    
                    if (!detail.productID) {
                        errorInputDetail('Item ' + index + ': Product required');
                        detailValid = false;
                        
                    }
                    
                    if (!detail.qty || detail.qty == "") {
                        errorInputDetail('Item ' + index + ': Qty required');
                        detailValid = false;
                    }
                    
                    if (detail.qty == " 0,00") {
                        errorInputDetail('Item ' + index + ': Data cannot be saved because qty 0');
                        detailValid = false;
                    }
                    
                    
                    if(productRegistered.indexOf(detail.productID) != -1) {
                        errorInputDetail('Item ' + index + ': Duplicate Product found');
                        detailValid = false;
                    } else {
                        productRegistered.push(detail.productID);
                    }
                });
            },
            onDelete: function(index) {
                var self = this;
                var length = self.row.length;
                
                if( length == 1 && self.row[0].productID == ''){
                     errorMsg = "Minimum 1 detail must be filled";
                     bootbox.alert(errorMsg);
                } else {
                
                    var doit = function()
                    {

                        if( length < 2  ){
                            self.onAdd();    
                        }

                        self.row.splice(index, 1);
                    }

                    if(self.row[index]['productID'] === '') {
                        doit();
                    } else {
                        bootbox.confirm('Are you sure you want to delete this row?', function(yes) {
                            console.log(yes);
                            if (yes) doit();
                        });
                    }
                }   
                    
            },
            onRemove: function(index) {
                var self = this;
              
                    if(self.row[index]['productID'] === '') {
                        self.row.splice(index, 1);
                    } 
             
            },
            initRow: function(){
                if(this.row.lenght <= 0){
                    this.onAdd();
                }
            }
        },
        mounted: function () {
            this.initRow();
            initInput();
            this.calculateSubTotal();
            this.calculateDiscount();
            this.calculateGrandTotal();
            this.calculateGrandTotalIDR();
            this.calculateTaxTotal();
        },
        updated: function () {
            this.initRow();
            initInput();
            this.calculateSubTotal();
            this.calculateDiscount();
            this.calculateGrandTotal();
            this.calculateGrandTotalIDR();
            this.calculateTaxTotal();
            $('.onSave').prop('disabled',false);
        } 
    });
    
    $('#form-purchase').on('beforeSubmit', function () {
        var formValid = detailValid;
        if (!formValid) {
            $('.onSave').prop('disabled',false);
        }
        return formValid;
    }); 
    
 
    
</script>   
<?php JsBlock::end() ?>


<?php JsBlock::begin() ?>
<script>
<?php
//$purchaseDetail = Json::encode($model->joinPurchaseOrderDetail);
$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/currency/check';
$refNumAjaxURL = Yii::$app->request->baseUrl. '/purchase/check';
$getContactPersonAjaxUrl = Yii::$app->request->baseUrl. '/supplier/get-contact-person';
$checkProductAjaxURL = Yii::$app->request->baseUrl. '/product/get';
?>
$(document).ready(function () {
   
     
    $('#trpurchaseorderhead-supplierid').change();
    $('.supplierID').change(function (e) {
        $this = $(this);
        var oldvalue = this.oldvalue;
        var supplierID = $(this).val();

        $.ajax({
            url: '<?=$getContactPersonAjaxUrl?>',
            async: false,
            type: 'POST',
            data: { supplierID: supplierID },
            success: function(data) {
                refillDataSelect2(data,'.contactPerson');
                refillDataSelect2(data,'.contactPersonCC');

                if (oldvalue != supplierID && 
                   ((vm.row.length == 1 && vm.row[0].productID) || vm.row.length > 1))
                {
                     bootbox.confirm('Changing te supplier will remove item details, are you sure ?', function(yes){
                        if (yes)
                        {
                           vm.$data.row = [];
                           vm.$data.row.push({
                                 price: 0, qty: 0, discount:0, productID:'', productName:'', uomName:'' , uomID:'',
                           });
                           vm.$data.grandSub = [{subtotals:0 }];
                           vm.$data.grandDisc =  [{discounts:0 }]; 
                           vm.$data.grandTotal = [{grandtotal:0 }];
                           vm.$data.TaxTotals = [{taxtotal:0 }];
                           vm.$data.grandTotalIDR = [{grandtotalIDR:0 }];
                          // console.log('wkwkwk');
                        } else 
                        {
                            $this.val(oldvalue).change();
                        }
                    });
                }
            }
            
        });
    });

    $('.selectCurrency').change(function(){
        var currencyID = $('.selectCurrency').val();
        
        currencyRate = getCurrencyRate(currencyID);
        currencyRate = replaceAll(currencyRate, ".", ",");
        currencyRate = replaceAll(currencyRate, '"', "");
        
        //$('.currencyRate').val(formatNumber(currencyRate)).change();
        vm.$data.Rate = formatNumber(currencyRate);
        if (currencyID == 'IDR')
        {
            $('.currencyRate').prop('readonly', false)
            $('.isImportValue').prop('checked', false).change();
            $('.VATValue').prop('checked', true).change();
            vm.$data.Tax = 10;
        } else
        {
            $('.currencyRate').prop('readonly', false)
            $('.isImportValue').prop('checked', true).change();
            $('.VATValue').prop('checked', false).change();
            vm.$data.Tax = 0;
        }
    });
    
    $('.purchase-detail-table .productBrowse').on('click', function (e) {
        
        if($('.supplierID').val() == ""){
            bootbox.alert("Select supplier first");
            return false;
        }
    });

    function getSalesDetails(refNum){
        var quotation = null;

        $.ajax({
            url: '<?=$refNumAjaxURL?>',
            async: false,
            type: 'POST',
            data: { refNum: refNum },
            success: function(result) {
                var result = JSON.parse(result);
                quotation = result;
            }
         });
        return quotation;
    }
    
    $('.refNum').change(function(){
        var refNum = $('.refNum').val();
        var result = getSalesDetails(refNum);
       
        
        console.log(result);
       
        if (!result.supplierID) {
            bootbox.alert('Cannot create purchase order from this Sales Order, because it has to or more detail seupplier');
            return;
        } else {
            vm.onRemove(0);
            $('.supplierID').val(result.supplierID).change();
            setTimeout(() => {
                result.products.forEach(function(entry) {  
                    // addRow(entry.productID.toString(), entry.productName.toString(), entry.uomID.toString(), entry.uomName.toString(), entry.qty.toString(), entry.price.toString(), entry.discount.toString(), entry.subTotal.toString());
                    // calculateSummary();
                    vm.row.push({productID: entry.productID, productName:entry.productName.toString(), uomName:entry.uomName.toString(), uomID:entry.uomID, price:entry.price, qty:entry.qty, discount:entry.discount});

                });
            }, 500);
        }
        
    });

    function getCurrencyRate(currencyID){
        var currencyRate = '0.00';
        $.ajax({
            url: '<?=$checkCurrencyRateAjaxURL?>',
            async: false,
            type: 'POST',
            data: { currencyID: currencyID },
            success: function(data) {
                currencyRate = data;
            }
         });
       
        return currencyRate;
    }
});
</script>   
<?php JsBlock::end() ?>

