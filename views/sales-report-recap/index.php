<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Recap Report';
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
    $('#salesreport-yearse').change(function(){
    
        var Yend = $(this).val();
        var Ystart = $('#salesreport-yearss').val();
        if (Ystart > Yend){
            errorMsg = "Year Start must be large to Year End";
            bootbox.alert(errorMsg);
            $('.btnPrint').hide();
            return false;
        } else {
            $('.btnPrint').show();
        }
    });
});
    
SCRIPT;
$this->registerJs($js);

?> 