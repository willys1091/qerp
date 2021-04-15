<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'Pending Goods Receipt: ' . $model->refNum;
$this->params['breadcrumbs'][] = ['label' => 'Goods Receipt', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refNum, 'url' => ['view', 'id' => $model->refNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-goodsreceipthead-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
