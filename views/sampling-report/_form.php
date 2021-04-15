<?php

use yii\helpers\Html;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\MsCustomer;
use app\models\MsProduct;
use app\models\MsSupplier;
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
                                    'data' => ['Sample Stock Position' => 'Sample Stock', 'List of Sample For Customer' => 'List of Sample For Customer',
                                        'Sample Receipt' => 'Sample Receipt',
                                        'Sample Delivery' => 'Despatch Of Sample Report'],
                                    'options' => [
                                        'prompt' => 'Select Type Report',
                                        'class' => 'refNumInput-1'],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">                            
                            <?= $form->field($model, 'dateStart')->widget(DatePicker::className(), AppHelper::getDatePickerConfig()) ?>
                        </div>
                        <div class="col-md-1">
                            <div style="margin-top: 27px; margin-left: 27px;">
                                <label>_</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <?= $form->field($model, 'dateEnd')->widget(DatePicker::className(), AppHelper::getDatePickerConfig()) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div id="product" class="col-md-12">
                            <?= $form->field($model, 'productID')
                                ->dropDownList(ArrayHelper::map(MsProduct::find()->distinct()->orderBy(['productName'=>SORT_ASC])->all(), 'productID', 'productName' ),
                                    ['prompt' => 'Select All', 'disabled'])
                            ?>      

                        </div>
                    </div>
                    <div class="row">
                        <div id="customer" class="col-md-12">
                            <?= $form->field($model, 'customerID')
                                ->dropDownList(ArrayHelper::map(MsCustomer::find ()->distinct()->orderBy(['customerName'=>SORT_ASC])->all(), 'customerID', 'customerName' ),
                                    ['prompt' => 'Select All', 'disabled'])
                            ?> 
                        </div>
                    </div>
                    <div class="row">
                        <div id="supplier" class="col-md-12">
                            <?=
                                $form->field($model, 'supplierID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsSupplier::find ()->distinct()->orderBy(['supplierName'=>SORT_ASC])->all(), 'supplierID', 'supplierName' ),
                                    'options' => [
                                        'prompt' => 'Select Supplier',
                                        'class' => 'refNumInput-1'],
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group text-right">                
                    <?= Html::submitButton('<i class="glyphicon glyphicon-print"> Print </i>',['name'=>'btnPrint_PDF', 'class' => 'btn btn-primary btnPrint']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>