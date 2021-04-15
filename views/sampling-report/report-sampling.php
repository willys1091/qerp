<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrSamplereceipthead */

$this->title = 'Report Sampling';
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
    $('#samplingreport-typereport').change(function(){
        var selectedValue = $(this).val();
        if (selectedValue == "List of Sample For Customer"){
            $('#customer').show(); 
        }
        else{
             $('#customer').hide();
        }
    });
});
        
SCRIPT;
$this->registerJs($js);

?> 
