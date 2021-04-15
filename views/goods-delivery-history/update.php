<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'Update Pending Goods Delivery: ' . $model->goodsDeliveryNum;
$this->params['breadcrumbs'][] = ['label' => 'Goods Receipt History', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goodsDeliveryNum, 'url' => ['view', 'id' => $model->goodsDeliveryNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-goodsreceipthead-update">

    <?= $this->render('_form', [
        'model' => $model,
        'isUpdate' => 1,
    ]) ?>

</div>
