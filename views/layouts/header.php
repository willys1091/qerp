<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

   <?= Html::a('<span class="logo-mini">'.Html::img('@web/assets_b/images/logonew.png', ['alt' => 'pic not found','width' => '40px','height' => '50px']).'</span><span class="logo-lg">PT. Qwinjaya Aditama</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <ul class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span><?= Yii::$app->user->identity->username; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <?=
                            Html::a(
                                'Change Password', ['/user/changepassword'], ['data-method' => 'post', 'class' => '']
                            )
                            ?>
                        </li>
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Logout'),
                                ['/site/logout'],
                                ['data-method' => 'post', 'class' => '']
                            ) ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </ul>
    </nav>
</header>
