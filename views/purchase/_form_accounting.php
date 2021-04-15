<?php

use app\components\AppHelper;
use app\components\JsBlock;
use app\models\LkPaymentmethod;
use app\models\MsCurrency;
use app\models\MsPaymentdue;
use app\models\MsSupplier;
use app\models\MsSuppliercontactdetail;
use app\models\MsTax;
use app\models\TrPurchaseorderhead;
use dosamigos\ckeditor\CKEditor;
use kartik\checkbox\CheckboxX;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\widgets\MaskedInput;
use yii\widgets\MaskedInputAsset;
use yii\widgets\Pjax;
/* @var $this View */
/* @var $model TrPurchaseorderhead */
/* @var $form ActiveForm2 */

MaskedInputAsset::register($this);
?>

<div class="tr-purchaseorderhead-form" id="app">

    <?php $form = ActiveForm::begin([
        
        'options' => [
            'id' => 'form-purchase'
        ]
        
    ]);
        
    ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Transaction Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'supplierpaymentDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => isset($isView)])) ?>
                        </div>
                        <div class="col-md-4">
                              <?= $form->field($model, 'giroNumber')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                              <?= $form->field($model, 'notes')->textArea(['maxlength' => true]) ?>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        <div class="box-footer">
            <div class="form-group text-right">
                <?= (!isset($isView) && !isset($isUpdate))? 
                         Html::submitButton('<i class="glyphicon glyphicon-save">Save</i>', ['class' => 'btn btn-primary onSave',  'v-on:click' => 'checkForm'])       
                         :  Html::submitButton('<i class="glyphicon glyphicon-pencil">Save</i>', ['class' => 'btn btn-primary onSave',  'v-on:click' => 'checkForm'])             

                ?>
                <?php if (!isset($isView)){ ?>
                    <?= AppHelper::getCancelButton() ?>
                <?php } else { ?>
                    <?= Html::a('<i class="glyphicon glyphicon-remove"> Cancel </i>', ['index'], ['class'=>'btn btn-danger']) ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
