<?php

use app\components\AppHelper;
use app\models\MsWarehouse;
use kartik\daterange\DateRangePicker;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>

<div class="stock-card-search">
    <?php
    $form = ActiveForm::begin([
                'id' => 'pettycash-form',
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
                    <?=
                    $form->field($model, 'pettyCashDate')->widget(DateRangePicker::className(), AppHelper::getDatePickerRangeConfigs())

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="form-group text-right">
        <?= Html::submitButton('<i class="fa fa-search with-text"></i>' . Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?=
        Html::submitButton('<i class="glyphicon glyphicon-download with-text"></i>' . Yii::t('app', 'Export Data'), [
            'id' => 'downloadReport',
            'name' => 'downloadReport',
            'data-pjax' => 0,
            'class' => 'btn btn-primary'
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
