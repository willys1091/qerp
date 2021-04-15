<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\AppHelper;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model app\models\LkUserRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userrole-form">
    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'userRole')->textInput(['maxlength' => true]) ?>
            
        </div>
        <div class="box-body">
        	<div class="panel panel-default">
                <div class="panel-heading">User Access</div>
                <div class="panel-body">
                    <div class="row" id="divUserAccess">
						<div class="col-md-12">
							<div class="form-group">
								<table class="table table-bordered user-access-table" style="border-collapse: inherit;">
									<thead class="user-access-drop">
										<tr>
											<th style="min-width: 400px" class="col-md-6">Description</th>
											<th style="text-align: center; min-width: 120px;" class="col-md-2">View</th>
											<th style="text-align: center; min-width: 120px;" class="col-md-2">Insert</th>
											<th style="text-align: center; min-width: 120px;" class="col-md-2">Update</th>
											<th style="text-align: center; min-width: 120px;" class="col-md-2">Delete</th>
											<th style="text-align: center; min-width: 13px;"></th>
										</tr>
										<tr>
											<th style="min-width: 400px" class="col-md-6"></th>
											<th style="text-align: center; min-width: 120px;" class="col-md-2"><input type="checkbox" class="selectView"></th>
											<th style="text-align: center; min-width: 120px;" class="col-md-2"><input type="checkbox" class="selectInsert"></th>
											<th style="text-align: center; min-width: 120px;" class="col-md-2"><input type="checkbox" class="selectUpdate"></th>
											<th style="text-align: center; min-width: 120px;" class="col-md-2"><input type="checkbox" class="selectDelete"></th>
											<th style="text-align: center; min-width: 13px;"></th>
										</tr>
									</thead>
									<tbody class="user-access-drop">

									</tbody>
									<?php if (!isset($isView)): ?>
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
$userAccess = \yii\helpers\Json::encode($model->joinMsUserAccess);

$js = <<< SCRIPT

$(document).ready(function () {
	
var initValue = $userAccess;
	var rowTemplate = "" +
		"<tr>" +
		"       <input type='hidden' class='userID' name='MsUseraccess[joinMsUserAccess][{{Count}}][ID]' value='{{ID}}' >" +
		"       <input type='hidden' class='userAccessID' name='MsUseraccess[joinMsUserAccess][{{Count}}][accessID]' data-key='{{Count}}' value='{{accessID}}' >" +
		"       {{accessID}}" +
		"   <td class='text-left col-md-6' style='min-width: 400px;'>" +
		"       <input type='hidden' class='userDescription' name='MsUseraccess[joinMsUserAccess][{{Count}}][description]' value='{{description}}' > {{description}}" +
                "   </td>" +
		"   <td class='text-center col-md-2' style='min-width: 120px;'>" +
		"       <input type='hidden' class='userViewValue' name='MsUseraccess[joinMsUserAccess][{{Count}}][viewValue]' value='{{viewValue}}' > " +
		"       <input type='checkbox' class='userView' name='MsUseraccess[joinMsUserAccess][{{Count}}][viewAcc]' {{viewAcc}} >" +
                "   </td>" +
		"   <td class='text-center col-md-2' style='min-width: 120px;'>" +
		"       <input type='hidden' class='userInsertValue' name='MsUseraccess[joinMsUserAccess][{{Count}}][insertValue]' value='{{insertValue}}' > " +
		"       <input type='checkbox' class='userInsert' name='MsUseraccess[joinMsUserAccess][{{Count}}][insertAcc]'  {{insertAcc}} >" +
                "   </td>" +
		"   <td class='text-center col-md-2' style='min-width: 120px;'>" +
		"       <input type='hidden' class='userUpdateValue' name='MsUseraccess[joinMsUserAccess][{{Count}}][updateValue]' value='{{updateValue}}' > " +
		"       <input type='checkbox' class='userUpdate' name='MsUseraccess[joinMsUserAccess][{{Count}}][updateAcc]' {{updateAcc}} >" +
                "   </td>" +
		"   <td class='text-center col-md-2' style='min-width: 120px;'>" +
		"       <input type='hidden' class='userDeleteValue' name='MsUseraccess[joinMsUserAccess][{{Count}}][deleteValue]' value='{{deleteValue}}' > " +
		"       <input type='checkbox' class='userDelete' name='MsUseraccess[joinMsUserAccess][{{Count}}][deleteAcc]' {{deleteAcc}} >" +
                "   </td>" +
		"</tr>";

 	initValue.forEach(function(entry) {
		addRow(entry.ID.toString(), entry.accessID.toString(), entry.description.toString(), entry.viewValue.toString(), entry.viewAcc.toString(), entry.insertValue.toString(), entry.insertAcc.toString(), entry.updateValue.toString(), entry.updateAcc.toString(), entry.deleteValue.toString(), entry.deleteAcc.toString());
	});
	
	function addRow(ID, accessID, description, viewValue, viewAcc, insertValue, insertAcc, updateValue, updateAcc, deleteValue, deleteAcc){
		var template = rowTemplate;
		
		template = replaceAll(template, '{{ID}}', ID);
		template = replaceAll(template, '{{accessID}}', accessID);
		template = replaceAll(template, '{{description}}', description);
		template = replaceAll(template, '{{viewValue}}', viewValue);
		template = replaceAll(template, '{{viewAcc}}', viewAcc);
		template = replaceAll(template, '{{insertValue}}', insertValue);
		template = replaceAll(template, '{{insertAcc}}', insertAcc);
		template = replaceAll(template, '{{updateValue}}', updateValue);
		template = replaceAll(template, '{{updateAcc}}', updateAcc);
		template = replaceAll(template, '{{deleteValue}}', deleteValue);
		template = replaceAll(template, '{{deleteAcc}}', deleteAcc);
		template = replaceAll(template, '{{Count}}', getMaximumCounter() + 1);
		$('.user-access-table tbody').append(template);
	}
	
	$('.selectView').change(function(){
		if($(".selectView").is(":checked")){
	        $('.user-access-table tbody').each(function() {
	            $('tr', this).each(function () {
	                $('.userViewValue').val(1);
					$('.userView').prop('checked', true); 
	            })
	        });
	    }
	    else{
	        $('.user-access-table tbody').each(function() {
	            $('tr', this).each(function () {
	                $('.userViewValue').val(0);
					$('.userView').prop('checked', false); 
	            })
	        });
	    }
	});
	$('.selectInsert').change(function(){
		if($(".selectInsert").is(":checked")){
	        $('.user-access-table tbody').each(function() {
	            $('tr', this).each(function () {
	                $('.userInsertValue').val(1);
					$('.userInsert').prop('checked', true); 
	            })
	        });
	    }
	    else{
	        $('.user-access-table tbody').each(function() {
	            $('tr', this).each(function () {
	                $('.userInsertValue').val(0);
					$('.userInsert').prop('checked', false); 
	            })
	        });
	    }
	});
	$('.selectUpdate').change(function(){
		if($(".selectUpdate").is(":checked")){
	        $('.user-access-table tbody').each(function() {
	            $('tr', this).each(function () {
	                $('.userUpdateValue').val(1);
					$('.userUpdate').prop('checked', true); 
	            })
	        });
	    }
	    else{
	        $('.user-access-table tbody').each(function() {
	            $('tr', this).each(function () {
	                $('.userUpdateValue').val(0);
					$('.userUpdate').prop('checked', false); 
	            })
	        });
	    }
	});
	$('.selectDelete').change(function(){
		if($(".selectDelete").is(":checked")){
	        $('.user-access-table tbody').each(function() {
	            $('tr', this).each(function () {
	                $('.userDeleteValue').val(1);
					$('.userDelete').prop('checked', true); 
	            })
	        });
	    }
	    else{
	        $('.user-access-table tbody').each(function() {
	            $('tr', this).each(function () {
	                $('.userDeleteValue').val(0);
					$('.userDelete').prop('checked', false); 
	            })
	        });
	    }
	});

	function accessIDExistsInTable(access){
		var exists = false;
		$('.userAccessID').each(function(){
			if($(this).val() == access){
				exists = true;
			}
		});
		return exists;
	}
	
	
	function getMaximumCounter() {
		var maximum = 0;
		 $('.userAccessID').each(function(){
			value = parseInt($(this).attr('data-key'));
			if(value > maximum){
				maximum = value;
			}
		});
		return maximum;
	}

              
	$("input[type='checkbox']").on('click', function() {
		if(this.checked) {
			$(this).prev().val(1);
			$(this).attr('checked', 'checked');
		}else{
			$(this).prev().val(0);
			$(this).attr('checked','');
		}
	});

	$('form').on("beforeValidate", function(){
		var countData = $('.user-access-table tbody tr').length;

		if(countData == 0){
			bootbox.alert("Minimum 1 detail must be filled");
			return false;
		}
	});
});
SCRIPT;
$this->registerJs($js);
?>


