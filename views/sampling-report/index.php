<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sampling Report';
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
    $('#samplingreport-typereport').change(function(){
        var selectedValue = $(this).val();
        if (selectedValue == "List of Sample For Customer"){
            $('#customer').show();
            $('#product').show();
            $('#supplier').hide();
        }
        else if (selectedValue == "Sample Stock Position"){
            $('#customer').hide();
            $('#product').show();
            $('#supplier').hide();
        }
        else if (selectedValue == "Sample Receipt"){
            $('#customer').hide();
            $('#supplier').show();
            $('#product').hide();
        }
        else{
            $('#customer').show();
            $('#product').hide();
            $('#supplier').hide();
        }        
    });
});
        
SCRIPT;
$this->registerJs($js);

?> 