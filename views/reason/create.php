<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsReason */

$this->title = 'Reason Information';
$this->params['breadcrumbs'][] = ['label' => 'Reason', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-reason-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
