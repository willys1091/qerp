<?php

use app\components\AppHelper;
use app\components\JsBlock;
use app\models\ActivationSearch;
use app\models\MsCustomerdetail;
use app\models\MsProduct;
use app\models\MsSetting;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model ActivationSearch */
/* @var $form ActiveForm */

$form = ActiveForm::begin([
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'action' => ['index'],
        'method' => 'POST',
        'options' => [
            'data-pjax' => 1,
        ],
    ]);
?>
<div class="panel panel-default">
   
    <div class="panel-body">
        <div class ="row">
             <div class='col-md-6'>
                <?php 
                echo $form->field($model, 'contactPerson')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(MsCustomerdetail::find()->where(['customerID' => $id])->all(), 'contactPerson', 'contactPerson'),
                    'options' => [
                        'placeholder' => '', 
                        'id'=>'contact'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);

                ?>
            </div>
            <div class='col-md-6'>
                <?php
                $data = MsSetting::find()->where(['key1' => 'InvoiceDueAutoNumber'])->one();
                echo $form->field($model, 'invoice')->textInput(['autocomplete' => 'off', 'value' => $data['value1']]);

                ?>
              
            </div>
                 <?= $form->field($model, 'id')->hiddenInput(['autocomplete' => 'off', 'value' => $id])->label(false) ?>
            <div class='col-md-12'>
                <div class="box-footer text-right">
                    <?= Html::submitButton('Print', ['class' => 'btn btn-primary print']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php JsBlock::begin() ?>
<script>
 $('.print').on('click', function (e) {
       
        if($('#receivabledueform-invoice').val() == ""){
            errorInputDetail('Invoice required');
            return false;
        }
       
    });
</script>   
<?php JsBlock::end() ?>