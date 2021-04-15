<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\components\AppHelper;
use kartik\touchspin\TouchSpin;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\MsSupplier */
/* @var $form yii\widgets\ActiveForm */
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
						<div class="col-md-4">
							<?= $form->field($model, 'supplierName')->textInput(['maxlength' => true, 'class' => 'form-control supplierName']) ?>
						</div>
						<div class="col-md-4">
							<?= $form->field($model, 'isForwarder')->widget(SwitchInput::classname(), [
									    'type' => SwitchInput::CHECKBOX 
									]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Contact Person Detail</div>
				<div class="panel-body">
					<div class="row" id="divPicSupplierDetail">
						<div class="col-md-12">
							<div class="form-group">
								<table class="table table-bordered contact-detail-table" style="border-collapse: inherit;">
									<thead>
									<tr>
										<th style="width: 35%;">Contact Person</th>
										<th style="width: 35%;">Nickname</th>
										<th style="width: 30%;">Position</th>
									</tr>
									</thead>
									<tbody>
										
									</tbody>
									<tfoot>
									<tr>
										<td>
											<?= Html::textInput('contactPerson', '', [
												'class' => 'form-control inputContactPerson',
												'maxlength'=>50
											]) ?>
										</td>
										<td>
											<?= Html::textInput('nickname', '', [
												'class' => 'form-control inputNickname',
												'maxlength'=>45
											]) ?>
										</td>
										<td>
											<?= Html::textInput('position', '', [
												'class' => 'form-control inputPosition',
												'maxlength'=>50
											]) ?>
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
				<div class="panel-heading">Bank Account Detail</div>
				<div class="panel-body">
					<div class="row" id="divPicSupplierDetail">
						<div class="col-md-12">
							<div class="form-group">
								<table class="table table-bordered pic-supplier-detail-table" style="border-collapse: inherit;">
									<thead>
									<tr>
										<th style="width: 15%;">Bank Name</th>
										<th style="width: 15%;">Swift Code</th>
										<th style="width: 20%;">Account No.</th>
										<th style="width: 10%;">Country</th>
										<th style="width: 10%;">City</th>
										<th style="width: 15%;">Street</th>
										<th style="width: 10%;">Postal Code</th>
									</tr>
									</thead>
									<tbody>
										
									</tbody>
									<tfoot>
									<tr>
	                                    <td class="visibility: hidden">
	                                        <?= Html::hiddenInput('supplierDetailID', '', [
	                                                        'class' => 'form-control picSuppIDInput'
	                                                ]) ?>
	                                    </td>
										<td>
											<?= Html::textInput('bankName', '', [
												'class' => 'form-control picSuppInput-1',
												'maxlength'=>50
											]) ?>
										</td>
										<td>
											<?= Html::textInput('swiftCode', '', [
												'class' => 'form-control picSuppInput-2',
												'maxlength'=>50
											]) ?>
										</td>
										<td>
											<?= Html::textInput('accountNo', '', [
												'class' => 'form-control picSuppInput-3',
												'maxlength'=>50
											]) ?>
										</td>
										<td>
											<?= Html::textInput('country', '', [
												'class' => 'form-control picSuppInput-4',
												'maxlength'=>50
											]) ?>
										</td>
										<td>
											<?= Html::textInput('city', '', [
												'class' => 'form-control picSuppInput-5',
												'maxlength'=>50
											]) ?>
										</td>
										<td>
											<?= Html::textInput('street', '', [
												'class' => 'form-control picSuppInput-6',
												'maxlength'=>50
											]) ?>
										</td>
										<td>
											<?= Html::textInput('postalCode', '', [
												'class' => 'form-control picSuppInput-7',
												'maxlength'=>50
											]) ?>
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
				<div class="panel-heading">Supplier Address</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<?= $form->field($model, 'postalCode')->textInput(['maxlength' => true]) ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'street')->textArea(['maxlength' => true]) ?>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Supplier Contact</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'officeNumber')->textInput(['maxlength' => true]) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'factoryNumber')->textInput(['maxlength' => true]) ?>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Supplier NPWP</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'npwp')->textInput(['maxlength' => true]) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'npwpRegisteredDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isView)])) ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'npwpAddress')->textArea(['maxlength' => true]) ?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<?= $form->field($model, 'notes')->textArea(['maxlength' => true, 'rows' => 4]) ?>
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
$supplierContactDetail = \yii\helpers\Json::encode($model->joinMsSupplierContactDetail);
$picSuppDetail = \yii\helpers\Json::encode($model->joinMsSupplierDetail);
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

$js = <<< SCRIPT

$(document).ready(function () {
    var initValueContact = $supplierContactDetail;
    var initValue = $picSuppDetail;
	
	var rowTemplate = "" +
		"<tr>" +
                "  <input type='hidden' class='supplierDetailID' name='MsSupplier[joinMsSupplierDetail][{{Count}}][supplierDetailID]' data-key='{{Count}}' value='{{supplierDetailID}}' >" +
		"       {{picSupplierID}}" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='50' class='text-left form-control supplierDetailBankName' style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierDetail][{{Count}}][bankName]' value='{{bankName}}' " +
		"   </td>" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='50' class='text-left form-control supplierDetailSwiftCode'   style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierDetail][{{Count}}][swiftCode]' value='{{swiftCode}}' " +
		"   </td>" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='50' class='text-left form-control supplierDetailAccountNo'  style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierDetail][{{Count}}][accountNo]' value='{{accountNo}}' " +
		"   </td>" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='15' class='text-left form-control supplierDetailCountry' style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierDetail][{{Count}}][country]' value='{{country}}' " +
		"   </td>" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='15' class='text-left form-control supplierDetailCity' style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierDetail][{{Count}}][city]' value='{{city}}' " +
		"   </td>" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='15' class='text-left form-control supplierDetailStreet' style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierDetail][{{Count}}][street]' value='{{street}}' " +
		"   </td>" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='15' class='text-left form-control supplierDetailPostalCode' style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierDetail][{{Count}}][postalCode]' value='{{postalCode}}' " +
		"   </td>" +
			$deleteRow
		"</tr>";
	 initValue.forEach(function(entry) {
		addRow(entry.supplierDetailID.toString(), entry.bankName.toString(), entry.swiftCode.toString(), entry.accountNo.toString(), entry.country.toString(), entry.city.toString(), entry.street.toString(), entry.postalCode.toString());
	});

	var rowTemplateContact = "" +
		"<tr>" +
		"       <input type='hidden' class='supplierDetailContactPersonID' name='MsSupplier[joinMsSupplierContactDetail][{{Count}}][supplierContactID]' value='{{supplierContactID}}' />" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='50' class='text-left form-control supplierDetailContactPerson' data-key='{{Count}}' style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierContactDetail][{{Count}}][contactPerson]' value='{{contactPerson}}' />" +
		"   </td>" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='50' class='text-left form-control supplierDetailNickname' data-key='{{Count}}' style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierContactDetail][{{Count}}][nickname]' value='{{nickname}}' />" +
		"   </td>" +
		"   <td class='text-center'>" +
		"       <input type='text' maxlength='50' class='text-left form-control supplierDetailPosition'   style='background-color:white; width: 100%' name='MsSupplier[joinMsSupplierContactDetail][{{Count}}][position]' value='{{position}}' />" +
		"   </td>" +
			$deleteRow
		"</tr>";
	initValueContact.forEach(function(entryContact) {
		addRowContact(entryContact.supplierContactID.toString(), entryContact.contactPerson.toString(), entryContact.nickname.toString(), entryContact.position.toString());
	});
        
    $('.contact-detail-table .btnAdd').on('click', function (e) {
		e.preventDefault();
		var supplierContactID = 0;
     	var contactPerson = $('.inputContactPerson').val();
     	var nickname = $('.inputNickname').val();
		var position = $('.inputPosition').val();
				
		addRowContact(supplierContactID, contactPerson, nickname, position);
		$('.inputContactPerson').val('');
		$('.inputNickname').val('');
		$('.inputPosition').val('');
	});

    $('.pic-supplier-detail-table .btnAdd').on('click', function (e) {
		e.preventDefault();
     	var supplierDetailID = 0;
		var bankName = $('.picSuppInput-1').val();
		var swiftCode = $('.picSuppInput-2').val();
    	var accountNo = $('.picSuppInput-3').val();
		var country = $('.picSuppInput-4').val();
		var city = $('.picSuppInput-5').val();
		var street = $('.picSuppInput-6').val();
		var postalCode = $('.picSuppInput-7').val();
				
		addRow(supplierDetailID, bankName, swiftCode, accountNo, country, city, street, postalCode);
		$('.picSuppInput-1').val('');
		$('.picSuppInput-2').val('');
		$('.picSuppInput-3').val('');
		$('.picSuppInput-4').val('');
		$('.picSuppInput-5').val('');
		$('.picSuppInput-6').val('');
		$('.picSuppInput-7').val('');
	});

	$('.contact-detail-table').on('click', '.btnDelete', function (e) {
		var self = this;
		e.preventDefault();
		yii.confirm('Are you sure you want to delete this data ?',deleteRow);
		function deleteRow(){
			$(self).parents('tr').remove();
		}
	});
	$('.pic-supplier-detail-table').on('click', '.btnDelete', function (e) {
		var self = this;
		e.preventDefault();
		yii.confirm('Are you sure you want to delete this data ?',deleteRow);
		function deleteRow(){
			$(self).parents('tr').remove();
		}
	});
	
    $('.btnEdit').on('click', function (e) {
		var self = this;
		e.preventDefault();
		if($(self).text() == 'Edit'){
		$(self).parents().parents('tr').find('.supplierDetailBankName').prop("readonly",false).attr('style', 'background-color:#DEDEDE; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailSwiftCode').prop("readonly",false).attr('style', 'background-color:#DEDEDE; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailAccountNo').prop("readonly",false).attr('style', 'background-color:#DEDEDE; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailCountry').prop("readonly",false).attr('style', 'background-color:#DEDEDE; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailCity').prop("readonly",false).attr('style', 'background-color:#DEDEDE; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailStreet').prop("readonly",false).attr('style', 'background-color:#DEDEDE; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailPostalCode').prop("readonly",false).attr('style', 'background-color:#DEDEDE; width: 100%');
		$(self).text('Save');
		$(self).removeClass('glyphicon glyphicon-pencil').addClass('glyphicon glyphicon-save');
		var countData = $('.flagInput').val();
		countData = parseInt(countData)-1;
		$('.flagInput').val(countData);
		}else{
		$(self).parents().parents('tr').find('.supplierDetailBankName').prop("readonly",true).attr('style', 'background-color:#FFFFFF; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailSwiftCode').prop("readonly",true).attr('style', 'background-color:#FFFFFF; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailAccountNo').prop("readonly",true).attr('style', 'background-color:#FFFFFF; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailCountry').prop("readonly",true).attr('style', 'background-color:#FFFFFF; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailCity').prop("readonly",true).attr('style', 'background-color:#FFFFFF; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailStreet').prop("readonly",true).attr('style', 'background-color:#FFFFFF; width: 100%');
		$(self).parents().parents('tr').find('.supplierDetailPostalCode').prop("readonly",true).attr('style', 'background-color:#FFFFFF; width: 100%');
		$(self).text('Edit');
		$(self).removeClass('glyphicon glyphicon-save').addClass('glyphicon glyphicon-pencil');
		var countData = $('.flagInput').val();
		countData = parseInt(countData)+1;
		$('.flagInput').val(countData);
		}

      });
        
    function addRowContact(supplierContactID, contactPerson, nickname, position){
		var template = rowTemplateContact;
		
		template = replaceAll(template, '{{supplierContactID}}', supplierContactID);
		template = replaceAll(template, '{{contactPerson}}', contactPerson);
		template = replaceAll(template, '{{nickname}}', nickname);
        template = replaceAll(template, '{{position}}', position);
		template = replaceAll(template, '{{Count}}', getMaximumCounterContact() + 1);
		$('.contact-detail-table tbody').append(template);
	}
    function addRow(supplierDetailID, bankName, swiftCode, accountNo, country, city, street, postalCode){
		var template = rowTemplate;
		
		template = replaceAll(template, '{{supplierDetailID}}', supplierDetailID);
        template = replaceAll(template, '{{bankName}}', bankName);
		template = replaceAll(template, '{{swiftCode}}', swiftCode);
		template = replaceAll(template, '{{accountNo}}', accountNo);
        template = replaceAll(template, '{{country}}', country);
        template = replaceAll(template, '{{city}}', city);
        template = replaceAll(template, '{{street}}', street);
        template = replaceAll(template, '{{postalCode}}', postalCode);
		template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
		$('.pic-supplier-detail-table tbody').append(template);
	}
	
	function picSupplierExistsInTable(picSupp){
		var exists = false;
		$('.picSuppDetailPicName').each(function(){
			if($(this).val() == picSupp){
				exists = true;
			}
		});
		return exists;
	}
	
	function getMaximumCounterContact() {
		var maximum = 0;
		 $('.supplierDetailContactPerson').each(function(){
			value2 = parseInt($(this).attr('data-key'));
			if(value2 > maximum){
				maximum = value2;
			}
		});
		return maximum;
	}
	function getMaximumCounter() {
		var maximum = 0;
		 $('.supplierDetailID').each(function(){
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
SCRIPT;
$this->registerJs($js);
?>
