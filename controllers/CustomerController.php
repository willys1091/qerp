<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\ControllerUAC;
use app\components\MdlDb;
use app\models\CustomerDetail;
use app\models\MsCustomer;
use app\models\MsCustomerdetail;
use kartik\form\ActiveForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\response;


/**
 * CustomerController implements the CRUD actions for MsCustomer model.
 */
class CustomerController extends MainController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MsCustomer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new MsCustomer();
        $model->flagActive = 1;
        
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single MsCustomer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {      
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MsCustomer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsCustomer();
        $model->joinMsCustomerDetail = [];
        $model->flagActive = 1;
        $model->tax = 1;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
            
        if ($model->load(Yii::$app->request->post())) {
            $model->creditLimit = str_replace(",",".",str_replace(".","",$model->creditLimit));
            $model->npwpRegisteredDate = AppHelper::convertDateTimeFormat($model->npwpRegisteredDate, 'd-m-Y', 'Y-m-d');
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if ($this->saveModel($model)) {
                  return $this->redirect(['index']);
            } 
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MsCustomer model.
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
            $model->creditLimit = str_replace(",",".",str_replace(".","",$model->creditLimit));
            $model->npwpRegisteredDate = AppHelper::convertDateTimeFormat($model->npwpRegisteredDate, 'd-m-Y', 'Y-m-d');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            if ($this->saveModel($model)) {
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
            $customerID = $data['customerID'];

            $detailModels = MsCustomerdetail::find()->select('customerDetailID, contactPerson')->where(['customerID'=>$customerID])->all();

            $data = array();
            foreach ($detailModels as $detailModel) {
                $temp["id"] = $detailModel->contactPerson;
                $temp["text"] = $detailModel->contactPerson;
                array_push($data, $temp);
            }
        }

        return Json::encode($data);
    }

    public function actionGetCustomerdetailpic()
    {
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $customerID = $data['customerID'];

            $detailModels = MsCustomerdetail::find()->select('customerDetailID, contactPerson')->where(['customerID'=>$customerID])->all();

            $data = array();
            foreach ($detailModels as $detailModel) {
                $temp["id"] = $detailModel->customerDetailID;
                $temp["text"] = $detailModel->contactPerson;
                array_push($data, $temp);
            }
        }

        return Json::encode($data);
    }
    
    /**
     * Deletes an existing MsCustomer model.
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

    public function actionCheck()
    {
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $customerID = $data['customerID'];
            
            $detailModel = MsCustomer::findOne($customerID);
            if ($detailModel !== null){
                $dueDateDays = $detailModel->dueDate;
                $taxs = $detailModel->tax;
                $dueDate = date('d-m-Y', strtotime("+".$dueDateDays." days"));

            }
        }

        return Json::encode([$dueDate, $taxs]);
    }
    /**
     * Finds the MsCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsCustomer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGetall()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $result = MsCustomer::find()
                ->select(['ms_customer.customerName AS name'])
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
            Yii::$app->end();
            $transaction->rollBack();
            return false;
        }   
      
        $detailModel = MsCustomerdetail::find(['customerID' => $model->customerID])->all();
        if($detailModel != null){
            if(sizeof($model->joinMsCustomerDetail) >= 0){
                $allContactID = array();
                foreach ($model->joinMsCustomerDetail as $msCustomerDetail) {
                    if($msCustomerDetail['customerDetailID'] == '0'){
                        $msCustomerDetailModel = new MsCustomerdetail();
                        $msCustomerDetailModel->customerID = $model->customerID;
                    }
                    else{
                        $msCustomerDetailModel = MsCustomerdetail::findOne(['customerDetailID' => $msCustomerDetail['customerDetailID']]);
                    }
                    $msCustomerDetailModel->nickname = $msCustomerDetail['nickname'];
                    $msCustomerDetailModel->contactPerson = $msCustomerDetail['contactPerson'];
                    $msCustomerDetailModel->addressType = $msCustomerDetail['addressType'];
                    $msCustomerDetailModel->country = $msCustomerDetail['country'];
                    $msCustomerDetailModel->city = $msCustomerDetail['city'];
                    $msCustomerDetailModel->street = $msCustomerDetail['street'];
                    $msCustomerDetailModel->postalCode = $msCustomerDetail['postalCode'];
                    $msCustomerDetailModel->phone = $msCustomerDetail['phone'];
                    $msCustomerDetailModel->fax = $msCustomerDetail['fax'];
                    $msCustomerDetailModel->email = $msCustomerDetail['email'];
                                 
                    if (!$msCustomerDetailModel->save()) {
                        print_r($msCustomerDetailModel->getErrors());
                        $transaction->rollBack();
                        return false;
                    }
                    array_push($allContactID, $msCustomerDetailModel->customerDetailID);
                }
                $deleteModel = MsCustomerdetail::find()
                        ->where(['customerID' => $model->customerID])
                        ->andWhere(['not in','customerDetailID',$allContactID])
                        ->all();
                foreach ($deleteModel as $item) {
                    $item->delete();
                }
            }
        }
        else{
            foreach ($model->joinMsCustomerDetail as $msCustomerDetail) {
                $msCustomerDetailModel = new MsCustomerdetail();
                $msCustomerDetailModel->customerID = $model->customerID;
                $msCustomerDetailModel->contactPerson = $msCustomerDetail['contactPerson'];
                $msCustomerDetailModel->nickname = $msCustomerDetail['nickname'];
                $msCustomerDetailModel->addressType = $msCustomerDetail['addressType'];
                $msCustomerDetailModel->country = $msCustomerDetail['country'];
                $msCustomerDetailModel->city = $msCustomerDetail['city'];
                $msCustomerDetailModel->street = $msCustomerDetail['street'];
                $msCustomerDetailModel->postalCode = $msCustomerDetail['postalCode'];
                $msCustomerDetailModel->phone = $msCustomerDetail['phone'];
                $msCustomerDetailModel->fax = $msCustomerDetail['fax'];
                $msCustomerDetailModel->email = $msCustomerDetail['email'];
                             
                if (!$msCustomerDetailModel->save()) {
                    print_r($msCustomerDetailModel->getErrors());
                    $transaction->rollBack();
                    return false;
                }
            }   
        }
        
                
        $transaction->commit(); 
        return true;
    }
    
     public function actionGetPics($selected = "") {
        $request = Yii::$app->request;
        if ($request->post('depdrop_parents')) {
            $parents = $request->post('depdrop_parents');
            if ($parents != null) {
                $customerID = $parents[0];
                $listData = CustomerDetail::getListData($customerID);
                $result = [];
                foreach ($listData as $customerDetailID => $contactPerson) {
                    $result[] = [
                        "id" => $customerDetailID,
                        "name" => $contactPerson
                    ];
                }
                if ($request->post('depdrop_params')) {
                    $params = $request->post('depdrop_params');
                    Yii::info($params);
                    $selected = $params[0];
                }
                
                echo Json::encode(['output' => $result, 'selected' => $selected]);
                return;
            }
            
            echo Json::encode(['output' => '', 'selected' => '']);
        }
    }
    
}
