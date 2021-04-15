<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsMarketing */

$this->title = 'Update Marketing : ' . $model->marketingName;
$this->params['breadcrumbs'][] = ['label' => 'Marketing', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-marketing-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
