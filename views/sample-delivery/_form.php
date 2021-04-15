<?php

use app\components\JsBlock;
use app\models\Customer;
use app\models\MsWarehouse;
use app\models\SampleDeliveryForm;
use app\models\Warehouse;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

$urlBrowseStock = Url::to(['/product/browse-stock-sample']);

$warehouseList = ArrayHelper::toArray(Warehouse::findActive(),[
    'app\models\Warehouse' => [
        'id' => 'warehouseID',
        'text' => 'warehouseName'
    ]]);

/* @var $this View */
/* @var $model SampleDeliveryForm */
/* @var $form ActiveForm */
?>

<div class="sample-delivery-form">
    <?php $form = ActiveForm::begin([
        'id'=> 'sample-delivery-form',
    ]); ?>

    <div class="panel panel-default">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Transaction Information</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <?= 
                                $form->field($model, 'customerID')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Customer::findActive(), 'customerID', 'customerName'),
                                    'options' => [
                                        'id' => 'customer-id',
                                        'placeholder' => 'Select '.$model->getAttributeLabel('customerID').'...',
                                    ]
                                ]);
                            ?>
                        </div> 
                        <div class="col-md-3">
                            <?php echo Html::hiddenInput('selected_id', $model->isNewRecord ? '' : $model->customerDetailID, ['id'=>'selected_id']); ?>
                            <?=
                                $form->field($model, 'customerDetailID')->widget(DepDrop::classname(),[
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'options' => [
                                        'id' => 'customer-detail-id'
                                    ],
                                    'pluginOptions' => [
                                        'depends' => ['customer-id'],
                                        'placeholder' => 'Select '.$model->getAttributeLabel('customerDetailID').'...',
                                        'url' => Url::to(['/customer/get-pics']),
                                        'initialize' => $model->isNewRecord ? false : true,
                                        'params'=> ['selected_id'], 
                                    ]
                                ]);
                                ?>
                        </div> 
                        <div class="col-md-3">
                            <?= $form->field($model, 'sampleDeliveryDate')->widget(DateControl::className()) ?>
                        </div> 
                        <div class="col-md-3">
                            <!-- <app-select2-group 
                                v-bind:options="warehouseList" 
                                v-bind:label="'Warehouse'" 
                                v-bind:name="'SampleDeliveryForm[warehouseID]'"
                                v-bind:id="'warehouseID'"
                                v-bind:show-error="warehouseError"
                                v-model="warehouseID">
                                <option value="">Select <?= $model->getAttributeLabel('warehouseID') ?></option>
                            </app-select2-group>-->
                            <?=
                                $form->field($model, 'warehouseID')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(MsWarehouse::findAll(['flagActive' => 1]), 'warehouseID', 'warehouseName'),
                                    'options' => [
                                        'prompt' => 'Select warehouse',
                                        'class' => 'warehouseID'
                                    ],
                                    'pluginEvents' => [
                                        "select2:open" => "function() { this.oldvalue = this.value; }",
                                    ]
                                ])
                            ?>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="box box-success" v-bind:class="{hidden: warehouseID==''}">
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
                                    <th style="width:10%">Stock</th>
                                    <th style="width:10%">Qty</th>
                                    <th style="width:40px;">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detail, index) in formDetails" v-bind:class="{hidden: !detail.active}" >
                                    <td>
                                        <app-input v-show="false" v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][sampleDeliveryDetailID]'" v-model="detail.sampleDeliveryDetailID"></app-input>
                                        <app-input v-show="false" v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][active]'" v-model="detail.active"></app-input>
                                        <app-input v-show="false" v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][productID]'" v-model="detail.productID"  v-bind:class="'SampleDeliveryForm'+index+'-1'" ></app-input>
                                        <div v-bind:class="{'input-group': detail.sampleDeliveryDetailID == ''}">
                                            <app-input v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][productName]'" v-model="detail.productName" v-bind:class="'SampleDeliveryForm'+index+'-0'"  placeholder="Product Name" maxlength="200" readonly='readonly' ></app-input>
                                            <span class="input-group-btn" v-bind:class="{hidden: detail.sampleDeliveryDetailID != ''}" >
                                            
                                                <a class="btn btn-primary btn-sm WindowDialogBrowse productBrowse"
                                                       href ="<?= Url::to(['product/browsebysample']) ?>"
                                                       v-bind:data-filter-input ="'.warehouseID'"
                                                       v-bind:data-target-value ="'.productIDInput'+index"
                                                       v-bind:data-target-text="'.SampleDeliveryForm'+index"
                                                       v-bind:data-target-width="'1000'"
                                                       v-bind:data-target-heigt="600">...</a>
                                                
                                            </span>
                                        </div>                                        
                                    </td>
                                    <td>
                                        <app-input type="text" class="form-control" v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][uomID]'" v-model="detail.uomID" placeholder="UOM" maxlength="50" readonly v-bind:class="'SampleDeliveryForm'+index+'-2'" ></app-input>
                                        <app-input type="text" class="form-control" v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][uomName]'" v-model="detail.uomName" placeholder="UOM" maxlength="50" readonly v-bind:class="'SampleDeliveryForm'+index+'-3'" ></app-input>
                                    </td>
                                    <td>
                                        <app-input v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][batchNumber]'" v-model="detail.batchNumber" placeholder="Batch Number" maxlength="100" v-bind:class="'SampleDeliveryForm'+index+'-9'"  readonly></app-input>
                                        <app-datepicker 
                                            v-model="detail.manufactureDate" 
                                            v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][manufactureDate]'"
                                            v-bind:class="'SampleDeliveryForm'+index+'-4'" 
                                            placeholder='Manufacture Date' readonly>
                                        </app-datepicker>
                                    </td>
                                    <td>
                                        <app-datepicker 
                                            v-model="detail.expiredDate" 
                                            v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][expiredDate]'"
                                            v-bind:class="'SampleDeliveryForm'+index+'-5'" 
                                            placeholder='Expired Date' readonly>
                                        </app-datepicker>                                
                                        <app-datepicker 
                                            v-model="detail.retestDate" 
                                            placeholder='Retest Date' 
                                            v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][retestDate]'"
                                            v-bind:class="'SampleDeliveryForm'+index+'-8'"  readonly>
                                        </app-datepicker>
                                    </td>
                                    <td>
                                        <app-decimal v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][stock]'" v-model="detail.stock" placeholder="Stock"   v-bind:class="'SampleDeliveryForm'+index+'-6'"  readonly></app-decimal>
                                    </td>
                                    <td>
                                        <app-decimal v-bind:name="'SampleDeliveryForm[formDetails]['+index+'][qty]'" v-model="detail.qty" placeholder="Qty"></app-decimal>
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
        <div class="panel panel-default"   v-bind:class="{hidden: warehouseID==''}">
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
                <?= Html::submitButton('<i class="glyphicon glyphicon-save"></i> Save', ['class' => 'btn btn-primary onSave',  'v-on:click' => 'checkForm']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-remove"></i> Cancel', ['index'], ['class' => 'btn btn-danger']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
<?php
    if ($model->_formDetails) {
        $details = Json::encode($model->_formDetails);
    } else {
        $details = "[{sampleDeliveryDetailID: '',productID: '',productName: '',"
            . " uomName:'', qty:'', batchNumber:'', manufactureDate: '',expiredDate: '',"
            . "retestDate: '',uomIDe:'', stock: '', active: 1}]";
    }
?>
<?php JsBlock::begin() ?>
<script>  
    var detailValid = false;
    var vm = new Vue({
        el:'#sample-delivery-form',
        data:{
            warehouseID:'<?= $model->warehouseID ?>',
            warehouseList:<?= Json::encode($warehouseList) ?>,
            formDetails:<?= $details ?>,
            warehouseError:false
        },
        watch:{
            warehouseID: function() {
                if(this.warehouseID != '') {
                    this.warehouseError=false;
                }
            }
        },
        methods: {
            onDelete: function(index) {
                var self = this;
                yii.confirm('Are you sure you want to delete this row?', function() {
                    if(self.formDetails[index]['sampleDeliveryDetailID'] === '') {
                        self.formDetails.splice(index, 1);
                    } else {
                        self.formDetails[index]['active'] = 0;
                    }                    
                });
            },
            addNewRow: function() {
                this.formDetails.push({
                    sampleDeliveryDetailID: '',
                    productID: '',
                    productName: '',
                    uomName:'', 
                    qty:'', 
                    batchNumber:'', 
                    manufactureDate: '',
                    expiredDate: '',
                    retestDate: '',
                    stock: '',
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
                    } else {
                        stock = detail.stock.toFloat();
                        qty = detail.qty.toFloat();
                        if(qty > stock) {
                            errorInputDetail('Item ' + index + ': Stock is not enough');
                            detailValid = false;
                        }
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
    $('#sample-delivery-form').on('beforeSubmit', function () {
          var formValid = detailValid;
          if (!formValid) {
              $('.onSave').prop('disabled',false);
          }
          return formValid;
          
    }); 


    $('.warehouseID').change(function (e) {
        $this = $(this);
        var oldvalue = this.oldvalue;
        var warehouseID = $(this).val();
        vm.$data.warehouseID = warehouseID;
        if (oldvalue != warehouseID && 
           ((vm.formDetails.length == 1 && vm.formDetails[0].productID) || vm.formDetails.length > 1))
        {
             bootbox.confirm('Changing the warehouse will remove item details, are you sure ?', function(yes){
                if (yes)
                {
                   vm.$data.formDetails = [];
                   vm.$data.formDetails.push({
                    sampleDeliveryDetailID: '',
                    productID: '',
                    productName: '',
                    uomName:'', 
                    qty:'', 
                    batchNumber:'', 
                    manufactureDate: '',
                    expiredDate: '',
                    retestDate: '',
                    stock: '',
                    active: 1});
                } else {
                    $this.val(oldvalue).change();
                }
            });
        }
    }); 

  
  
</script>
<?php JsBlock::end() ?>