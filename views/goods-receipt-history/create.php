<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'Create Tr Goodsreceipthead';
$this->params['breadcrumbs'][] = ['label' => 'Tr Goodsreceiptheads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsreceipthead-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
