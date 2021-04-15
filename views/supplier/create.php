<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsSupplier */

$this->title = 'Supplier Information';
$this->params['breadcrumbs'][] = ['label' => 'Supplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-supplier-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlAllProduct = yii\helpers\Url::to(['supplier/getall']);

$js = <<< SCRIPT
var urlAllProduct = '$urlAllProduct';
        
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
        
        var name = $('.supplierName').val();
        isGettingData = true;
        checkSimilar(urlAllProduct, 'Supplier', name, function(confirmed){
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