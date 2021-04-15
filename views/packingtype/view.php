<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MsPackingtype */

$this->title = $model->packingTypeID;
$this->params['breadcrumbs'][] = ['label' => 'Ms Packingtypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-packingtype-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->packingTypeID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->packingTypeID], [
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
            'packingTypeID',
            'packingTypeName',
            'notes',
            'flagActive:boolean',
            'createdBy',
            'createdDate',
            'editedBy',
            'editedDate',
        ],
    ]) ?>

</div>
