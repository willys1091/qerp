<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use kartik\widgets\FileInput;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Petty Cash';
$this->params['breadcrumbs'][] = $this->title;
$balance = 0;
?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= Yii::t('app', 'Upload Petty Cash') ?></h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                        $form = ActiveForm::begin([
                                    'enableAjaxValidation' => true,
                                    'options' => [
                                        'enctype' => 'multipart/form-data'
                                    ],
                        ]);
                        ?>
                        <div class="col-md-12">
                            <?=
                            $form->field($model, 'fileUpload')->widget(FileInput::classname(), [
                                'options' => [
                                    'accept' => 'file/*',
                                    'class' => 'file-upload',
                                    'disabled' => isset($isView),
                                ],
                                'pluginOptions' => [
                                    'showPreview' => false,
                                    'showCaption' => true,
                                    'showRemove' => true,
                                    'showUpload' => false,
                                ],
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <div class="pull-right">
                            <a href="#" onclick='window.open("<?= Url::to(['download/template-petty']) ?>");' class="btn btn-warning">
                                <i class="glyphicon glyphicon-save with-text"></i><?= Yii::t('app', 'Download Template') ?>
                            </a>
                            <?= Html::submitButton('<i class="glyphicon glyphicon-upload with-text"></i>' . Yii::t('app', 'Upload'), ['class' => 'btn btn-primary btnSave']) ?>
                        </div>
                        <div class="clearfix"></div>    
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="modal-footer" style="text-align: left;">

            </div>
        </div>
    </div>
</div>

<div class="ms-product-index">
    <div class="box box-default" style="border-top-color: #508d52;">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Search') ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                     <?php echo $this->render('_search', ['model' => $model]); ?>
                </div>
            </div>
        </div>
    </div>
    <?= GridView::widget([
    'dataProvider' =>$detailModel->search($model),
        'pjax' => false,
        'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'showPageSummary' => true,
        'toolbar' => [
            
            [
                'content' =>
                    AppHelper::getToolbarButtonPopUps('create', '#', Yii::t('app', 'Upload'), 'btn-primary', 'upload', 'btnUpload') .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app', 'Reset')
                    ])
            ],
        ],
   
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label' => Yii::t('app', 'Date'),
                'value'=> 'pettyCashDate',         
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => AppHelper::getDatePickersRangeConfig(),
                'hAlign' => 'center',
                'filterInputOptions' => [
                    'class' => 'text-center form-control'
                ],
                'width' => '10%'
            ],
            [
                'label' => Yii::t('app', 'Voucher'),
                'value'=> 'voucher',   
                'width'=>'10%',
                'headerOptions' => ['style' => 'text-align: left']
            ],
            [
                'label' => Yii::t('app', 'Notes'),
                'value'=> 'notes',   
                'width'=>'40%',
                'width'=>'40%',
                'headerOptions' => ['style' => 'text-align: left'],
                'pageSummary' => true,
                'pageSummaryFunc' => function ($data) {
                    return Yii::t('app', 'Total');
                },
            ],
            [
                'label' => Yii::t('app', 'Debit'),
                'pageSummary' => true,
                'pageSummaryFunc'=> GridView::F_SUM,
                'format' => ['decimal', 0],
                'value' => function ($data) {
                    return  $data->drAmount;
                },
                 'hAlign' => 'right',
            ],
            [
                'label' => Yii::t('app', 'Credit'),
                'hAlign' => 'right',
                'width'=>'10%',
                'format' => ['decimal', 0],
                'pageSummary' => true,
                'pageSummaryFunc'=> GridView::F_SUM,
                'value' => function ($data) {
                    return $data->crAmount;
                },
               
            ],
            [
                'label' => Yii::t('app', 'Balance'),
                'hAlign' => 'right',
                'format' => ['decimal', 0],
                'value' => function($model) use (&$balance){
                    $balance += ($model['drAmount'] - $model['crAmount']);
                    return $balance;
                    
                }
             
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}'.'{delete}',
                'hAlign' => 'center',
                'vAlign' => 'middle',
				'width' => '50px',
                'header' => '',
                'buttons' => [
                    'update' => function ($url, $model) {
                    return $model->voucher ? Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model['pettyCashNum']],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]) : '' ;
                    },
                    'delete' => function ($url, $model) {
                            $url = ['delete', 'id' => $model['pettyCashNum']];
                            $icon = 'trash';
                            $label = 'Delete';
                            $confirm = 'Are you sure you want to delete this data ?';
                        return $model->voucher ? Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                            'title' => $label,
                            'aria-label' => $label,
                            'data-confirm' => $confirm,
                            'data-method' => 'post',
                            'data-pajax' => '0'
                        ]) :'' ;
                    }
                ]
            ]
        ],
]); ?>
</div>
<?php
$stockCardUrl = Url::to(["petty-cash/index"]);
$js = <<< SCRIPT
    $(document).ready(function () {
        $("#btnUpload").click(function(){
            $("#myModal").modal();
        });
    
        $(document).on("click", "#downloadReport", function(){
            var form = $("#pettycash-form").serialize();
            window.location = '$stockCardUrl?downloadReport=true&' + form;
            return false;
        });
    });
	
    $(document).on('pjax:end', function () {
        $("#btnUpload").click(function(){
            $("#myModal").modal();
        });
    });
SCRIPT;
$this->registerJs($js);
?>
