<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsPaymentdue */

$this->title = 'Create Payment Due';
$this->params['breadcrumbs'][] = ['label' => 'Payment Due', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-paymentdue-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
