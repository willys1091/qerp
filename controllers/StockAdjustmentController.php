<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\StockCard;
use app\models\StockHpp;
use app\models\StockopnameDetailHpp;
use app\models\TrJournalhead;
use app\models\TrStockopnamedetail;
use app\models\TrStockopnamehead;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * StockAdjustmentController implements the CRUD actions for TrStockopnamehead model.
 */
class StockAdjustmentController extends MainController
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
     * Lists all TrStockopnamehead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrStockopnamehead();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->stockOpnameDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrStockopnamehead model.
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
     * Creates a new TrStockopnamehead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrStockopnamehead();
        $model->joinStockDetail = [];
        $model->stockOpnameDate = date('d-m-Y');

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

    public function actionBrowse($filter = null)
    {
        $this->view->params['browse'] = true;

        $model = new TrStockopnamehead();
        $model->load(Yii::$app->request->queryParams);

        $this->layout = 'browseLayout';
        return $this->render('browse', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing TrStockopnamehead model.
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
            
            
            foreach ($model->joinStockDetail AS $detail)
            {
               $qty = str_replace(",",".",str_replace(".","",$detail['qty']));
               $real = str_replace(",",".",str_replace(".","",$detail['realQty']));
               
                
                if($real > $qty ){

                    Yii::$app->session->setFlash('error', "Real Qty must not be larger than Stock Qty");
                    $model = $this->findModel($id);

                    return $this->render('update', [
                            'model' => $model
                    ]);
                   
                } 
            
            }
            if ($this->saveModel($model, false)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model
        ]);
    }

    /**
     * Deletes an existing TrStockopnamehead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $connection = MdlDb::getDbConnection();
//        $setSql = "SET SQL_SAFE_UPDATES=0";
//        $command = $connection->createCommand($setSql);
//        $command->execute();
//
//        $sql = "DELETE from tr_journaldetail
//                where journalHeadID IN
//                (SELECT journalHeadID from tr_journalhead where refNum='".$id."')";
//        $connection = MdlDb::getDbConnection();
//        $command = $connection->createCommand($sql);
//        $command->execute();
//
//        TrJournalhead::deleteAll('refNum = :refNum', [":refNum" => $id]);
//        TrStockopnamedetail::deleteAll('stockOpnameNum = :stockOpnameNum', [":stockOpnameNum" => $id]);
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }
//    
    
        public function actionDelete($id)
    {   
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();

        
        
        $model = $this->findModel($id);
    
            $stockDetail = array_values($model->joinStockDetail);
            Yii::trace($model->joinStockDetail, 'TEST');
            foreach ($model->stockOpnameDetails AS $detail)
            {
                foreach ($detail->hpps as $detailHpp) {
                        StockHpp::addStock($model->warehouseID, $detail->batchNumber, $detailHpp->refNum, $detailHpp->HPP, $detailHpp->qty, $detailHpp->manufactureDate, $detailHpp->retestDate, $detailHpp->expiredDate, $detailHpp->stockDate);
                        Yii::trace($model->joinStockDetail, 'SATU');
                        
                        $detailHpp->delete();
                    }
                   
                    StockHpp::deleteAll('refNum = :refNum AND warehouseID = :warehouseID AND productID = :productID', [":refNum" => $model->stockOpnameNum,
                        ":warehouseID" => $model->warehouseID,
                        ":productID" => $detail->productID]);
                    StockCard::deleteAll('refNum = :refNum  AND productID = :productID', [":refNum" => $model->stockOpnameNum,
                        ":productID" => $detail->productID]);

                    foreach($detail->hpps as $detailHpp) $detailHpp->delete();
                    
                    $detail->delete();
            }
            
                 $sql = "DELETE from tr_journaldetail
                        where journalHeadID IN
                        (SELECT journalHeadID from tr_journalhead where refNum='".$id."')";
                        $connection = MdlDb::getDbConnection();
                        $command = $connection->createCommand($sql);
                        $command->execute();
                        
                        
            TrJournalhead::deleteAll('refNum = :refNum', [":refNum" => $id]);
            TrStockopnamedetail::deleteAll('stockOpnameNum = :stockOpnameNum', [":stockOpnameNum" => $id]);
            $this->findModel($id)->delete();
             $transaction->commit();
        return $this->redirect(['index']);
        
    }


    /**
     * Finds the TrStockopnamehead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrStockopnamehead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrStockopnamehead::findOne($id)) !== null) {
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
            
            //$transaction = $connection->beginTransaction();
            $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
            $modelMonth = date("m",strtotime($model->stockOpnameDate)) - 1;
           
            $tempModel = TrStockopnamehead::find()
            ->where('YEAR(stockOpnameDate) LIKE :stockOpnameDate',[
                    ':stockOpnameDate' => date("Y",strtotime($model->stockOpnameDate))
            ])
            ->orderBy('stockOpnameNum DESC')
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/SA/".substr(date("Y",strtotime($model->stockOpnameDate)), -2)."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->stockOpnameNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/SA/".substr(date("Y",strtotime($model->stockOpnameDate)), -2)."/".$month[$modelMonth]."/".$temp;
            }
            
            $model->stockOpnameNum = $tempTransNum;
            $model->stockOpnameDate = AppHelper::convertDateTimeFormat($model->stockOpnameDate, 'd-m-Y', 'Y-m-d H:i:s'); 
        }
        if(!$newTrans){
            $model->stockOpnameDate = AppHelper::convertDateTimeFormat($model->stockOpnameDate, 'd-m-Y', 'Y-m-d H:i:s'); 
            
        }
       
        $warehouseID = $model->warehouseID;
        $refNum = $model->stockOpnameNum;
        $model->type = 'lose';
        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }

        $connection = MdlDb::getDbConnection();
        $setSql = "SET SQL_SAFE_UPDATES=0";
        $command = $connection->createCommand($setSql);
        $command->query();
        $detailStockopname = TrStockopnamedetail::find()->where(['stockOpnameNum' => $refNum])->all();
        $detailStockcard = Stockcard::find()->where(['refNum' => $refNum])->all();
        
        
        
        if($detailStockopname != null) {
            $stockDetail = array_values($model->joinStockDetail);
            Yii::trace($model->joinStockDetail, 'TEST');
            foreach ($model->stockOpnameDetails AS $detail)
            {
                //DELETE DETAIL
                $i = -1;
                if (!array_find($stockDetail, $i, function($x, $id){
                    return $x['stockOpnameDetailID'] == $id;
                }, [$detail->stockOpnameDetailID]))
                {
                   // $productID = $detail->productID;
                   
                     foreach ($detail->hpps as $detailHpp) {
                        StockHpp::addStock($model->warehouseID, $detail->batchNumber, $detailHpp->refNum, $detailHpp->HPP, $detailHpp->qty, $detailHpp->manufactureDate, $detailHpp->retestDate, $detailHpp->expiredDate, $detailHpp->stockDate);
                        Yii::trace($model->joinStockDetail, 'SATU');
                        
                        $detailHpp->delete();
                    }
                   
                    StockHpp::deleteAll('refNum = :refNum AND warehouseID = :warehouseID AND productID = :productID', [":refNum" => $refNum,
                        ":warehouseID" => $warehouseID,
                        ":productID" => $detail->productID]);
                    StockCard::deleteAll('refNum = :refNum  AND productID = :productID', [":refNum" => $refNum,
                        ":productID" => $detail->productID]);

                    //foreach($detail->hpps as $detailHpp) $detailHpp->delete();
                    
                    $detail->delete();
                    
                }  else {
                     Yii::trace($model->joinStockDetail, 'DUA');
                    $stockDetail = array_values($model->joinStockDetail);
                    foreach ($detail->hpps as $detailHpp)
                    {
                        StockHpp::addStock($model->warehouseID, $detail->batchNumber, $detailHpp->refNum, $detailHpp->HPP, $detailHpp->qty, $detailHpp->manufactureDate, $detailHpp->retestDate, $detailHpp->expiredDate, $detailHpp->stockDate);
                        $detailHpp->delete();
                        
                    }
                    
                    StockHpp::deleteAll('refNum = :refNum AND warehouseID = :warehouseID AND productID = :productID', [":refNum" => $refNum,
                        ":warehouseID" => $warehouseID,
                        ":productID" => $detail->productID]);
                    StockCard::deleteAll('refNum = :refNum  AND productID = :productID', [":refNum" => $refNum,
                        ":productID" => $detail->productID]);
                   
                    $stockUpdate = $stockDetail[$i];

                    $detail->qtyInStock = str_replace(",",".",str_replace(".","",$stockUpdate['qty']));
                    $detail->productID = $stockUpdate['productID'];
                    $detail->uomID = $stockUpdate['uomID'];
                    $detail->batchNumber = $stockUpdate['batchNumber'];
                    $detail->qtyReal =  str_replace(",",".",str_replace(".","",$stockUpdate['realQty']));
                    $detail->expiredDate = AppHelper::convertDateTimeFormat($stockUpdate['expiredDate'], 'd-m-Y', 'Y-m-d'); 
                    $detail->manufactureDate =  AppHelper::convertDateTimeFormat($stockUpdate['manufactureDate'], 'd-m-Y', 'Y-m-d');
                    $detail->save();
                    
                    
                    $qtyReal =  $detail->qtyInStock - $detail->qtyReal ;
                    var_dump($qtyReal);
                    //die();
                    $hpps = StockHpp::cutStock($model->warehouseID, $detail->batchNumber,$qtyReal);
                  
                   
                    $warehouseID = intval($model->warehouseID);
                    
                    foreach ($hpps as $hpp)
                    {
                       

//                        $insertStockHpp = new StockHpp();
//                        $insertStockHpp->stockDate =  $hpp['stockDate'];
//                        $insertStockHpp->refNum = $refNum;
//                        $insertStockHpp->manufactureDate =  $detail->manufactureDate;
//                        $insertStockHpp->expiredDate =  $detail->expiredDate;
//                        $insertStockHpp->warehouseID =  $warehouseID;
//                        $insertStockHpp->productID =  $detail->productID;
//                        $insertStockHpp->HPP =  $hpp['HPP'];
//                        $insertStockHpp->qtyStock =  $hpp['qty'];
//                        $insertStockHpp->batchNumber =  $detail->batchNumber;
//                        $insertStockHpp->save();


                        $insertStockDetailHpp = new StockopnameDetailHpp();
                        $insertStockDetailHpp->stockOpnameDetailID =   $detail->stockOpnameDetailID;
                        $insertStockDetailHpp->stockDate =  $hpp['stockDate'];
                        $insertStockDetailHpp->refNum =  $hpp['refNum'];
                        $insertStockDetailHpp->HPP =  $hpp['HPP'];
                        $insertStockDetailHpp->qty =  $hpp['qty'];
                        $insertStockDetailHpp->manufactureDate =  $hpp['manufactureDate'];
                        $insertStockDetailHpp->retestDate =  $hpp['retestDate'];
                        $insertStockDetailHpp->expiredDate =  $hpp['expiredDate'];
                        
                        
                        
                        if (!$insertStockDetailHpp->save()) {
                        print_r($insertStockDetailHpp->getErrors());
                        Yii::$app->end();
                        $transaction->rollBack();
                        return false;
                        }
                        if (!$detail->save()) {
                            print_r($detail->getErrors());
                           
                            Yii::$app->end();
                            $transaction->rollBack();
                            return false;
                        }
                    }
                    
                    
             
                }
            }
            $mode = 3;
            $command = $connection->createCommand('call sp_insert_stockcard(:refNum,:transactiondates,:mode)');
            $command->bindParam(':refNum', $refNum);
            $command->bindParam(':transactiondates', $dates);
            $command->bindParam(':mode', $mode);
            $command->execute();
            
        } else {
            
              foreach ($model->joinStockDetail as $stockDetail) {
                $detailModel = new TrStockopnamedetail();
                $detailModel->stockOpnameNum = $model->stockOpnameNum;
                $detailModel->productID = $stockDetail['productID'];
                $detailModel->uomID = $stockDetail['uomID'];
                $detailModel->batchNumber = $stockDetail['batchNumber'];
                $detailModel->manufactureDate = AppHelper::convertDateTimeFormat($stockDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
                $detailModel->expiredDate = AppHelper::convertDateTimeFormat($stockDetail['expiredDate'], 'd-m-Y', 'Y-m-d');
                $detailModel->retestDate = AppHelper::convertDateTimeFormat($stockDetail['retestDate'], 'd-m-Y', 'Y-m-d');
                $detailModel->qtyInStock = str_replace(",",".",str_replace(".","",$stockDetail['qty']));
                $detailModel->qtyReal = str_replace(",",".",str_replace(".","",$stockDetail['realQty']));
                $stockHPP = str_replace(",",".",str_replace(".","",$stockDetail['stockHPP']));
                $detailModel->HPP = str_replace(",",".",str_replace(".","",$stockDetail['HPP']));
                $detailModel->save();
                
                $productID = $detailModel->productID;
                $qtyInStock = $detailModel->qtyInStock;
                $qtyReal = $qtyInStock - $detailModel->qtyReal ;
                $HPP = $detailModel->HPP;
                $batchNumber = $detailModel->batchNumber;
                $mode = $batchNumber2; //stock opname/adjustment
                
//                var_dump($qtyInStock);
//                var_dump($detailModel->qtyReal);
                
                
//                $data = StockHpp::findOne(['batchNumber' => $batchNumber]);
//                $data->qtyStock = str_replace(",",".",str_replace(".","",$stockDetail['realQty']));
//                $data->save();
               
                $hpps = StockHpp::cutStock($warehouseID, $batchNumber, $qtyReal);
                //$updateStockHpp = StockHpp::findOne(['batchNumber' => $batchNumber, 'warehouseID' => $sourceWarehouseID ]);
                //$updateStockHpp->qtyStock = $qtyTotal;
                //$updateStockHpp->save();
                foreach ($hpps as $hpp)
                {
                    
//                    $insertStockHpp = new StockHpp;
//                    $insertStockHpp->stockDate =  date('Y-m-d H:i:s');
//                    $insertStockHpp->refNum =  $tempTransNum;
//                    $insertStockHpp->manufactureDate =  $detailModel->manufactureDate;
//                    $insertStockHpp->expiredDate =  $detailModel->expiredDate;
//                    $insertStockHpp->warehouseID =  $warehouseID;
//                    $insertStockHpp->productID =  $detailModel->productID;
//                    $insertStockHpp->HPP =  $hpp['HPP'];
//                    $insertStockHpp->qtyStock =  $hpp['qty'];
//                    $insertStockHpp->batchNumber =  $detailModel->batchNumber;
//                    $insertStockHpp->save();
                    
                    
                    $insertStockDetailHpp = new StockopnameDetailHpp();
                    $insertStockDetailHpp->stockOpnameDetailID =   $detailModel->stockOpnameDetailID;
                    $insertStockDetailHpp->stockDate =  $hpp['stockDate'];
                    $insertStockDetailHpp->refNum =  $hpp['refNum'];
                    $insertStockDetailHpp->HPP =  $hpp['HPP'];
                    $insertStockDetailHpp->qty =  $hpp['qty'];
                    $insertStockDetailHpp->manufactureDate =  $hpp['manufactureDate'];
                    $insertStockDetailHpp->retestDate =  $hpp['retestDate'];
                    $insertStockDetailHpp->expiredDate =  $hpp['expiredDate'];
                }
                if (!$insertStockDetailHpp->save() ) {
                    print_r($detailModel->getErrors());
                    Yii::$app->end();
                    $transaction->rollBack();
                    return false;
                }
                if (!$detailModel->save()) {
                    print_r($detailModel->getErrors());
                     
                    Yii::$app->end();
                    $transaction->rollBack();
                    return false;
                }
            }
            
            $mode = 3;
            $command = $connection->createCommand('call sp_insert_stockcard(:refNum,:transactiondates,:mode)');
            $command->bindParam(':refNum', $refNum);
            $command->bindParam(':transactiondates', $dates);
            $command->bindParam(':mode', $mode);
            $command->execute();
        }
        
        
        if(!$newTrans){
            //delete from journal
            $connection = MdlDb::getDbConnection();
            $sql = "DELETE a
            FROM tr_journaldetail a
            JOIN tr_journalhead b on a.journalHeadID = b.journalHeadID
            WHERE b.refNum = '" . $refNum ."' ";
            $command= $connection->createCommand($sql);
            $command->execute();
                
            TrJournalHead::deleteAll('refNum = :refNum', [":refNum" => $refNum]);
        }
        
        //insert to journal
        $connection = MdlDb::getDbConnection();
        $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
        $mode = 8; //stock adjustment

        $command->bindParam(':refNum', $refNum);
        $command->bindParam(':mode', $mode);
        $command->queryAll();
        $transaction->commit();
        return true;
    }
}
