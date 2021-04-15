<?php
use yii\helpers\Html;
?>
<p>You have entered the following information:</p>

<ul>
    <li><label>Type Report</label>: <?= Html::encode($model->typeReport) ?></li>
    <li><label>Date Start</label>: <?= Html::encode($model->dateStart) ?></li>
    <li><label>Date End</label>: <?= Html::encode($model->dateEnd) ?></li>
    <li><label>Customer</label>: <?= Html::encode($model->customerID) ?></li>    
</ul>
