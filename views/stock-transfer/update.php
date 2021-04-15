<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrStocktransferhead */

$this->title = 'Update Stock Transfer: ' . $model->stockTransferNum;
$this->params['breadcrumbs'][] = ['label' => 'Stock Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->stockTransferNum, 'url' => ['view', 'id' => $model->stockTransferNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-stocktransferhead-update">

    <?= $this->render('_form', [
        'model' => $model,
        'update' => 1
    ]) ?>

</div>
