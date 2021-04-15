<?php

use app\components\AppHelper;
use app\components\JsBlock;
use app\models\MsSupplier;
use app\models\SampleReceiptForm;
use app\models\Supplier;
use app\models\Warehouse;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\select2\ThemeKrajeeAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

$urlBrowseProduct = Url::to(['/product/browse']);

$supplierList = ArrayHelper::toArray(Supplier::findActive(),[
    'app\models\Supplier' => [
        'id' => 'supplierID',
        'text' => 'supplierName'
    ]]);

/* @var $this View */
/* @var $model SampleReceiptForm */
/* @var $form ActiveForm */
ThemeKrajeeAsset::register($this);
?>

<div class="sample-receipt-form">
    <?php $form = ActiveForm::begin([
        'id'=> 'sample-receipt-form',
    ]); ?>

    <div class="panel panel-default">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Transaction Information</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
<!--                            <app-select2-group 
                                v-bind:options="supplierList" 
                                v-bind:label="'Supplier'" 
                                v-bind:name="'SampleReceiptForm[supplierID]'"
                                v-bind:id="'supplierID'"
                                v-bind:show-error="supplierError"
                                v-model="supplierID">
                                <option value="">Select <?= $model->getAttributeLabel('supplierID') ?></option>
                            </app-select2-group>-->

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
                        <div class="col-md-3">
                            <?= $form->field($model, 'sampleReceiptDate')->widget(DateControl::className()) ?>
                            
                        </div> 
                        <div class="col-md-3">
                            <?= $form->field($model, 'refNum')->textInput(['maxlength' => true]) ?>
                        </div> 
                        <div class="col-md-3">
                            <?= $form->field($model, 'warehouseID')->dropDownList(ArrayHelper::map(Warehouse::findActive(),'warehouseID','warehouseName'),[
                                'prompt' => 'Select '.$model->getAttributeLabel('warehouseID')
                            ]) ?>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="box box-success" v-bind:class="{hidden: supplierID==''}">
                <div class="box-header with-border">
                    <h3 class="box-title">Item Details</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbl-detail">
                            <thead class="detail-thead">
                                <tr>
                                    <th >Product</th>
                                    <th style="width:10%">Unit</th>
                                    <th style="width:20%">Batch Num</th>
                                    <th style="width:20%">Expired Date</th>
                                    <th style="width:10%">Qty</th>
                                    <th style="width:40px;">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detail, index) in formDetails" v-bind:class="{hidden: !detail.active}" >
                                    <td>
                                        <app-input v-show="false" v-bind:name="'SampleReceiptForm[formDetails]['+index+'][sampleReceiptDetailID]'" v-model="detail.sampleReceiptDetailID"></app-input>
                                        <app-input v-show="false" v-bind:name="'SampleReceiptForm[formDetails]['+index+'][active]'" v-model="detail.active"></app-input>
                                        <app-input v-show="false" v-bind:name="'SampleReceiptForm[formDetails]['+index+'][productID]'" v-model="detail.productID" v-bind:class="'productDetailInput'+index+'-1'" ></app-input>
                                        <div v-bind:class="{'input-group': detail.sampleReceiptDetailID == ''}">
                                            <app-input v-bind:name="'SampleReceiptForm[formDetails]['+index+'][productName]'" v-model="detail.productName" v-bind:class="'productDetailInput'+index+'-0'" placeholder="Product Name" maxlength="200" readonly='readonly' v-bind:id="'productName'+index"></app-input>
                                                  <span class="input-group-btn" v-bind:class="{hidden: detail.sampleReceiptDetailID != ''}" >       
                                                    <a class="btn btn-primary btn-sm WindowDialogBrowse productBrowse"
                                                       href ="<?= Url::to(['sample-receipt/browsebysupplier']) ?>"
                                                       v-bind:data-filter-input ="'.supplierID'"
                                                       v-bind:data-target-value ="'.productIDInput'+index"
                                                       v-bind:data-target-text="'.productDetailInput'+index"
                                                       v-bind:data-target-width="'1000'"
                                                       v-bind:data-target-heigt="600">...</a>
                                                 </span>
                                        </div>
                                    </td>
                                    <td>
                                        <app-input type="hidden" class="form-control" v-bind:name="'SampleReceiptForm[formDetails]['+index+'][uomID]'" v-bind:class="'productDetailInput'+index+'-2'" v-model="detail.uomID" placeholder="UOM" maxlength="50" readonly v-bind:id="'uomID'+index"></app-input>
                                        <app-input type="text" class="form-control" v-bind:name="'SampleReceiptForm[formDetails]['+index+'][uomName]'" v-bind:class="'productDetailInput'+index+'-3'" v-model="detail.uomName" placeholder="UOM" maxlength="50" readonly v-bind:id="'uomName'+index"></app-input>
                                    </td>
                                    <td>
                                        <app-input v-bind:name="'SampleReceiptForm[formDetails]['+index+'][batchNumber]'" v-model="detail.batchNumber" placeholder="Batch Number" maxlength="100" v-bind:id="'batchNumber'+index" v-bind:readonly="detail.sampleReceiptDetailID != ''"></app-input>
                                        <app-datepicker 
                                            v-model="detail.manufactureDate" 
                                            v-bind:name="'SampleReceiptForm[formDetails]['+index+'][manufactureDate]'"
                                            v-bind:id="'manufactureDate'+index"
                                            placeholder='Manufacture Date'>
                                        </app-datepicker>
                                    </td>
                                    <td>
                                        <app-datepicker 
                                            v-model="detail.expiredDate" 
                                            v-bind:name="'SampleReceiptForm[formDetails]['+index+'][expiredDate]'"
                                            v-bind:id="'expiredDate'+index"
                                            placeholder='Expired Date'>
                                        </app-datepicker>                                
                                        <app-datepicker 
                                            v-model="detail.retestDate" 
                                            placeholder='Retest Date' 
                                            v-bind:name="'SampleReceiptForm[formDetails]['+index+'][retestDate]'"
                                            v-bind:id="'retestDate'+index">
                                        </app-datepicker>
                                    </td>
                                    <td>
                                    <app-decimal v-bind:name="'SampleReceiptForm[formDetails]['+index+'][qty]'" v-model="detail.qty"  placeholder="Qty"></app-decimal>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger" v-on:click.prevent="onDelete(index)">X</a>
                                    </td>
                                </div>       
                            </tbody>
                        </table>
                        <?=
                            Html::a('<i class="fa fa-plus"></i> Add', '#', ['class' => 'btn btn-primary', 'v-on:click.prevent' => 'onAdd']);
                        ?>
                    </div>
                </div>
            </div>
        <div class="panel panel-default"  v-bind:class="{hidden: supplierID==''}">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'notes')->textArea(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="panel-footer">
            <div class="text-right">
                <?php if (!isset($isView)): ?>
                <?= Html::submitButton('<i class="glyphicon glyphicon-save"></i> Save', ['class' => 'btn btn-primary onSave',  'v-on:click' => 'checkForm']) ?>
                <?php endif; ?>
                <?php if (!isset($isView)) { ?>
                    <?= AppHelper::getCancelButton() ?>
                <?php } else { ?>
                    <?= Html::a('<i class="glyphicon glyphicon-remove"> Cancel </i>', ['index'], ['class' => 'btn btn-danger']) ?>
                <?php } ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
<?php
    if ($model->_formDetails) {
        $details = Json::encode($model->_formDetails);
    } else {
        $details = "[{sampleReceiptDetailID: '',productID: '',productName: '', uomName:'', qty:'', batchNumber:'', manufactureDate: '',expiredDate: '',retestDate: '',active: 1}]";
    }
?>
<?php JsBlock::begin() ?>
<script>    
    var vm = new Vue({
        el:'#sample-receipt-form',
        data:{
            supplierID:'<?= $model->supplierID ?>',
            supplierList:<?= Json::encode($supplierList) ?>,
            formDetails:<?= $details ?>,
            supplierError:false
        },
        watch:{
            supplierID: function() {
                if(this.supplierID != '') {
                    this.supplierError=false;
                }
            }
        },
        methods: {
            onDelete: function(index) {
                var self = this;
                yii.confirm('Are you sure you want to delete this row?', function() {
                    if(self.formDetails[index]['sampleReceiptDetailID'] === '') {
                        self.formDetails.splice(index, 1);
                    } else {
                        self.formDetails[index]['active'] = 0;
                    }                    
                });
            },
            addNewRow: function() {
                this.formDetails.push({
                    sampleReceiptDetailID: '',
                    productID: '',
                    productName: '',
                    uomName:'', 
                    qty:'', 
                    batchNumber:'', 
                    manufactureDate: '',
                    expiredDate: '',
                    retestDate: '',
                    active: 1});
            },
            onAdd: function() {
                this.addNewRow();
                initInput();
            },  
            checkForm: function() {
            detailValid = true;
            var productRegistered = [];
            vm.formDetails.forEach(function(detail, i) {
                var index = i + 1;

                    if (!detail.productName) {
                        errorInputDetail('Item ' + index + ': Product required');
                        detailValid = false;
                    }
                    if (!detail.qty) {
                        errorInputDetail('Item ' + index + ': Qty required');
                        detailValid = false;
                    }
                    if (!detail.batchNumber) {
                        errorInputDetail('Item ' + index + ': Batch Number required');
                        detailValid = false;
                    }
                    if (!detail.manufactureDate) {
                        errorInputDetail('Item ' + index + ': Manufacture Date required');
                        detailValid = false;
                    }
                    if (!(detail.expiredDate || detail.retestDate)) {
                        errorInputDetail('Item ' + index + ': Either Expired Date / Retest Date required');
                        detailValid = false;
                    }

                    if(productRegistered.indexOf(detail.productID + ',' + detail.batchNumber) != -1) {
                        errorInputDetail('Item ' + index + ': Duplicate Product and Batch Number found');
                        detailValid = false;
                    } else {
                        productRegistered.push(detail.productID + ',' + detail.batchNumber);
                    }
                });
        
                
            },
        },
        updated: function() {
            detailValid = true;
                        
            var activeDetails = this.formDetails.filter(function (item) {
                return item.active;
            });
            if (activeDetails.length <= 0) {
                this.addNewRow();
            }
              $('.onSave').prop('disabled',false);
        }
    });
    
     $('#sample-receipt-form').on('beforeSubmit', function () {
        var formValid = detailValid;
        
        if (!formValid) {
            $('.onSave').prop('disabled',false);
        }
        return formValid;
    }); 

     $('.supplierID').change(function (e) {
        $this = $(this);
        var oldvalue = this.oldvalue;
        var supplierID = $(this).val();
        vm.$data.supplierID = supplierID;
        if (oldvalue != supplierID && 
           ((vm.formDetails.length == 1 && vm.formDetails[0].productID) || vm.formDetails.length > 1))
        {
             bootbox.confirm('Changing the warehouse will remove item details, are you sure ?', function(yes){
                if (yes)
                {
                   vm.$data.formDetails = [];
                   vm.$data.formDetails.push({
                    sampleReceiptDetailID: '',
                    productID: '',
                    productName: '',
                    uomName:'', 
                    qty:'', 
                    batchNumber:'', 
                    manufactureDate: '',
                    expiredDate: '',
                    retestDate: '',
                    active: 1});
                } else {
                    $this.val(oldvalue).change();
                }
            });
        }
    }); 

</script>
<?php JsBlock::end() ?>