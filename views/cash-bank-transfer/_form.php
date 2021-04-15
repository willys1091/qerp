<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\MsCoa;
use app\models\MsCurrency;
use kartik\widgets\DatePicker;
use yii\helpers\Json;
use endrikexe\ClientScript;

/* @var $this yii\web\View */
/* @var $model app\models\CashBankTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-bank-transfer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Cash/Bank Transfer Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'transferDate')->widget(DatePicker::className(), AppHelper::getDatePickerConfig([])) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'voucherNum')->textInput([
                                'maxlength' => true
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'sourceCurrency')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 AND (coaNo LIKE "1110.%" OR coaNo LIKE "1111.%" OR coaNo LIKE "9110.0001%")')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Source Currency',
                                        'class' => 'selectSourceCurrency'],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'destinationCurrency')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::find ()->where('coaLevel = 4 AND (coaNo LIKE "1110.%" OR coaNo LIKE "1111.%" OR coaNo LIKE "9110.0001%") AND flagActive = 1')->orderBy('description')->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Destination Currency',
                                        'class' => 'selectDestinationCurrency'],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'sourceRate')
                            ->widget(\yii\widgets\MaskedInput::classname(), [
                                            'clientOptions' => [
                                            'alias' => 'decimal',
                                            'digits' => 2,
                                            'digitsOptional' => false,
                                            'radixPoint' => ',',
                                            'groupSeparator' => '.',
                                            'autoGroup' => true,
                                            'removeMaskOnSubmit' => false
                                                                ],
                                                'options' => [
                                                    'class' => 'form-control sourceRate'
                                                ],
                                            ])?>

                            
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'destinationRate')
                            ->widget(\yii\widgets\MaskedInput::classname(), [
                                            'clientOptions' => [
                                            'alias' => 'decimal',
                                            'digits' => 2,
                                            'digitsOptional' => false,
                                            'radixPoint' => ',',
                                            'groupSeparator' => '.',
                                            'autoGroup' => true,
                                            'removeMaskOnSubmit' => false
                                                                ],
                                                'options' => [
                                                    'class' => 'form-control destinationRate'
                                                ],
                                            ])?>

                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'sourceAmount')
                            ->widget(\yii\widgets\MaskedInput::classname(), [
                                            'clientOptions' => [
                                            'alias' => 'decimal',
                                            'digits' => 2,
                                            'digitsOptional' => false,
                                            'radixPoint' => ',',
                                            'groupSeparator' => '.',
                                            'autoGroup' => true,
                                            'removeMaskOnSubmit' => false
                                                                ],
                                                'options' => [
                                                    'class' => 'form-control sourceAmount'
                                                ],
                                            ])?>

                            
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'destinationAmount')
                            ->widget(\yii\widgets\MaskedInput::classname(), [
                                            'clientOptions' => [
                                            'alias' => 'decimal',
                                            'digits' => 2,
                                            'digitsOptional' => false,
                                            'radixPoint' => ',',
                                            'groupSeparator' => '.',
                                            'autoGroup' => true,
                                            'removeMaskOnSubmit' => false
                                                                ],
                                                'options' => [
                                                    'class' => 'form-control destinationAmount',
                                                    'readonly' => 'readonly'
                                                ],
                                            ])?>

                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'additionalInfo')->textArea(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="box-footer">
            <div class="form-group text-right">
                <?php if (!isset($isView)): ?>
                    <?= Html::submitButton('<i class="glyphicon glyphicon-save"> Save </i>', ['class' => 'btn btn-primary btnSave']) ?>
                <?php endif; ?>
                
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

<?php
$checkCurrencyRateAjaxURL = Yii::$app->request->baseUrl. '/coa/checkcurrency';

ClientScript::singleton()->beginScript('js'); ?>
<script>

var errorMessages = <?= Json::encode($model->errorMessages) ?>;
if (errorMessages)
{
    errorMessages.forEach(function(item, index){
        bootbox.alert(item);
    });
}
    
$('.sourceRate').change(function(){
    var sourceRate = $('.sourceRate').val();
    var destinationRate = $('.destinationRate').val();
    var sourceAmount = $('.sourceAmount').val();
    var destinationAmount = $('.destinationAmount').val();
    var destAmount = 0;

    sourceRate = replaceAll(sourceRate, ".", "");
    sourceRate = replaceAll(sourceRate, ",", ".");
    sourceRate = parseFloat(sourceRate);
    if (isNaN(sourceRate)){
        sourceRate = parseFloat(0);
    }
    destinationRate = replaceAll(destinationRate, ".", "");
    destinationRate = replaceAll(destinationRate, ",", ".");
    destinationRate = parseFloat(destinationRate);
    if (isNaN(destinationRate)){
        destinationRate = parseFloat(0);
    }
    sourceAmount = replaceAll(sourceAmount, ".", "");
    sourceAmount = replaceAll(sourceAmount, ",", ".");
    sourceAmount = parseFloat(sourceAmount);
    if (isNaN(sourceAmount)){
        sourceAmount = parseFloat(0);
    }
    destinationAmount = replaceAll(destinationAmount, ".", "");
    destinationAmount = replaceAll(destinationAmount, ",", ".");
    destinationAmount = parseFloat(destinationAmount);
    if (isNaN(destinationAmount)){
        destinationAmount = parseFloat(0);
    }

    var destAmount = sourceRate*sourceAmount/destinationRate;

    destAmount = destAmount.toFixed(2);
    destAmount = replaceAll(destAmount, ".", ",");
    $('.destinationAmount').val(formatNumber(destAmount));
});
$('.destinationRate').change(function(){
    var sourceRate = $('.sourceRate').val();
    var destinationRate = $('.destinationRate').val();
    var sourceAmount = $('.sourceAmount').val();
    var destinationAmount = $('.destinationAmount').val();
    var destAmount = 0;

    sourceRate = replaceAll(sourceRate, ".", "");
    sourceRate = replaceAll(sourceRate, ",", ".");
    sourceRate = parseFloat(sourceRate);
    if (isNaN(sourceRate)){
        sourceRate = parseFloat(0);
    }
    destinationRate = replaceAll(destinationRate, ".", "");
    destinationRate = replaceAll(destinationRate, ",", ".");
    destinationRate = parseFloat(destinationRate);
    if (isNaN(destinationRate)){
        destinationRate = parseFloat(0);
    }
    sourceAmount = replaceAll(sourceAmount, ".", "");
    sourceAmount = replaceAll(sourceAmount, ",", ".");
    sourceAmount = parseFloat(sourceAmount);
    if (isNaN(sourceAmount)){
        sourceAmount = parseFloat(0);
    }
    destinationAmount = replaceAll(destinationAmount, ".", "");
    destinationAmount = replaceAll(destinationAmount, ",", ".");
    destinationAmount = parseFloat(destinationAmount);
    if (isNaN(destinationAmount)){
        destinationAmount = parseFloat(0);
    }

    var destAmount = sourceRate*sourceAmount/destinationRate;

    destAmount = destAmount.toFixed(2);
    destAmount = replaceAll(destAmount, ".", ",");
    $('.destinationAmount').val(formatNumber(destAmount));
});
$('.sourceAmount').change(function(){
    var sourceRate = $('.sourceRate').val();
    var destinationRate = $('.destinationRate').val();
    var sourceAmount = $('.sourceAmount').val();
    var destinationAmount = $('.destinationAmount').val();
    var destAmount = 0;

    sourceRate = replaceAll(sourceRate, ".", "");
    sourceRate = replaceAll(sourceRate, ",", ".");
    sourceRate = parseFloat(sourceRate);
    if (isNaN(sourceRate)){
        sourceRate = parseFloat(0);
    }
    destinationRate = replaceAll(destinationRate, ".", "");
    destinationRate = replaceAll(destinationRate, ",", ".");
    destinationRate = parseFloat(destinationRate);
    if (isNaN(destinationRate)){
        destinationRate = parseFloat(0);
    }
    sourceAmount = replaceAll(sourceAmount, ".", "");
    sourceAmount = replaceAll(sourceAmount, ",", ".");
    sourceAmount = parseFloat(sourceAmount);
    if (isNaN(sourceAmount)){
        sourceAmount = parseFloat(0);
    }
    destinationAmount = replaceAll(destinationAmount, ".", "");
    destinationAmount = replaceAll(destinationAmount, ",", ".");
    destinationAmount = parseFloat(destinationAmount);
    if (isNaN(destinationAmount)){
        destinationAmount = parseFloat(0);
    }

    var destAmount = sourceRate*sourceAmount/destinationRate;

    destAmount = destAmount.toFixed(2);
    destAmount = replaceAll(destAmount, ".", ",");
    $('.destinationAmount').val(formatNumber(destAmount));
});

$('.selectSourceCurrency').change(function(){
    var coaNo = $('.selectSourceCurrency').val();
    var result = getCurrencyRate(coaNo);
    currencyRate = result.currencyRate.toString();
    currencyRate = replaceAll(currencyRate, ".", ",");
    currencyRate = replaceAll(currencyRate, '"', "");
    $('.sourceRate').val(formatNumber(currencyRate));
});
$('.selectDestinationCurrency').change(function(){
    var coaNo = $('.selectDestinationCurrency').val();
    var result = getCurrencyRate(coaNo);
    currencyRate = result.currencyRate.toString();
    currencyRate = replaceAll(currencyRate, ".", ",");
    currencyRate = replaceAll(currencyRate, '"', "");
    $('.destinationRate').val(formatNumber(currencyRate));
});

function getCurrencyRate(coaNo){
    var result = [];
    $.ajax({
        url: '<?=$checkCurrencyRateAjaxURL?>',
        async: false,
        type: 'POST',
        data: { coaNo: coaNo },
        success: function(data) {
            result = JSON.parse(data);
        }
     });
    return result;
}
</script>
<?php ClientScript::singleton()->endScript(); ?>