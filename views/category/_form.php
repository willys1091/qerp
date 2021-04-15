<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\AppHelper;
use app\models\MsCoa;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\MsProductcategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-productcategory-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'ProductCategoryName')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'coaNo')->widget(Select2::classname(),[
                        'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 and coaNo like "1119.%"')->orderBy('description')->all(), 'coaNo', 'description' ),
                        'options' => [
                            'prompt' => 'Select COA'],
                    ]);
                    ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'flagInventory')->widget(SwitchInput::classname(), [
                        'type' => SwitchInput::CHECKBOX 
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'notes')->textArea(['maxlength' => true]) ?>
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