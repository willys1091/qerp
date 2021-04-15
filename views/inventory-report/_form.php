<?php

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsCustomer;
use app\models\MsProduct;
use app\models\MsSupplier;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$connection = MdlDb::getDbConnection();
$sql = 'SELECT year(`goodsReceiptDate`)AS periode FROM `tr_goodsreceipthead`';
$command = $connection->createCommand($sql);
$result = $command->queryAll();
?>

<div class="tr-samplereceipthead-form">

    <?php $form = ActiveForm::begin([
            'id' => 'form-filter-report',

        ]); 
    ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12"> 
                            <?=
                                $form->field($model, 'typeReport')->widget(Select2::classname(),[
                                    'data' => ['Kartu Persediaan Barang' => 'Kartu Persediaan Barang',
                                        'Laporan OOT' => 'Laporan OOT',
                                        'Kartu Import' => 'Kartu Import',
                                        'Import Realization Report (BPOM)' => 'Import Realization Report (BPOM)',
                                        'Import Realization Report (MENPERINDAG)' => 'Import Realization Report (MENPERINDAG)',
                                        ],
                                    'options' => [
                                        'prompt' => 'Select Type Report',
                                        'class' => 'refNumInput-1'],
                                ]);
                            ?>                           
                        </div>
                    </div>
                    <div class="row">
                        <div id="periode" class="col-md-12">  
                         
                            <?= $form->field($model, 'periode')->dropDownList(ArrayHelper::map($result,'periode','periode'));
                            ?>  
                           
                        </div>
                    </div>
                    <div class="row">
                        <div id="poNum" class="col-md-12"> 
                            <?= Html::activeHiddenInput($model, 'purchaseNumID', ['class' => 'purchaseNumID']) ?>
                            <?= $form->field($model, 'purchaseNum', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['purchase/browsebyyear'], [
                                            'title' => 'browse Purchase',
                                            'data-filter-input' => '#inventoryreport-periode',
                                            'data-target-value' => '.purchaseNumID',
                                            'data-target-text' => '.purchaseNumIDInput',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse supplierBrowse'
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'purchaseNumIDInput']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div id="goodsReceiptNum" class="col-md-12"> 
                            
                            <?= $form->field($model, 'goodsReceiptNum', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['goods-receipt-history/browsebypurchase'], [
                                            'title' => 'browse goods receipt',
                                            'data-filter-input' => '.purchaseNumID',
                                            'data-target-value' => '.goodsReceiptNum',
                                            'data-target-text' => '.goodsReceiptNumInput',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse supplierBrowse'
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'goodsReceiptNumInput']) ?>
                        </div>
                    </div>
                  
                    <div id="date" class="row">
                        <div class="col-md-5">                            
                            <?= $form->field($model, 'dateS')->widget(DatePicker::className(), AppHelper::getDatePickerConfig()) ?>
                        </div>
                        <div class="col-md-5">                            
                            <?= $form->field($model, 'dateE')->widget(DatePicker::className(), AppHelper::getDatePickerConfig()) ?>
                        </div>
                    </div>
                    <div id="monthPeriod" class="row">
                        <div class="col-md-2">
                            <?= $form->field($model, 'monthYear')->widget(DatePicker::className(), AppHelper::getMonthYearsPickerConfig([
                                'value' => date('m-Y')
                            ]))->label('From Date') ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($model, 'month')->widget(DatePicker::className(), AppHelper::getMonthYearsPickerConfig([
                                //'name' => 'month', 
                                'value' => date('m-Y'),
                            ]))->label('To Date') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div id="productIDStock" class="col-md-12">  
                           
                            <?= $form->field($model, 'productIDStock')
                                ->dropDownList(ArrayHelper::map(MsProduct::find()->distinct()->orderBy(['productName'=>SORT_ASC])->all(), 'productID', 'productName' ),
                            ['prompt' => 'Please Select a Product'])
                            ?>
                        </div>  
                        <div id="product" class="col-md-12">  
                            <?= $form->field($model, 'productName', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['goods-receipt-history/browsebyproduct'], [
                                            'title' => 'browse goods receipt',
                                            'data-filter-input' => '.goodsReceiptNumInput',
                                            'data-target-text' => '.productIDInput',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse supplierBrowse'
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'productIDInput']) ?>
							<?=$form->field($model, 'productID')->hiddenInput(['autocomplete' => 'off',  'class' => 'form-control productIDInput-1',])->label(false)?>
                            <?=$form->field($model, 'batchNumber')->hiddenInput(['autocomplete' => 'off',  'class' => 'form-control productIDInput-2',])->label(false)?>
                        </div>
                    </div>
                    <div class="row">
                        <div id="productOOT" class="col-md-12">  
                            <?= $form->field($model, 'productOOT')
                                ->widget(Select2::className(), [
                                    'data' => ArrayHelper::map(MsProduct::find()->distinct()->where(['flagOOT' => true])->orderBy(['productName'=>SORT_ASC])->all(), 'productID', 'productName' ),
                                    'options' => [
                                        'prompt' => 'Please Select a Product',
                                    ]
                                ]);
                            ?>
                        </div>
                    </div>
                    <div id="monthPicker" class="row">
                        <div class="col-md-2">
                            <?= $form->field($model, 'monthPicker')->widget(DatePicker::className(), AppHelper::getMonthYearPickerConfig([
                                'value' => date('m-Y')
                            ])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group text-right">                
                    <?= Html::submitButton('<i class="glyphicon glyphicon-print"> Print </i>', ['name' => 'btnPrint_PDF', 'class' => 'btn btn-primary btnPrint']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$checkPOAjaxURL = Yii::$app->request->baseUrl. '/inventory-report/check';

$js = <<< SCRIPT
//$("#inventoryreport-periode").on("change", function() {
//	var value = $(this).val();
//	$.ajax({
//		url: "$checkPOAjaxURL",
//		data: {value: value},
//		type: "POST",
//		success: function(data) {
//                    $("#inventoryreport-goodsreceiptnum").html(data);
//		}
//	});
//});
    
//$("#goodsreceiptnum").on("change", function() {
//
//	console.log('kwwkwkw');
//});
SCRIPT;
$this->registerJs($js);
?>