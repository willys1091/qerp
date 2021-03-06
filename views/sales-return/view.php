<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TrSalesreturnhead */

$this->title = $model->salesReturnNum;
$this->params['breadcrumbs'][] = ['label' => 'Tr Salesreturnheads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-salesreturnhead-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->salesReturnNum], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->salesReturnNum], [
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
            'salesReturnNum',
            'salesReturnDate',
            'customerID',
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
