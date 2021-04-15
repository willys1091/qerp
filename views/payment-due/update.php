<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsPaymentdue */

$this->title = 'Update Ms Paymentdue: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Ms Paymentdues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-paymentdue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
