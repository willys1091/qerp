<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsSubcategory */

$this->title = 'Update Sub Category: ' . $model->subcategoryID;
$this->params['breadcrumbs'][] = ['label' => 'Product Sub Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subcategoryID, 'url' => ['view', 'id' => $model->subcategoryID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-subcategory-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
