<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrCustomerpayment */

$this->title = 'Create Customer Payment';
$this->params['breadcrumbs'][] = ['label' => 'Customer Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-customerpayment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
