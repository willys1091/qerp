<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use app\components\MdlDb;
use app\models\TrGoodsreceipthead;
use app\models\MsProduct;

$connection = MdlDb::getDbConnection();
$sql = 'SELECT year(`goodsReceiptDate`)AS year FROM `tr_goodsreceipthead`';
$command = $connection->createCommand($sql);
$result = $command->queryAll();

//$year = TrGoodsdeliveryhead::find()->select('goodsDeliveryDate')->distinct()->all();
//var_dump($result);
//yii::$app->end();
?>

<div class="tr-samplereceipthead-form">

    <?php $form = ActiveForm::begin([
            'id' => 'form-filter-report',
        ]); 
    ?>

    <div class="box box-primary box-solid">
        <div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'year')->dropDownList(ArrayHelper::map($result,'year','year'));
                            ?>                           
                        </div>                    
                        <div id="periode" class="col-md-6">
                            
                             <?=
                                $form->field($model, 'periode')->widget(Select2::classname(),[
                                    'data' => [
                                        '1' => 'January - March', 
                                        '2' => 'April - June',
                                        '3' => 'July - September',
                                        '4' => 'October - December'],
                                    'options' => [
                                        'prompt' => 'Select Periode',
                                        'class' => 'refNumInput-1'],
                                ]);
                            ?>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6" id="product">
                            <?= $form->field($model, 'product')->dropDownList(ArrayHelper::map(MsProduct::find()->distinct()->all(),'productID','productName'),[
                                    'options' => [
                                        'prompt' => 'Select All',                                        
                                    ],
                                ]);
                            ?>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group text-right">                
                    <?= Html::submitButton('<i class="glyphicon glyphicon-print"> Print </i>',['name'=>'btnPrint_PDF', 'class' => 'btn btn-primary btnPrint']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>