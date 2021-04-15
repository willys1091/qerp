<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\AppHelper;
use app\models\MsCoa;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MsTax */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-tax-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="box box-primary box-solid">
		<div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
		<div class="box-body md-col-4">
			<div class="row">
				<div class="col-md-12">
					<?= $form->field($model, 'taxName')->textInput(['maxlength' => true]) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?= $form->field($model, 'taxRate')
						->widget(\yii\widgets\MaskedInput::classname(), [
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
										])?>
				</div>
				<div class="col-md-12">
					<?=
                    $form->field($model, 'coaNo')->widget(Select2::classname(),[
                        'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 AND (coaNo LIKE "1122.%" OR coaNo LIKE "5%")')->orderBy('description')->all(), 'coaNo', 'description' ),
                        'options' => [
                            'prompt' => 'Select Coa Number'],
                    ]);
                    ?>
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

