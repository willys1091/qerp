<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrPurchaseordernoninventoryhead */

$this->title = 'View Purchase Order Non Inventory'. $model->purchaseOrderNonInventoryNum;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order Non Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->purchaseOrderNonInventoryNum, 'url' => ['view', 'id' => $model->purchaseOrderNonInventoryNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-purchaseorderhead-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
<?php

$js = <<< SCRIPT
$(document).ready(function(){
    $(':input').prop('disabled', true);
});
SCRIPT;
$this->registerJs($js);
