<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $model app\models\MsSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
        <?php foreach ($models as $i=>$model){ ?>
            <?php if ($model->value2 == 'text'){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label text-right"><?php echo $model->key2; ?></label>
                        <?= $form->field($model, '['.$i.']value1')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            <?php 
            } 
            elseif ($model->value2 == 'textarea'){ ?>
                <div class="row">
                    <div class="col-md-12"> 
                        <label class="control-label text-right"><?php echo $model->key2; ?></label>
                        <?= $form->field($model, '['.$i.']value1')->textArea(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
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
    
    $(".cancel-button").on("click",function(e){
       e.preventDefault();
       bootbox.confirm("Unsaved data will be discarded. Are you sure?", function(result){ 
            result ? window.location.replace("index") : "";
        });
    });
});
SCRIPT;
$this->registerJs($js);
?>