<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrCustomeradvancepayment */

$this->title = 'Update Customer Advance Payment: ' . $model->custAdvancePaymentNum;
$this->params['breadcrumbs'][] = ['label' => 'Customer Advance Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->custAdvancePaymentNum, 'url' => ['view', 'id' => $model->custAdvancePaymentNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-customeradvancepayment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
