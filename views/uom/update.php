<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsUom */

$this->title = 'Update Uom : ' . $model->uomName;
$this->params['breadcrumbs'][] = ['label' => 'UOM', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-uom-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
