<?php

use yii\web\View;


/* @var $this View */
/* @var $model app\models\SampleDeliveryForm */

$this->title = 'Create Sample Delivery';
$this->params['breadcrumbs'][] = ['label' => 'Sample Delivery', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-delivery-create">

    <?= $this->render('_form', [
        'model' => $model,
        'update' => '0'
    ]) ?>

</div>