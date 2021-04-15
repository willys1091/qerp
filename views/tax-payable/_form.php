<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\components\AppHelper;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\TrTaxinhead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-taxinhead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-heading">Basic Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>PPn Masukan</label>
                        </div>
                        <div class="col-md-12">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'summary' => '',
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['style' => 'text-align: center']
                                    ],
                                    [
                                        'attribute' => 'taxInvoiceNum',
                                        'headerOptions' => ['style' => 'text-align: left']
                                    ],
                                    [
                                        'attribute' => 'taxSource',
                                        'headerOptions' => ['style' => 'text-align: left']
                                    ],
                                    [
                                        'attribute' => 'taxGrandTotal',
                                        'value' => function ($data) {
                                            return AppHelper::formatNumberTwoDecimalConfig($data['taxGrandTotal']);
                                        },
                                        'contentOptions' => ['class'=>'text-right'],
                                        'headerOptions' => ['class'=>'text-right'],
                                    ],
                                    [
                                        'attribute' => 'taxRate',
                                        'value' => function ($data) {
                                            return AppHelper::formatNumberTwoDecimalConfig($data['taxRate']);
                                        },
                                        'contentOptions' => ['class'=>'text-right'],
                                        'headerOptions' => ['class'=>'text-right'],
                                    ],
                                    [
                                        'class' => 'kartik\grid\CheckboxColumn'
                                    ],
                                ],
                            ]); ?>
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
