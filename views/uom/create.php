<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsUom */

$this->title = 'UOM Information';
$this->params['breadcrumbs'][] = ['label' => 'UOM', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-uom-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
