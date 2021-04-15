<?php

use yii\web\View;

/* @var $this View */
/* @var $model app\models\SampleDeliveryForm */

$this->title = 'Update Sample Delivery';
$this->params['breadcrumbs'][] = ['label' => 'Sample Delivery', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sample-delivery-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
