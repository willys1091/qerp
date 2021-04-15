<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsTax */

$this->title = 'Tax Information';
$this->params['breadcrumbs'][] = ['label' => 'Tax', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-tax-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
