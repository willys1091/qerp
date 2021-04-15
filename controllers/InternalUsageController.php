<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsReason;
use app\models\MsUser;
use app\models\TrInternalusagedetail;
use app\models\TrInternalusagehead;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * InternalUsageController implements the CRUD actions for TrInternalusagehead model.
 */
class InternalUsageController extends MainController
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
     * Lists all TrInternalusagehead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrInternalusagehead();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->internalUsageDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrInternalusagehead model.
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
     * Creates a new TrInternalusagehead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrInternalusagehead();
        $model->joinStockDetail = [];
        $model->joinPurposeDetail = [];
        $modelPurpose = MsReason::find()->where('flagActive = 1')->all();
        $j = 0;
        foreach ($modelPurpose as $joinPurposeDetail) {
            $model->joinPurposeDetail[$j]["id"] = $joinPurposeDetail['mapReasonID'];
            $model->joinPurposeDetail[$j]["text"] = $joinPurposeDetail['mapReasonName'];
            $j += 1;
        }
        $model->internalUsageDate = date('d-m-Y');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->createdDate = new Expression('NOW()');
            $model->editedDate = new Expression('NOW()');
            $model->createdBy = Yii::$app->user->identity->username;
            $model->editedBy = Yii::$app->user->identity->username;

            if($this->saveModel($model, true)){
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing TrInternalusagehead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->joinPurposeDetail = [];
        $modelPurpose = MsReason::find()->all();
        $j = 0;
        foreach ($modelPurpose as $joinPurposeDetail) {
            $model->joinPurposeDetail[$j]["id"] = $joinPurposeDetail['mapReasonID'];
            $model->joinPurposeDetail[$j]["text"] = $joinPurposeDetail['mapReasonName'];
            $j += 1;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveModel($model, true)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model
        ]);
    }

    /**
     * Deletes an existing TrInternalusagehead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        TrInternalusagedetail::deleteAll('internalUsageNum = :internalUsageNum', [":internalUsageNum" => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrInternalusagehead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrInternalusagehead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrInternalusagehead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionPrint($id)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        $model = TrInternalusagedetail::find()
                ->select('ms_uom.uomName,tr_internalusagehead.internalUsageDate, ms_product.productName, ms_product.origin, tr_internalusagedetail.qty, tr_internalusagehead.notes')
                ->joinWith('usageDetail')
                ->joinWith('product')
                ->joinWith('uom')
                ->where(['tr_internalusagehead.internalUsageNum' => $id])
                ->all();
        $director = MsUser::findOne(['userRole' => 'DIRECTOR']);
        $content = $this->render('print',[
            'model' => $model,
            'director' => $director,
        ]);
        
        $mpdf = new mPDF('',    // mode - default ''
                        'A4',    // format - A4, default ''
                        0,     // font size - default 0
                        '',    // default font family
                        '13',    // margin_left
                        '13',    // margin right
                        '5',     // margin top
                        '10',    // margin bottom
                        '0',     // margin header
                        '5',     // margin footer
                        'L'     // P = portrait, L = landscape
                );
        $mpdf->AddPage('L');
        $mpdf->WriteHTML($content);
        $mpdf->Output('report.pdf','I');
       
    }

    protected function saveModel($model, $newTrans)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();

        if($newTrans){
            $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
            $modelMonth = date("m",strtotime($model->internalUsageDate)) - 1;
           
            $tempModel = TrInternalusagehead::find()
            ->where('SUBSTRING(internalUsageNum, 8, 2) LIKE :internalUsageDate',[
                    ':internalUsageDate' => date("y",strtotime($model->internalUsageDate))
            ])
            ->orderBy([new Expression("CAST(SUBSTRING(internalUsageNum, '-3', '3') AS UNSIGNED) DESC")])
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/IU/".date("y",strtotime($model->internalUsageDate))."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->internalUsageNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/IU/".date("y",strtotime($model->internalUsageDate))."/".$month[$modelMonth]."/".$temp;
            }
            $model->internalUsageNum = $tempTransNum;
        }
        $model->internalUsageDate = AppHelper::convertDateTimeFormat($model->internalUsageDate, 'd-m-Y', 'Y-m-d');
        // echo "<pre>";
        // var_dump($model->joinStockDetail);
        // echo "</pre>";
        // yii::$app->end();

        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }

        $connection = MdlDb::getDbConnection();
        $setSql = "SET SQL_SAFE_UPDATES=0";
        $command = $connection->createCommand($setSql);
        $command->execute();

        foreach ($model->joinStockDetail as $stockDetail) {
            $detailModel = new TrInternalusagedetail();
            $detailModel->internalUsageNum = $model->internalUsageNum;
            $detailModel->productID = $stockDetail['productID'];
            $detailModel->uomID = $stockDetail['uomID'];
            $detailModel->qty = str_replace(",",".",str_replace(".","",$stockDetail['qty']));
            $detailModel->batchNumber = $stockDetail['batchNumber'];
            $detailModel->purposeAccount = $stockDetail['purposeID'];
            $detailModel->manufactureDate = AppHelper::convertDateTimeFormat($stockDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
            if($stockDetail['expiredDate'] != null || $stockDetail['expiredDate'] != ""){
                $detailModel->expiredDate = AppHelper::convertDateTimeFormat($stockDetail['expiredDate'], 'd-m-Y', 'Y-m-d');
            }
            if($stockDetail['retestDate'] != null || $stockDetail['retestDate'] != ""){
                $detailModel->retestDate = AppHelper::convertDateTimeFormat($stockDetail['retestDate'], 'd-m-Y', 'Y-m-d');
            }
            if (!$detailModel->save()) {
                print_r($detailModel->getErrors());
                Yii::$app->end();
                $transaction->rollBack();
                return false;
            }
        }
        $transaction->commit();
        return true;
    }
}
