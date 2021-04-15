<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'View Goods Receipt History: ' . $model->goodsReceiptNum;
$this->params['breadcrumbs'][] = ['label' => 'Goods Receipt History', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goodsReceiptNum, 'url' => ['view', 'id' => $model->goodsReceiptNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-goodsreceipthead-view">
    <?=
    		$this->render($model->status == 0 ? '_form':'_formApproval', [
	        	'model' => $model,
	    	])
    		
    ?>

</div>
<?php

$js = <<< SCRIPT
$(document).ready(function(){
    $(':input').prop('disabled', true);
});
SCRIPT;
$this->registerJs($js);
