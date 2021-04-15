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
                                    'data' => ['Product' => 'Product', 'Supplier' => 'Supplier', 'Customer' => 'Customer',],
                                    'options' => [
                                        'prompt' => 'Select Type Report',
                                        'class' => 'salesReport'],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <?= $form->field($model, 'yearsS')->widget(DatePicker::className(), AppHelper::getYearPickerConfig(), [
                               'options' => [
                               'prompt' => 'Select Type Report',
                               'class' => 'Ystart'],
                            ]) ?>
                        </div>
                        
                        <div class="col-md-5">
                            <?= $form->field($model, 'yearsE')->widget(DatePicker::className(), AppHelper::getYearPickerConfig(), [
                               'options' => [
                               'prompt' => 'Select Type Report',
                               'class' => 'Yend'],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group text-right">                
                    <?= Html::submitButton('<i class="glyphicon glyphicon-print"> Print </i>',['name'=>'btnPrint_PDF','target' => '_blank' ,'class' => 'btn btn-primary btnPrint']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>