<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrSupplierpaymenthead */

$this->title = 'Create Forwarder Payment';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-supplierpaymenthead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
