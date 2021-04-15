<?php

use app\components\AppHelper;
use app\models\MsProduct;
use app\models\MsProductdetail;
use app\models\MsPackingtype;
use app\models\MsUom;
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

$this->title = 'Purchase List';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="ms-user-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
		
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
			[
				'attribute' => 'purchaseOrderNum',
				'label' => 'Purchase Order Number',
			],
            [
                'attribute' => 'purchaseOrderDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig()
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
                            'data-return-value' => $model->purchaseOrderNum,
                            'data-return-text' => \yii\helpers\Json::encode([$model->purchaseOrderNum])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>


