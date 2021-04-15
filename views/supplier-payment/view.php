<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */
$this->title = 'View Supplier Payment: ' . $model->supplierPaymentNum;
$this->params['breadcrumbs'][] = ['label' => 'Supplier Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->supplierPaymentNum, 'url' => ['view', 'id' => $model->supplierPaymentNum]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="tr-goodsreceipthead-view">
    <?= $this->render('_form', [
        'model' => $model,
        'isView' => 1,
    ]) ?>

</div>
<?php

$js = <<< SCRIPT
$(document).ready(function(){
    $(':input').prop('disabled', true);
});
SCRIPT;
$this->registerJs($js);
