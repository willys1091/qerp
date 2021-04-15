<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use app\models\LkDocumenttype;
use app\models\MsReportdestination;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\MsDocumenttype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-documenttype-form">

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
                		<div class="col-md-12">
							<?= $form->field($model, 'documentTypeName')->textInput(['maxlength' => true]) ?>
						</div>
                	</div>
                    <div class="row">
						<div class="col-md-6">
			                <?=
				                $form->field($model, 'lkDocumentTypeID')->widget(Select2::classname(),[
				                    'data' => ArrayHelper::map(LkDocumenttype::find ()->distinct()->all(), 'lkDocumentTypeID', 'lkDocumentTypeName' ),
				                    'options' => [
				                        'prompt' => 'Select Transaction Type'],
				                ]);
			                ?>
						</div>
						<div class="col-md-6">
							<?=
		                        $form->field($model, 'reportDestination')->widget(Select2::classname(),[
		                            'data' => ArrayHelper::map(MsReportdestination::find()->all(), 'reportDestinationID', 'reportDestinationName'),
		                            'options' => [ 'placeholder' => 'Report to', 'multiple' => true],
		                        ]);
		                    ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<?=
		                        $form->field($model, 'ordinal')->widget(TouchSpin::classname(), [
		                        'options' => ['placeholder' => '', ],
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
							<?= $form->field($model, 'flagMandatory')->widget(SwitchInput::classname(), [
									    'type' => SwitchInput::CHECKBOX 
									]); ?>
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