<?php
$this->title = 'Tri Wulan Report';
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
    $('#product').hide();});
        
SCRIPT;
$this->registerJs($js);
?> 





