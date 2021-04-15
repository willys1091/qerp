<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrPettyCash */

$this->title = 'Create Tr Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Tr Petty Cashes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-petty-cash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
