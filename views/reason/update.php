<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsReason */

$this->title = 'Update Reason : ' . $model->mapReasonID;
$this->params['breadcrumbs'][] = ['label' => 'Reason', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-reason-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
