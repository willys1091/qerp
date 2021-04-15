<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrSalesquotationhead */

$this->title = 'Update Sales Quotation: ' . $model->salesQuotationNum;
$this->params['breadcrumbs'][] = ['label' => 'Sales Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->salesQuotationNum, 'url' => ['view', 'id' => $model->salesQuotationNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-salesquotationhead-update">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
