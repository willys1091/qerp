<?php

use app\components\AppHelper;
use app\models\TrGoodsdeliverydetail;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods Receipt History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-goodsreceipthead-index">

    <?= GridView::widget([
        'dataProvider' => $model->search(Yii::$app->request->get()),
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
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center']
            ],
            [
                'attribute' => 'goodsReceiptDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => AppHelper::getDatePickersRangeConfig(),
                'hAlign' => 'center',
                'filterInputOptions' => [
                    'class' => 'text-center form-control'
                ],
                'width' => '18%'
            ],
            [
                'attribute' => 'goodsReceiptNum',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'transType',
                'value' => 'transType',
                'filter' => [
                    'Purchase Order' => 'Purchase Order', 
                    'Sales Return' => 'Sales Return',
                    'Stock Transfer' => 'Stock Transfer'
                ],                
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ], 
            [
                'attribute' => 'sources',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'attribute' => 'status',
                'value' => function($model) { return $model['status'] == '0'? 'Not Approved' : 'Approved';},
                'filter' => [
                    '-' => 'All',
                    '0' => 'Not Approved', 
                    '1' => 'Approved'
                ],                
                'filterType' => GridView::FILTER_SELECT2,
                'filterInputOptions' => [
                    'prompt' => 'All'
                ],
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}'.' '.'{print}'.' '.'{update}'.' '.'{update_head}'.' '.'{delete}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'width' => '150px',
                'header' => '',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-eye-open action-icon'></span>&nbsp;&nbsp;",
                            ['view', 'id' => $model['goodsReceiptNum']],
                            [
                                            'title' => 'View',
                                            'class' => 'open-modal-btn'
                            ]);
                     },
                    'print' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-print action-icon'></span>&nbsp;&nbsp;",
                        ['print', 'id' => $model['goodsReceiptNum']],
                        [
                            'title' => 'Print',
                            'class' => 'btnPrint'
                        ]);
                     },
                    'update' => function ($url, $model) {
                    return $model['status'] == '0'? Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model['goodsReceiptNum']],
                        [
                            'title' => 'Edit ',
                            'class' => 'open-modal-btn'
                        ]) : '';
                    },
//                    'update_reportImport' => function ($url, $model) {
//                    return  $model['import'] != null ? Html::a("<span class='glyphicon glyphicon-edit action-icon'></span>&nbsp;&nbsp;",
//                        ['updatereportimport', 'id' => $model['goodsReceiptNum']],
//                        [
//                            'title' => 'Edit Report Import',
//                            'class' => 'open-modal-btn'
//                        ]) :'' ;
//                    },
                     'update_head' => function ($url, $model) {
                      return $model['status'] != '0' ? Html::a("<span class='glyphicon glyphicon-edit action-icon'></span>&nbsp;&nbsp;",
                        ['updatehead', 'id' => $model['goodsReceiptNum']],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]) :'' ;
                    },
                    'delete' => function ($url, $model) {
                        /*$url = ['delete-approve', 'id' => $model['goodsReceiptNum']];
                                $icon = 'trash';
                                $label = 'Delete New';
                                $confirm = 'Are you sure you want to delete this data ?';
                                return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                                'title' => $label,
                                'aria-label' => $label,
                                'data-confirm' => $confirm,
                                'data-method' => 'post',
                                'data-pajax' => '0'
						]);*/ 
                       if(TrGoodsdeliverydetail::find()->where(['batchNumber'=> $model['batchNumber']])->one() == NULL and $model['status'] != '0' ) {
                                $url = ['delete-approve', 'id' => $model['goodsReceiptNum']];
                                $icon = 'trash';
                                $label = 'Delete New';
                                $confirm = 'Are you sure you want to delete this data ?';
                                return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                                'title' => $label,
                                'aria-label' => $label,
                                'data-confirm' => $confirm,
                                'data-method' => 'post',
                                'data-pajax' => '0'
                            ]); 
                                
                        } elseif( $model['status'] == '0' ) {
                                $url = ['delete', 'id' => $model['goodsReceiptNum']];
                                $icon = 'trash';
                                $label = 'Delete';
                                $confirm = 'Are you sure you want to delete this data ?';
                                return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                                'title' => $label,
                                'aria-label' => $label,
                                'data-confirm' => $confirm,
                                'data-method' => 'post',
                                'data-pajax' => '0'
                            ]); 
                        } 
                    }
                ]
            ]
        ],
    ]); ?>
</div>

<?php
$js = <<< SCRIPT
$(document).ready(function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_view_goods_receipt_history','height=600,width=1024');
    console.log(newWindow);
        if (window.focus) {
            newWindow.focus();
        }
    });
   
});

$(document).on('pjax:end',function(){
    $('.btnPrint').click(function(e){
        e.preventDefault();
        var newWindow = window.open($(this).attr('href'),'report_view_goods_receipt_history','height=600,width=1024');
        if (window.focus) {
            newWindow.focus();
        }
     });
});
SCRIPT;
$this->registerJs($js);

?>


