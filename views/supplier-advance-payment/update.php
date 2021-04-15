<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrSupplieradvancepayment */

$this->title = 'Update Supplier Advance Payment: ' . $model->supplierAdvancePaymentNum;
$this->params['breadcrumbs'][] = ['label' => 'Supplier Advance Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->supplierAdvancePaymentNum, 'url' => ['view', 'id' => $model->supplierAdvancePaymentNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-supplieradvancepayment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
