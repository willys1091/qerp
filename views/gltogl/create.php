<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Gltogl */

$this->title = 'GL to GL';
$this->params['breadcrumbs'][] = ['label' => 'GL to GL Information', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gltogl-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
