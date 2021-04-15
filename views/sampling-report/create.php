<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrSamplereceipthead */

$this->title = 'Create Supplier Sample Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Sample Receipt', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-samplereceipthead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
