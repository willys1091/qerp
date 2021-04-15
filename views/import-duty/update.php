<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'Import Duty: ' . $model->goodsReceiptNum;
$this->params['breadcrumbs'][] = ['label' => 'Import Duty', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goodsReceiptNum, 'url' => ['view', 'id' => $model->goodsReceiptNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-goodsreceipthead-update">
    <?= $this->render('_form', [
        'model' => $model,
        'isUpdate' =>'1'
    ]) ?>

</div>
