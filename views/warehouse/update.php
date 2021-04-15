<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsWarehouse */

$this->title = 'Update Warehouse Information : ' . $model->warehouseName;
$this->params['breadcrumbs'][] = ['label' => 'Warehouse', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-warehouse-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
