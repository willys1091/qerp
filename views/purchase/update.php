<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrPurchaseorderhead */

$this->title = 'Update Purchase Order: ' . $model->purchaseOrderNum;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->purchaseOrderNum, 'url' => ['view', 'id' => $model->purchaseOrderNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-purchaseorderhead-update">

    <?= $this->render('_form', [
        'model' => $model,
        'isUpdate' => 1,
    ]) ?>

</div>
