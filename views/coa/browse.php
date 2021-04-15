<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\MsCurrency;
use app\models\MsCoa;
use yii\widgets\Pjax;
/* @var $this yii\web\View
 * @var $model \app\models\TrSalesOrderHead
 */

$this->title = 'COA List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-order-index">
    <?= GridView::widget([
        'dataProvider' => $model->searchLevelFour(),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
          
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'coaNo',
            'description',
            [
                'attribute' => 'currencyID',
                'value' => 'currency.currencyName',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{select}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'select' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-ok'></span>", "#", [
                            'class' => 'WindowDialogSelect',
                            'data-return-value' => $model->coaNo,
                            'data-return-text' => \yii\helpers\Json::encode([$model->coaNo,$model->description,$model->currencyID])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>

