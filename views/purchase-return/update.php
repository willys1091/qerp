<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrPurchasereturnhead */

$this->title = 'Update Purchase Return: ' . $model->purchaseReturnNum;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Return', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->purchaseReturnNum, 'url' => ['view', 'id' => $model->purchaseReturnNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-purchasereturnhead-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
