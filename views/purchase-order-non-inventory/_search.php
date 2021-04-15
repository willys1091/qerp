<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrPurchaseordernoninventoryheadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-purchaseordernoninventoryhead-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'purchaseOrderNonInventoryDate') ?>

    <?= $form->field($model, 'refNum') ?>

    <?= $form->field($model, 'hasVAT')->checkbox() ?>

    <?= $form->field($model, 'taxInvoice') ?>

    <?php // echo $form->field($model, 'supplierID') ?>

    <?php // echo $form->field($model, 'additionalInfo') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'discountTotal') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'VAT') ?>

    <?php // echo $form->field($model, 'grandTotal') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
