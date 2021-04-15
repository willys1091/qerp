<?php

namespace app\controllers;

use Yii;
use app\models\TrGoodsreceipthead;
use app\models\TrGoodsreceipthead2;
use app\models\TrGoodsreceiptdetail;
use app\models\TrPurchaseorderhead;
use app\models\TrSalesreturnhead;
use app\models\TrStocktransferhead;
use app\models\MsProduct;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use kartik\form\ActiveForm;
use yii\web\response;
use app\components\MdlDb;
use app\components\AppHelper;
use yii\helpers\Json;

/**
 * GoodsReceiptController implements the CRUD actions for TrGoodsreceipthead model.
 */
class GoodsReceiptController extends MainController
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
     * Lists all TrGoodsreceipthead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrGoodsreceipthead();
        $model->load(Yii::$app->request->queryParams);
//        $model->startDate = date('01-m-Y');
//        $model->endDate = date('d-m-Y');
//        $model->shipment = "$model->startDate to $model->endDate";
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrGoodsreceipthead model.
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
     * Creates a new TrGoodsreceipthead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrGoodsreceipthead();
        $model->goodsReceiptDate = date('d-m-Y');
        $model->joinGoodsReceiptDetail = [];

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if($this->saveModel($model, true)){
                $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionBrowse()
    {
        $this->view->params['browse'] = true;
        $model = new TrGoodsreceipthead();
        $model->load(Yii::$app->request->queryParams);
        $this->layout = 'browseLayout';
        return $this->render('browse', [
            'model' => $model
        ]);
    }

    public function actionBrowsebysupplier($filter)
    {
        $this->view->params['browse'] = true;
        $model = new TrGoodsreceipthead();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrGoodsreceipthead::find()
                                        ->select(['tr_goodsreceipthead.goodsReceiptNum','tr_goodsreceipthead.goodsReceiptDate','tr_goodsreceipthead.refNum'])
                                        ->joinWith('purchaseOrder')
                                        ->joinWith('stockHPP')
                                        ->where('tr_goodsreceipthead.transType = :refNum',[':refNum' => 'Purchase Order'])
                                        ->andWhere('tr_stockhpp.refNum is not null')
                                        ->andWhere('tr_purchaseorderhead.supplierID = :refSupplier',[':refSupplier' => $filter]),
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browsebysupplier', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    
    public function actionGetHscode()
    {
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            
            $productID = $data['productID'];

            $detailModels = MsProduct::find()->select('hsCode')->distinct()->where(['productID'=>$productID])->all();
            
            $data = array();
            foreach ($detailModels as $detailModel) {
                $temp["id"] = $detailModel->hsCode;
                $temp["text"] = $detailModel->hsCode;
                array_push($data, $temp);
            }
        }

        return \yii\helpers\Json::encode($data);
    }

    /**
     * Updates an existing TrGoodsreceipthead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (strpos($id, 'PO') !== false){
            $model = $this->findRefPO($id);
            $model->transType = 'Purchase Order';
        }
        else if (strpos($id, 'SR') !== false){
            $model = $this->findRefSR($id);
            $model->transType = 'Sales Return';
        }
        else if (strpos($id, 'ST') !== false){
            $model = $this->findRefST($id);
            $model->transType = 'Stock Transfer';
        } else 
        {
            $model = $this->findRefPO($id);
            $model->transType = 'Purchase Order';
        }
        $model->goodsReceiptDate = date('d-m-Y');
        $model->AWBDate = date('d-m-Y');
        $model->joinHsCodeDetail = [];

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
     * Deletes an existing TrGoodsreceipthead model.
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
     * Finds the TrGoodsreceipthead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrGoodsreceipthead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrGoodsreceipthead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findRefPO($id)
    {
        if (($model = TrGoodsreceipthead::find()
                                        ->rightJoin('tr_purchaseorderhead', 'tr_goodsreceipthead.refNum = tr_purchaseorderhead.purchaseOrderNum')
                                        ->where(['tr_purchaseorderhead.purchaseOrderNum' => $id])
                                        ->one()
            ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findRefSR($id)
    {
        if (($model = TrGoodsreceipthead::find()
                                        ->rightJoin('tr_salesreturnhead', 'tr_goodsreceipthead.refNum = tr_salesreturnhead.salesReturnNum')
                                        ->where(['tr_salesreturnhead.salesReturnNum' => $id])
                                        ->one()
            ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findRefST($id)
    {
        if (($model = TrGoodsreceipthead::find()
                                        ->rightJoin('tr_stocktransferhead', 'tr_goodsreceipthead.refNum = tr_stocktransferhead.stockTransferNum')
                                        ->where(['tr_stocktransferhead.stockTransferNum' => $id])
                                        ->one()
            ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function saveModel($model, $newTrans)
    {
        $goodsModel = new TrGoodsreceipthead();
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $modelMonth = date("m",strtotime($model->goodsReceiptDate)) - 1;
        
        $tempModel = TrGoodsreceipthead::find()
        ->where('SUBSTRING(goodsReceiptNum, 8, 2) LIKE :goodsReceiptDate',[
                ':goodsReceiptDate' => date("y",strtotime($model->goodsReceiptDate))
        ])
        ->orderBy([new Expression("CAST(SUBSTRING(goodsReceiptNum, '-3', '3') AS UNSIGNED) DESC")])
        ->one();
        $tempTransNum = "";
        
        if (empty($tempModel)){
            $tempTransNum = "QJA/GR/".date("y",strtotime($model->goodsReceiptDate))."/".$month[$modelMonth]."/001";
        }
        else{
            $temp = substr($tempModel->goodsReceiptNum,-3,3)+1;
            $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
            $tempTransNum = "QJA/GR/".date("y",strtotime($model->goodsReceiptDate))."/".$month[$modelMonth]."/".$temp;
        }
        
        $goodsModel->goodsReceiptNum = $tempTransNum;
        $goodsModel->refNum = $model->refNum;
        $goodsModel->transType = $model->transType;
        $goodsModel->deliveryNum = $model->deliveryNum;
        $goodsModel->warehouseID = $model->warehouseID;
        $goodsModel->goodsReceiptDate = AppHelper::convertDateAndTimeFormat($model->goodsReceiptDate.' '.$model->goodsReceiptTime, 'd-m-Y H:i', 'Y-m-d H:i');
        $goodsModel->AWBDate = AppHelper::convertDateTimeFormat($model->AWBDate, 'd-m-Y', 'Y-m-d');
        $goodsModel->AWBNum = $model->AWBNum;
        $goodsModel->PPJK = $model->PPJK;

        $goodsModel->createdBy = Yii::$app->user->identity->username;
        $goodsModel->createdDate = new Expression('NOW()');
        $goodsModel->editedBy = Yii::$app->user->identity->username;
        $goodsModel->editedDate = new Expression('NOW()');

        if (!$goodsModel->save()) {
            print_r($goodsModel->getErrors());
            $transaction->rollBack();
            return false;
        }
        
        $connection = MdlDb::getDbConnection();
        $setSql = "SET SQL_SAFE_UPDATES=0";
        $command = $connection->createCommand($setSql);
        $command->execute();

        foreach ($model->joinGoodsReceiptDetail as $goodsDetail) {
            $goodsDetailModel = new TrGoodsreceiptdetail();
            $goodsDetailModel->goodsReceiptNum = $goodsModel->goodsReceiptNum;
            $goodsDetailModel->productID = $goodsDetail['productID'];
            $goodsDetailModel->uomID = $goodsDetail['uomID'];
            $goodsDetailModel->temperature = $goodsDetail['temperature'];
            $goodsDetailModel->qty = str_replace(",",".",str_replace(".","",$goodsDetail['qtyReceived']));
            $goodsDetailModel->batchNumber = $goodsDetail['batchNumber'];
            $goodsDetailModel->hsCode = $goodsDetail['hsCode'];
            $goodsDetailModel->manufactureDate = AppHelper::convertDateTimeFormat($goodsDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
            if($goodsDetail['expireDate'] != null || $goodsDetail['expireDate'] != "")
                $goodsDetailModel->expiredDate = AppHelper::convertDateTimeFormat($goodsDetail['expireDate'], 'd-m-Y', 'Y-m-d');
            if($goodsDetail['retestDate'] != null || $goodsDetail['retestDate'] != "")
                $goodsDetailModel->retestDate = AppHelper::convertDateTimeFormat($goodsDetail['retestDate'], 'd-m-Y', 'Y-m-d');
            $goodsDetailModel->pack = $goodsDetail['packID'];
            $goodsDetailModel->packQty = str_replace(",",".",str_replace(".","",$goodsDetail['packQty']));
            $goodsDetailModel->notes = nl2br($goodsDetail['notes']);
            if(isset($goodsDetail['condition'])){
                if(strcmp($goodsDetail['condition'],"on") == 0)
                    $goodsDetailModel->goodsCondition = 1;
            }
            else
                $goodsDetailModel->goodsCondition = 0;

            if (!$goodsDetailModel->save()) {
                print_r($goodsDetailModel->getErrors());
                Yii::$app->end();
                $transaction->rollBack();
                return false;
            }
        }
        
        $transaction->commit();
        return true;
    }
}
