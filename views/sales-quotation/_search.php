<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;
?>

<div class="ms-appsetting-search">
    <div class="box-body" id="myForm">
        <div class="row">            
            &nbsp;&nbsp;<button ID="btnFilterSearch" class="btn btn-primary"><i class="fa fa-search"></i></button>            
        </div>
    </div>
    
    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'post',
    ]);
    ?>    
    <div class="box box-default" id="boxFilterSearch" style="display: none;">        
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'startDate')->widget(DatePicker::className(), [
                        'options' => [],
                        'pluginOptions' => ['format' => 'yyyy-mm-dd']
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'endDate')->widget(DatePicker::className(), [
                        'options' => [],
                        'pluginOptions' => ['format' => 'yyyy-mm-dd']
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<< SCRIPT
   
    $(document).ready(function () {
       $("#btnFilterSearch").click(function () {
        $("#boxFilterSearch").slideToggle();
    });

    });

SCRIPT;
$this->registerJs($js);
?>