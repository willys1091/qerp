<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'Create Goods Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Goods Receipt', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsreceipthead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
