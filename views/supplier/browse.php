<?php

use app\components\AppHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View 
/* @var $this yii\web\View
 * @var $model \app\models\MsSupplier
 */

$this->title = 'Supplier List';
?>
<div class="ms-user-index">
    <?= GridView::widget([
        'dataProvider' => $model->searchNonForwarder(),
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
            'supplierName',
            //'dueDate',
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
                            'data-return-value' => $model->supplierID,
                            'data-return-text' => \yii\helpers\Json::encode([$model->supplierName])
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
</div>

<?php
$insertAjaxURL = Yii::$app->request->baseUrl. '/supplier/input';
//$picSuppDetail = \yii\helpers\Json::encode($model->joinMsPicSupplier);
$js = <<< SCRIPT
$('my-selector').dialog('option', 'position', 'center');

$(document).ready(function(){
    $(".btnAdd").click(function(){
        $("#myModal").modal();
    });
	$('#msproduct-barcodenumbers').val('Auto');
	$('#msproduct-standardfee').val('0,00');
	
	
	function insertSupplier(supplierName, dueDate, contactPerson, npwp){
             
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
