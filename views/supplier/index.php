<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Supplier';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-supplier-index">

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
                    GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'Master Supplier-'.date('d-M-Y')],
                    GridView::HTML => ['label' => 'Export as HTML', 'filename' => 'Master Supplier -'.date('d-M-Y')],
                    GridView::PDF => ['label' => 'Export as PDF',
                                      'filename' => 'Master Supplier-'.date('d-M-Y'),
                                      'config' => [
                                            'methods' => [
                                                'SetHeader' => ['Master Supplier'],
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
                'width' => '320px',
                'attribute' => 'supplierID',
                'value' => function ($data) {
                    return "SUP{$data->supplierID}";
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],

            [   
                'width' => '320px',
                'attribute' => 'supplierName',
                'headerOptions' => ['style' => 'text-align: left']
            ],
               
            [
                'label' => 'Address',
                'attribute' => 'street',
                'width' => '350px',
                'value' => function ($data) {
                    return "{$data->street} {$data->city} {$data->province} {$data->country}";
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],
               
            [
                'width' => '200px',
                'attribute' => 'officeNumber',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'email',
                'width' => '200px',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'label' => 'Contact',
                'attribute' => 'supplierID',
                'width' => '300px',
                'value' => function ($data) {
                    return implode(', ', array_map(function($x){
                        $position = $x->position;
                        
                        if($position){
                           $position = '('.$x->position.')';
                        }
                        
                        return "$x->contactPerson {$position} ";
                    }, $data->supplierContact));
                },
                'headerOptions' => ['style' => 'text-align: left']
            ],     
            AppHelper::getIsActiveColumn(),
            AppHelper::getMasterActionColumn()
        ],
    ]); ?>
</div>
