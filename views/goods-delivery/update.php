<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsdeliveryhead */

$this->title = 'Create Goods Delivery: ' . $model->goodsDeliveryNum;
$this->params['breadcrumbs'][] = ['label' => 'Goods Delivery', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goodsDeliveryNum, 'url' => ['view', 'id' => $model->goodsDeliveryNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-goodsdeliveryhead-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
