<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class MainController extends Controller
{
    public function beforeAction($action) {
        if (!parent::beforeAction($action))
        {
            return false;
        }
        
        if (!Yii::$app->user->identity)
        {
            $this->redirect(['site/login']);
            return false;
        }
        
        return true;
    }
}