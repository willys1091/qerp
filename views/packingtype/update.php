<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsPackingtype */

$this->title = 'Update Packing Type : ' . $model->packingTypeName;
$this->params['breadcrumbs'][] = ['label' => 'Packing Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-packingtype-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
