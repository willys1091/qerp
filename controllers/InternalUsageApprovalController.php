<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsReason;
use app\models\StockCard;
use app\models\StockHpp;
use app\models\TrInternalusagedetail;
use app\models\TrInternalusagehead;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * InternalUsageApprovalController implements the CRUD actions for TrInternalusagehead model.
 */
class InternalUsageApprovalController extends MainController
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

    protected function saveModel($model, $newTrans)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        $warehouseID = $model->warehouseID;
        $refNum = $model->internalUsageNum;


        foreach ($model->joinStockDetail as $stockDetail) {
            $productID = $stockDetail['productID'];
            $qty = str_replace(",",".",str_replace(".","",$stockDetail['qty']));
            $batchNumber = $stockDetail['batchNumber'];

            $inQty = 0;

            $hpps = StockHpp::cutStock($warehouseID, $batchNumber, $qty);
            
            if (!$hpps)
            {
                $transaction->rollback();
                Yii::$app->session->addFlash('error', 'Gagal save karena qty stock sudah kosong');
                return false;
            }
            
            $usageDetail = TrInternalusagedetail::findOne(['productID' => $productID, 'batchNumber' => $batchNumber]);
            $usageDetail->HPP = $hpps[0]['HPP'];
            $usageDetail->save();
            
            
            $stockCards = new StockCard;
            $stockCards->refNum = $refNum;
            $stockCards->transactionDate = date('Y-m-d H:i:s');
            $stockCards->productID = $productID;
            $stockCards->warehouseID = $warehouseID;
            $stockCards->outQty = $qty;
            $stockCards->inQty = $inQty;
            $stockCards->flagStatus = 1;
            $stockCards->batchNumber = $batchNumber;
            $stockCards->manufactureDate = AppHelper::convertDateTimeFormat($stockDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
            $stockCards->expiredDate = AppHelper::convertDateTimeFormat($stockDetail['expiredDate'], 'd-m-Y', 'Y-m-d');
            $stockCards->retestDate = AppHelper::convertDateTimeFormat($stockDetail['retestDate'], 'd-m-Y', 'Y-m-d');
            
            if (!$stockCards->save() ) {
               
                print_r($stockCards->getErrors());
                //print_r($stockCard->getErrors());
                Yii::$app->end();
                $transaction->rollBack();
                return false;
            }

        }

        //insert to journal
        $connection = MdlDb::getDbConnection();
        $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
        $mode = 9; //internal Usage

        $command->bindParam(':refNum', $refNum);
        $command->bindParam(':mode', $mode);
        $command->queryAll();
        $transaction->commit();

        return true;
    }
}
