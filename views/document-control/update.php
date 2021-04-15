<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\AppHelper;
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
use kartik\form\ActiveField;
use app\models\TrDocumentcontrolhead;
use app\models\TrDocumentcontroldetail;

/* @var $this yii\web\View */
/* @var $model app\models\TrDocumentcontrolhead */
$params = Yii::$app->request->get('id');
$params = explode("?",$params);
$title = $params[0];
$this->title = 'Document Details: '.$title;
$initialPreview = '';
?>
<div class="tr-documentcontrolhead-update">
	<?php $form = ActiveForm::begin(['options' => [
                   'enctype' => 'multipart/form-data',
                ]]); ?>
	<div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
		    <?php
		    	$i = 0;

		        foreach ($detailModel as $documentDetail) {
		            $result[$i]["docTypeID"] = $documentDetail->documentTypeID;
		            $result[$i]["docTypeName"] = $documentDetail->documentTypeName;
		            $result[$i]["flagMandatory"] = $documentDetail->flagMandatory;
                        ?>
		    		
		    		<?= $form->field($model, 'documentID['.$i.']')->hiddenInput(['maxlength' => true, 'value' => $result[$i]["docTypeID"]])->label(false) ?>

		            <div class="col-md-6">
			            <label class="control-label">
			            	<?php echo $result[$i]["docTypeName"]; 
			            	if($result[$i]["flagMandatory"]=='1') echo "<h7 style='color: red;'> *</h7>"; ?>	
			            </label>
			            </br>
			            <?php
                                        $preview = null;
                                        $initialCaption = null;
                                        $fileName = null;
                                        $detailID = null;
                                                
			            	if($model->docControlHeadID != null){
                                            $detail = TrDocumentcontroldetail::find()
                                                    ->where(['docControlHeadID' => $model->docControlHeadID])
                                                    ->andWhere(['documentTypeID' => $documentDetail->documentTypeID])
                                                    ->one();
                                            if ($detail)
                                            {
                                                $detailID = $detail['docControlDetailID'];
                                                $fileName = $detail['document'];
                                                $previewUrl = Url::to("@web/assets_b/uploads/document/$fileName");
                                                $preview = '<embed class="kv-preview-data file-preview-pdf fulldiv" src="'.$previewUrl.'" type="application/pdf" >';
                                            
                                                $initialCaption = $detail['document'];
                                            }
			            	}
			            ?>
			            <?=
			            	$form->field($model, "documentFiles[$i]")->widget(FileInput::classname(), [
                                            'options' => [
                                                'accept' => 'document/pdf'
                                            ],
                                            'pluginOptions' => [
                                                //'required' => $documentDetail->flagMandatory == 1 ? true : false,
                                                'removeLabel' => 'Delete',
                                                'cancelLabel' => 'Cancel',
                                                'showUpload' => false,
                                                'showCancel' => false,
                                                'showRemove' => false,
                                                'initialPreviewAsData'=>false,
                                                'initialPreview' => [$preview],
                                                'initialCaption'=> [$initialCaption],
                                                'initialPreviewConfig' => [
                                                    [
                                                        'caption' => $initialCaption,
                                                        'url' => Url::toRoute("document-control/delete-detail/?id=$detailID"),
                                                        'key' => $fileName
                                                    ]
                                                ]
                                            ],
                                            
                                        ])->label(false)
		                ?>
		            </div>
		    <?php
		            $i += 1;
		        }
		    ?>
    	</div>
    	<div class="box-footer">
            <div class="form-group text-right">
                <?php if (!isset($isView)): ?>
                    <?= Html::submitButton('<i class="glyphicon glyphicon-save"> Save </i>', ['class' => 'btn btn-primary btnSave']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
