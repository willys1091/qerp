<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\AppHelper;

/* @var $this yii\web\View */
/* @var $model app\models\MsPackingtype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-packingtype-form">

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
                            <?= $form->field($model, 'packingTypeName')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'notes')->textArea(['maxlength' => true]) ?>
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