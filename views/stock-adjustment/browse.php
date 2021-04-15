<?php

use app\components\AppHelper;
use app\models\MsWarehouse;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\db\Expression;

/* @var $this yii\web\View
 * @var $model \app\models\ProductDetail
 */

$this->title = 'Stock Adjustment List';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ms-user-index">
    <?= GridView::widget([
        'dataProvider' => $model->search(),
        'filterModel' => $model,
		'filterUrl' => Url::to(['product/browse']),
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
            [
               
            ],
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
			'stockOpnameNum',
            [
                'attribute' => 'stockOpnameDate',
                'width'=>'110px',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig()
            ],
            [
                'attribute' => 'warehouseID',
                'width'=>'250px',
                'value' => 'parentWarehouse.warehouseName',
                'filter' => ArrayHelper::map(MsWarehouse::find()->all(), 'warehouseID', 'warehouseName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ]
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
                            'data-return-value' => $model->stockOpnameNum,
                            'data-return-text' => \yii\helpers\Json::encode([$model->warehouseID])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>
