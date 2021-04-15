<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrPurchasereturnhead */

$this->title = 'Create Purchase Return';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Return', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-purchasereturnhead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
