<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrSalesorderhead */

$this->title = 'Create Sales Order';
$this->params['breadcrumbs'][] = ['label' => 'Sales Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-salesorderhead-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
