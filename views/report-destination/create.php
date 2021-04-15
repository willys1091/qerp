<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsReportdestination */

$this->title = 'Report Destination Information';
$this->params['breadcrumbs'][] = ['label' => 'Report Destination', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-reportdestination-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
