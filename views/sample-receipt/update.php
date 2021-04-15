<?php

use yii\web\View;

/* @var $this View */
/* @var $model app\models\SampleReceiptForm */

$this->title = 'Update Sample Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Sample Receipt', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sample-receipt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
