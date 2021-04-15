<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsProdukSupplier */

$this->title = 'Product Supplier';
$this->params['breadcrumbs'][] = ['label' => 'ProductSupplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-productsupplier-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlAllProduct = yii\helpers\Url::to(['product-supplier/getall']);

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
        
        var productID = $('form #mapproductsupplier-productid').val();
        isGettingData = true;
        checkSimilarr(urlAllProduct, 'Product Supplier', productID, function(confirmed){
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