<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrSupplieradvancepayment */

$this->title = 'Create Supplier Advance Payment';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Advance Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-supplieradvancepayment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
