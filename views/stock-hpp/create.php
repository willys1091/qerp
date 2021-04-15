<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StockHpp */

$this->title = 'Create Stock Hpp';
$this->params['breadcrumbs'][] = ['label' => 'Stock Hpps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-hpp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
