<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrStockopnamehead */

$this->title = 'Update Found Stock Adjustment: ' . $model->stockOpnameNum;
$this->params['breadcrumbs'][] = ['label' => 'FoundStock Adjustment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->stockOpnameNum];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-stockopnamehead-update">

    <?= $this->render('_form', [
        'model' => $model,
        'update' => 1
    ]) ?>

</div>
