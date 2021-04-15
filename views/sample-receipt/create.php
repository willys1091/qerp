<?php

use yii\web\View;


/* @var $this View */
/* @var $model app\models\SampleReceiptForm */

$this->title = 'Create Sample Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Sample Receipt', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-receipt-create">

    <?= $this->render('_form', [
        'model' => $model,
        'update' => '0'
    ]) ?>

</div>