<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StockCard */

$this->title = 'Update Stock Card: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Stock Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stock-card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
