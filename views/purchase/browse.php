<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\MsProduct;
use app\models\MsMarketing;
use yii\widgets\Pjax;
/* @var $this yii\web\View
 * @var $model \app\models\TrSalesOrderHead
 */

$this->title = 'Purchase Order List';
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
            'purchaseOrderNum',
            [
                'attribute' => 'purchaseOrderDate',
                'format' => ['date', 'php:d-m-Y'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => AppHelper::getDatePickerConfig()
            ],
            [
                'attribute' => 'supplierID',
                'value' => 'parentSupplier.supplierName',
            ],
			[
                'attribute' => 'grandTotal',
                'value' => function ($model) {
                    return $model->currencyID." ".number_format($model->grandTotal,2,",",".");
                },
                'contentOptions' => [
                    'class' => 'text-right'
                ],
                'headerOptions' => [
                	'class' => 'text-right'
                ],
                'filterInputOptions' => [
                    'class' => 'text-right form-control'
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
                            'data-return-value' => $model->purchaseOrderNum,
                            'data-return-text' => \yii\helpers\Json::encode([$model->purchaseOrderNum,$model->supplierID,$model->supplier->supplierName,number_format($model->rate, 2, ',', '.'),$model->grandTotal,$model->currencyID])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>

<?php
$insertAjaxURL = Yii::$app->request->baseUrl. '/sales-quotation/input';
$js = <<< SCRIPT
$('my-selector').dialog('option', 'position', 'center');

$(document).ready(function(){
    $(".btnAdd").click(function(){
        $("#myModal").modal();
    });
    $('#msproduct-barcodenumbers').val('Auto');
    $('#msproduct-standardfee').val('0,00');
    
    
    function insertQuotation(supplierName, dueDate, contactPerson, npwp){
             
        var result = 'FAILED';
        $.ajax({
            url: '$insertAjaxURL',
            async: false,
            type: 'POST',
            data: { supplierName: supplierName, 
                    dueDate: dueDate, 
                    contactPerson: contactPerson, 
                    npwp: npwp},

            success: function(data) {
                    result = data;
            }
        });
        return result;
    }
     
});
    
$(document).bind('keydown keyup', function(e) {
    if(e.which === 116) {
       console.log('blocked');
       return false;
    }
    if(e.which === 82 && e.ctrlKey) {
       console.log('blocked');
       return false;
    }
});


SCRIPT;
$this->registerJs($js);
?>
