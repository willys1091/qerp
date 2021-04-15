<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MsReportdestination */

$this->title = 'Update Report Destination: ' . $model->reportDestinationID;
$this->params['breadcrumbs'][] = ['label' => 'Report Destination', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reportDestinationID, 'url' => ['view', 'id' => $model->reportDestinationID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ms-reportdestination-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
