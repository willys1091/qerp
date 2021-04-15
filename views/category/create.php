<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsProductcategory */

$this->title = 'Category Information';
$this->params['breadcrumbs'][] = ['label' => 'Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-productcategory-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>