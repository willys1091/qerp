<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View
 * @var $model \app\models\TrSalesOrderHead
 */

$this->title = 'Goods Delivery List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-order-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
          
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'goodsDeliveryNum',
            [
                'attribute' => 'goodsDeliveryDate',
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
                            'data-return-value' => $model->goodsDeliveryNum,
                            'data-return-text' => \yii\helpers\Json::encode([
                                                    $model->goodsDeliveryNum
                                                    ])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>
