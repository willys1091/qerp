<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsSupplier */

$this->title = 'Update Supplier : ' . $model->supplierName;
$this->params['breadcrumbs'][] = ['label' => 'Supplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-supplier-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
