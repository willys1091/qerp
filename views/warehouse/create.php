<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MsWarehouse */

$this->title = 'Warehouse Information';
$this->params['breadcrumbs'][] = ['label' => 'Warehouse', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-warehouse-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$urlGetAll = yii\helpers\Url::to(['warehouse/getall']);
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
        
        var name = $('.warehouseName').val();
        isGettingData = true;
        checkSimilar(urlGetAll, 'Warehouse', name, function(confirmed){
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