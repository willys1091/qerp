<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsProduct */

$this->title = 'Update Product Supplier ';
$this->params['breadcrumbs'][] = ['label' => 'Product Supplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-productsuppier-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
