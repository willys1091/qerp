<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsMarketing */

$this->title = 'Marketing Information';
$this->params['breadcrumbs'][] = ['label' => 'Marketing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-marketing-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlGetAll = yii\helpers\Url::to(['marketing/getall']);
$js = <<< SCRIPT
var urlGetAll = '$urlGetAll';
        
$(document).ready(function () {
        
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
        
        var name = $('form #msmarketing-marketingname').val();
        isGettingData = true;
        checkSimilar(urlGetAll, 'Marketing', name, function(confirmed){
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