<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\Gltogl;
use app\models\Gltogldetail;
use app\models\TrJournalhead;
use kartik\widgets\ActiveForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * GltoglController implements the CRUD actions for Gltogl model.
 */
class GltoglController extends MainController
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
     * Lists all Gltogl models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Gltogl();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->gltoglDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * Displays a single Gltogl model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Gltogl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gltogl();
        $model->joinDebitDetail = [];
        $model->joinCreditDetail = [];
        $model->gltoglDate = date('d-m-Y');
        $model->createdBy = Yii::$app->user->identity->username;
        $model->createdDate = new Expression('NOW()');
        $model->editedBy = Yii::$app->user->identity->username;
        $model->editedDate = new Expression('NOW()');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if($this->saveModel($model, true)){
                return $this->redirect(['index']);
            }
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Gltogl model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            
            
            if ($this->saveModel($model, false)) {
                $model->save();
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model
        ]);
    }

    /**
     * Deletes an existing Gltogl model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {  
        $transaction = Yii::$app->db->beginTransaction();    
        $model = TrJournalhead::find()->where(['refNum' => $id])->one();
        if(!Gltogldetail::deleteAll('gltoglNum = :gltoglNum', [":gltoglNum" => $id])){
            
            Yii::$app->session->setFlash('error', "GL Code ".$id."Delete Failed");
            $transaction->rollBack();
            return $this->redirect(['index']); 
        }
        
        if(!$model){
            
            Yii::$app->session->setFlash('error', "GL Code ".$id."Delete Failed");
            $transaction->rollBack();
            return $this->redirect(['index']);
        } else {
            $model->delete();
        }
     
       
       
        if(!$this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('error', "GL Code ".$id."Delete Failed");
            $transaction->rollBack();
             return $this->redirect(['index']);
        }
        $transaction->commit();
        Yii::$app->session->setFlash('success', "GL Code ".$id." Success Delete");

       return $this->redirect(['index']);
    }

    /**
     * Finds the Gltogl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Gltogl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gltogl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function saveModel($model, $newTrans)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();

        if ($newTrans){
            $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
            $modelMonth = date("m",strtotime($model->gltoglDate)) - 1;

            $tempModel = Gltogl::find()
            ->where('SUBSTRING(gltoglNum, 8, 2) LIKE :gltoglDate',[
                    ':gltoglDate' => date("y",strtotime($model->gltoglDate))
            ])
            ->orderBy([new Expression("CAST(SUBSTRING(gltoglNum, '-3', '3') AS UNSIGNED) DESC")])
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/GL/".date("y",strtotime($model->gltoglDate))."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->gltoglNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/GL/".date("y",strtotime($model->gltoglDate))."/".$month[$modelMonth]."/".$temp;
            }
            $model->gltoglNum = $tempTransNum;
        }
        $model->voucherNum;
        $model->notes;
        $model->gltoglDate = AppHelper::convertDateTimeFormat($model->gltoglDate, 'd-m-Y', 'Y-m-d');

        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }
        
        Gltogldetail::deleteAll('gltoglNum = :gltoglNum', [":gltoglNum" => $model->gltoglNum]);

        if (empty($model->joinDebitDetail) || !is_array($model->joinDebitDetail) || count($model->joinDebitDetail) < 1) {
            $transaction->rollBack();
            return false;
        }
        if (empty($model->joinCreditDetail) || !is_array($model->joinCreditDetail) || count($model->joinCreditDetail) < 1) {
            $transaction->rollBack();
            return false;
        }

        foreach ($model->joinDebitDetail as $debitDetail) {
            $debitDetailModel = new Gltogldetail();
            $debitDetailModel->gltoglNum = $model->gltoglNum;
            $debitDetailModel->coaNo = $debitDetail['debitID'];
            $debitDetailModel->currencyID = $debitDetail['debitCurrency'];
            $debitDetailModel->rate = str_replace(",",".",str_replace(".","",$debitDetail['debitRate']));
            $debitDetailModel->debitAmount = str_replace(",",".",str_replace(".","",$debitDetail['debitAmount']));

            if (!$debitDetailModel->save()) {
                $transaction->rollBack();
                return false;
            }
        }
        foreach ($model->joinCreditDetail as $creditDetail) {
            $creditDetailModel = new Gltogldetail();
            $creditDetailModel->gltoglNum = $model->gltoglNum;
            $creditDetailModel->coaNo = $creditDetail['creditID'];
            $creditDetailModel->currencyID = $creditDetail['creditCurrency'];
            $creditDetailModel->rate = str_replace(",",".",str_replace(".","",$creditDetail['creditRate']));
            $creditDetailModel->creditAmount = str_replace(",",".",str_replace(".","",$creditDetail['creditAmount']));

            if (!$creditDetailModel->save()) {
                $transaction->rollBack();
                return false;
            }
        }

        $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
        $journalRefNum = $model->gltoglNum;
        $mode = 11; 

        $command->bindParam(':refNum', $journalRefNum);
        $command->bindParam(':mode', $mode);
        $command->queryAll();
        
        $transaction->commit();
        
        return true;
    }
}
