<?php


use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Sample Stock Cards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-stock-card-index">
    
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
       'showPageSummary' => true,
        'toolbar' => [
          
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['style' => 'text-align: center']
            ],
            [
                'label' => Yii::t('app', 'Product Name'),
                'width'=>'200px',
                'value' => function ($data) {
                    return $data->productName ." ".''."".$data->batchNumber."".'';
                },
            ],
            [
                'label' => Yii::t('app', 'Customer'),
                'hAlign' => 'center',
                'value' => function ($data) {
                    return $data->customerName;
                },           
            ],
            [
                'label' => Yii::t('app', 'Supplier'),
                'hAlign' => 'center',
                'value' => function ($data) {
                    return $data->supplierName;
                },           
            ],
            [
                'label' => Yii::t('app', 'Origin'),
                'hAlign' => 'center',
                'value' => function ($data) {
                    return $data->origin;
                },           
            ],
            
            [
                'label' => Yii::t('app', 'Unit'),
                'width'=>'50px',
                'value' => 'uomName'
            ],
            [
                'label' => Yii::t('app', 'Transaction Date'),
                'hAlign' => 'center',
                'value'=> 'transactionDate',                
            ],
            
            [
                'label' => Yii::t('app', 'Reference Number'),
                'hAlign' => 'center',
                'value' =>'refNum',
                'pageSummary' => true,
                'pageSummaryFunc' => function ($data) {
                    return Yii::t('app', 'Total');
                },
                
            ],
            [
                'label' => Yii::t('app', 'In Qty'),
                'pageSummary' => true,
                'pageSummaryFunc'=> GridView::F_SUM,
                'format' => ['decimal', 4],
                'value' => function ($data) {
                    return $data->inQty;
                },
                 'hAlign' => 'center',
            ],
            [
                'label' => Yii::t('app', 'Out Qty'),
                'hAlign' => 'center',
                'format' => ['decimal', 4],
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
                'format' => ['decimal', 4],
                'value' => function($model) use (&$balance){
                    $balance += ($model['inQty'] - $model['outQty']);
                      return $balance;
                    
                }
             
            ],
        ],
    ]); ?>
</div>
<?php
$stockCardUrl = Url::to(["sample-stock-card/index"]);

$js = <<<SCRIPT
$(document).ready(function() {
        
    $(document).on("click", "#downloadReport", function(){
        var form = $("#stock-card-form").serialize();
        window.location = '$stockCardUrl?downloadReport=true&' + form;
        return false;
    });
});
SCRIPT;
$this->registerJs($js);
?>