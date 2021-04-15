<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrTaxinhead */

$this->title = 'Update Tax Payable: ' . $model->taxInNum;
$this->params['breadcrumbs'][] = ['label' => 'Tax Payable', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->taxInNum, 'url' => ['view', 'id' => $model->taxInNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-taxinhead-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
