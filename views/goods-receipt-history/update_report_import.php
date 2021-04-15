<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'Update Import Realization Report: ' . $model->goodsReceiptNum;
$this->params['breadcrumbs'][] = ['label' => 'Goods Receipt History', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goodsReceiptNum, 'url' => ['view', 'id' => $model->goodsReceiptNum]];
$this->params['breadcrumbs'][] = 'Update Import Realization Report';
?>
<div class="tr-goodsreceiptcost-update">

    <?= $this->render('_form_report_import', [
        'model' => $model,
    ]) ?>

</div>
