<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrTaxinhead */

$this->title = 'Create Tax Payable';
$this->params['breadcrumbs'][] = ['label' => 'Tax Payable', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-taxinhead-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
