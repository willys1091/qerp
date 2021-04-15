<?php

use app\components\AppHelper;
use app\models\MsWarehouse;
use kartik\daterange\DateRangePicker;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Modal;

?>

<div class="stock-card-search">
    <?php
    $form = ActiveForm::begin([
                'id' => 'stock-card-form',
                'enableAjaxValidation' => false,
                'method' => 'GET',
                'options' => [
                    'data-pjax' => true,
                    'name' => 'stock-card-search-form',
                ],
    ]);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="row"> 
                <div class="col-md-4">
                    <?= Html::activeHiddenInput($model, 'productID', ['id' => 'productIDHead']) ?>
                    <?=
                    $form->field($model, 'productName', [
                        'addon' => [
                            'append' => [
                                'content' => Html::a('...', ['sample-stock-card/browse'], [
                                    'title' => 'Transaction Code',
                                    /*'data-target-value' => '.refNum',
                                    'data-target-text' => '.refNumInput',
                                    'data-target-width' => '1000',
                                    'data-target-height' => '600',*/
                                    //'class' => 'btn btn-primary btn-sm WindowDialogBrowse purchaseBrowse',
                                    'class' => 'btn btn-primary btn-sm',
                                    'disabled' => isset($isView),
                                    'data-modal' => '#main-modal',
                                    'data-target-value' => '#productIDHead',
                                  
                                ]),
                                'asButton' => true
                            ],
                        ]
                    ])->textInput(['class' => 'refNumInput-0 product-name', 'readonly' => 'readonly'])

                    ?>
                </div>
              
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'transactionDate')->widget(DateRangePicker::className(), AppHelper::getDatePickerRangeConfigs())

                    ?>
                </div>
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'warehouseID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(MsWarehouse::findAll(['flagActive' => 1]), 'warehouseID', 'warehouseName'),
                        'options' => [
                            'prompt' => 'Select Warehouse',
                            'class' => 'warehouseID'
                        ],
                    ])

                    ?>
                </div>
            </div>
           
        </div>
    </div>
</div>

    <div class="form-group text-right">
        <?= Html::submitButton('<i class="fa fa-search with-text"></i>' . Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?=
        Html::submitButton('<i class="glyphicon glyphicon-download with-text"></i>' . Yii::t('app', 'Export Excel'), [
            'id' => 'downloadReport',
            'name' => 'downloadReport',
            'data-pjax' => 0,
            'class' => 'btn btn-primary'
        ])
        ?>
         <?=
        Html::submitButton('<i class="glyphicon glyphicon-download with-text"></i>' . Yii::t('app', 'Export Pdf'), [
            'id' => 'downloadReportPdf',
            'name' => 'downloadReportPdf',
            'class' => 'btn btn-primary',
            'onclick' => "$('#stock-card-form').attr('target', '_blank');"
        ])
        ?>
        <?= Html::a('<i class="glyphicon glyphicon-refresh with-text"></i>' . Yii::t('app', 'Clear Filter'), ['index'], ['class' => 'btn btn-primary', 'title' => Yii::t('app', 'Clear  Filter')]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
Modal::begin([
    'id' => 'main-modal',
    'size' => 'modal-lg',
   
]); ?>



<?php Modal::end(); ?>

<?php
$getLocationListAjaxURL = Yii::$app->request->baseUrl . '/branch/get-locations';
$exportURL = Yii::$app->request->baseUrl . '/sample-stock-card/export';
$selectLocationText = '- ' . Yii::t('app', 'All') . ' -';

$js = <<<SCRIPT
$(document).ready(function() {        
    $('#branchIDHead').change(function () {
        getLocationList();
    });
        
    function getLocationList(branchID){
        var branchID = $('#branchIDHead').val();
        
        showLoading();
        $.ajax({
            url: '$getLocationListAjaxURL',
            type: 'POST',
            data: { branchID: branchID, mode: 1 },
            success: function(data) {
                fillLocationList(JSON.parse(data));
            },
            complete: function() {
                hideLoading();
            }   
        });
    }
        
    function fillLocationList(locationList) {
        $('#locationIDHead').empty();
        //$('#locationIDHead').append($("<option>", {value: '', text: '$selectLocationText'}));
        locationList.forEach(function(entry) {
            $('#locationIDHead').append($("<option>", {value: entry.locationID, text: entry.locationName}));
        });
    }
    
    $('#btnExportRaw').click(function() {  
        var productName = $('#productNameHead').val();
        var productCode = $('#productCodeHead').val();  
        var categoryID = $('#categoryIDHead').val();
        var uomID = $('#uomIDHead').val();
        var transType = $('#transTypeHead').val();
        var date = $('#stockcard-stockdate').val();
        var dateFrom = date.split(' - ')[0];
        var dateTo = date.split(' - ')[1];
        var branchID = $('#branchIDHead').val();
        var locationID = $('#locationIDHead').val();
        var newWindow = window.open('$exportURL' + '?productName=' + productName + '&productCode=' + productCode + '&categoryID=' + categoryID + '&uomID=' + uomID + 
            '&transType=' + transType + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&branchID=' + branchID + '&locationID=' + locationID,'name','height=720,width=1366');
        if (window.focus) {
            newWindow.focus();
        }       
    });
});
SCRIPT;
$this->registerJs($js);
?>