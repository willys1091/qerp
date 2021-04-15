<?php
use yii\helpers\Html;

dmstr\web\AdminLteAsset::register($this);
app\assets_b\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="<?= Yii::getAlias('@web').'/assets_b/images/logonew.png' ?>">
    <?php $this->head() ?>
</head>
<body class="login-page" style="background: url('<?= Yii::getAlias('@web').'/assets_b/images/login-bg.jpg' ?>'); overflow:hidden">
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
