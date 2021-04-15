<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrDocumentcontrolhead */

$this->title = 'Create Document Control';
$this->params['breadcrumbs'][] = ['label' => 'Document Control', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-documentcontrolhead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
