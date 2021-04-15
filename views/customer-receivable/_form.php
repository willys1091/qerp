<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrCustomerreceivablehead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-customerreceivablehead-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'receivableNum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receivableDate')->textInput() ?>

    <?= $form->field($model, 'customerID')->textInput() ?>

    <?= $form->field($model, 'createdBy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createdDate')->textInput() ?>

    <?= $form->field($model, 'editedBy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'editedDate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
