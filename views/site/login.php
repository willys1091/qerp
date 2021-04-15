<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'QERP - Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-box-body">
        <div class="login-logo">
            <a href="#">
               
				<?= Html::img('@web/assets_b/images/logonew.png', ['alt' => 'pic not found','width' => '108px','height' => '108px']); ?>  
            </a>
        </div>
        <p class="login-box-msg">Sign in to start your session</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?=
            $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput([
                'placeholder' => $model->getAttributeLabel('username'),
                'autocomplete' => 'off',                
            ])
        ?>

        <?=
            $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
        ?>

        <div class="row">
            <div class="col-xs-offset-8 col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>
        <div class="row">
            <div class="text-center" style="margin-top: 10px; font-weight: bold;">
        <?=
        Html::a('PT. Karya Digital', 'http://www.karyadigital.com', [
            'target' => '_blank'
        ])
        ?> &copy; <?= date('Y') ?>
            </div>
        </div>
<?php ActiveForm::end(); ?>
    </div>

</div>
