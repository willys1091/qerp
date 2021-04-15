<?php

use app\components\AppHelper;
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model app\models\SubCategory */
/* @var $form ActiveForm */
?>

<div class="sub-category-form">
    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
	<div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3"> 
                        <?= $form->field($model, 'pettyCashDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isView)])) ?>
                    </div>
                    <div class="col-md-3"> 
                        <?= $form->field($model, 'voucher')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-3"> 
                        <?= $form->field($model, 'drAmount')
                            ->widget(\yii\widgets\MaskedInput::classname(), [
                                'clientOptions' => [
                                'alias' => 'decimal',
                                'digits' => 0,
                                'digitsOptional' => false,
                                'radixPoint' => ',',
                                'groupSeparator' => '.',
                                'autoGroup' => true,
                                'removeMaskOnSubmit' => false
                                                    ],
                                    'options' => [
                                        'class' => 'form-control currencyRate'
                                    ],
                        ])?>
                    </div>
                     <div class="col-md-3"> 
                        <?= $form->field($model, 'crAmount')
                            ->widget(\yii\widgets\MaskedInput::classname(), [
                                'clientOptions' => [
                                'alias' => 'decimal',
                                'digits' => 0,
                                'digitsOptional' => false,
                                'radixPoint' => ',',
                                'groupSeparator' => '.',
                                'autoGroup' => true,
                                'removeMaskOnSubmit' => false
                                                    ],
                                    'options' => [
                                        'class' => 'form-control currencyRate'
                                    ],
                        ])?>
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-md-12"> 
                            <?= $form->field($model, 'notes')->textArea(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <?php if (!isset($isView)): ?>
                        <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk with-text"></i>Save', 
                        ['class' => 'btn btn-primary btnSave']) ?>
                        <?php endif; ?>
                        <?= Html::a('<i class="glyphicon glyphicon-chevron-left with-text"></i>Back', ['index'], ['class'=>'btn btn-danger']) ?>
                    </div>
                    <div class="clearfix"></div>           
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>