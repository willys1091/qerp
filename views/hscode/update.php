<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsHscode */

$this->title = 'Update HS Code: ' . $model->hsCodeID;
$this->params['breadcrumbs'][] = ['label' => 'HS Code', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->hsCodeID, 'url' => ['view', 'id' => $model->hsCodeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-hscode-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
