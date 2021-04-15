<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-samplereceipthead-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>


<?php
$js = <<< SCRIPT
$(document).ready(function(){
    $('#customer').hide();
    $('#product').hide();
    $('#supplier').hide();
   
    $('.salesReport').change(function(){
        var selectedValue = $(this).val();
        if (selectedValue == "Product"){
            $('#customer').hide();
            $('#supplier').hide();
            $('#product').show();
           
        }
        else if (selectedValue == "Customer"){
            $('#customer').show();
            $('#product').hide();
            $('#supplier').hide();
          
        }
        else if (selectedValue == "Supplier"){
            $('#customer').hide();
            $('#product').hide();
            $('#supplier').show();
          
        }
           
    });
   
});
    

    

        
SCRIPT;
$this->registerJs($js);

?> 