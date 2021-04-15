<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TrGoodsreceipthead */

$this->title = 'View Internal Usage: ' . $model->internalUsageNum;
$this->params['breadcrumbs'][] = ['label' => 'Internal Usage', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->internalUsageNum, 'url' => ['view', 'id' => $model->internalUsageNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-goodsreceipthead-view">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php

$js = <<< SCRIPT
$(document).ready(function(){
    $(':input').prop('disabled', true);
});
SCRIPT;
$this->registerJs($js);
