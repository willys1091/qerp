<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */
if($update){
  $this->title = 'Update Goods Receipt History: ' . $model->goodsReceiptNum;  
} else {
  $this->title = 'Update Pending Goods Receipt: ' . $model->goodsReceiptNum; 
}

$this->params['breadcrumbs'][] = ['label' => 'Goods Receipt History', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goodsReceiptNum, 'url' => ['view', 'id' => $model->goodsReceiptNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-goodsreceipthead-update">

    <?= $this->render('_form', [
        'model' => $model,
        'update' => $update,
    ]) ?>

</div>
<?php

$js = <<< SCRIPT

$(document).ready(function(){
    var update =  $update
    console.log(update);
    if(update){
        
        $('.goodsDetailHsCode ').prop('disabled', true);
        
    }
});
SCRIPT;
$this->registerJs($js);
