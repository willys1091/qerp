<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsCustomer */

$this->title = 'Update Customer : ' . $model->customerName;
$this->params['breadcrumbs'][] = ['label' => 'Customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-customer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
