<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsCustomer */

$this->title = 'Customer Information';
$this->params['breadcrumbs'][] = ['label' => 'Customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-customer-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlGetAll = yii\helpers\Url::to(['customer/getall']);
$js = <<< SCRIPT
var urlGetAll = '$urlGetAll';
$(document).ready(function (){
    var confirmSubmit = false;
    var isGettingData = false;
    $('form').on('submit', function(e)
    {
        if (!validated)
        {
            return false;
        }
        
        if (confirmSubmit)
        {
            return true;
        } else
        {
            e.preventDefault();
        }
        if (isGettingData) { return; }
        
        var name = $('form #mscustomer-customername').val();
        isGettingData = true;
        checkSimilar(urlGetAll, 'Customer', name, function(confirmed){
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