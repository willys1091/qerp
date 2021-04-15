<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TrPurchasereturnhead */

$this->title = $model->purchaseReturnNum;
$this->params['breadcrumbs'][] = ['label' => 'Tr Purchasereturnheads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-purchasereturnhead-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->purchaseReturnNum], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->purchaseReturnNum], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'purchaseReturnNum',
            'purchaseReturnDate',
            'supplierID',
            'currencyID',
            'rate',
            'coaNo',
            'grandTotal',
            'additionalInfo',
            'createdBy',
            'createdDate',
            'editedBy',
            'editedDate',
        ],
    ]) ?>

</div>
