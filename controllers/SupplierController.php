<?php

namespace app\controllers;

use Yii;
use app\models\MsSupplier;
use app\models\MsSuppliercontactdetail;
use app\models\MsSupplierdetail;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ControllerUAC;
use app\components\MdlDb;
use yii\filters\AccessControl;
use yii\db\Expression;
use app\components\AppHelper;

class SupplierController extends MainController{
    public function init(){
        if(Yii::$app->user->isGuest){
            $this->goHome();
        }
    }
  
    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MsSupplier::find(),
        ]);
        $model = new MsSupplier();
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionBrowse()
    {
        $this->view->params['browse'] = true;
        $model = new MsSupplier();
        $model->load(Yii::$app->request->queryParams);
    
        $this->layout = 'browseLayout';
        return $this->render('browse', [
                'model' => $model
        ]);
    }
    /**
     * Creates a new MsSupplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsSupplier();
        $model->joinMsSupplierContactDetail = [];
        $model->joinMsSupplierDetail = [];
        $model->flagActive = 1;
        $model->createdBy = Yii::$app->user->identity->username;
        $model->createdDate = new Expression('NOW()');
        $model->editedBy = Yii::$app->user->identity->username;
        $model->editedDate = new Expression('NOW()');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->npwpRegisteredDate = AppHelper::convertDateTimeFormat($model->npwpRegisteredDate, 'd-m-Y', 'Y-m-d');

            if ($this->saveModel($model)) {
                  return $this->redirect(['index']);
            } 
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsSupplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->npwpRegisteredDate = AppHelper::convertDateTimeFormat($model->npwpRegisteredDate, 'Y-m-d H:i:s', 'd-m-Y');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
       if ($model->load(Yii::$app->request->post())) {
            $model->npwpRegisteredDate = AppHelper::convertDateTimeFormat($model->npwpRegisteredDate, 'd-m-Y', 'Y-m-d');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            if ($this->updateModel($model)) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetContactPerson()
    {
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $supplierID = $data['supplierID'];

            $detailModels = MsSuppliercontactdetail::find()->select('contactPerson')->where(['supplierID'=>$supplierID])->all();

            $data = array();
            foreach ($detailModels as $detailModel) {
                $temp["id"] = $detailModel->contactPerson;
                $temp["text"] = $detailModel->contactPerson;
                array_push($data, $temp);
            }
        }

        return \yii\helpers\Json::encode($data);
    }

    /**
     * Deletes an existing MsSupplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->flagActive = 0;
        $model->save();

        return $this->redirect(['index']);
    }
    public function actionRestore($id)
    {
        $model = $this->findModel($id);

        $model->flagActive = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MsSupplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsSupplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsSupplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGetall()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $result = MsSupplier::find()
                ->select(['supplierName AS name'])
                ->asArray()
                ->all();
        
        return $result;
    }
    protected function saveModel($model)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        
        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }   
        
        foreach ($model->joinMsSupplierDetail as $msSupplierDetail) {
            $msSupplierDetailModel = new MsSupplierdetail();
            $msSupplierDetailModel->supplierDetailID = '';
            $msSupplierDetailModel->supplierID = $model->supplierID;
            $msSupplierDetailModel->bankName = $msSupplierDetail['bankName'];
            $msSupplierDetailModel->swiftCode = $msSupplierDetail['swiftCode'];
            $msSupplierDetailModel->accountNo = $msSupplierDetail['accountNo'];
            $msSupplierDetailModel->country = $msSupplierDetail['country'];
            $msSupplierDetailModel->city = $msSupplierDetail['city'];
            $msSupplierDetailModel->street = $msSupplierDetail['street'];
            $msSupplierDetailModel->postalCode = $msSupplierDetail['postalCode'];
                         
            if (!$msSupplierDetailModel->save()) {
                print_r($msSupplierDetailModel->getErrors());
                $transaction->rollBack();
                return false;
            }
        }   
        
        foreach ($model->joinMsSupplierContactDetail as $msSupplierContactDetail) {
            $msSupplierContactDetailModel = new MsSuppliercontactdetail();
            $msSupplierContactDetailModel->supplierID = $model->supplierID;
            $msSupplierContactDetailModel->nickname = $msSupplierContactDetail['nickname'];
            $msSupplierContactDetailModel->contactPerson = $msSupplierContactDetail['contactPerson'];
            $msSupplierContactDetailModel->position = $msSupplierContactDetail['position'];
                         
            if (!$msSupplierContactDetailModel->save()) {
                print_r($msSupplierContactDetailModel->getErrors());
                $transaction->rollBack();
                return false;
            }
        }   
                
        $transaction->commit(); 
        return true;
    }
    protected function updateModel($model)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();

        if (!$model->save()) {
            print_r($model->getErrors());
            Yii::$app->end();
            $transaction->rollBack();
            return false;
        }   
      
        $detailModel = MsSupplierdetail::find(['supplierID' => $model->supplierID])->all();
        if($detailModel != null){
            if(sizeof($model->joinMsSupplierDetail) >= 0){
                $allDetailID = array();
                foreach ($model->joinMsSupplierDetail as $msSupplierDetail) {
                    if($msSupplierDetail['supplierDetailID'] == '0'){
                        $msSupplierDetailModel = new MsSupplierdetail();
                        $msSupplierDetailModel->supplierID = $model->supplierID;
                    }
                    else{
                        $msSupplierDetailModel = MsSupplierdetail::findOne(['supplierDetailID' => $msSupplierDetail['supplierDetailID']]);
                    }
                    $msSupplierDetailModel->bankName = $msSupplierDetail['bankName'];
                    $msSupplierDetailModel->swiftCode = $msSupplierDetail['swiftCode'];
                    $msSupplierDetailModel->accountNo = $msSupplierDetail['accountNo'];
                    $msSupplierDetailModel->country = $msSupplierDetail['country'];
                    $msSupplierDetailModel->city = $msSupplierDetail['city'];
                    $msSupplierDetailModel->street = $msSupplierDetail['street'];
                    $msSupplierDetailModel->postalCode = $msSupplierDetail['postalCode'];
                                 
                    if (!$msSupplierDetailModel->save()) {
                        print_r($msSupplierDetailModel->getErrors());
                        $transaction->rollBack();
                        return false;
                    }
                    array_push($allDetailID, $msSupplierDetailModel->supplierDetailID);
                }
                $deleteModel = MsSupplierdetail::find()
                        ->where(['supplierID' => $model->supplierID])
                        ->andWhere(['not in','supplierDetailID',$allDetailID])
                        ->all();
                foreach ($deleteModel as $item) {
                    $item->delete();
                }
            }
        }
        else{
            foreach ($model->joinMsSupplierDetail as $msSupplierDetail) {
                $msSupplierDetailModel = new MsSupplierdetail();
                $msSupplierDetailModel->supplierID = $model->supplierID;
                $msSupplierDetailModel->bankName = $msSupplierDetail['bankName'];
                $msSupplierDetailModel->swiftCode = $msSupplierDetail['swiftCode'];
                $msSupplierDetailModel->accountNo = $msSupplierDetail['accountNo'];
                $msSupplierDetailModel->country = $msSupplierDetail['country'];
                $msSupplierDetailModel->city = $msSupplierDetail['city'];
                $msSupplierDetailModel->street = $msSupplierDetail['street'];
                $msSupplierDetailModel->postalCode = $msSupplierDetail['postalCode'];
                             
                if (!$msSupplierDetailModel->save()) {
                    print_r($msSupplierDetailModel->getErrors());
                    $transaction->rollBack();
                    return false;
                }
            }  
        }      

        $contactModel = MsSuppliercontactdetail::find(['supplierID' => $model->supplierID])->all();
        if($contactModel != null){
            if(sizeof($model->joinMsSupplierContactDetail) >= 0){
                $allContactID = array();
                foreach ($model->joinMsSupplierContactDetail as $msSupplierContactDetail) {
                    if($msSupplierContactDetail['supplierContactID'] == '0'){
                        $msSupplierContactDetailModel = new MsSuppliercontactdetail();
                        $msSupplierContactDetailModel->supplierID = $model->supplierID;
                    }
                    else{
                        $msSupplierContactDetailModel = MsSuppliercontactdetail::findOne(['supplierContactID' => $msSupplierContactDetail['supplierContactID']]);
                    }
                    $msSupplierContactDetailModel->nickname = $msSupplierContactDetail['nickname'];
                    $msSupplierContactDetailModel->contactPerson = $msSupplierContactDetail['contactPerson'];
                    $msSupplierContactDetailModel->position = $msSupplierContactDetail['position'];
                                 
                    if (!$msSupplierContactDetailModel->save()) {
                        print_r($msSupplierContactDetailModel->getErrors());
                        $transaction->rollBack();
                        return false;
                    }
                    array_push($allContactID, $msSupplierContactDetailModel->supplierContactID);
                }
                $deleteModel = MsSuppliercontactdetail::find()
                        ->where(['supplierID' => $model->supplierID])
                        ->andWhere(['not in','supplierContactID',$allContactID])
                        ->all();
                foreach ($deleteModel as $item) {
                    $item->delete();
                }
            }
        }
        else{
            foreach ($model->joinMsSupplierContactDetail as $msSupplierContactDetail) {
                $msSupplierContactDetailModel = new MsSuppliercontactdetail();
                $msSupplierContactDetailModel->supplierID = $model->supplierID;
                $msSupplierContactDetailModel->contactPerson = $msSupplierContactDetail['contactPerson'];
                $msSupplierContactDetailModel->nickname = $msSupplierContactDetail['nickname'];
                $msSupplierContactDetailModel->position = $msSupplierContactDetail['position'];
                             
                if (!$msSupplierContactDetailModel->save()) {
                    print_r($msSupplierContactDetailModel->getErrors());
                    $transaction->rollBack();
                    return false;
                }
            }   
        }     
                
        $transaction->commit(); 
        return true;
    }
}
