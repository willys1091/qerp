<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrPurchaseordernoninventoryhead */

$this->title = 'Update Purchase Order Non Inventory';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order Non Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-purchaseorderhead-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
