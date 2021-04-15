<?php

use yii\helpers\Html;

$this->title = 'Cash / Bank - In / Out Information';
$this->params['breadcrumbs'][] = ['label' => 'Cash / Bank  - In / Out', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-cashinout-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>