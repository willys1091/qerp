<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\AppHelper;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TrJournaldetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-journal-search">
    <?php
    $form = ActiveForm::begin([
                'id' => 'form-filter-journal',
    ]);
    ?>
    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'searchRef')
                    ->textInput(['placeholder' => 'Search'])
                    ->label('Search') ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'journalDate')->widget(DateRangePicker::className(), [
                        'useWithAddon' => false,
                        'convertFormat' => true,
                        'startAttribute' => 'startDate',
                        'endAttribute' => 'endDate',
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'd-m-Y',
                                'separator' => ' to ',
                            ],
                            'opens' => 'left'
                        ],
                        'options' => [
                            'class' => 'drp-container form-control',
                            'readonly' => true
                        ]
                    ])
                    ?>
                </div>
            </div>
            
        </div>
        <div class="box-footer text-right">
            <?= Html::submitButton('<i class="fa fa-search"></i> Search', [
                'class' => 'btn btn-primary']
            ) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
