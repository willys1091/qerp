<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsDocumenttype */

$this->title = 'Document Type Information';
$this->params['breadcrumbs'][] = ['label' => 'Document Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-documenttype-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlGetAll = yii\helpers\Url::to(['documenttype/getall']);
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
        
        var name = $('form #msdocumenttype-documenttypename').val();
        isGettingData = true;
        checkSimilar(urlGetAll, 'Document Type', name, function(confirmed){
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