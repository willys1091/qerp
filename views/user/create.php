<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsUser */

$this->title = 'User Information';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
 <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
