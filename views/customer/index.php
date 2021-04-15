<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Customer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-customer-index">
    <?= GridView::widget([
        'dataProvider' => $model->search(),
        'filterModel' => $model,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'summary' => '',
        'toolbar' => [
            '{export}',
            '{toggleData}',
            [
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [
                        'class' => 'btn toolbar-icon',
                        'title' => Yii::t('app', 'Create')
                    ]).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
                'exportConfig' => [
                    GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'Master Customer-'.date('d-M-Y')],
                    GridView::HTML => ['label' => 'Export as HTML', 'filename' => 'Master Customer -'.date('d-M-Y')],
                    GridView::PDF => ['label' => 'Export as PDF',
                                      'filename' => 'Master Customer-'.date('d-M-Y'),
                                      'config' => [
                                            'methods' => [
                                                'SetHeader' => ['Master Customer'],
                                                'SetFooter' => ['PT.Qwinjaya Aditama ' . '||Page {PAGENO}'],
                                            ]
                                        ],
                                     ],
                    GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'Master Customer-'.date('d-M-Y')],
                    GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'Master Customer-'.date('d-M-Y')],
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center']
            ],
            [
                'attribute' => 'customerName',
                
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [   
                'label' => 'Address',
                'attribute' => 'npwpAddress',
                'width' => '230px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            
            [
                'attribute' => 'email',
                'width' => '150px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'npwp',
                'width' => '150px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'creditLimit',
                'width' => '100px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'dueDate',
                'width' => '100px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            AppHelper::getIsActiveColumn(),
            AppHelper::getMasterActionColumn()
        ],
    ]); ?>
</div>
