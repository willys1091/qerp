<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\StockCard;
use app\models\StockHpp;
use app\models\StockTransferDetailHpp;
use app\models\TrGoodsdeliveryhead;
use app\models\TrGoodsreceipthead;
use app\models\TrStocktransferdetail;
use app\models\TrStocktransferhead;
use kartik\form\ActiveForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\response;

/**
 * StockTransferController implements the CRUD actions for TrStocktransferhead model.
 */
class StockTransferController extends MainController
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
     * Lists all TrStocktransferhead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrStocktransferhead();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->stockTransferDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrStocktransferhead model.
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
     * Creates a new TrStocktransferhead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrStocktransferhead();
        $model->joinStockDetail = [];
        $model->stockTransferDate = date('d-m-Y');
        
        

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
     * Updates an existing TrStocktransferhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//        $model->stockTransferDate = AppHelper::convertDateTimeFormat($model->stockTransferDate, 'd-m-Y', 'Y-m-d');
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//           
//             return $this->redirect(['index']);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }
    
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
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model
        ]);
    }

    /**
     * Deletes an existing TrStocktransferhead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {   
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        
        
        $model = $this->findModel($id);
    
        
            $stockDetail = array_values($model->joinStockDetail);
            
            foreach ($model->stockTransferDetails AS $detail)
            {
                    foreach ($detail->hpps as $detailHpp) {
                        StockHpp::addStock($model->sourceWarehouse, $detail->batchNumber, $detailHpp->refNum, $detailHpp->HPP, $detailHpp->qty, $detailHpp->manufactureDate, $detailHpp->retestDate, $detailHpp->expiredDate, $detailHpp->stockDate);
                        $detailHpp->delete();
                    }

                    StockHpp::deleteAll('refNum = :refNum AND warehouseID = :warehouseID AND productID = :productID', [":refNum" => $model->stockTransferNum,
                        ":warehouseID" => $model->destinationWarehouseID,
                        ":productID" => $detail->productID]);
                    StockCard::deleteAll('refNum = :refNum  AND productID = :productID', [":refNum" => $model->stockTransferNum,
                        ":productID" => $detail->productID]);

                    foreach($detail->hpps as $detailHpp) $detailHpp->delete();
                    
                    $detail->delete();
                
            }
           
            TrStocktransferdetail::deleteAll('stockTransferNum = :stockTransferNum', [":stockTransferNum" => $id]);
            $this->findModel($id)->delete();
            $transaction->commit();
           // return true;
            return $this->redirect(['index']);
        
    }

    /**
     * Finds the TrStocktransferhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrStocktransferhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrStocktransferhead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function saveModel($model, $newTrans)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        
        if($newTrans){
            $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
            $modelMonth = date("m",strtotime($model->stockTransferDate)) - 1;

            $tempModel = TrStocktransferhead::find()
            ->where('YEAR(stockTransferDate) LIKE :stockTransferDate',[
                    ':stockTransferDate' => date("Y",strtotime($model->stockTransferDate))
            ])
            ->orderBy('stockTransferNum DESC')
            ->one();
            $tempTransNum = "";

            if (empty($tempModel)){
                $tempTransNum = "QJA/ST/".substr(date("Y",strtotime($model->stockTransferDate)), -2)."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->stockTransferNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/ST/".substr(date("Y",strtotime($model->stockTransferDate)), -2)."/".$month[$modelMonth]."/".$temp;
            }
            
            $model->stockTransferNum = $tempTransNum;
            $transferDateBeforeConvert = $model->stockTransferDate;
            $model->stockTransferDate = AppHelper::convertDateTimeFormat($model->stockTransferDate, 'd-m-Y', 'Y-m-d');
            $sourceWarehouseID = $model->sourceWarehouseID;
            $destinationWerehouseID = $model->destinationWarehouseID;

            if (!$model->save()) {

                print_r($model->getErrors());
                $transaction->rollBack();
                return false;
            }
        }
     
        
        if (!$newTrans)
        {
            $stockDetail = array_values($model->joinStockDetail);
            //Yii::trace($model->joinStockDetail, 'TEST');
            foreach ($model->stockTransferDetails AS $detail)
            {
                //DELETE DETAIL
                $i = -1;
                if (!array_find($stockDetail, $i, function($x, $id){
                    return $x['stockTransferDetailID'] == $id;
                }, [$detail->stockTransferDetailID]))
                {
                   // $productID = $detail->productID;
                     foreach ($detail->hpps as $detailHpp) {
                        StockHpp::addStock($model->sourceWarehouse, $detail->batchNumber, $detailHpp->refNum, $detailHpp->HPP, $detailHpp->qty, $detailHpp->manufactureDate, $detailHpp->retestDate, $detailHpp->expiredDate, $detailHpp->stockDate);
                        $detailHpp->delete();
                    }

                    StockHpp::deleteAll('refNum = :refNum AND warehouseID = :warehouseID AND productID = :productID', [":refNum" => $model->stockTransferNum,
                        ":warehouseID" => $model->destinationWarehouseID,
                        ":productID" => $detail->productID]);
                    StockCard::deleteAll('refNum = :refNum  AND productID = :productID', [":refNum" => $model->stockTransferNum,
                        ":productID" => $detail->productID]);

                    foreach($detail->hpps as $detailHpp) $detailHpp->delete();
                    
                    $detail->delete();
                } else {
                    //Yii::trace($stockDetail[$i]['qty'], 'ekekek');
                   
                    //$detail->qty = $stockDetail[$i]['qty'];
                    $detail->productID = $stockDetail[$i]['productID'];
//                   $detail->batchNumber = $stockDetail[$i]['batchNumber'];
                    
                    foreach ($detail->hpps as $detailHpp)
                    {
                        StockHpp::addStock($model->sourceWarehouse, $detail->batchNumber, $detailHpp->refNum, $detailHpp->HPP, $detailHpp->qty, 
                            $detailHpp->manufactureDate, $detailHpp->retestDate, $detailHpp->expiredDate, $detailHpp->stockDate);
                        $detailHpp->delete();
                        
                        
                    }
                    
                    StockHpp::deleteAll('refNum = :refNum AND warehouseID = :warehouseID AND productID = :productID', 
                        [":refNum" => $model->stockTransferNum, 
                         ":warehouseID" => $model->destinationWarehouseID, 
                         ":productID" =>  $detail->productID]);
                    StockCard::deleteAll('refNum = :refNum  AND productID = :productID', 
                       [":refNum" => $model->stockTransferNum, 
                        ":productID" =>  $detail->productID]);
                   
                    $stockUpdate = $stockDetail[$i];
                 
//                    var_dump( $model->stockTransferNum);
//                    die();
                    
                    $detail->qtyInStock = str_replace(",",".",str_replace(".","",$stockUpdate['qty']));
                    $detail->productID = $stockUpdate['productID'];
                    $detail->uomID = $stockUpdate['uomID'];
                    $detail->batchNumber = $stockUpdate['batchNumber'];
                    $detail->qtyTransfer =  str_replace(",",".",str_replace(".","",$stockUpdate['transferedQty']));
                    $detail->expiredDate = AppHelper::convertDateTimeFormat($stockUpdate['expiredDate'], 'd-m-Y', 'Y-m-d'); 
                    $detail->manufactureDate =  AppHelper::convertDateTimeFormat($stockUpdate['manufactureDate'], 'd-m-Y', 'Y-m-d');
                    $detail->save();
                    

                    
                
                    
                    $hpps = StockHpp::cutStock($model->sourceWarehouse, $detail->batchNumber,$detail->qtyTransfer);
                    
                    $warehouseID = intval($model->destinationWarehouseID);
                    $sourceWarehouse = $model->sourceWarehouse->warehouseID;
                  
                 
                    foreach ($hpps as $hpp)
                    {
                        $stockCards = new StockCard;
                        $stockCards->refNum = $model->stockTransferNum;
                        $stockCards->transactionDate = $hpp['stockDate'];
                        $stockCards->productID = $detail->productID;
                        $stockCards->warehouseID = $sourceWarehouse;
                        $stockCards->outQty =  $detail->qtyTransfer;
                        $stockCards->inQty = 0.00;
                        $stockCards->flagStatus = 1;
                        $stockCards->batchNumber =  $detail->batchNumber;
                        $stockCards->manufactureDate = $detail->manufactureDate;
                        $stockCards->expiredDate = $detail->expiredDate;
                        $stockCards->save(); 

                        $stockCard = new StockCard();
                        $stockCard->refNum = $model->stockTransferNum;
                        $stockCard->transactionDate = $hpp['stockDate'];
                        $stockCard->productID = $detail->productID;
                        $stockCard->warehouseID = $warehouseID;
                        $stockCard->inQty = $detail->qtyTransfer;
                        $stockCard->outQty = 0.00;
                        $stockCard->flagStatus = 1;
                        $stockCard->batchNumber = $detail->batchNumber;
                        $stockCard->manufactureDate = $detail->manufactureDate;
                        $stockCard->expiredDate = $detail->expiredDate;
                        $stockCard->save();

                        $insertStockHpp = new StockHpp();
                        $insertStockHpp->stockDate =  $hpp['stockDate'];
                        $insertStockHpp->refNum =  $model->stockTransferNum;
                        $insertStockHpp->manufactureDate =  $detail->manufactureDate;
                        $insertStockHpp->expiredDate =  $detail->expiredDate;
                        $insertStockHpp->warehouseID =  $warehouseID;
                        $insertStockHpp->productID =  $detail->productID;
                        $insertStockHpp->HPP =  $hpp['HPP'];
                        $insertStockHpp->qtyStock =  $hpp['qty'];
                        $insertStockHpp->batchNumber =  $detail->batchNumber;
                        $insertStockHpp->save();


                        $insertStockDetailHpp = new StockTransferDetailHpp;
                        $insertStockDetailHpp->transferDetailID =   $detail->stockTransferDetailID;
                        $insertStockDetailHpp->stockDate =  $hpp['stockDate'];
                        $insertStockDetailHpp->refNum =  $hpp['refNum'];
                        $insertStockDetailHpp->HPP =  $hpp['HPP'];
                        $insertStockDetailHpp->qty =  $hpp['qty'];


                    }
                  
                    
                    if (!$insertStockHpp->save() ||  !$insertStockDetailHpp->save()) {
                        var_dump('hpp');
                        print_r($insertStockHpp->getErrors());
                        //print_r($updateStockHpp->getErrors());
                        print_r($insertStockDetailHpp->getErrors());
                        Yii::$app->end();
                        $transaction->rollBack();
                        return false;
                    }


                    if (!$stockCards->save()) {
                        var_dump('stokcards');
                        print_r($stockCards->getErrors());
                        var_dump(Json::encode($stockCards));
                        Yii::$app->end();
                        $transaction->rollBack();
                        return false;
                    }
                    if (!$stockCard->save() )
                    {
                        var_dump('stokcard');
                        print_r($stockCard->getErrors());
                        Yii::$app->end();
                        $transaction->rollBack();
                        return false;
                    }
                    if (!$detail->save()) {

                        print_r($detail->getErrors());
                        var_dump('detaail');
                        Yii::$app->end();
                        $transaction->rollBack();
                        return false;
                    }

                }
            }
            
            foreach ($model->joinStockDetail AS $stockDetail)
            {
                $detail = TrStocktransferdetail::findOne(['stockTransferDetailID' => $stockDetail['stockTransferDetailID']]);
                $detail->stockTransferNum = $model->stockTransferNum;
                $detail->productID = $stockDetail['productID'];
                $detail->uomID = $stockDetail['uomID'];
                $detail->batchNumber = $stockDetail['batchNumber'];
                $detail->manufactureDate = AppHelper::convertDateTimeFormat($stockDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
                $detail->expiredDate = AppHelper::convertDateTimeFormat($stockDetail['expiredDate'], 'd-m-Y', 'Y-m-d');
                $detail->qtyInStock = str_replace(",",".",str_replace(".","",$stockDetail['qty']));
                $detail->qtyTransfer = str_replace(",",".",str_replace(".","",$stockDetail['transferedQty']));
                $detail->save();
            }
            
        } else {
            $connection = MdlDb::getDbConnection();
            $setSql = "SET SQL_SAFE_UPDATES=0";
            $command = $connection->createCommand($setSql);
            $command->execute();
              
            foreach ($model->joinStockDetail as $stockDetail) {
                $detailModel = new TrStocktransferdetail();
                $detailModel->stockTransferNum = $model->stockTransferNum;
                $detailModel->productID = $stockDetail['productID'];
                $detailModel->uomID = $stockDetail['uomID'];
                $detailModel->batchNumber = $stockDetail['batchNumber'];
                $detailModel->manufactureDate = AppHelper::convertDateTimeFormat($stockDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
                $detailModel->expiredDate = AppHelper::convertDateTimeFormat($stockDetail['expiredDate'], 'd-m-Y', 'Y-m-d');
                $detailModel->qtyInStock = str_replace(",",".",str_replace(".","",$stockDetail['qty']));
                $detailModel->qtyTransfer = str_replace(",",".",str_replace(".","",$stockDetail['transferedQty']));
                $detailModel->save();
                
                $stockCards = new StockCard;
                $stockCards->refNum = $tempTransNum;
                $stockCards->transactionDate = date('Y-m-d H:i:s');
                $stockCards->productID = $stockDetail['productID'];
                $stockCards->warehouseID = $sourceWarehouseID;
                $stockCards->outQty = str_replace(",",".",str_replace(".","",$stockDetail['transferedQty']));
                $stockCards->inQty = 0.00;
                $stockCards->flagStatus = 1;
                $stockCards->batchNumber = $stockDetail['batchNumber'];
                $stockCards->manufactureDate = AppHelper::convertDateTimeFormat($stockDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
                $stockCards->expiredDate = AppHelper::convertDateTimeFormat($stockDetail['expiredDate'], 'd-m-Y', 'Y-m-d');
                $stockCards->save(); 
                
                $stockCard = new StockCard;
                $stockCard->refNum = $tempTransNum;
                $stockCard->transactionDate = date('Y-m-d H:i:s');
                $stockCard->productID = $stockDetail['productID'];
                $stockCard->warehouseID = $destinationWerehouseID;
                $stockCard->inQty = str_replace(",",".",str_replace(".","",$stockDetail['transferedQty']));
                $stockCard->outQty = 0.00;
                $stockCard->flagStatus = 1;
                $stockCard->batchNumber = $stockDetail['batchNumber'];
                $stockCard->manufactureDate = AppHelper::convertDateTimeFormat($stockDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
                $stockCard->expiredDate = AppHelper::convertDateTimeFormat($stockDetail['expiredDate'], 'd-m-Y', 'Y-m-d');
                $stockCard->save();

                $batchNumber = $stockDetail['batchNumber'];
                $qtySource = str_replace(",",".",str_replace(".","",$stockDetail['qty']));
                $qtyTransfer = str_replace(",",".",str_replace(".","",$stockDetail['transferedQty']));

                $qtyTotal = $qtySource - $qtyTransfer;


                $hpps = StockHpp::cutStock($sourceWarehouseID, $batchNumber, $qtyTransfer);
                //$updateStockHpp = StockHpp::findOne(['batchNumber' => $batchNumber, 'warehouseID' => $sourceWarehouseID ]);
                //$updateStockHpp->qtyStock = $qtyTotal;
                //$updateStockHpp->save();
                foreach ($hpps as $hpp)
                {
                    
                    
                    $insertStockHpp = new StockHpp;
                    $insertStockHpp->stockDate =  date('Y-m-d H:i:s');
                    $insertStockHpp->refNum =  $tempTransNum;
                    $insertStockHpp->manufactureDate =  $stockCards->manufactureDate;
                    $insertStockHpp->expiredDate =  $stockCards->expiredDate;
                    $insertStockHpp->warehouseID =  $destinationWerehouseID;
                    $insertStockHpp->productID =  $stockCards->productID;
                    $insertStockHpp->HPP =  $hpp['HPP'];
                    $insertStockHpp->qtyStock =  $hpp['qty'];
                    $insertStockHpp->batchNumber =  $stockCards->batchNumber;
                    $insertStockHpp->save();
                    
                    
                    $insertStockDetailHpp = new StockTransferDetailHpp;
                    $insertStockDetailHpp->transferDetailID =   $detailModel->stockTransferDetailID;
                    $insertStockDetailHpp->stockDate =  $hpp['stockDate'];
                    $insertStockDetailHpp->refNum =  $hpp['refNum'];
                    $insertStockDetailHpp->HPP =  $hpp['HPP'];
                    $insertStockDetailHpp->qty =  $hpp['qty'];
                    
                   
                }

                if (!$insertStockHpp->save() ||  !$insertStockDetailHpp->save()) {

                    print_r($insertStockHpp->getErrors());
                    //print_r($updateStockHpp->getErrors());
                    print_r($insertStockDetailHpp->getErrors());
                    Yii::$app->end();
                    $transaction->rollBack();
                    return false;
                }


                if (!$detailModel->save() || !$stockCards->save() || !$stockCard->save() ) {

                    print_r($stockCards->getErrors());
                    print_r($stockCard->getErrors());
                    Yii::$app->end();
                    $transaction->rollBack();
                    return false;
                }
            }
            
            
        }
        $transaction->commit();
        return true;
    }
}
