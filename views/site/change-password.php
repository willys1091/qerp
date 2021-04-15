<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChangePasswordForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
    'options' => [
        'role' => 'form'
    ]
]);
?>
<div class="change-pasword-form">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo Yii::t('app', 'Password Information') ?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'currentPassword')->passwordInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'newPassword')->passwordInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'repeatPassword')->passwordInput() ?>
                </div>
            </div>
        </div>
        <div class="box-footer text-right">
            <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-danger', 'style' => 'width: 100px;']) ?>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'style' => 'width: 100px;']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
