<?php

use app\components\AppHelper;
use app\models\MsCoa;
use app\models\MsCustomer;
use app\models\MsProduct;
use app\models\MsSupplier;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use kartik\switchinput\SwitchInputAsset;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

SwitchInputAsset::register($this);
?>
<div class="tr-samplereceipthead-form">
    
    <?php $form = ActiveForm::begin(); ?>

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
                                    'data' => [
                                        'GL Report' => 'GL Report',
                                    	'Profit Loss' => 'Profit / Loss',
                                        'Balance Sheet' => 'Balance Sheet',
                                        'Trial Balance' => 'Trial Balance',
                                        'Tax Recapitulation' => 'Tax Recapitulation',
                                        ],
                                    'options' => [
                                        'prompt' => 'Select Type Report',
                                        'class' => 'typeReport'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-6 startDate rowDate">
                            <?= $form->field($model, 'startDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig([])) ?>          
                        </div>
                        <div class="col-md-6 endDate rowDate">
                            <?= $form->field($model, 'endDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig([])) ?>          
                        </div>
                        <div class="col-md-12 coaRow">
                            <?=
                                $form->field($model, 'coaNo')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find()->where('coaLevel = 4')->orderBy('coaNo')->all(), 'coaNo', 'description', 'coaNo' ),
                                    'options' => [
                                        'prompt' => 'Select COA Number',
                                        'class' => 'coaNo'
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-2 monthPicker">
                            <div class="form-group">
                                <?= Html::label('Bulan') ?>
                                <?= DatePicker::widget(AppHelper::getMonthYearPickerConfig([
                                    'name' => 'monthYear',
                                    'value' => date('m-Y'),
                                    'class' => 'form-control'
                                ])) ?>
                            </div>
                        </div>
<!--                        <div class="row">
                            <div class="col-md-5">                            
                                <?= $form->field($model, 'startDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig()) ?>
                            </div>
                            <div class="col-md-1">
                                <div style="margin-top: 27px; margin-left: 27px;">
                                    <label>_</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <?= $form->field($model, 'endDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig()) ?>
                            </div>
                        </div>-->
                        <div class="col-md-2 detail"
                            <div class="form-group">
                                <?= Html::label('Tampilkan Rincian') ?>
                                <?= SwitchInput::widget([
                                    'name' => 'showDetail',
                                    'type' => SwitchInput::CHECKBOX,
                                    
                                    'pluginOptions' => [
                                        'onText' => 'YES',
                                        'offText' => 'NO',
                                    ], 
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group text-right">                
                    <?= Html::submitButton('<i class="glyphicon glyphicon-print"> Print </i>',['name'=>'btnPrint', 'value' => 'btnPrint', 'class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<< SCRIPT
$(document).ready(function(){
    hideComponent();
    $('.typeReport').change(function(){
        hideComponent();

        if ($(this).val() == "GL Report") {
            $('.coaRow').show();
            $('.startDate').show();
            $('.endDate').show();
        } else if ($(this).val() == "Balance Sheet") {
            $('.startDate').show();
            $('.endDate').show();
            $('.detail').show();
        } else if ($(this).val() == 'Profit Loss') {
            $('.startDate').show();
            $('.endDate').show();
            $('.detail').show();
        } else if ($(this).val() == "Trial Balance") {
            $('.startDate').show();
            $('.endDate').show();
        }
    });

    function hideComponent(){
        $('.monthPicker').hide();
        $('.startDate').hide();
        $('.endDate').hide();
        $('.coaRow').hide();
        $('.rowDate').hide();
        $('.detail').hide();
    }
});
        
SCRIPT;
$this->registerJs($js);

?> 
