<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CashBankTransfer */

$this->title = 'Update Cash / Bank Transfer: ' . $model->transferID;
$this->params['breadcrumbs'][] = ['label' => 'Cash / Bank Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->transferID, 'url' => ['view', 'id' => $model->transferID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cash-bank-transfer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
