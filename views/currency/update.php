<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsCurrency */

$this->title = 'Update Currency : ' . $model->currencyID;
$this->params['breadcrumbs'][] = ['label' => 'Currency', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-currency-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
