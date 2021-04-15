<?php

use app\assets_b\AppAsset;
use app\components\JsBlock;
use dmstr\helpers\AdminLteHelper;
use dmstr\web\AdminLteAsset;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $content string */

AdminLteAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?= Url::to(["assets_b/images/logonew.png"]) ?>" rel="shortcut icon">
        <?= Html::csrfMetaTags() ?>
        <title>QERP - <?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition <?= AdminLteHelper::skinClass() ?> sidebar-mini sidebar-collapse">
        <?php $this->beginBody() ?>
        <div class="wrapper">            
            <div class="hidden">
                <?= Select2::widget(['name' => 'selectName']); ?>
            </div>
            <?= $this->render('header.php') ?>

            <?= $this->render('left.php') ?>

            <?= $this->render('content.php', ['content' => $content]) ?>

        </div>

        <div class="hidden">
            <?= Select2::widget(['name' => 'selectName']); ?>
        </div>

        <div id="ModalDialogContainer" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" >
                    <div id="ModalDialogBody">
                    </div>
                </div>
            </div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>