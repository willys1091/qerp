<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsCustomer;
use app\models\MsWarehouse;
use app\models\StockHpp;
use app\models\TrCustomeradvancebalancehead;
use app\models\TrCustomerpayment;
use app\models\TrGoodsdeliverydetail;
use app\models\TrGoodsdeliveryhead;
use kartik\form\ActiveForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class GoodsDeliveryController extends MainController{
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
        $model = new TrGoodsdeliveryhead();
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionBrowse(){
        $this->view->params['browse'] = true;
        $model = new TrGoodsdeliveryhead();
        $model->load(Yii::$app->request->queryParams);
        $this->layout = 'browseLayout';
        return $this->render('browse', [
            'model' => $model
        ]);
    }

     public function actionBrowsepayment(){
        $this->view->params['browse'] = true;
        $model = new TrGoodsdeliveryhead();
        $model->load(Yii::$app->request->queryParams);
        $this->layout = 'browseLayout';
        
//        $query = TrGoodsdeliveryhead::find()
//                                        ->select(['tr_goodsdeliveryhead.goodsDeliveryNum', 
//                                            'ms_customer.customerName' ,
//                                            'tr_goodsdeliveryhead.goodsDeliveryDate',
//                                            'tr_goodsdeliveryhead.refNum'])
//                                        ->joinWith('salesOrder.customer')
//                                        ->joinWith('customerPayment')
//                                        ->where(['transType = "Sales Order"'])
//                                        ->andWhere(['tr_customerpayment.paymentAmount < tr_customerpayment.transactionAmount'])
//                                        ->andFilterWhere(['=', 'tr_goodsdeliveryhead.goodsDeliveryNum', $model->goodsDeliveryNum])
//                                        ->andFilterWhere(['like', 'tr_goodsdeliveryhead.goodsDeliveryNum', $model->goodsDeliveryNum])
//                                        ->andFilterWhere(['like', 'ms_customer.customerName', $model->customerName])
//                                        ->andFilterWhere(['like', 'tr_goodsdeliveryhead.refNum', $model->refNum])
//                                        ->andFilterWhere(['=', "DATE_FORMAT(tr_goodsdeliveryhead.goodsDeliveryDate, '%d-%m-%Y')", $model->goodsDeliveryDate]);
//        
//        $query2 = TrGoodsdeliveryhead::find()
//                                        ->select(['tr_goodsdeliveryhead.goodsDeliveryNum', 
//                                            'ms_customer.customerName' ,
//                                            'tr_goodsdeliveryhead.goodsDeliveryDate',
//                                            'tr_goodsdeliveryhead.refNum'])
//                                        ->joinWith('salesOrder.customer')
//                                        ->where(['transType = "Sales Order"'])
//                                        ->andFilterWhere(['=', 'tr_goodsdeliveryhead.goodsDeliveryNum', $model->goodsDeliveryNum])
//                                        ->andFilterWhere(['like', 'tr_goodsdeliveryhead.goodsDeliveryNum', $model->goodsDeliveryNum])
//                                        ->andFilterWhere(['like', 'ms_customer.customerName', $model->customerName])
//                                        ->andFilterWhere(['like', 'tr_goodsdeliveryhead.refNum', $model->refNum])
//                                        ->andFilterWhere(['=', "DATE_FORMAT(tr_goodsdeliveryhead.goodsDeliveryDate, '%d-%m-%Y')", $model->goodsDeliveryDate]);
//        $unions = $query->union($query2);
//        if (!$isDownload) {
//            $dataProvider = new ActiveDataProvider([
//            'query' =>  $unions,//$filter->productName ? $unions : $query2,
//            'sort' => [
//                'defaultOrder' => ['transactionDate' => SORT_ASC],
//
//                ],
//                'pagination' => [
//                    'pageSize' => 0
//                ]
//            ]);
        $gdDate  =  AppHelper::convertDateTimeFormat($model->goodsDeliveryDate, 'd-m-Y', 'Y-m-d');
        $filterDeliveryNum = !$model->goodsDeliveryNum ? '' : "
            AND receipt.refNum = '$model->goodsDeliveryNum'
            ";
        $filterDeliveryDate = !$model->goodsDeliveryDate ? '' : "
            AND receivable.goodsDeliveryDate LIKE '%$gdDate%'
            ";
       
        
        $sql = "SELECT  receipt.refNum AS goodsDeliveryNum, customer.customerName, receivable.goodsDeliveryDate, receivable.refNum,
        receipt.amount, receivable.transType,
        @paid := (
            SELECT IFNULL(SUM(tr_customerpayment.paymentAmount), 0) FROM tr_customerpayment WHERE tr_customerpayment.refNum = receipt.refNum
        ) AS paid,
        CAST(receipt.amount - @paid AS DECIMAL(20, 2)) AS outstanding
        FROM tr_customerreceivabledetail AS receipt
		LEFT JOIN tr_customerreceivablehead As csHead On csHead.receivableNum = receipt.receivableNum
		LEFT JOIN tr_goodsdeliveryhead AS receivable ON receivable.goodsDeliveryNum = receipt.refNum
        LEFT JOIN tr_salesorderhead AS soHead On soHead.salesOrderNum = receivable.refNum
        LEFT JOIN ms_customer As customer On customer.customerID = soHead.customerID
       
        WHERE receipt.amount - (
            SELECT IFNULL(SUM(tr_customerpayment.paymentAmount), 0) FROM tr_customerpayment WHERE tr_customerpayment.refNum = receipt.refNum
        ) > 0
        $filterDeliveryNum
        $filterDeliveryDate
        $filterTransNum
 
         
      
        ";
            
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => ['goodsDeliveryDate' => SORT_DESC, 'goodsDeliveryNum' => SORT_ASC],
                'attributes' => ['goodsDeliveryDate', 'goodsDeliveryNum']
            ]
        ]);
//        $dataProvider = new SqlDataProvider([
//                            'query' => TrGoodsdeliveryhead::find()
//                                        ->select('tr_goodsdeliveryhead.goodsDeliveryNum, ms_customer.customerName ,tr_goodsdeliveryhead.goodsDeliveryDate, tr_goodsdeliveryhead.refNum')
//                                        ->joinWith('salesOrder.customer')
//                                        ->joinWith('customerPayment')
//                                        ->where('transType = "Sales Order"')
//                                        //->andWhere('tr_customerpayment.paymentAmount < tr_customerpayment.transactionAmount')
//                                        ->andFilterWhere(['=', 'tr_goodsdeliveryhead.goodsDeliveryNum', $model->goodsDeliveryNum])
//                                        ->andFilterWhere(['like', 'tr_goodsdeliveryhead.goodsDeliveryNum', $model->goodsDeliveryNum])
//                                        ->andFilterWhere(['like', 'ms_customer.customerName', $model->customerName])
//                                        ->andFilterWhere(['like', 'tr_goodsdeliveryhead.refNum', $model->refNum])
//                                        ->andFilterWhere(['=', "DATE_FORMAT(tr_goodsdeliveryhead.goodsDeliveryDate, '%d-%m-%Y')", $model->goodsDeliveryDate]),
//                            'sort' => [
//                                        'defaultOrder' => ['tr_goodsdeliveryhead.goodsDeliveryDate' => SORT_DESC, 'tr_goodsdeliveryhead.goodsDeliveryNum' => SORT_ASC],
//                                        'attributes' => ['tr_goodsdeliveryhead.goodsDeliveryDate', 'tr_goodsdeliveryhead.goodsDeliveryNum']
//                                    ]
//                        ]);
        return $this->render('browse', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
	
	public function actionBrowsebycustomer($filter)
    {
        $this->view->params['browse'] = true;
        $model = new TrGoodsdeliveryhead();
        $model->load(Yii::$app->request->queryParams);
        
        $dataProvider = new ActiveDataProvider([
                            'query' => TrGoodsdeliveryhead::find()
                                        ->select(['tr_goodsdeliveryhead.goodsDeliveryNum','tr_goodsdeliveryhead.goodsDeliveryDate','tr_goodsdeliveryhead.refNum'])
                                        ->joinWith('salesOrder')
                                        ->where('tr_salesorderhead.customerID = :refCustomer',[':refCustomer' => $filter])
                                        ->andFilterWhere(['=', 'DATE(tr_goodsdeliveryhead.goodsDeliveryDate)', AppHelper::convertDateTimeFormat($model->goodsDeliveryDate, 'd-m-Y', 'Y-m-d')])
                                        ->andFilterWhere(['like', 'tr_goodsdeliveryhead.goodsDeliveryNum', $model->goodsDeliveryNum])
                                        ->andFilterWhere(['like', 'tr_goodsdeliveryhead.refNum', $model->refNum])
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browsebycustomer', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
   

    /**
     * Updates an existing TrGoodsdeliveryhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (strpos($id, 'SO') !== false){
            $model = $this->findRefSO($id);
            $model->transType = 'Sales Order';
        }
        else if (strpos($id, 'PR') !== false){
            $model = $this->findRefPR($id);
            $model->transType = 'Purchase Return';
        }
        else if (strpos($id, 'ST') !== false){
            $model = $this->findRefST($id);
            $model->transType = 'Stock Transfer';
        }
        $model->refNum = $id;
        $model->deliveryStatus = 1;
        $model->shipmentBy = "PT QWINJAYA ADITAMA";
        $model->joinStockDetail = [];
        
        $modelStock = StockHpp::find()->all();

        $j = 0;
        foreach ($modelStock as $joinStockDetail) {
            $model->joinStockDetail[$j]["batchNumber"] = $joinStockDetail['batchNumber'];
            
            $j += 1;
        }

        $model->goodsDeliveryDate = date('d-m-Y');       

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

    public function actionGetStockDetail()
    {
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            
            $warehouseID = $data['warehouseID'];
            $productID = $data['productID'];

            $detailModels = StockHpp::find()->select('batchNumber,qtyStock,manufactureDate,expiredDate,retestDate')->where(['warehouseID'=>$warehouseID,'productID'=>$productID])->all();
            
            $data = array();
            foreach ($detailModels as $detailModel) {
                $editedManDate = AppHelper::convertDateTimeFormat($detailModel->manufactureDate, 'Y-m-d H:i:s', 'd-m-Y');
                $editedExpiredDate = AppHelper::convertDateTimeFormat($detailModel->expiredDate, 'Y-m-d H:i:s', 'd-m-Y');
                $editedRetestDate = AppHelper::convertDateTimeFormat($detailModel->retestDate, 'Y-m-d H:i:s', 'd-m-Y');
				
                $temp["id"] = $detailModel->batchNumber.'|'.$detailModel->qtyStock.'|'.$editedManDate.'|'.$editedExpiredDate.'|'.$editedRetestDate;
                $temp["text"] = $detailModel->batchNumber;
                array_push($data, $temp);
            }
        }

        return Json::encode($data);
    }
    /**
     * Deletes an existing TrGoodsdeliveryhead model.
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
     * Finds the TrGoodsdeliveryhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrGoodsdeliveryhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrGoodsdeliveryhead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findRefSO($id)
    {
        if (($model = TrGoodsdeliveryhead::find()
                                        ->rightJoin('tr_salesorderhead', 'tr_goodsdeliveryhead.refNum = tr_salesorderhead.salesOrderNum')
                                        ->where(['tr_salesorderhead.salesOrderNum' => $id])
                                        ->one()
            ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findRefPR($id)
    {
        if (($model = TrGoodsdeliveryhead::find()
                                        ->rightJoin('tr_purchasereturnhead', 'tr_goodsdeliveryhead.refNum = tr_purchasereturnhead.purchaseReturnNum')
                                        ->where(['tr_purchasereturnhead.purchaseReturnNum' => $id])
                                        ->one()
            ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findRefST($id)
    {
        if (($model = TrGoodsdeliveryhead::find()
                                        ->rightJoin('tr_stocktransferhead', 'tr_goodsdeliveryhead.refNum = tr_stocktransferhead.stockTransferNum')
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
        $goodsModel = new TrGoodsdeliveryhead();
        $connection = MdlDb::getDbConnection();
        
        $transaction = $connection->beginTransaction();
        $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $modelMonth = date("m",strtotime($model->goodsDeliveryDate)) - 1;
       
        $tempModel = TrGoodsdeliveryhead::find()
        ->where('SUBSTRING(goodsDeliveryNum, 8, 2) LIKE :goodsDeliveryDate',[
                ':goodsDeliveryDate' => date("y",strtotime($model->goodsDeliveryDate))
        ])
        ->orderBy([new Expression("CAST(SUBSTRING(goodsDeliveryNum, '-4', '4') AS UNSIGNED) DESC")])
        ->one();
        $tempTransNum = "";
        
        if (empty($tempModel)){
            $starting = date("Y",strtotime($model->goodsDeliveryDate)) == '2017' ? '0293' : '0001';
            $tempTransNum = "QJA/GD/".date("y",strtotime($model->goodsDeliveryDate))."/".$month[$modelMonth]."/".$starting;
        }
        else{
            $temp = substr($tempModel->goodsDeliveryNum,-4,4)+1;
            $temp = str_pad($temp,4,"0",STR_PAD_LEFT);
            $tempTransNum = "QJA/GD/".date("y",strtotime($model->goodsDeliveryDate))."/".$month[$modelMonth]."/".$temp;
        }
        
        $goodsModel->goodsDeliveryNum = $tempTransNum;
        $goodsModel->refNum = $model->refNum;
        $goodsModel->invoiceNum = $model->invoiceNum;
        $goodsModel->transType = $model->transType;
        $goodsModel->deliveryNum = $model->deliveryNum;
        $goodsModel->deliveryStatus = $model->deliveryStatus;
        $goodsModel->warehouseID = $model->warehouseID;
        $goodsModel->shipmentBy = $model->shipmentBy;
        $goodsModel->customerDetailID = $model->customerDetailID;
        $goodsModel->goodsDeliveryDate = AppHelper::convertDateAndTimeFormat($model->goodsDeliveryDate.' '.$model->goodsDeliveryTime, 'd-m-Y H:i', 'Y-m-d H:i');
        $goodsModel->additionalInfo = $model->additionalInfo;
        $goodsModel->createdBy = Yii::$app->user->identity->username;
        $goodsModel->createdDate = new Expression('NOW()');
        $goodsModel->editedBy = Yii::$app->user->identity->username;
        $goodsModel->editedDate = new Expression('NOW()');

        if (!$goodsModel->save()) {
            print_r($goodsModel->getErrors());
            $transaction->rollBack();
            return false;
        }
        $deliveryDates = $goodsModel->goodsDeliveryDate;
        $setSql = "SET SQL_SAFE_UPDATES=0";
        $command = $connection->createCommand($setSql);
        $command->execute();

        $journalRefNum = $goodsModel->goodsDeliveryNum;
        $goodsReceiptNum = $goodsModel->goodsDeliveryNum;
        foreach ($model->joinGoodsDeliveryDetail as $goodsDetail) {
            $batchNumberArr = explode("|",$goodsDetail['batchNumber']);
            $goodsDetailModel = new TrGoodsdeliverydetail();
            $goodsDetailModel->goodsDeliveryNum = $goodsModel->goodsDeliveryNum;
            $goodsDetailModel->productID = $goodsDetail['productID'];
            $goodsDetailModel->uomID = $goodsDetail['uomID'];
            $goodsDetailModel->qty = str_replace(",",".",str_replace(".","",$goodsDetail['qty']));
            $goodsDetailModel->batchNumber = $batchNumberArr[0];
            $goodsDetailModel->manufactureDate = AppHelper::convertDateTimeFormat($goodsDetail['manufactureDate'], 'd-m-Y', 'Y-m-d');
            if(!empty($goodsDetail['expiredDate'])) $goodsDetailModel->expiredDate = AppHelper::convertDateTimeFormat($goodsDetail['expiredDate'], 'd-m-Y', 'Y-m-d');
            if(!empty($goodsDetail['retestDate'])) $goodsDetailModel->retestDate = AppHelper::convertDateTimeFormat($goodsDetail['retestDate'], 'd-m-Y', 'Y-m-d');
            $goodsDetailModel->pack = $goodsDetail['packID'];
            $goodsDetailModel->packQty = $goodsDetail['packQty'];
            $goodsDetailModel->notes = nl2br($goodsDetail['notes']);

            $productID = $goodsDetailModel->productID;
            $qty = $goodsDetailModel->qty;
            $batchNumber = $goodsDetailModel->batchNumber;
            $manufactureDate = $goodsDetailModel->manufactureDate;
            $expiredDate = $goodsDetailModel->expiredDate;
            $retestDate = $goodsDetailModel->retestDate;

            if (!$goodsDetailModel->save()) {
                print_r($goodsDetailModel->getErrors());
                $transaction->rollBack();
                return false;
            }
            $warehouseID = $model->warehouseID;
            StockHpp::cutStock($warehouseID, $batchNumber, $qty);
              
              //$command = $connection->createCommand('call sp_delete_stockhpp(:warehouseID,:productID,:qty,:batchNumber)');
              //$command->bindParam(':warehouseID', $warehouseID);
//            $command->bindParam(':productID', $productID);
//            $command->bindParam(':qty', $qty);
//            $command->bindParam(':batchNumber', $batchNumber);
//            $command->execute();
        }
        //input to stock card
        $mode = 2;
        $command = $connection->createCommand('call sp_insert_stockcard(:refNum,:transactionDates,:mode)');
        $command->bindParam(':refNum', $goodsReceiptNum);
        $command->bindParam(':transactionDates', $deliveryDates);
        $command->bindParam(':mode', $mode);
        $command->execute(); 
        
        if($model->transType == "Sales Order" || $model->transType == "Purchase Return"){
            //input to journal
            $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
            $mode = 'goods delivery'; //goods delivery

            $command->bindParam(':refNum', $journalRefNum);
            $command->bindParam(':mode', $mode);

            $command->queryAll();
            
        }
        
        if($model->transType == "Sales Order"){
            //input to payable
            $command = $connection->createCommand('call sp_insert_payablereceivable(:refNum, :mode)');
            $mode = 3; //goods delivery

            $command->bindParam(':refNum', $journalRefNum);
            $command->bindParam(':mode', $mode);
            
            $command->execute();
                
        }

        $transaction->commit();
        return true;
    }
}
