<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'Approve Goods Receipt: ' . $model->goodsReceiptNum;
$this->params['breadcrumbs'][] = ['label' => 'Goods Receipt Approval', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goodsReceiptNum, 'url' => ['view', 'id' => $model->goodsReceiptNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-goodsreceipthead-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
