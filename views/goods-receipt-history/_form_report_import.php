<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\MsWarehouse;
use app\models\MsSupplier;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-goodsreceipthead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Import Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label isImport">CIF</label>
                            <?= $form->field($model, 'CIF')
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
                                        'class' => 'form-control text-right cnf isImport'
                                    ],
                                    ])
                            ->label(false)
                            ?>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label isImport">FOB</label>
                            <?= $form->field($model, 'FOB')
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
                                        'class' => 'form-control text-right cnf isImport'
                                    ],
                                    ])
                            ->label(false)
                            ?>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label isImport">CNF</label>
                            <?= $form->field($model, 'CNF')
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
                                        'class' => 'form-control text-right cnf isImport'
                                    ],
                                    ])
                            ->label(false)
                            ?>
                        </div>
                        <div class="col-md-4 ">
                            <?= $form->field($model, 'lsNo')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4 ">
                            <?= $form->field($model, 'lsDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig()) ?>
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

