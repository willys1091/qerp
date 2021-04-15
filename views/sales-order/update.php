<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrSalesorderhead */

$this->title = 'Update Sales Order: ' . $model->salesOrderNum;
$this->params['breadcrumbs'][] = ['label' => 'Sales Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->salesOrderNum, 'url' => ['view', 'id' => $model->salesOrderNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-salesorderhead-update">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
