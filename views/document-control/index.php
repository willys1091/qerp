<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\LkDocumenttype;
use app\models\TrJournalhead;
use app\models\TrJournaldetail;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Control';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-documentcontrolhead-index">

    <?= GridView::widget([
        'dataProvider' => $model->searchpembelian(),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'summary' => '',
        'toolbar' => [
            [
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                //'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                  
                    return Yii::$app->controller->renderPartial('_detail-expanded', ['model' => $model]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            [
                'attribute' => 'documentTypeName',
                'width'=>'250px',
                'value' => 'documentTypeName',
                // 'value' => function ($data) {
                //     return $data[''];
                // },
                'filter' => ArrayHelper::map(LkDocumenttype::find()->all(), 'lkDocumentTypeName', 'lkDocumentTypeName'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ]
            ],
            'refNumber',   
            [
                'attribute' => 'refDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig(),
                'width' => '110px'
            ],   
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return $data['status'] < 0? "Incomplete" : "Complete";
                },
            ],  
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'update' => function ($url, $model) {
                        $id = $model['refNumber'];
                    return Html::a("<span class='glyphicon glyphicon-file action-icon'></span>&nbsp;&nbsp;",
                        ['document-control/update', 'id' => $id],
                        [
                            'title' => 'Add/Edit Document',
                            'data-target-width' => '1000',
                            'data-target-height' => '600',
                            'class' => 'WindowDialogBrowse',
                        ]);
                    }
                ]
            ]
        ],
    ]); ?>
</div>
