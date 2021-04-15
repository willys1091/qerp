<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrStocktransferhead */

$this->title = 'Create Stock Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Stock Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-stocktransferhead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
