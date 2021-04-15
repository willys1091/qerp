<?php

use app\models\HsCode;
use app\models\PackingType;
use app\models\Product;
use app\models\ProductCategory;
use app\models\ProductSubCategory;
use app\models\Supplier;
use app\models\Uom;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Product */
/* @var $form ActiveForm */
?>

<div class="product-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'productName')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'supplierID')->dropDownList(ArrayHelper::map(Supplier::findActive(), 'supplierID', 'supplierName'),[
                        'prompt' => 'Select '.$model->getAttributeLabel('supplierID')
                    ]) ?>
                </div>                
                <div class="col-md-3">
                    <?= $form->field($model, 'origin')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">            
                <div class="col-md-3">
                    <?= $form->field($model, 'productCategoryID')->dropDownList(ArrayHelper::map(ProductCategory::findActive(), 'productCategoryID', 'productCategoryName'),[
                        'prompt' => 'Select '.$model->getAttributeLabel('productCategoryID')
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'productSubCategoryID')->dropDownList(ArrayHelper::map(ProductSubCategory::findActive(), 'productSubCategoryID', 'productSubCategoryName'),[
                        'prompt' => 'Select '.$model->getAttributeLabel('productSubCategoryID')
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'flagOOT')->dropDownList([
                        '0' => 'Non-OOT',
                        '1' => 'OOT'
                    ],[
                        'prompt' => 'Select '.$model->getAttributeLabel('flagOOT')
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'hsCodeID')->dropDownList(ArrayHelper::map(HsCode::findActive(), 'hsCodeID', 'hsCode'),[
                        'prompt' => 'Select '.$model->getAttributeLabel('hsCodeID')
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'minQty')->textInput([
                            'class' => 'form-control input-decimal text-right',
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'uomID')->dropDownList(ArrayHelper::map(Uom::findActive(), 'uomID', 'uomName'),[
                        'prompt' => 'Select '.$model->getAttributeLabel('uomID')
                    ]) ?>
                </div>             
                <div class="col-md-3">
                    <?= $form->field($model, 'packingTypeID')->dropDownList(ArrayHelper::map(PackingType::findActive(), 'packingTypeID', 'packingTypeName'),[
                        'prompt' => 'Select '.$model->getAttributeLabel('packingTypeID')
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'uomPackingTypeQty')->textInput([
                            'class' => 'form-control input-decimal text-right',
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'notes')->textArea([
                        'rows' => 3
                    ]) ?>
                </div> 
            </div>
        </div>
        <div class="panel-footer">
            <div class="text-right">
                <?= Html::submitButton('<i class="glyphicon glyphicon-save"></i> Save', ['class' => 'btn btn-primary btnSave']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-remove"></i> Cancel', ['index'], ['class' => 'btn btn-danger']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>