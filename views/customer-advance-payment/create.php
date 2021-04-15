<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrCustomeradvancepayment */

$this->title = 'Create Customer Advance Payment';
$this->params['breadcrumbs'][] = ['label' => 'Customer Advance Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-customeradvancepayment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
