<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsProduct */

$this->title = 'Update Product : ' . $model->productName;
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-product-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
