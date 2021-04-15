<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrCustomerpayment */

$this->title = 'Update Customer Payment: ' . $model->customerPaymentNum;
$this->params['breadcrumbs'][] = ['label' => 'Customer Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customerPaymentNum, 'url' => ['view', 'id' => $model->customerPaymentNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-customerpayment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
