<?php

use yii\web\View;

/* @var $this View */
/* @var $model app\models\Product */

$this->title = 'Update Product';
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
