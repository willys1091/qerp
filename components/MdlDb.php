<?php
namespace app\components;

use Yii;
use yii\web\NotFoundHttpException;
use app\components\AppHelper;

class MdlDb extends \yii\web\Controller{
	
    public function getDbConnection(){
        return AppHelper::getDbConnection();
        /*
        $dbUser = new \yii\db\Connection([
                'dsn' => 'mysql:host=localhost;dbname=ptkd_qerp',
                'username' => 'root',
                'password' => '',
        ]);
        return $dbUser;
         * *.
         */
    }
}