<?php

use app\components\AppHelper;
use app\models\MsProduct;
use app\models\MsWarehouse;
use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Cards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-card-index">

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
    <?php 
    $balance = 0;
    ?>
    <?= GridView::widget([
       'dataProvider' => $detailModel->search($model),
       'pjax' => false,
       'panel' => [
            'heading' => $this->title,
            'headingOptions' => ['class'=>'panel-heading qwinjaya-header'],
        ],
        'toolbar' => [
        ],
       'showPageSummary' => true,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center']
            ],
            [
                'label' => Yii::t('app', 'Product Name'),
                'width'=>'200px',
                'value' => function ($data) {
                    return $data->productName ;
                },
            ],
           
            [
                'label' => Yii::t('app', 'Transaction Date'),
                'hAlign' => 'center',
                'value'=> 'transactionDate',                
            ],
                    
            [
                'label' => Yii::t('app', 'Reference Number'),
                'hAlign' => 'center',
                'value' => function ($data) {
                    return $data->refNum ;
                },
              
                
            ],
            
            [
                'label' => Yii::t('app', 'Faktur Number'),
                'hAlign' => 'center',
                'value' => function ($data) {
                    return $data->invoiceNum ;
                },
                'pageSummary' => true,
                'pageSummaryFunc' => function ($data) {
                    return Yii::t('app', 'Total');
                },
                
            ],
            [
                'label' => Yii::t('app', 'Batch Number'),
                'hAlign' => 'center',
                'value' => function ($data) {
                    return $data->batchNumber ;
                },               
            ],
            [
                'label' => Yii::t('app', 'In Qty'),
                'pageSummary' => true,
                'pageSummaryFunc'=> GridView::F_SUM,
                'format' => ['decimal', 2],
                'value' => function ($data) {
                    return $data->inQty;
                },
                 'hAlign' => 'center',
            ],
            [
                'label' => Yii::t('app', 'Out Qty'),
                'hAlign' => 'center',
                'format' => ['decimal', 2],
                'pageSummary' => true,
                'pageSummaryFunc'=> GridView::F_SUM,
                'value' => function ($data) {
                    return $data->outQty;
                },
               
            ],
            [
                'attribute' => 'balanceQty',
                'label' => Yii::t('app', 'Balance Qty'),
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function($model) use (&$balance){
                    $balance += ($model['inQty'] - $model['outQty']);
                    return $balance;
                    
                }
             
            ],
        ],
    ]); ?>
</div>
<?php
$stockCardUrl = Url::to(["stock-card/index"]);

$js = <<<SCRIPT
$(document).ready(function() {
        
    $(document).on("click", "#downloadReport", function(){
         $("#stock-card-form").attr('target', '_blank');
        var form = $("#stock-card-form").serialize();
        window.location = '$stockCardUrl?downloadReport=true&' + form;
        return false;
    });
    
    $(document).on("click", "#downloadReportPdf", function(){
     $("#stock-card-form").attr('target', '_blank');
        var form = $("#stock-card-form").serialize();
        window.open('$stockCardUrl?downloadReportPdf=true&' + form, '_blank');
        return false;
    });
});
SCRIPT;
$this->registerJs($js);
?>