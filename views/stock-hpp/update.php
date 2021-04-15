<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StockHpp */

$this->title = 'Update Stock Hpp: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Stock Hpps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stock-hpp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
