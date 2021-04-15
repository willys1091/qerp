<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrSalesquotationhead */

$this->title = 'Create Sales Quotation - New';
$this->params['breadcrumbs'][] = ['label' => 'Sales Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-salesquotationhead-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
