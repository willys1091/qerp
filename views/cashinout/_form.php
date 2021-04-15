<?php

use app\components\AppHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\models\MsCoa;
use app\models\MsCurrency;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use endrikexe\ClientScript;

$actionName = Yii::$app->controller->action->id;
?>

<style>
    #table-tr-detail tfoot tr th, #table-tr-detail tbody tr th
    {
        font-weight: normal;
    }
</style>

<div class="tr-cashinout-form">
    <?php $form = ActiveForm::begin([
        'id' => 'cashinout-form'
    ]); ?>
    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Transaction Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'cashInOutDate')
                                    ->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => false])) 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'voucherNum')->textInput();
                            ?>
                        </div>
                        <div class="visibility: hidden">
                            <?= $form->field($model, 'refNum', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['cash-in-out/browse'], [
                                            'title' => 'Reference Number',
                                            'data-target-value' => '.refNum',
                                            'data-target-text' => '.salesDetail',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse refBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refNum', 'readonly' => 'readonly']) ?>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'checkOrGiroNum')->textInput();
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'checkOrGiroDate')
                                    ->widget(DatePicker::className(), AppHelper::getDatePickerConfig(['disabled' => false]))
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?=
                                $form->field($model, 'cashAccount')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsCoa::cashBankCoa()->all(), 'coaNo', 'description' ),
                                    'options' => [
                                        'prompt' => 'Select Cash Account',
                                        'id' => 'cashAccount'
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= Html::label('Type', 'type', ['class' => 'control-label']) ?>
                            <?= Html::textInput('type', null, ['name' => 'type', 'id' => 'coaType', 'readonly' => 'readonly', 'class' => 'form-control']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'flagCashInOut')->widget(Select2::classname(),[
                                    'name' => 'flow',
                                    'value' => '',
                                    'data' => ['in' => 'In', 'out' => 'Out'],
                                    'options' => ['multiple' => false, 'placeholder' => 'Select Flow', 'id' => 'cash-flow']
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?=
                            $form->field($model, 'currencyID')->widget(Select2::classname(),[
                                'data' => ArrayHelper::map(MsCurrency::find()->where('flagActive = 1')->all(), 'currencyID', function($model, $defaultValue) {
                                        return $model['currencyID'].' - '.$model['currencyName'];
                                    } ),
                                'options' => [
                                    'prompt' => 'Select Currency',
                                    'class' => 'selectCurrency'],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'rate')
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
                                        'class' => 'form-control currencyRate'
                                    ],
                                ])?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'penerima')->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">Transaction Detail</div>
                <div class="panel-body">
                    <div class="row" id="RowTransactionDetail">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-transaction-detail" id="table-tr-detail" style="border-collapse: inherit;">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">COA</th>
                                                <th style="width: 10%;" class="text-right">Amount</th>
                                                <th style="width: 10%;">Notes</th>
                                                <th style="width: 1%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        <tfoot>
                                        <?php if ($actionName == "create" || $actionName == "update"): ?>
                                            <tr>
                                                <th>
                                                    <?= Select2::widget([
                                                            'name' => 'detail-coa',
                                                            'value' => '',
                                                            'data' => [],
                                                            'options' => [
                                                                'multiple' => false, 
                                                                'placeholder' => 'Please select flow first !', 
                                                                'class' => 'transaction-detail-coa', 
                                                                'id' => 'detail-coa'
                                                            ]
                                                        ]);
                                                    ?>
                                                    <?= Select2::widget([
                                                            'name' => 'detail-coa-in',
                                                            'value' => '',
                                                            'data' => ArrayHelper::map(MsCoa::cashInCoa()->all(), 'coaNo', 'description'),
                                                            'options' => [
                                                                'multiple' => false, 
                                                                'placeholder' => 'Select COA', 
                                                                'class' => 'transaction-detail-coa', 
                                                                'id' => 'detail-coa-in'
                                                            ]
                                                        ]);
                                                    ?>
                                                    <?= Select2::widget([
                                                            'name' => 'detail-coa-out',
                                                            'value' => '',
                                                            'data' => ArrayHelper::map(MsCoa::cashOutCoa()->all(), 'coaNo', 'description'),
                                                            'options' => [
                                                                'multiple' => false, 
                                                                'placeholder' => 'Select COA', 
                                                                'class' => 'transaction-detail-coa', 
                                                                'id' => 'detail-coa-out'
                                                            ]
                                                        ]);
                                                    ?>
                                                </th>
                                                <th>
                                                    <?= \yii\widgets\MaskedInput::widget([
                                                        'name' => 'detail-amount',
                                                        'value' => '0,00',
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
                                                            'class' => 'form-control text-right transaction-detail-amount',
                                                            'id' => 'detail-amount',
                                                        ],
                                                    ]) ?>
                                                </th>
                                                <th>
                                                    <?= Html::textArea('detail-notes', null, ['class' => 'form-control', 'id' => 'detail-notes']) ?>
                                                </th>
                                                <td class="text-center">
                                                    <?= Html::a('<i class="glyphicon glyphicon-plus">Add</i>', '#', ['class' => 'btn btn-primary btn-sm', 'id' => 'btnAdd']) ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">Transaction Summary</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6" style="overflow:auto;resize:none">
                            <?= $form->field($model, 'additionalInfo')->textArea(['maxlength' => true, 'rows' => '10']) ?>
                        </div>
                        <div class="col-md-6">
                            <div class="clearfix" style="height:1em; margin-bottom: 5px;">                               
                            </div>
                            <?= $form->field($model, 'total')
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
                                        'class' => 'form-control',
                                        'style' => 'width:50%;',
                                        'readonly' => 'readonly'
                                    ],
                                ])
                                ->label(' Total', ['style'=>'width:50%; float:left; font-size:1.4em;'])
                            ?>
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
<script>
    //Declare Declare while in global scope
    var errorMessages = <?= Json::encode($model->errorMessages) ?>;
    
    var coasIn = <?= Json::encode(MsCoa::cashInCoa()->asArray()->all()) ?>;
    var coasOut = <?= Json::encode(MsCoa::cashOutCoa()->asArray()->all()) ?>;
    
    var coas = coasIn.concat(coasOut);
    
    var detailTemplate = `
        <tr>
            <th>{{coa}}</th>
            <th class="text-right">{{amount}}</th>
            <th style='white-space: pre-wrap;'>{{notes}}</th>
            <th>
                <button class="btn btn-danger btn-sm" onClick="removeDetail({{index}})">
                    <i class="glyphicon glyphicon-remove">Delete</i>
                </button>
            </th>
        </tr>
        <input type="hidden" name="TrCashinouthead[transactionDetails][{{index}}][destinationAccount]" value="{{coaNo}}">
        <input type="hidden" name="TrCashinouthead[transactionDetails][{{index}}][amount]" value="{{amount}}">
        <input type="hidden" name="TrCashinouthead[transactionDetails][{{index}}][notes]" value="{{notes}}">
    `;
    var transactionDetails = [];
    
    function findCoaByNo(coaNo)
    {
        return coas.find(x => x.coaNo == coaNo);
    }
    
    function removeDetail(index)
    {
        transactionDetails.splice(index, 1);
        refreshDetailList();
    }
    
    function refreshDetailList()
    {
        let html = '';
        let total = 0;
        
        for (var i = 0; i < transactionDetails.length; i++)
        {
            let transactionDetail = transactionDetails[i];
            
            html += detailTemplate.replaceAll('{{coaNo}}', transactionDetail.destinationAccount)
                .replaceAll('{{coa}}', findCoaByNo(transactionDetail.destinationAccount).description)
                .replaceAll('{{amount}}', transactionDetail.amount)
                .replaceAll('{{notes}}', transactionDetail.notes)
                .replaceAll('{{index}}', i);
            total += transactionDetail.amount.currencyToFloat();
        }

        $('#table-tr-detail tbody').html(html);
        $('#trcashinouthead-total').val(total);
    }
</script>

<?php ClientScript::singleton()->beginScript('js'); ?>
<script>
    var checkCurrencyRateAjaxURL = <?= "'".Yii::$app->request->baseUrl. "/currency/check';" ?>
    transactionDetails = <?= Json::encode($model->transactionDetails) ?>;
    
    refreshDetailList();
    
    var cashFlow = $('#cash-flow').val();
    $('#detail-coa').next().css('display', cashFlow == 'in' || cashFlow == 'out' ? 'none' : 'block');
    $('#detail-coa-in').next().css('display', cashFlow == 'in' ? 'block' : 'none');
    $('#detail-coa-out').next().css('display', cashFlow == 'out' ? 'block' : 'none');
    
    $('#coaType').val($('#cashAccount').val().split('.')[0] == '1110' ? 'Kas' : 'Bank');
    
    $('.selectCurrency').change(function(){
        var currencyID = $('.selectCurrency').val();
        currencyRate = getCurrencyRate(currencyID);
        currencyRate = replaceAll(currencyRate, ".", ",");
        currencyRate = replaceAll(currencyRate, '"', "");
        $('.currencyRate').val(formatNumber(currencyRate));
    });

    function getCurrencyRate(currencyID){
        var currencyRate = '0.00';
        $.ajax({
            url: checkCurrencyRateAjaxURL,
            async: false,
            type: 'POST',
            data: { currencyID: currencyID },
            success: function(data) {
                currencyRate = data;
            }
         });
        return currencyRate;
    }

    $('#cashAccount').on('change', function(e){
        var type = $(this).val().split('.')[0] == '1110' ? 'Kas' : 'Bank';
        $('#coaType').val(type);
    });

    $('#btnAdd').on('click', function(e){
        e.preventDefault();
        
        if (cashFlow == '')
        {
            bootbox.alert('Please select cash flow first !');
            return;
        }
        
        $detailCoa = $(cashFlow == 'in' ? '#detail-coa-in' : '#detail-coa-out');
        $detailAmount = $('#detail-amount');
        $detailNotes = $('#detail-notes');

        if ($detailCoa.val() == null || $detailCoa.val() == '')
        {
            bootbox.alert('COA cannot be blank');
            return;
        }
        if ($detailAmount.val().currencyToFloat() <= 0)
        {
            bootbox.alert('Amount must be greater than 0');
            return;
        }

        detailObj = {
            'destinationAccount': $detailCoa.val(),
            'amount': $detailAmount.val(),
            'notes': $detailNotes.val()
        }
        transactionDetails.push(detailObj);
        refreshDetailList();

        $detailAmount.val('0,00');
        $detailNotes.val(null);
    });
    
    $('#cash-flow').on('change', function(e){
        cashFlow = $(this).val();
        
        $('#detail-coa').next().css('display', 'none');
        $('#detail-coa-in').next().css('display', cashFlow == 'in' ? 'block' : 'none');
        $('#detail-coa-out').next().css('display', cashFlow == 'out' ? 'block' : 'none');
    });
    
    $('#cashinout-form').on('beforeSubmit', function(e) {
        if (transactionDetails.length == 0)
        {
            bootbox.alert('You must add atleast one transaction detail');
            $(this).find(':submit').prop('disabled', false);
            return false;
        }
        
        return true;
    });
    
    if (errorMessages)
    {
        errorMessages.forEach(function(item, index){
            bootbox.alert(item);
        });
    }
</script>
<?php ClientScript::singleton()->endScript(); ?>