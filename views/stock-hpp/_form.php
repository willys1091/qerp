<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StockHpp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-hpp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stockDate')->textInput() ?>

    <?= $form->field($model, 'refNum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expiredDate')->textInput() ?>

    <?= $form->field($model, 'warehouseID')->textInput() ?>

    <?= $form->field($model, 'productID')->textInput() ?>

    <?= $form->field($model, 'HPP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qtyStock')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
