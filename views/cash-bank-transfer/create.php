<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CashBankTransfer */

$this->title = 'Create Cash/Bank Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Cash / Bank Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-bank-transfer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
