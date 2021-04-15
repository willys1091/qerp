<?php

use yii\web\View;


/* @var $this View */
/* @var $model app\models\PackingType */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>