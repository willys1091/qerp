<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrJournaldetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-journaldetail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'journalHeadID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coaNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'originalDrAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'originalCrAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'drAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crAmount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
