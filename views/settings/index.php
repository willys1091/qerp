<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-setting-index">

    <?= $this->render('_form', [
        'models' => $models,
    ]) ?>
</div>
