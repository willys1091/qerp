<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrPettyCash */

$this->title = 'Update Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Tr Petty Cashes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pettyCashNum, 'url' => ['view', 'id' => $model->pettyCashNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-petty-cash-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
