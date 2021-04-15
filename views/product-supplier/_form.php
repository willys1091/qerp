<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\AppHelper;
use app\models\MsSupplier;
use app\models\MsProduct;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MsTax */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-productsupplier-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="box box-primary box-solid">
		<div class="box-header with-border qwinjaya-header">
            <h3 class="box-title"></h3>
        </div>
		<div class="box-body md-col-4">
        <div class="row">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'productID')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(MsProduct::find(['flagActive' => 1])->orderBy(new yii\db\Expression("REPLACE(productName, ' ', '') ASC"))->all(), 'productID', 'productName'),
                                    'options' => [
                                        'prompt' => 'Select Product',
                                        'class' => 'productID'
                                    ],
                                ])

                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'supplierID')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(MsSupplier::find(['flagActive' => 1])->orderBy(new yii\db\Expression("REPLACE(supplierName, ' ', '') ASC"))->all(), 'supplierID', 'supplierName'),
                                    'options' => [
                                        'prompt' => 'Select Supplier',
                                        'class' => 'supplierID'
                                    ],
                                ])
                                ?>
                            </div>
                        </div>
			
				
		</div>
		<div class="box-footer">
			<div class="form-group text-right">
				<?php if (!isset($isView)): ?>
					<?= Html::submitButton('<i class="glyphicon glyphicon-save"> Save </i>', ['class' => 'btn btn-primary btnSave']) ?>
				<?php endif; ?>
				
				<?php if (!isset($isView)){ ?>
					<?= AppHelper::getCancelButton() ?>
				<?php } else { ?>
					<?= Html::a('<i class="glyphicon glyphicon-remove"> Cancel </i>', ['index'], ['class'=>'btn btn-danger']) ?>
				<?php } ?>
			</div>
		</div>
		
	</div>
	<?php ActiveForm::end(); ?>
    

</div>

