<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounting Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>