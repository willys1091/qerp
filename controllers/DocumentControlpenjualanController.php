<?php

namespace app\controllers;

use Yii;
use app\models\TrDocumentcontrolhead;
use app\models\TrDocumentcontroldetail;
use app\models\MsDocumenttype;
use app\models\TrPurchaseorderhead;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use kartik\form\ActiveForm;
use yii\web\response;
use app\components\AppHelper;
use app\components\MdlDb;
use yii\base\Model;
use yii\web\UploadedFile;

class DocumentControlpenjualanController extends MainController{
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

    public function actionIndex(){
        $model = new TrDocumentcontrolhead(['scenario' => 'search']);
        $model->load(Yii::$app->request->queryParams);
        return $this->render('index', [
            'model' => $model,
        ]); 
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing TrDocumentcontrolhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->view->params['browse'] = true;
        $params = Yii::$app->request->get('id');
        $params = explode("?",$params);
        $refNum = $params[0];
        $docType = 2;
        $docModel = TrDocumentcontrolhead::find()
                    ->joinWith('documentDetail')
                    ->where(['=', 'tr_documentcontrolhead.refNum', $refNum])
                    ->count();
        $detailModel = MsDocumenttype::find()
                                    ->where(['lkDocumentTypeID' => $docType])
                                    ->all();
        if($docModel == 0){
            $model = new TrDocumentcontrolhead();
        }
        else{
            $model = TrDocumentcontrolhead::find()
                    ->where(['=', 'tr_documentcontrolhead.refNum', $refNum])
                    ->one();

        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->lkDocumentTypeID = $docType;
            $model->refNum = $refNum;
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if (!$model->save()) {
                var_dump($model->getErrors());
            }
            $headID = $model->docControlHeadID;
            $i = 0;
            foreach($model->documentFiles as $files){
                if($file = UploadedFile::getInstance($model, 'documentFiles['.$i.']')){
                    $documentID = $model->documentID[$i];
                    $refNum = str_replace("/","-",$refNum);
                    $fileName = $refNum."_".$documentID.".pdf";
                    $filePath = Yii::$app->basePath.'/assets_b/uploads/document/'. $fileName;
         
                    $file->saveAs($filePath);
                   
                    $modelDetail = new TrDocumentcontroldetail();
                    $modelDetail->docControlHeadID = $headID;
                    $modelDetail->documentTypeID = $documentID;
                    $modelDetail->document = $fileName;
                    if (!$modelDetail->save()) {
                        var_dump($modelDetail->getErrors());
                    }
                }
                $i++;
            }
            
            // Yii::$app->end();
        }
        $this->layout = 'browseLayout';
        return $this->render('update', [
                'detailModel' => $detailModel,
                'model' => $model
        ]);
    }
    public function actionGetImage($fileName) {
        $extension = end(explode(".", $fileName));
        $response = Yii::$app->getResponse();
        if ($extension == 'pdf'){
           $response->headers->set('Content-Type', 'application/pdf');
        }
        
        
        $response->format = Response::FORMAT_RAW;
        $imgFullPath = Yii::$app->basePath . '/assets_b/uploads/document/' . $fileName;

        if (file_exists($imgFullPath)) {
            if (!is_resource($response->stream = fopen($imgFullPath, 'r'))) {
                throw new ServerErrorHttpException('file access failed: permission deny');
            }
        } else {
            throw new NotFoundHttpException();
        }

        $response->send();
    }
    /**
     * Deletes an existing TrDocumentcontrolhead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionDeleteDetail ($id)
    {
        if (!Yii::$app->request->post('key'))
        {
            throw new \yii\web\NotFoundHttpException("Failed to delete, no key provided");
        }
        
        $fileName = Yii::$app->request->post('key');
        $file = Yii::getAlias("@webroot/assets_b/uploads/document/$fileName");
        
        $fileExist = false;
        if(file_exists($file))
        {
            $fileExist = true;
            unlink($file);
        }
        
        $detailModel = TrDocumentcontroldetail::find()
            ->where(['docControlDetailID' => $id])
            ->one();
        if (!$detailModel)
        {
            if ($fileExist)
            {
                throw new \yii\web\NotFoundHttpException("File is deleted, but found no data in database");
            } else
            {
                throw new \yii\web\NotFoundHttpException("File not exist, and found no data in database");
            }
        }
        
        $detailModel->delete();
        
        return true;
    }
    
    public function actionBrowse()
    {
        $this->view->params['browse'] = true;
        $model = new TrPurchaseorderhead();
        $model->load(Yii::$app->request->queryParams);
    
        return $this->render('browse', [
                'model' => $model
        ]);
    }
    public function actionCheck()
    {
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $docType = $data['docType'];

            $detailModel = MsDocumenttype::find()
                                        ->where(['lkDocumentTypeID' => $docType])
                                        ->all();

            if ($detailModel !== null){
                $i = 0;
                foreach ($detailModel as $documentDetail) {
                    $result[$i]["docTypeID"] = $documentDetail->documentTypeID;
                    $result[$i]["docTypeName"] = $documentDetail->documentTypeName;
                    $result[$i]["flagMandatory"] = $documentDetail->flagMandatory;

                    $i += 1;
                }
            }
        }

        return \yii\helpers\Json::encode($result);
    }

    /**
     * Finds the TrDocumentcontrolhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrDocumentcontrolhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrDocumentcontrolhead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findDocument(){
                
        $this->joinDocumentDetail = [];
        $i = 0;
        foreach ($this->getMasterDocument()->all() as $joinDocumentDetail) {
            $this->joinPurchaseOrderDetail[$i]["document"] = $joinPurchaseOrderDetail->document;
            $i += 1;
        }
    }

    protected function saveModel($model)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();

        if( $documentFiles = UploadedFile::getInstances($model, 'documentFiles')){
            //echo "string";
            //Yii::$app->end();
            foreach ($documentFiles as $file) {
                $ktpFileName = Yii::$app->basePath.'/assets_b/uploads/document/'. $file .'pdf';
                $file->saveAs($ktpFileName);
            }
        }
        

        if (!$model->save()) {
            $transaction->rollBack();
            return false;
        }
        TrDocumentcontroldetail::deleteAll('docControlHeadID = :docControlHeadID', [":docControlHeadID" => $model->docControlHeadID]);
        
        $documentDetailModel = new TrDocumentcontroldetail();
        $documentDetailModel->docControlHeadID = $model->docControlHeadID;
        $documentDetailModel->documentTypeID = 2;
        $documentDetailModel->document = $model->documentFiles;

        // echo "<pre>";
        // var_dump($documentDetailModel);
        // echo "</pre>";
        // Yii::$app->end();

        if (!$documentDetailModel->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
