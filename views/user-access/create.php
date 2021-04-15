<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LkUserRole */

$this->title = 'User Access Information';
$this->params['breadcrumbs'][] = ['label' => 'User Role', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userrole-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
