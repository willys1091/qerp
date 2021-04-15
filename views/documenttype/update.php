<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsDocumenttype */

$this->title = 'Update Document Type : ' . $model->documentTypeName;
$this->params['breadcrumbs'][] = ['label' => 'Document Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-documenttype-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
