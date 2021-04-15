<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsCoa */

$this->title = 'Coa Information';
$this->params['breadcrumbs'][] = ['label' => 'Coa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-coa-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlGetAll = yii\helpers\Url::to(['coa/getall?id='.$model->coaNo]);
$js = <<< SCRIPT
var urlGetAll = '$urlGetAll';
        
$(document).ready(function () {
    $('form').on('beforeSubmit', function () {
        $(this).find(':submit').prop('disabled', true);
    });
        
    var confirmSubmit = false;
    var isGettingData = false;
    $('form').on('submit', function(e){

        if (confirmSubmit)
        {
            return true;
        } else
        {
            e.preventDefault();
        }
        if (isGettingData) { return; }
        
        var name = $('form #mscoa-description').val();
        isGettingData = true;
        checkSimilar(urlGetAll, 'COA', name, function(confirmed){
            isGettingData = false;
            if (confirmed)
            {
                confirmSubmit = true;
                $('form').submit();
            } else
            {
                $('form button[type=submit]').prop('disabled', false);
            }
        });
    });
});
SCRIPT;
$this->registerJs($js);
?>