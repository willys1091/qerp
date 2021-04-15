<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsProductcategory */

$this->title = 'Update Category : ' . $model->ProductCategoryName;
$this->params['breadcrumbs'][] = ['label' => 'Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-productcategory-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
