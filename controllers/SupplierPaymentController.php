<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSupplier;
use app\models\TrGoodsreceipthead;
use app\models\TrGoodsreceipthead2;
use app\models\TrJournalhead;
use app\models\TrPurchaseordernoninventoryhead;
use app\models\TrSupplieradvancebalancedetail;
use app\models\TrSupplieradvancebalancehead;
use app\models\TrSupplieradvancepayment;
use app\models\TrSupplierpayabledetail;
use app\models\TrSupplierpayablehead;
use app\models\TrSupplierpaymentdetail;
use app\models\TrSupplierpaymenthead;
use kartik\widgets\ActiveForm;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SupplierPaymentController extends MainController
{
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

    public function actionIndex()
    {
        $model = new TrSupplierpaymenthead();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->supplierPaymentDate = "$model->startDate to $model->endDate";
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

    public function actionCreate()
    {
        $model = new TrSupplierpaymenthead();
        $model->joinPaymentDetail = [];
        $model->supplierPaymentDate = date('d-m-Y');
        $model->createdBy = Yii::$app->user->identity->username;
        $model->editedBy = Yii::$app->user->identity->username;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $existing = TrSupplierpaymenthead::find()
                    ->where(['voucherNum' => $model->voucherNum])
                    ->one();
            
            if ($existing)
            {
                $model->errorMessages = [
                    "Voucher Number has already been used in payment number $existing->supplierPaymentNum"
                ];
                return $this->render('create', [
                    'model' => $model
                ]);
            }
            
            if ($this->saveModel($model, true)) {
                return $this->redirect(['index']);
            }
            
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionBrowsebysupplier($filter,$filter2)
    {
        $this->view->params['browse'] = true;
        $model = new TrGoodsreceipthead();
        $model->load(Yii::$app->request->queryParams);
        
        
        $grDate  =  AppHelper::convertDateTimeFormat($model->transactionDate, 'd-m-Y', 'Y-m-d');
        $filterGrDate = !$model->transactionDate ? '' : "
            AND DATE(receiptHead.goodsReceiptDate) = '$grDate'
            ";
        $filterRefnum= !$model->transactionRefNum ? '' : "
            AND receiptHead.goodsReceiptNum LIKE '%$model->transactionRefNum%'
            ";
        $filterOriRefnum= !$model->originalRefNum ? '' : "
            AND receiptHead.refNum LIKE '%$model->originalRefNum%'
            ";
        $newQuery = "SELECT IFNULL((receiptHead.goodsReceiptNum),payDetail.refNum) AS transactionRefNum, payHead.payableDate AS transactionDate, 
        receiptHead.refNum AS originalRefNum, payDetail.amount AS grandTotal,
        (
            SELECT IFNULL(SUM(advPaymentDetail.amount), 0)
            FROM tr_supplieradvancebalancedetail AS advPaymentDetail
            LEFT JOIN tr_supplieradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
            WHERE advPaymentDetail.refNum = receiptHead.refNum AND advPaymenthead.supplierID = pohead.supplierID
        ) AS advancedPaymentAmount,
        (
            SELECT IFNULL(SUM(paymentDetail.paymentAmount), 0)
            FROM tr_supplierpaymenthead AS paymentHead
            LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
            WHERE paymentDetail.refNum = payDetail.refNum AND paymentHead.supplierID = payHead.supplierID 
        ) AS previousPayment,
        CAST((SELECT payDetail.amount - advancedPaymentAmount - previousPayment) AS DECIMAL(18,2)) AS outstandingAmount
        FROM  tr_supplierpayabledetail AS payDetail 
        LEFT JOIN tr_goodsreceipthead AS receiptHead ON payDetail.refNum = receiptHead.goodsReceiptNum
        LEFT JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = receiptHead.refNum
        LEFT JOIN tr_supplierpayablehead AS payHead ON payHead.payableNum = payDetail.payableNum
        WHERE  payDetail.currency = '$filter2' AND payHead.supplierID = $filter
        $filterGrDate   
        $filterRefnum
        $filterOriRefnum    
        HAVING outstandingAmount > 0
        ORDER BY transactionDate DESC";

        $dataProvider = new SqlDataProvider([
            'sql' => $newQuery,
            //'params' => [':status' => 1],
            //'totalCount' => 1,
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);
        
        $this->layout = 'browseLayout';
        return $this->render('browsebysupplier', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionCheckrefnum()
    {
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];
            $supplierID = $data['supplierID'];
            $supplierModel = MsSupplier::findOne($supplierID);
            
            
            $refNumArray = explode("/", $refNum);
            
            if($refNumArray[1] == "GR"){
                $sqlGoods = "SELECT c.supplierID,b.refNum,IF(c.isImport=1,b.pibRate,c.rate) as rate,sum(a.qty*d.price*(100-d.discount)/100) as price,c.taxRate
                        from tr_goodsreceiptdetail a join tr_goodsreceipthead b on a.goodsReceiptNum=b.goodsReceiptNum
                        join tr_purchaseorderhead c on b.refNum=c.purchaseOrderNum
                        left join tr_purchaseorderdetail d on c.purchaseOrderNum=d.purchaseOrderNum and a.productID=d.productID
                        where a.goodsReceiptNum='".$refNum."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlGoods);
                $headResult = $temp->queryAll();
                foreach ($headResult as $queryResult) {
                    $GRRefNum = $queryResult['refNum'];
                    $supplierID = $queryResult['supplierID'];
                    $result["whtAmount"] = "0.00";
                    $result["price"] = $queryResult['price'];
                    $result["rate"] = $queryResult['rate'];
                    $result["taxRate"] = $queryResult['taxRate'];
                }
            }
            else if($refNumArray[1] == "PONI"){
                $sqlGoods = "SELECT a.supplierID,a.rate,a.hasVAT,a.WHTRate,sum(b.qty*b.price*(100-b.discount)/100) as price
                        from tr_purchaseordernoninventoryhead a join tr_purchaseordernoninventorydetail b on a.purchaseOrderNonInventoryNum=b.purchaseOrderNonInventoryNum
                        where a.purchaseOrderNonInventoryNum='".$refNum."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlGoods);
                $headResult = $temp->queryAll();
                foreach ($headResult as $queryResult) {
                    $supplierID = $queryResult['supplierID'];
                    $result["whtAmount"] = $queryResult['price']*$queryResult['WHTRate']/100;
                    $result["price"] = $queryResult['price'];
                    $result["rate"] = $queryResult['rate'];
                    $result["taxRate"] = ($queryResult['hasVAT'] > 0)? "10,00":"0,00";
                }
            }  else if($refNumArray[0] == "INIT"){
                $sqlGoods = "SELECT b.supplierID,a.amount as price
                        from tr_supplierpayabledetail a join tr_supplierpayablehead b on a.payableNum=b.payableNum
                        where a.refNum='".$refNum."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlGoods);
                $headResult = $temp->queryAll();
                foreach ($headResult as $queryResult) {
                    $supplierID = $queryResult['supplierID'];
                    $result["whtAmount"] = "0.00";
                    $result["price"] = $queryResult['price'];
                    $result["rate"] = "0.00";
                    $result["taxRate"] = 0.00;
                }
            }

            $modelPreviousPayment = TrSupplierpaymenthead::find()
                                    ->select([new Expression('SUM(tr_supplierpaymentdetail.paymentAmount) as paymentAmount')])
                                    ->joinWith('paymentDetail')
                                    ->where('tr_supplierpaymentdetail.refNum = :refNum',[':refNum' => $refNum])
                                    ->andWhere(['supplierID' => $supplierID])
                                    ->one();
            if(is_null($modelPreviousPayment->paymentAmount)){
                $result["previousPayment"] = "0.00";
            }
            else{
                $result["previousPayment"] = $modelPreviousPayment->paymentAmount;
            }

            $modelAdvancedPayment = TrSupplieradvancebalancehead::find()
                                    ->select([new Expression('SUM(tr_supplieradvancebalancedetail.amount) as amount')])
                                    ->joinWith('balanceDetail')
                                    ->andFilterWhere(['refNum' => $GRRefNum])
                                    ->andWhere(['supplierID' => $supplierID])
                                    ->one();

            if(is_null($modelAdvancedPayment->amount))
                $result["advancedPayment"] = "0.00";
            else
                $result["advancedPayment"] = $modelAdvancedPayment->amount;

            return \yii\helpers\Json::encode($result);
        }
    }

    public function actionOutstanding($filter,$filter2){
        $model = new TrSupplierpaymenthead();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => TrSupplierpaymenthead::find()
                        ->where(['=', 'refNum', $filter]),
        ]);

        $this->layout = 'browseLayout';
        return $this->render('outstanding', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveModel($model, false)) {
                return $this->redirect(['index']);
            }
            
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $connection = MdlDb::getDbConnection();
        $setSql = "SET SQL_SAFE_UPDATES=0";
        $command = $connection->createCommand($setSql);
        $command->execute();

        $sql = "DELETE from tr_journaldetail
                where journalHeadID IN
                (SELECT journalHeadID from tr_journalhead where refNum='".$id."')";
        $connection = MdlDb::getDbConnection();
        $command = $connection->createCommand($sql);
        $command->execute();

        TrJournalhead::deleteAll('refNum = :refNum', [":refNum" => $id]);

        $connection = MdlDb::getDbConnection();
        $setSql = "SET SQL_SAFE_UPDATES=0";
        $command = $connection->createCommand($setSql);
        $command->execute();

//        $payableDetailModel = TrSupplierpayabledetail::find()
//                            ->where('refNum = "'.$id.'"')
//                            ->one();
//        if ($payableDetailModel)
//        {
//            $payableNum = $payableDetailModel->payableNum;
//            TrSupplierpayabledetail::deleteAll('refNum = :refNum', [":refNum" => $id]);
//            TrSupplierpayablehead::deleteAll('payableNum = :payableNum', [":payableNum" => $payableNum]);
//        }
        
        $detail = TrSupplierpaymentdetail::find()->where(['supplierPaymentNum' => $id ])->all();
        
        foreach ($detail as $d) {
            
            $idSuppAdvance= TrSupplieradvancebalancedetail::find()->where(['refNum' => $d['refNum']])->one();
            TrSupplieradvancebalancedetail::deleteAll('refNum = :refNum', [":refNum" =>  $d['refNum']]);
            TrSupplieradvancebalancehead::deleteAll('balanceHeadID = :balanceHeadID', [":balanceHeadID" => $idSuppAdvance['balanceHeadID']]);
            
        }
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = TrSupplierpaymenthead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function saveModel($model, $newTrans)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        
        $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $modelMonth = date("m",strtotime($model->supplierPaymentDate)) - 1;
       
        if ($newTrans){
            $tempModel = TrSupplierpaymenthead::find()
            ->where("SUBSTRING_INDEX(SUBSTRING_INDEX(supplierPaymentNum, '/', 3), '/', -1) LIKE :y",[
                    ':y' => date("y",strtotime($model->supplierPaymentDate))
            ])
            ->orderBy([new Expression("CAST(SUBSTRING(supplierPaymentNum, '-3', '3') AS UNSIGNED) DESC")])
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/SP/".substr(date("Y",strtotime($model->supplierPaymentDate)), -2)."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->supplierPaymentNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/SP/".substr(date("Y",strtotime($model->supplierPaymentDate)), -2)."/".$month[$modelMonth]."/".$temp;
            }
            
            $model->supplierPaymentNum = $tempTransNum;
            $model->createdDate = new Expression('NOW()');
        }

        $model->supplierPaymentDate = AppHelper::convertDateTimeFormat($model->supplierPaymentDate, 'd-m-Y', 'Y-m-d');
        $model->editedDate = new Expression('NOW()');
        $model->rate = str_replace(",",".",str_replace(".","",$model->rate));
        $model->provisiCost = str_replace(",",".",str_replace(".","",$model->provisiCost));
        $model->adminFeeAmount = str_replace(",",".",str_replace(".","",$model->adminFeeAmount));
        $model->adminFeeRate = str_replace(",",".",str_replace(".","",$model->adminFeeRate));
        $journalRefNum = $model->supplierPaymentNum;

        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }

        TrSupplierpaymentdetail::deleteAll('supplierPaymentNum = :supplierPaymentNum', [":supplierPaymentNum" => $model->supplierPaymentNum]);
        
        if (empty($model->joinPaymentDetail) || !is_array($model->joinPaymentDetail) || count($model->joinPaymentDetail) < 1) {
            $transaction->rollBack();
            return false;
        }
       
        
        foreach ($model->joinPaymentDetail as $joinPaymentDetail) {
            if(!$newTrans){
                $tax = $joinPaymentDetail['taxRate'];
            } else {
                $tax = str_replace(",",".",str_replace(".","",$joinPaymentDetail['taxRate']));
            }
            $paymentDetailModel = new TrSupplierpaymentdetail();
            $paymentDetailModel->supplierPaymentNum = $model->supplierPaymentNum;
            $paymentDetailModel->refNum = $joinPaymentDetail['refNum'];
            $paymentDetailModel->whtAmount = str_replace(",",".",str_replace(".","",$joinPaymentDetail['WHTAmount']));
            $paymentDetailModel->transactionAmountBeforeTax = str_replace(",",".",str_replace(".","",$joinPaymentDetail['priceBeforeTax']));
            $paymentDetailModel->tax =  str_replace(",",".",str_replace(".","",$joinPaymentDetail['taxRate']));
            $paymentDetailModel->paymentAmount = str_replace(",",".",str_replace(".","",$joinPaymentDetail['payment']));
            $outstanding = str_replace(",",".",str_replace(".","",$joinPaymentDetail['outstanding']));
            $advancedPayment = str_replace(",",".",str_replace(".","",$joinPaymentDetail['advancedPayment']));

            if (!$paymentDetailModel->save()) {
                print_r($paymentDetailModel->getErrors());
                $transaction->rollBack();
                return false;
            }

            if($advancedPayment > 0){
                $advancedBalanceHead = new TrSupplieradvancebalancehead();
                $advancedBalanceHead->balanceDate = new Expression('NOW()');
                $advancedBalanceHead->supplierID = $model->supplierID;
                if (!$advancedBalanceHead->save()) {
                    print_r($advancedBalanceHead->getErrors());
                    $transaction->rollBack();
                    return false;
                }

                $advancedBalanceDetail = new TrSupplieradvancebalancedetail();
                $advancedBalanceDetail->balanceHeadID = $advancedBalanceHead->balanceHeadID;
                $advancedBalanceDetail->refNum = $paymentDetailModel->refNum;
                $advancedBalanceDetail->amount = -($advancedPayment);
                if (!$advancedBalanceDetail->save()) {
                    print_r($advancedBalanceDetail->getErrors());
                    $transaction->rollBack();
                    return false;
                }
            }
        }
        $idSupp =  $model->supplierPaymentNum;
        if(!$newTrans){
            //delete from journal
            $connection = MdlDb::getDbConnection();
            $sql = "DELETE a
            FROM tr_journaldetail a
            JOIN tr_journalhead b on a.journalHeadID = b.journalHeadID
            WHERE b.refNum = '" . $idSupp ."' ";
            $command= $connection->createCommand($sql);
            $command->execute();     
            TrJournalhead::deleteAll('refNum = :refNum', [":refNum" => $idSupp]);
                
        }
        
        $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
        $mode = 5; //supplier payment

        $command->bindParam(':refNum', $journalRefNum);
        $command->bindParam(':mode', $mode);
        $command->queryAll();
        
        $transaction->commit();
        return true;
    }
    public function actionPrints($id = null)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT cs.supplierName,spDetail.paymentAmount,spPay.*
                FROM tr_supplierpaymenthead as spPay
                LEFT JOIN tr_supplierpaymentdetail spDetail on spDetail.supplierPaymentNum = spPay.supplierPaymentNum
                LEFT JOIN ms_supplier cs on cs.supplierID= spPay.supplierID
                WHERE spPay.supplierPaymentNum = "'.$id.'"';
        
        $command = $connection->createCommand($sql);        
        $model = $command->queryAll();
       
        $view = 'report_voucher';
        $content = $this->renderPartial($view, [
            'model' => $model,
        ]);         

        $mpdf = new mPDF('',    // mode - default ''
                        'A4',    // format - A4, default ''
                        0,     // font size - default 0
                        '',    // default font family
                        '20',    // margin_left
                        '20',    // margin right
                        '5',     // margin top
                        '15',    // margin bottom
                        '0',     // margin header
                        '5',     // margin footer
                        'P'     // P = portrait, L = landscape
                );
        $mpdf->WriteHTML($content);
        $mpdf->Output('report.pdf','I');
        exit;
        
        
    }
}
