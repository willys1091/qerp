<?php

use yii\helpers\Html;
use app\components\AppHelper;
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
use kartik\form\ActiveField;
use app\models\TrDocumentcontrolhead;

/* @var $this yii\web\View */
/* @var $model app\models\TrDocumentcontrolhead */

$this->title = 'Document Details: '.Yii::$app->request->get('filter2');
?>
<div class="tr-documentcontrolhead-update">
	<?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => [
                   'enctype' => 'multipart/form-data',
                ]]); ?>
	<div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
		    <?php
		    	$i = 0;

		        foreach ($detailModel as $documentDetail) {
		            $result[$i]["docTypeID"] = $documentDetail->documentTypeID;
		            $result[$i]["docTypeName"] = $documentDetail->documentTypeName;
		            $result[$i]["flagMandatory"] = $documentDetail->flagMandatory;
		    ?>
		            <div class="col-md-6">
			            <label class="control-label">
			            	<?php echo $result[$i]["docTypeName"]; 
			            	if($result[$i]["flagMandatory"]=='1') echo "<h7 style='color: red;'> *</h7>"; ?>
			            		
			            </label>
			            </br>
			            <?=
			            	$form->field($model, "documentFiles")->widget(FileInput::classname(), [
							    'options' => ['accept' => 'pdf/*'],
							    'pluginOptions' => [
		                            'removeLabel' => 'Hapus',
		                            'cancelLabel' => 'Batal',
		                            'showUpload' => false,
		                            'showCancel' => false,
		                            'overwriteInitial' => false
		                        ]
							])->label(false)
		                ?>
		            </div>
		    <?php
		            $i += 1;
		        }
		    ?>
    	</div>
    	<div class="box-footer">
            <div class="form-group text-right">
                <?php if (!isset($isView)): ?>
                    <?= Html::submitButton('<i class="glyphicon glyphicon-save"> Save </i>', ['class' => 'btn btn-primary btnSave']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
