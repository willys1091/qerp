<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\StockCard;
use app\models\StockHpp;
use app\models\TrGoodsreceiptcost;
use app\models\TrGoodsreceiptdetail;
use app\models\TrGoodsreceipthead;
use app\models\TrGoodsreceiptheadhistory;
use app\models\TrJournaldetail;
use app\models\TrJournalhead;
use app\models\TrSupplierpayabledetail;
use app\models\TrSupplierpayablehead;
use app\models\TrSupplierpaymentdetail;
use kartik\form\ActiveForm;
use mPDF;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GoodsReceiptHistoryController implements the CRUD actions for TrGoodsreceipthead model.
 */
class GoodsReceiptHistoryController extends MainController
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
        $model = new TrGoodsreceiptheadhistory();
        //$model->goodsReceiptDate = date('d-m-Y');
        $model->startDate  = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->goodsReceiptDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

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
        $model = new TrGoodsreceiptheadhistory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->goodsReceiptNum]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TrGoodsreceipthead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->joinHsCodeDetail = [];
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->invoiceDate = date("Y-m-d H:i", strtotime($model->invoiceDate));
            $model->SKIDate = date("Y-m-d H:i", strtotime($model->SKIDate));
            if ($this->saveModel($model, true)) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
                'model' => $model
        ]);
    }
    
    public function actionUpdatehead($id)
    {   $connection = Yii::$app->db;
        $model = $this->findModel($id);
       
       

        if ($model->load(Yii::$app->request->post())) {
           
            $model->goodsReceiptDate = $model->goodsReceiptDate = AppHelper::convertDateAndTimeFormat($model->goodsReceiptDate.' '.$model->goodsReceiptTime, 'd-m-Y H:i', 'Y-m-d H:i');
            $model->AWBNum = $model->AWBNum;
            $model->AWBDate = date("Y-m-d", strtotime($model->AWBDate));
            $model->deliveryNum = $model->deliveryNum;
            $model->warehouseID = $model->warehouseID;
            $model->SKIDate = date("Y-m-d", strtotime($model->SKIDate));
            $model->PPJK = $model->PPJK;
            $model->invoiceDate = date("Y-m-d", strtotime($model->invoiceDate));
			
			foreach ($model->joinGoodsReceiptDetail as $detail) {
               
                $details = TrGoodsreceiptdetail::findOne(['goodsReceiptNum' => $id, 'productID' => $detail['productID'], 'goodsReceiptDetailID' => $detail['goodsReceiptDetailID']]);
                
                $details->manufactureDate = $detail['manufactureDate'] ? date("Y-m-d", strtotime($detail['manufactureDate'])) : null;
                $details->expiredDate = $detail['expireDate'] ? date("Y-m-d", strtotime($detail['expireDate'])) : null;
                $details->retestDate = $detail['retestDate'] ? date("Y-m-d", strtotime($detail['retestDate'])) : null;
                $details->save();
				
				StockHpp::updateAll(['manufactureDate' => $details->manufactureDate, 'expiredDate' => $details->expiredDate, 'retestDate' => $details->retestDate], ['and',['=','productID',$detail['productID']], ['=','qtyStock',$detail['qtyReceived']], ['=','batchNumber',$detail['batchNumber']]]);
               
            }
			
			
            if ($model->save()) {
                
                StockCard::deleteAll('refNum = :refNum', [":refNum" => $id]);
                
                $mode = 1;
                $command = $connection->createCommand('call sp_insert_stockcard(:refNum,:transactionDates,:mode)');
                $command->bindParam(':refNum', $id);
                $command->bindParam(':transactionDates', $model->goodsReceiptDate);
                $command->bindParam(':mode', $mode);
                $command->execute(); 
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
                'model' => $model,
                'update' => 1
        ]);
    }
    
    public function actionUpdatereportimport($id)
    {
        $model = TrGoodsreceiptcost::find()->where(['goodsReceiptNum' => $id])->one();
        
        $model->lsDate ? $model->lsDate =  date("d-m-Y", strtotime($model->lsDate)) : '';
      
       
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->CIF = str_replace(",",".",str_replace(".","",$model->CIF));
            $model->CNF = str_replace(",",".",str_replace(".","",$model->CNF));
            $model->FOB = str_replace(",",".",str_replace(".","",$model->FOB));
            $model->lsDate =  date("Y-m-d", strtotime($model->lsDate));
            
            
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update_report_import', [
                'model' => $model
        ]);
    }
    
    
    public function actionPrint($id)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT h.fullName, a.goodsReceiptNum, a.goodsReceiptDate, a.SKINumber, a.SKIDate,
                month(a.goodsReceiptDate) as month, day(a.goodsReceiptDate) as day,
                date_format(a.goodsReceiptDate, "%h:%i %p") as jam, a.createdBy,
                b.productID, c.productName, c.origin, e.supplierName, a.invoiceNum, 
                a.refNum, b.packQty, f.uomName, g.packingTypeName, b.qty, b.batchNumber, 
                 b.manufactureDate, b.expiredDate, b.retestDate, d.shipmentType, b.temperature, b.notes
                FROM tr_goodsreceipthead a
                LEFT JOIN tr_goodsreceiptdetail b ON b.goodsReceiptNum = a.goodsReceiptNum
                LEFT JOIN ms_product c ON c.productID = b.productID 
                LEFT JOIN tr_purchaseorderhead d ON d.purchaseOrderNum = a.refNum
                LEFT JOIN ms_supplier e ON e.supplierID = c.supplierID
                LEFT JOIN ms_uom f ON f.uomID = b.uomID
                LEFT JOIN ms_packingtype g ON g.packingTypeID = b.pack
                LEFT JOIN ms_user h on h.username = a.createdBy
                
                WHERE a.goodsReceiptNum = "'.$id.'"';
        $temp = $connection->createCommand($sql);
        $model = $temp->queryAll();
        $view = 'report_view_goods_receipt_history';  
        $check1 = $connection->createCommand('SELECT value1, value2 FROM ms_setting WHERE key1 = "checker1" AND key2 = "goodsReceipt"')->queryAll();
        $check2 = $connection->createCommand('SELECT value1, value2 FROM ms_setting WHERE key1 = "checker2" AND key2 = "goodsReceipt"')->queryAll();
        $audit1 = $connection->createCommand('SELECT value1, value2 FROM ms_setting WHERE key1 = "audit1" AND key2 = "goodsReceipt"')->queryAll();
        $audit2 = $connection->createCommand('SELECT value1, value2 FROM ms_setting WHERE key1 = "audit2" AND key2 = "goodsReceipt"')->queryAll();
        
        $head = TrGoodsreceipthead::findOne($id);
        
        $mpdf = new mPDF();
        
        $productCount = sizeof($model);
        $startIndex = 0;
        $count = 4;
        $pages = [];
        while ($startIndex < $productCount)
        {
            $content = $this->renderPartial($view, [         
                'model' => array_slice($model, $startIndex, $count),
                'mpdf' => $mpdf,
                'head' => $head,
                'check1' => $check1,
                'check2' => $check2,
                'audit1' => $audit1,
                'audit2' => $audit2
            ]);
            array_push($pages, $content);
            
            $startIndex += $count;
        }
        
        $pageCount = sizeof($pages);
        for ($i = 0; $i < $pageCount; $i++)
        {
            $content = $pages[$i];
            
            $mpdf->AddPage('L');
            $content = str_replace('{pagecount}', $pageCount, str_replace('{pageno}', $i + 1, $content));
            $mpdf->WriteHTML($content);
        }
        
        $mpdf->debug = true;
        $mpdf->Output('report.pdf','I');
        exit;
    }

    public function actionBrowsebypurchase($filter)
    {
        $this->view->params['browse'] = true;
        $model = new TrGoodsreceiptheadhistory();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrGoodsreceiptheadhistory::find()
                                        ->where('refNum = :PurchseNum',[':PurchseNum' => $filter]),
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browsebypurchase', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    
    public function actionBrowsebyproduct($filter)
    {
        $this->view->params['browse'] = true;
        $model = new TrGoodsreceiptdetail();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrGoodsreceiptdetail::find()
                                        ->select('ms_product.productName, tr_goodsreceiptdetail.*')
                                        ->joinWith('product')
                                        ->where('goodsReceiptNum = :goodsReceiptNum',[':goodsReceiptNum' => $filter])
                                        ->andFilterWhere(['like', 'ms_product.productName', $model->productName])
                                        ->andFilterWhere(['=', 'tr_goodsreceiptdetail.goodsReceiptNum', $model->goodsReceiptNum]),
                        ]);
        
        $this->layout = 'browseLayout';
        return $this->render('browsebyproduct', [
            'dataProvider' => $dataProvider,
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
        $transaction = Yii::$app->db->beginTransaction();   
        try{
            TrGoodsreceiptdetail::deleteAll('goodsReceiptNum = :goodsReceiptNum', [":goodsReceiptNum" => $id]);
            $this->findModel($id)->delete();


            
            //TrJournalhead::deleteAll('refNum = :refNum', ["refNum" => $id]);
            
            TrGoodsreceiptcost::deleteAll('goodsReceiptNum = :goodsReceiptNum', [":goodsReceiptNum" => $id]);
            StockHpp::deleteAll('refNum = :refNum', [":refNum" => $id]);
            StockCard::deleteAll('refNum = :refNum', [":refNum" => $id]);
            
            
            //TrSupplierpayabledetail::deleteAll('refNum = :refNum', [":refNum" => $id]);
            
            //TrSupplierpayabledetail::deleteAll('refNum = :refNum', [":refNum" => $id]);

            
        } catch (Exception $exception) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
        return $this->redirect(['index']);
    }
    
    public function actionDeleteApprove($id)
    {   
 
        $transaction = Yii::$app->db->beginTransaction();   
        try{
            TrGoodsreceiptdetail::deleteAll('goodsReceiptNum = :goodsReceiptNum', [":goodsReceiptNum" => $id]);
            $this->findModel($id)->delete();

            
            //$journal = TrJournalhead::findOne(['refNum' => $id, 'transactionType' => 'Import Duty']);
            //$journal->delete();
            $journalGr = TrJournalhead::findOne(['refNum' => $id, 'transactionType' => 'Goods Receipt']);
            $journalGr->delete();
            //TrJournalhead::deleteAll('refNum = :refNum', ["refNum" => $id]);
            
            TrGoodsreceiptcost::deleteAll('goodsReceiptNum = :goodsReceiptNum', [":goodsReceiptNum" => $id]);
            StockHpp::deleteAll('refNum = :refNum', [":refNum" => $id]);
            StockCard::deleteAll('refNum = :refNum', [":refNum" => $id]);
            $supplierPayableDetail = TrSupplierpayabledetail::findOne(['refNum' => $id]);
            $supplierPayableHead = $supplierPayableDetail->trSupplierpayablehead;
            $supplierPayableDetail->delete();
            $supplierPayableHead->delete();
            
            //TrSupplierpayabledetail::deleteAll('refNum = :refNum', [":refNum" => $id]);
            
            //TrSupplierpayabledetail::deleteAll('refNum = :refNum', [":refNum" => $id]);

            
            
            
        } catch (Exception $exception) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
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
        if (($model = TrGoodsreceiptheadhistory::findOne($id)) !== null) {
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
        
//        $goodsModel->goodsReceiptNum = $model->goodsReceiptNum;
//        $goodsModel->refNum = $model->refNum;
//        $goodsModel->transType = $model->transType;
//        $goodsModel->deliveryNum = $model->deliveryNum;
//        $goodsModel->warehouseID = $model->warehouseID;
//        $goodsModel->goodsReceiptDate = AppHelper::convertDateAndTimeFormat($model->goodsReceiptDate.' '.$model->goodsReceiptTime, 'd-m-Y H:i', 'Y-m-d H:i');
//        $goodsModel->AWBDate = AppHelper::convertDateTimeFormat($model->AWBDate, 'd-m-Y', 'Y-m-d');
//        $goodsModel->AWBNum = $model->AWBNum;
//        $goodsModel->PPJK = $model->PPJK;
//       
//        $goodsModel->editedBy = Yii::$app->user->identity->username;
//        $goodsModel->editedDate = new Expression('NOW()');

        // echo "<pre>";
        // var_dump($goodsModel);
        // echo "</pre>";
        // yii::$app->end();
        
        $model->goodsReceiptDate = AppHelper::convertDateAndTimeFormat($model->goodsReceiptDate.' '.$model->goodsReceiptTime, 'd-m-Y H:i', 'Y-m-d H:i');
        $model->AWBDate = AppHelper::convertDateTimeFormat($model->AWBDate, 'd-m-Y', 'Y-m-d');
        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }
        
//        $connection = MdlDb::getDbConnection();
//        $setSql = "SET SQL_SAFE_UPDATES=0";
//        $command = $connection->createCommand($setSql);
//        $command->execute();
        
        TrGoodsreceiptdetail::deleteAll('goodsReceiptNum = :goodsReceiptNum', [":goodsReceiptNum" => $model->goodsReceiptNum]);
        
        if (empty($model->joinGoodsReceiptDetail) || !is_array($model->joinGoodsReceiptDetail) || count($model->joinGoodsReceiptDetail) < 1) {
            $transaction->rollBack();
            return false;
        }
      
        foreach ($model->joinGoodsReceiptDetail as $goodsDetail) {
            $goodsDetailModel = new TrGoodsreceiptdetail();
            $goodsDetailModel->goodsReceiptNum = $model->goodsReceiptNum;
            $goodsDetailModel->productID = $goodsDetail['productID'];
            $goodsDetailModel->uomID = $goodsDetail['uomID'];
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
            $goodsDetailModel->notes = "";
             
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
