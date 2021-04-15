<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsUser */

$this->title = 'Update User : ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
