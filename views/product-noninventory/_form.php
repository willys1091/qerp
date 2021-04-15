<?php

use app\components\AppHelper;
use app\models\MsPackingtype;
use app\models\MsProduct;
use app\models\MsProductcategory;
use app\models\MsSubcategory;
use app\models\MsSupplier;
use app\models\MsUom;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use kartik\touchspin\TouchSpin;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\widgets\MaskedInput;

/* @var $this View */
/* @var $model MsProduct */
/* @var $form ActiveForm2 */
?>

<div class="ms-product-form">
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
                            <div class="col-md-4">
                                <?= $form->field($model, 'productName')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'minQty')
                                    ->widget(MaskedInput::classname(), [
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
                                                            'class' => 'form-control'
                                                        ],
                                ])?>
                            </div>
                            <div class="col-md-4">
                            <?= $form->field($model, 'hsCode', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['hscode/browse'], [
                                            'title' => 'HS Code',
                                            'data-target-value' => '.refNum',
                                            'data-target-text' => '.salesDetail',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse supplierBrowse'
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refNum']) ?>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'productCategoryID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsProductcategory::find()->where('flagActive = 1')->all(), 'productCategoryID', 'ProductCategoryName' ),
                                    'options' => [
                                        'prompt' => 'Select Category'],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'productSubcategoryID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsSubcategory::find()->where('flagActive = 1')->all(), 'subcategoryID', 'subcategoryName' ),
                                    'options' => [
                                        'prompt' => 'Select Sub Category'],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-4">
                            <?= $form->field($model, 'flagOOT')->widget(SwitchInput::classname(), [
                                        'type' => SwitchInput::CHECKBOX,
                                        'pluginOptions' => [
                                            'labelText' => '',
                                            'onText' => 'YES',
                                            'offText' => 'NO',
                                        ], 
                                    ]); ?>
                        </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'supplierID')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(MsSupplier::find(['flagActive' => 1])->orderBy(new yii\db\Expression("REPLACE(supplierName, ' ', '') ASC"))->all(), 'supplierID', 'supplierName'),
                                    'options' => [
                                        'prompt' => 'Select Supplier',
                                        'class' => 'supplierID'
                                    ],
                                ])

                                ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'origin')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div> -->
                        
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Product Detail</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'uomID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsUom::find()->where('flagActive = 1')->all(), 'uomID', 'uomName' ),
                                    'options' => [
                                        'prompt' => 'Select UOM',
                                        'class' => 'uomID'],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?=
                                $form->field($model, 'packingTypeID')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsPackingtype::find()->where('flagActive = 1')->all(), 'packingTypeID', 'packingTypeName' ),
                                    'options' => [
                                        'prompt' => 'Select Packing Type',
                                        'class' => 'packingTypeID'],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model, 'uomQty')
                                    ->widget(MaskedInput::classname(), [
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
                                                            'class' => 'form-control'
                                                        ],
                                ])?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model, 'buyPrice')
                                    ->widget(MaskedInput::classname(), [
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
                                                            'class' => 'form-control'
                                                        ],
                                ])?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model, 'sellPrice')
                                    ->widget(MaskedInput::classname(), [
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
                                                            'class' => 'form-control'
                                                        ],
                                                    ])?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'notes')->textArea(['maxlength' => true]) ?>
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
$js = <<< SCRIPT
$(document).ready(function () {
    $('.btnSave').on('click', function (e) {
        var uomID = $('.uomID').val();
        var packingTypeID = $('.packingTypeID').val();
        var uomQty = $('.uomQty').val();

        if(uomID.length == 0 || packingTypeID.length == 0 || uomQty.length == 0){
            bootbox.alert("Detail produk harus diisi!");
            return false;
        }
        return true;
    });
});
SCRIPT;
$this->registerJs($js);
?>