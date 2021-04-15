<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrSupplierpaymenthead */

$this->title = 'Update Forwarder Payment: ' . $model->supplierPaymentNum;
$this->params['breadcrumbs'][] = ['label' => 'Supplier Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->supplierPaymentNum, 'url' => ['view', 'id' => $model->supplierPaymentNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-supplierpaymenthead-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
