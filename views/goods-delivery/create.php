<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsdeliveryhead */

$this->title = 'Create Goods Delivery';
$this->params['breadcrumbs'][] = ['label' => 'Goods Delivery', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsdeliveryhead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
