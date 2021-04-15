<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Gltogl */

$this->title = 'Update GL to GL: ' . $model->gltoglNum;
$this->params['breadcrumbs'][] = ['label' => 'GL to GL Information', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gltoglNum, 'url' => ['view', 'id' => $model->gltoglNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gltogl-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
