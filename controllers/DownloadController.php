<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class DownloadController extends Controller {

    public function init() {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }
    }

    public function actionTemplatePetty() {
        $path = Yii::getAlias('@webroot') . '/assets_b/downloads/excel/PETTY_TEMPLATE.xlsx';
        Yii::$app->response->sendFile($path);
    }

}
