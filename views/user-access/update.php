<?php

use yii\helpers\Html;

$this->title = 'Update User Access :' . ' ' . $model->userRole;
$this->params['breadcrumbs'][] = ['label' => 'User Access', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userrole-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
