<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrStockopnamehead */

$this->title = 'Create Lost Stock Adjustment';
$this->params['breadcrumbs'][] = ['label' => 'Lost Stock Adjustment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-stockopnamehead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
