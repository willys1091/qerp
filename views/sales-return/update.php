<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrSalesreturnhead */

$this->title = 'Update Sales Return: ' . $model->salesReturnNum;
$this->params['breadcrumbs'][] = ['label' => 'Sales Return', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->salesReturnNum, 'url' => ['view', 'id' => $model->salesReturnNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-salesreturnhead-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
