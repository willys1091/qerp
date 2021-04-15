<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\form\ActiveField;
use app\components\AppHelper;
use app\models\LkDocumenttype;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\TrDocumentcontrolhead */
/* @var $form yii\widgets\ActiveForm */

$this->params['docDetail'] = '';
?>

<div class="tr-documentcontrolhead-form">

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
                        <div class="col-md-6">
                            <?= $form->field($model, 'refNum', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('...', ['document-control/browse'], [
                                            'title' => 'Reference Number',
                                            'data-target-value' => '.refInput',
                                            'data-target-text' => '.refInput',
                                            'data-target-width' => '1000',
                                            'data-target-height' => '600',
                                            'class' => 'btn btn-primary btn-sm WindowDialogBrowse',
                                            'disabled' => isset($isView)
                                        ]),
                                        'asButton' => true
                                    ],
                                ]
                            ])->textInput(['class' => 'refInput browseReference', 'readonly' => 'readonly']) ?>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="control-label">Document Type</label>
                            <?= Html::textInput('documentType', '', [
                                                'class' => 'form-control documentType',
                                                'readonly' => 'readonly'
                                            ]) ?>
                        </div>
                            <?= Html::activeHiddenInput($model, 'lkDocumentTypeID', ['class' => 'documentTypeID']) ?>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table table-bordered upload-detail-table" style="border-collapse: inherit;">
                                        <tbody>
                                        
                                        </tbody>
                                        <?php
                                                    for($i=0; $i<0; $i++){
                                            ?>
                                        <tr>
                                            <td>
                                                <?=
                                                        FileInput::widget([
                                                            'name' => 'document',
                                                            'options' => [
                                                                'class' => 'docFile',
                                                            ],
                                                            'pluginOptions' => [
                                                                'removeLabel' => 'Hapus',
                                                                'cancelLabel' => 'Batal',
                                                                'showUpload' => false,
                                                                'showCancel' => false,
                                                                'initialPreview' => $model->getPhotosInitialPreview(),
                                                                'initialPreviewConfig' => $model->getPhotosInitialPreviewConfig(),
                                                                'overwriteInitial' => false
                                                            ]
                                                        ]);
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                                    }
                                                ?>
                                    </table>
                                </div>
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
$purchaseDetail = \yii\helpers\Json::encode($model->joinDocumentDetail);
$checkDocTypeAjaxURL = Yii::$app->request->baseUrl. '/document-control/check';
echo $this->params['docDetail'];
$js = <<< SCRIPT

$(document).ready(function () {

    $('.browseReference').change(function(){
        if($('.browseReference').val().includes("QJA")){
            $('.documentType').val('Penjualan');
            $('.documentTypeID').val('2');
        }
        var docType = $('.documentTypeID').val();
        var doc = getDocuments(docType);
    });

    function getDocuments(docType){
        var detail = [];
        $.ajax({
            url: '$checkDocTypeAjaxURL',
            async: false,
            type: 'POST',
            data: { docType: docType },
            success: function(docData) {
                var result = JSON.parse(docData);
                detail = result;
            }
        });
        return detail;
    }

    function replaceAll(string, find, replace) {
        return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }

    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:\${}()|\[\]\/\\\\])/g, "\\\\$1");
    }

});
SCRIPT;
$this->registerJs($js);
?>
