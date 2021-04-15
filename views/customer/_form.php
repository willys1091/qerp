<?php

use app\components\AppHelper;
use app\models\LkJenissarana;
use app\models\MsSupplier;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\touchspin\TouchSpin;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this View */
/* @var $model MsSupplier */
/* @var $form ActiveForm */
?>

<div class="ms-supplier-form">
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
                        <div class="col-md-6">
                            <?= $form->field($model, 'customerName')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                    $form->field($model, 'creditLimit')
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
                                            'class' => 'form-control'
                                        ],
                                    ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= 
                                $form->field($model, 'saranaID')->widget(Select2::classname(),[
                                'data' => ArrayHelper::map(LkJenissarana::find ()->all(), 'saranaID', 'saranaName' ),
                                'options' => [
                                    'prompt' => 'Select Jenis Sarana'],   
                            ]);
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?=
                            $form->field($model, 'dueDate')->widget(TouchSpin::classname(), [
                                'options' => ['placeholder' => '',],
                                'pluginOptions' => [
                                    'buttonup_class' => 'btn btn-primary',
                                    'buttondown_class' => 'btn btn-info',
                                    'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                    'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'tax')->widget(SwitchInput::classname(), [
                                        'type' => SwitchInput::CHECKBOX,
                                        'pluginOptions' => [
                                            'labelText' => '',
                                            'onText' => 'YES',
                                            'offText' => 'NO',
                                        ], 
                                    ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Customer Detail</div>
                <div class="panel-body">
                    <div class="row" id="divPicSupplierDetail">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table table-bordered detail-table" style="border-collapse: inherit;">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%;">
                                                <div class="row">Contact Person</div>      
                                                <div class="row">Nickname</div>                        
                                            </th>
                                            <th style="width: 15%;">Address Type</th>
                                            <th style="width: 20%;">
                                                <div class="row">Country</div>
                                                <div class="row">City</div>
                                            </th>
                                            <th style="width: 15%;">
                                                <div class="row">Phone</div>
                                                <div class="row">Fax</div>
                                                <div class="row">Email</div>
                                            </th>
                                            <th style="width: 25%;">Street</th>
                                            <th style="width: 10%;">Postal Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="visibility: hidden">
                                                <?=
                                                Html::hiddenInput('customerDetailID', '', [
                                                    'class' => 'form-control detailInputID'
                                                ])
                                                ?>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?=
                                                        Html::textInput('contactPerson', '', [
                                                            'class' => 'form-control detailInputContactPerson',
                                                            'maxlength' => 50
                                                        ])
                                                        ?>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?=
                                                        Html::textInput('nickname', '', [
                                                            'class' => 'form-control detailInputNickname',
                                                            'maxlength' => 50
                                                        ])
                                                        ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                        <?=
                                                        Html::textInput('addressType', '', [
                                                            'class' => 'form-control detailInputAddressType',
                                                            'maxlength' => 50
                                                        ])
                                                        ?>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <?=
                                                    Html::textInput('country', '', [
                                                        'class' => 'form-control detailInputCountry',
                                                        'maxlength' => 50
                                                    ])
                                                    ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <?=
                                                    Html::textInput('city', '', [
                                                        'class' => 'form-control detailInputCity',
                                                        'maxlength' => 50
                                                    ])
                                                    ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?=
                                                        Html::textInput('phone', '', [
                                                            'class' => 'form-control detailInputPhone',
                                                            'maxlength' => 50,
                                                            'placeholder' => 'Phone'
                                                        ])
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?=
                                                        Html::textInput('fax', '', [
                                                            'class' => 'form-control detailInputFax',
                                                            'maxlength' => 50,
                                                            'placeholder' => 'Fax'
                                                        ])
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?=
                                                        Html::textInput('email', '', [
                                                            'class' => 'form-control detailInputEmail',
                                                            'maxlength' => 50,
                                                            'placeholder' => 'Email'
                                                        ])
                                                        ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?=
                                                Html::textArea('street', '', [
                                                    'class' => 'form-control detailInputStreet',
                                                    'maxlength' => 200
                                                ])
                                                ?>
                                            </td>
                                            <td>
                                                <?=
                                                Html::textInput('postalCode', '', [
                                                    'class' => 'form-control detailInputPostalCode',
                                                    'maxlength' => 50
                                                ])
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?= Html::a('<i class="glyphicon glyphicon-plus">Add</i>', '#', ['class' => 'btn btn-primary btn-sm btnAdd']) ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">NPWP</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
<?= $form->field($model, 'npwp')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
<?= $form->field($model, 'npwpAddress')->textArea(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                <?=
                $form->field($model, 'npwpRegisteredDate')->widget(DatePicker::classname(), [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoWidget' => true,
                        'autoclose' => true,
                    ]
                ]);
                ?>
                        </div>
                        <div class="col-md-6">
<?= $form->field($model, 'notes')->textArea(['maxlength' => true]) ?>
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
$customerDetail = Json::encode($model->joinMsCustomerDetail);
$deleteRow = '';
$editRow = '';
if (!isset($isEdit)) {
    $deleteRow = <<< DELETEROW
			"   <td class='text-center'>" +
			"       <a class='btn btn-danger btn-sm btnDelete' href='#'><i class='glyphicon glyphicon-remove'></i>Delete</a>" +
			"   </td>" +
DELETEROW;
}

if (!isset($isCreate)) {
    $editRow = <<< EDITROW
			"   <td class='text-center'>" +
			"       <a class='btn btn-danger btn-sm btnEdit' href='#'><i class='glyphicon glyphicon-pencil'></i>Edit</a>" +
			"   </td>" +
EDITROW;
}
$urlGetAll = Url::to(['customer/getall']);
$js = <<< SCRIPT
var urlGetAll = '$urlGetAll';
var validated = false;
$(document).ready(function () {
    
    var initValue = $customerDetail;
	
    var rowTemplate = "" +
            "<tr>" +
            "  <input type='hidden' class='customerDetailID' name='MsCustomer[joinMsCustomerDetail][{{Count}}][customerDetailID]' data-key='{{Count}}' value='{{customerDetailID}}' >" +
            "       {{customerDetailID}}" +
            "   <td class='text-center'><div class='row'><div class='col-md-12'>" +
            "       <input type='text' maxlength='50' class='form-control customerDetailContactPerson'  style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][contactPerson]' value='{{contactPerson}}'>" +
            "   </div>" +
            "   <div class='col-md-12'>" +
            "       <input type='text' maxlength='50' class='form-control customerDetailNickname'  style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][nickname]' value='{{nickname}}'>" +
            "   </div></div></td>" +
            "   <td class='text-center'>" +
            "       <input type='text' maxlength='50' class='form-control customerDetailCustomerName'   style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][addressType]' value='{{addressType}}'>" +
            "   </td>" +
            "   <td class='text-center'>" +
            "       <div class='row'><div class='col-md-12'>" +   
            "       	<input type='text' maxlength='15' class='form-control customerDetailCountry' style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][country]' value='{{country}}'>" +
            "       </div></div>" + 
            "       <div class='row'><div class='col-md-12'>" +  
            "       	<input type='text' maxlength='15' class='form-control customerDetailCity' style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][city]' value='{{city}}'>" +
            "       </div></div>" + 
            "   </td>" +
            "   <td class='text-center'>" +
            "       <div class='row'><div class='col-md-12'>" +   
            "       	<input type='text' maxlength='50' placeholder='Phone' class='form-control customerDetailPhone'  style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][phone]' value='{{phone}}'>" +
            "       </div></div>" + 
            "       <div class='row'><div class='col-md-12'>" +  
            "       	<input type='text' maxlength='50' placeholder='Fax' class='form-control customerDetailFax'  style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][fax]' value='{{fax}}'>" +
            "       </div></div>" +
            "       <div class='row'><div class='col-md-12'>" +  
            "       	<input type='text' maxlength='50' placeholder='Email' class='form-control customerDetailEmail'  style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][email]' value='{{email}}'>" +
            "       </div></div>" + 
            "   </td>" +
            "   <td >" +
            "       <textarea style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][street]'>{{street}}</textarea>" +
            "   </td>" +
            "   <td class='text-center'>" +
            "       <input type='text' maxlength='15' class='form-control customerDetailPostalCode' style='background-color:white; width: 100%' name='MsCustomer[joinMsCustomerDetail][{{Count}}][postalCode]' value='{{postalCode}}'>" +
            "   </td>" +$deleteRow
            "</tr>";
    initValue.forEach(function(entry){
        entry.customerDetailID = entry.customerDetailID ? entry.customerDetailID : "";
        entry.contactPerson = entry.contactPerson ? entry.contactPerson : "";
        entry.nickname = entry.nickname ? entry.nickname : "";
        entry.addressType = entry.addressType ? entry.addressType : "";
        entry.country = entry.country ? entry.country : "";
        entry.city = entry.city ? entry.city : "";
        entry.street = entry.street ? entry.street : "";
        entry.postalCode = entry.postalCode ? entry.postalCode : "";
        entry.phone = entry.phone ? entry.phone : "";
        entry.fax = entry.fax ? entry.fax : "";
        entry.email = entry.email ? entry.email : "";
        
        addRow(entry.customerDetailID.toString(), entry.contactPerson.toString(), 
            entry.nickname.toString(), entry.addressType.toString(), entry.country.toString(), 
            entry.city.toString(), entry.street.toString(), entry.postalCode.toString(), 
            entry.phone.toString(), entry.fax.toString(), entry.email.toString(), entry.used
        );
    });   
           
    $('.detail-table .btnAdd').on('click', function (e) {
        e.preventDefault();
     	var customerDetailID = "0";
        var contactPerson = $('.detailInputContactPerson').val();
        var nickname = $('.detailInputNickname').val();
        var addressType = $('.detailInputAddressType').val();
        var country = $('.detailInputCountry').val();
        var city = $('.detailInputCity').val();
        var street = $('.detailInputStreet').val();
        var postalCode = $('.detailInputPostalCode').val();
        var phone = $('.detailInputPhone').val();
        var fax = $('.detailInputFax').val();
        var email = $('.detailInputEmail').val();
        
        if(contactPerson==''){
           bootbox.alert("Contact Person cannot be blank");
           $('form button[type=submit]').prop('disabled', true);
           return false;
        } 
    
        if(addressType==''){
           bootbox.alert("AddressType cannot be blank");
           $('form button[type=submit]').prop('disabled', true);
           return false;
        } 
    
        
    
        
        addRow(customerDetailID, contactPerson, nickname, addressType, country, city, street, postalCode, phone, fax, email, false);
        $('.detailInputContactPerson').val('');
        $('.detailInputNickname').val('');
        $('.detailInputAddressType').val('');
        $('.detailInputCountry').val('');
        $('.detailInputCity').val('');
        $('.detailInputStreet').val('');
        $('.detailInputPostalCode').val('');
        $('.detailInputPhone').val('');
        $('.detailInputFax').val('');
        $('.detailInputEmail').val('');
    
        $('form button[type=submit]').prop('disabled', false);
    });

    $('.detail-table').on('click', '.btnDelete', function (e) {
        var self = this;
        e.preventDefault();
        yii.confirm('Are you sure you want to delete this data ?',deleteRow);
        function deleteRow(){
            $(self).parents('tr').remove();
            var countData = $('.detail-table tbody tr').length;
            $('.flagInput').val(countData)-1;
        }
    });
        
    function addRow(customerDetailID, contactPerson, nickname, addressType, country, city, street, postalCode, phone, fax, email, used){
        var template = rowTemplate;
        if (used === undefined) used = false;
    
        template = replaceAll(template, '{{customerDetailID}}', customerDetailID);
        template = replaceAll(template, '{{contactPerson}}', contactPerson);
        template = replaceAll(template, '{{nickname}}', nickname);
        template = replaceAll(template, '{{addressType}}', addressType);
        template = replaceAll(template, '{{country}}', country);
        template = replaceAll(template, '{{city}}', city);
        template = replaceAll(template, '{{street}}', street);
        template = replaceAll(template, '{{postalCode}}', postalCode);
        template = replaceAll(template, '{{phone}}', phone);
        template = replaceAll(template, '{{fax}}', fax);
        template = replaceAll(template, '{{email}}', email);
        if (used) template = replaceAll(template, 'btnDelete', 'btnDelete hide');
        
        template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
        $('.detail-table tbody').append(template);
        var countData = $('.detail-table tbody tr').length;
        $('.flagInput').val(countData)+1;
    }

    function getMaximumCounter() {
        var maximum = 0;
         $('.customerDetailID').each(function(){
            value = parseInt($(this).attr('data-key'));
            if(value > maximum){
                maximum = value;
            }
        });
        return maximum;
    }

    
    $('form').on("beforeValidate", function(){
        var countData = $('.detail-table tbody tr').length;
        var flag = $('.flagInput').val();
        
        if(countData == 0){
            bootbox.alert("Minimum 1 detail must be filled");
            $('form button[type=submit]').prop('disabled', false);
            return false;
        }
        
        if(flag < countData){
           bootbox.alert("process save in detail");
           $('form button[type=submit]').prop('disabled', false);
           return false;
        }
        
        validated = true;
    });
});
SCRIPT;
$this->registerJs($js);
?>