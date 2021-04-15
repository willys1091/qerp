<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsSubcategory */

$this->title = 'Create Sub Category';
$this->params['breadcrumbs'][] = ['label' => 'Sub Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-subcategory-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlGetAll = yii\helpers\Url::to(['subcategory/getall']);
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
        
        var name = $('form #mssubcategory-subcategoryname').val();
        isGettingData = true;
        checkSimilar(urlGetAll, 'Sub Category', name, function(confirmed){
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