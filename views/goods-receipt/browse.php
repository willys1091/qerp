<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View
 * @var $model \app\models\TrSalesOrderHead
 */

$this->title = 'Goods Receipt List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-order-index">
    <?= GridView::widget([
        'dataProvider' => $model->searchBrowse(),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
          
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'goodsReceiptNum',
            [
                'attribute' => 'goodsReceiptDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig()
            ],
            'refNum',
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
                            'data-return-value' => $model->goodsReceiptNum,
                            'data-return-text' => \yii\helpers\Json::encode([
                                                    $model->goodsReceiptNum
                                                    ])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>

<?php
$js = <<< SCRIPT
$('my-selector').dialog('option', 'position', 'center');

$(document).ready(function(){
    $(".btnAdd").click(function(){
        $("#myModal").modal();
    });


SCRIPT;
$this->registerJs($js);
?>
