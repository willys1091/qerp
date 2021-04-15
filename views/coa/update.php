<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsCoa */

$this->title = 'Update Coa : ' . $model->coaNo;
$this->params['breadcrumbs'][] = ['label' => 'Coa', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-coa-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
