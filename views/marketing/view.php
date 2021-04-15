<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MsMarketing */

$this->title = $model->marketingID;
$this->params['breadcrumbs'][] = ['label' => 'Ms Marketings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-marketing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->marketingID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->marketingID], [
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
            'marketingID',
            'marketingName',
            'phone1',
            'phone2',
            'email:email',
            'notes',
            'flagActive:boolean',
            'createdBy',
            'createdDate',
            'editedBy',
            'editedDate',
        ],
    ]) ?>

</div>
