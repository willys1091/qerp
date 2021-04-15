<?php

namespace app\controllers;

use Yii;
use app\models\MsUseraccess;
use app\models\LkAccesscontrol;
use app\models\LkFilteraccess;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\widgets\ActiveForm;
use yii\web\Response;
use app\components\AppHelper;
use yii\db\Expression;
use yii\filters\AccessControl;
use app\components\MdlDb;

class UserAccessController extends MainController
{
    public function actionIndex()
    {
        $model = new MsUseraccess();

        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model
        ]);
    }
    public function actionCreate()
    {
        $model = new MsUseraccess();
		$model->joinMsUserAccess = [];
        $connection = MdlDb::getDbConnection();
        $sql = "SELECT DISTINCT a.accessID, b.description, 0 AS viewAcc, 0 AS insertAcc, 0 AS updateAcc, 0 AS deleteAcc
                FROM lk_filteraccess a
                JOIN lk_accesscontrol b on a.accessID = b.accessID
                LEFT JOIN ms_useraccess c on b.accessID = c.accessID 
                ORDER BY b.description";
        $temp = $connection->createCommand($sql);
        $headResult = $temp->queryAll();
        $i = 0;
        foreach ($headResult as $headMenu) {
            $model->joinMsUserAccess[$i]["ID"] = "0";
            $model->joinMsUserAccess[$i]["accessID"] = $headMenu['accessID'];
            $model->joinMsUserAccess[$i]["description"] = $headMenu['description'];
			$model->joinMsUserAccess[$i]["viewValue"] = ($headMenu['viewAcc'] ? 1 : 0);
            $model->joinMsUserAccess[$i]["viewAcc"] = ($headMenu['viewAcc'] > 0 ? "checked" : "");
			$model->joinMsUserAccess[$i]["insertValue"] =($headMenu['insertAcc'] ? 1 : 0);
			$model->joinMsUserAccess[$i]["insertAcc"] = ($headMenu['insertAcc'] > 0 ? "checked" : "");
			$model->joinMsUserAccess[$i]["updateValue"] = ($headMenu['updateAcc'] ? 1 : 0);
			$model->joinMsUserAccess[$i]["updateAcc"] = ($headMenu['updateAcc'] > 0 ? "checked" : "");
			$model->joinMsUserAccess[$i]["deleteValue"] = ($headMenu['deleteAcc'] ? 1 : 0);
			$model->joinMsUserAccess[$i]["deleteAcc"] = ($headMenu['deleteAcc'] > 0 ? "checked" : "");
        $i += 1;
        }
		
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            if($this->saveModel($model)){
            	return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
		
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        $connection = MdlDb::getDbConnection();
        $sql = "SELECT DISTINCT c.ID, a.accessID, b.description, IFNULL(c.viewAcc,0) AS viewAcc, IFNULL(c.insertAcc,0) AS insertAcc , 
                IFNULL(c.updateAcc,0) AS updateAcc, IFNULL(c.deleteAcc,0) AS deleteAcc
                FROM lk_filteraccess a
                JOIN lk_accesscontrol b on a.accessID = b.accessID
                LEFT JOIN ms_useraccess c on b.accessID = c.accessID 
                where c.userRole = '" .$id . "'
                ORDER BY b.description";
        $temp = $connection->createCommand($sql);
        $headResult = $temp->queryAll();

        $i = 0;
        foreach ($headResult as $headMenu) {
            $model->joinMsUserAccess[$i]["ID"] = $headMenu['ID'];
			$model->joinMsUserAccess[$i]["accessID"] = $headMenu['accessID'];
            $model->joinMsUserAccess[$i]["description"] = $headMenu['description'];
			$model->joinMsUserAccess[$i]["viewValue"] = ($headMenu['viewAcc'] ? 1 : 0);
            $model->joinMsUserAccess[$i]["viewAcc"] = ($headMenu['viewAcc'] > 0 ? "checked" : "");
			$model->joinMsUserAccess[$i]["insertValue"] =($headMenu['insertAcc'] ? 1 : 0);
			$model->joinMsUserAccess[$i]["insertAcc"] = ($headMenu['insertAcc'] > 0 ? "checked" : "");
			$model->joinMsUserAccess[$i]["updateValue"] = ($headMenu['updateAcc'] ? 1 : 0);
			$model->joinMsUserAccess[$i]["updateAcc"] = ($headMenu['updateAcc'] > 0 ? "checked" : "");
			$model->joinMsUserAccess[$i]["deleteValue"] = ($headMenu['deleteAcc'] ? 1 : 0);
			$model->joinMsUserAccess[$i]["deleteAcc"] = ($headMenu['deleteAcc'] > 0 ? "checked" : "");
            $i += 1;
        }
		
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveModel($model)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDelete($id)
    {
        $model = MsUseraccess::find()->where('userRole = "'.$id.'"')->all();
        foreach ($model as $key) {
            $key->flagActive = 0;
            $key->save();
        }
        return $this->redirect(['index']);
    }
    public function actionRestore($id)
    {
        $model = MsUseraccess::find()->where('userRole = "'.$id.'"')->all();
        foreach ($model as $key) {
            $key->flagActive = 1;
            $key->save();
        }
        return $this->redirect(['index']);
    }
    
    protected function findModel($id)
    {
        if (($model = MsUseraccess::findOne(['userRole'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function saveModel($model)
    {
        $connection = MdlDb::getDbConnection();
        $transaction =  $connection->beginTransaction();
        
        $userAccessModel = MsUseraccess::find()
                            ->where(["userRole" => $model->userRole])
                            ->all();

        if($userAccessModel != null){
            foreach ($model->joinMsUserAccess as $userAccess) {
                $modelUserAccess = MsUseraccess::findOne(['ID' => $userAccess['ID']]);
                $modelUserAccess->userRole = $model->userRole;
                $modelUserAccess->accessID = $userAccess['accessID'];
                $modelUserAccess->indexAcc = $userAccess['viewValue'];
                $modelUserAccess->viewAcc = $userAccess['viewValue'];
                $modelUserAccess->insertAcc = $userAccess['insertValue'];
                $modelUserAccess->updateAcc = $userAccess['updateValue'];
                $modelUserAccess->deleteAcc = $userAccess['deleteValue'];
                
                $modelUserAccess->flagActive = 1;

                if (!$modelUserAccess->save()) {
                    print_r($modelUserAccess->getErrors());
                    $transaction->rollBack();
                    return false;
                } 
                
            } 
        }
        else{
            foreach ($model->joinMsUserAccess as $userAccess) {
                $modelUserAccess = new MsUseraccess();
                $modelUserAccess->userRole = $model->userRole;
                $modelUserAccess->accessID = $userAccess['accessID'];
                $modelUserAccess->indexAcc = $userAccess['viewValue'];
                $modelUserAccess->viewAcc = $userAccess['viewValue'];
                $modelUserAccess->insertAcc = $userAccess['insertValue'];
                $modelUserAccess->updateAcc = $userAccess['updateValue'];
                $modelUserAccess->deleteAcc = $userAccess['deleteValue'];
                
                $modelUserAccess->flagActive = 1;

                if (!$modelUserAccess->save()) {
                    print_r($modelUserAccess->getErrors());
                    $transaction->rollBack();
                    return false;
                } 
                
            } 
        }
        
            
        $transaction->commit(); 
        return true;
    }
}
