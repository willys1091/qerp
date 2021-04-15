<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrInternalusagehead */

$this->title = 'Create Internal Usage';
$this->params['breadcrumbs'][] = ['label' => 'Internal Usage', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-internalusagehead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
