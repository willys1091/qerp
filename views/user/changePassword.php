<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form kartik\widgets\ActiveForm */
/* @var $model app\models\ChangePasswordForm */

$this->title = Yii::t('app', 'Changes Password');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary box-solid">
    <?php $form = ActiveForm::begin([]); ?>
    <div class="box-header with-border qwinjaya-header">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="panel panel-default">
            <div class="panel-body">

                <?= $form->field($model, 'currentPassword')->passwordInput() ?>

                <?= $form->field($model, 'newPassword')->passwordInput() ?>

                <?= $form->field($model, 'repeatPassword')->passwordInput() ?>

            </div>
            <div class="panel-footer">
                <div class="pull-right">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-save"> Save </i>', ['class' => 'btn btn-primary btnSave']) ?>
                    <?= Html::a('<i class="glyphicon glyphicon-remove"> Cancel </i>', ['index'], ['class' => 'btn btn-danger']) ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div></div>
</div>
<?php ActiveForm::end(); ?>