<?php

use app\components\AppHelper;
use app\controllers\SiteController;
use app\models\MsUser;
use app\models\MsUseraccess;
use kartik\form\ActiveField;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model MsUser */
/* @var $form ActiveForm2 */
?>

<div class="ms-user-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
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
                            <?= $form->field($model, 'username')->textInput([
                                'maxlength' => true,'placeholder'=>'',
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'fullName')->textInput([
                                'maxlength' => true, 
                            ]) ?>       
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder'=> $model->isNewRecord ? '' : 'Leave blank if not renewed.']) ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'userRole')->widget(Select2::classname(),[
                                    'data' => ArrayHelper::map(MsUseraccess::find ()->distinct()->all(), 'userRole', 'userRole' ),
                                    'options' => [
                                        'prompt' => 'Select User Role'],
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput([
                                'maxlength' => true,
                                'placeholder' => 'E-mail'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phoneNumber')->textInput([
                                'maxlength' => true,
                                'placeholder' => 'Phone Number'
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'dashboard')->widget(Select2::classname(),[
                                    'data' => SiteController::$dashboardList,
                                    'options' => [
                                        'prompt' => 'Select User Role'],
                                ]);
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
