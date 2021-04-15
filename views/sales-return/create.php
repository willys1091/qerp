<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrSalesreturnhead */

$this->title = 'Create Sales Return';
$this->params['breadcrumbs'][] = ['label' => 'Sales Return', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-salesreturnhead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
