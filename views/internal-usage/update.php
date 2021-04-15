<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrInternalusagehead */

$this->title = 'Update Internal Usage: ' . $model->internalUsageNum;
$this->params['breadcrumbs'][] = ['label' => 'Internal Usage', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->internalUsageNum, 'url' => ['view', 'id' => $model->internalUsageNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-internalusagehead-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
