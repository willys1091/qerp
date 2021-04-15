<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrPurchaseorderhead */

$this->title = 'Create Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-purchaseorderhead-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
