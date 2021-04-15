<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsProduct */

$this->title = 'Product Information';
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-product-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlAllProduct = yii\helpers\Url::to(['product/getall']);

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
        
        var productName = $('form #msproduct-productname').val();
        isGettingData = true;
        checkSimilarr(urlAllProduct, 'Product', productName, function(confirmed){
            isGettingData = false;
            if (confirmed)
            {
                $('form button[type=submit]').prop('disabled', true);
            } 
        });
    });
});
SCRIPT;
$this->registerJs($js);
?>