<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsCoasetting;
use app\models\MsSupplier;
use app\models\TrGoodsreceipthead;
use app\models\TrGoodsreceipthead2;
use app\models\TrImportduty;
use app\models\TrJournaldetail;
use app\models\TrJournalhead;
use app\models\TrPurchaseordernoninventoryhead;
use app\models\TrSupplieradvancebalancedetail;
use app\models\TrSupplieradvancebalancehead;
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
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ForwarderPaymentController extends MainController
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

//        $queryGR = TrGoodsreceipthead::find()
//                ->select(['(tr_goodsreceiptcost.importDutyAmount + tr_goodsreceiptcost.PPNImportAmount + tr_goodsreceiptcost.PPHImportAmount
//                 + IF(tr_goodsreceiptcost.otherCostAmount IS NULL, 0, tr_goodsreceiptcost.otherCostAmount)
//                 + IF(tr_goodsreceiptcost.taxInvoiceAmount IS NULL, 0, tr_goodsreceiptcost.taxInvoiceAmount)) AS total','tr_goodsreceipthead.goodsReceiptNum as transactionRefNum','tr_goodsreceipthead.goodsReceiptDate as transactionDate','tr_goodsreceipthead.refNum as originalRefNum'])
//                ->joinWith('goodsReceiptCost')
//                ->where('tr_goodsreceiptcost.goodsReceiptNum is not null')
//                ->andWhere('tr_goodsreceipthead.PPJK = :PPJK',[':PPJK' => $filter])
//                ->andWhere("(importDutyAmount + PPNImportAmount + PPHImportAmount + IF(otherCostAmount IS NULL, 0, otherCostAmount) + IF(taxInvoiceAmount IS NULL, 0, taxInvoiceAmount))"
//                        . " - (SELECT SUM(paymentAmount) FROM tr_supplierpaymentdetail WHERE refNum = tr_goodsreceipthead.goodsReceiptNum) > 0 "
//                        . " OR (SELECT SUM(paymentAmount) FROM tr_supplierpaymentdetail WHERE refNum = tr_goodsreceipthead.goodsReceiptNum) IS NULL")
//                ->orderBy(['transactionDate' => SORT_DESC]);
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
        $sql = "SELECT receiptHead.goodsReceiptNum AS transactionRefNum, receiptHead.goodsReceiptDate AS transactionDate, 
                receiptHead.refNum AS originalRefNum, cost.importDutyAmount AS beaMasuk, cost.PPNImportAmount AS PPN, cost.PPHImportAmount AS PPH, (cost.importDutyAmount + cost.PPNImportAmount + cost.PPHImportAmount )AS grandTotal,
                (
                    SELECT IFNULL(SUM(advPaymentDetail.amount), 0)
                    FROM tr_supplieradvancebalancedetail AS advPaymentDetail
                    LEFT JOIN tr_supplieradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
                    WHERE advPaymentDetail.refNum = receiptHead.refNum AND advPaymenthead.supplierID = receiptHead.PPJK 
                ) AS advancedPaymentAmount,
                (
                    SELECT IFNULL(SUM(paymentDetail.paymentAmount), 0)
                    FROM tr_supplierpaymenthead AS paymentHead
                    LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
                    WHERE paymentDetail.refNum = receiptHead.goodsReceiptNum AND paymentHead.supplierID = receiptHead.PPJK 
                ) AS previousPayment,
                CAST((SELECT floor(cost.importDutyAmount + cost.PPNImportAmount + cost.PPHImportAmount ) - advancedPaymentAmount - previousPayment) AS DECIMAL(18,2)) AS outstandingAmount
                FROM tr_goodsreceipthead AS receiptHead
                LEFT JOIN tr_goodsreceiptcost AS cost ON cost.goodsReceiptNum = receiptHead.goodsReceiptNum
                JOIN tr_supplierpayabledetail AS payDetail ON payDetail.refNum = receiptHead.goodsReceiptNum
                WHERE receiptHead.PPJK = $filter
                $filterRefnum
                $filterGrDate
                $filterOriRefnum
                HAVING outstandingAmount > 0
                ORDER BY transactionDate DESC";
        
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
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
                $sqlGoods = "SELECT receipt.refNum, 1 AS rate, 0 AS taxRate, cost.importDutyAmount AS importDuty, cost.PPNImportAmount AS PPN, cost.PPHImportAmount AS PPH,
                SUM(cost.importDutyAmount + cost.PPNImportAmount + cost.PPHImportAmount) AS price
                FROM tr_goodsreceiptcost AS cost
                LEFT JOIN tr_goodsreceipthead AS receipt ON receipt.goodsReceiptNum = cost.goodsReceiptNum
                WHERE cost.goodsReceiptNum = '$refNum'";
                
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlGoods);
                $headResult = $temp->queryAll();
                foreach ($headResult as $queryResult) {
                    
                    $GRRefNum = $queryResult['refNum'];
                    $result["whtAmount"] = "0.00";
                    $result["price"] = $queryResult['price'];
                    $result["price"] = $queryResult['price'];
                    $result["importDuty"] = $queryResult['importDuty'];
                    $result["PPN"] = $queryResult['PPN'];
                    $result["PPH"] = $queryResult['PPH'];
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
            }

            $modelPreviousPayment = TrSupplierpaymenthead::find()
                                    ->select([new Expression('SUM(tr_supplierpaymentdetail.paymentAmount) as paymentAmount')])
                                    ->joinWith('paymentDetail')
                                    ->where('tr_supplierpaymentdetail.refNum = :refNum',[':refNum' => $refNum])
                                    ->andWhere(['like', 'tr_supplierpaymentdetail.supplierPaymentNum', 'QJA/FP' ])
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
                                    ->where('refNum = :refNum',[':refNum' => $refNum])
                                    ->one();

            if(is_null($modelAdvancedPayment->amount))
                $result["advancedPayment"] = "0.00";
            else
                $result["advancedPayment"] = $modelAdvancedPayment->amount;

            return Json::encode($result);
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
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
//            
//            TrSupplierpayabledetail::deleteAll('refNum = :refNum', [":refNum" => $id]);
//            TrSupplierpayablehead::deleteAll('payableNum = :payableNum', [":payableNum" => $payableNum]);
//        }
        
        
        $detail = TrSupplierpaymentdetail::find()->where(['supplierPaymentNum' => $id ])->all();
        
        foreach ($detail as $d) {
            
            
            $connection = MdlDb::getDbConnection();
            $sql = "DELETE a
            FROM tr_journaldetail a
            JOIN tr_journalhead b on a.journalHeadID = b.journalHeadID
            WHERE b.refNum = '" . $d['refNum'] ."' AND b.transactionType = 'Import Duty'";
            $command= $connection->createCommand($sql);
            $command->execute();

            TrJournalHead::deleteAll('refNum = :refNum AND transactionType = :transactionType', [":refNum" => $d['refNum'],":transactionType" => "Import Duty"]);

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
    
    /**
     * 
     * @param TrSupplierpaymenthead $model
     * @param boolean $newTrans
     * @return boolean
     */
    protected function saveModel($model, $newTrans)
    {
        
        $connection = AppHelper::getDbConnection();
        $transaction = $connection->beginTransaction();
        
        $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $modelMonth = date("m",strtotime($model->supplierPaymentDate)) - 1;

        if ($newTrans){
            $tempModel = TrSupplierpaymenthead::find()
            ->where('SUBSTRING(supplierPaymentNum, 8, 2) LIKE :supplierPaymentDate',[
                    ':supplierPaymentDate' => date("y",strtotime($model->supplierPaymentDate))
            ])
            ->orderBy([new Expression("CAST(SUBSTRING(supplierPaymentNum, -3, 3) AS UNSIGNED) DESC")])
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/FP/".date("y",strtotime($model->supplierPaymentDate))."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->supplierPaymentNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/FP/".date("y",strtotime($model->supplierPaymentDate))."/".$month[$modelMonth]."/".$temp;
            }
            
            $model->supplierPaymentNum = $tempTransNum;
            $model->createdDate = new Expression('NOW()');
        }

        $model->supplierPaymentDate = AppHelper::convertDateTimeFormat($model->supplierPaymentDate, 'd-m-Y', 'Y-m-d');
        $model->editedDate = new Expression('NOW()');
        $model->rate = '1';
        $model->adminFeeRate = '1';
        $model->adminFeeAmount = str_replace(',', '.',str_replace('.', '', $model->adminFeeAmount));
        

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
        $totalPaymentAmount = 0;
        $Totalpajakbydimuka = 0;
        foreach ($model->joinPaymentDetail as $joinPaymentDetail) {
            $paymentDetailModel = new TrSupplierpaymentdetail();
            $paymentDetailModel->supplierPaymentNum = $model->supplierPaymentNum;
            $paymentDetailModel->refNum = $joinPaymentDetail['refNum'];
            
            $paymentDetailModel->whtAmount = str_replace(",",".",str_replace(".","",$joinPaymentDetail['WHTAmount']));
            $paymentDetailModel->transactionAmountBeforeTax = str_replace(",",".",str_replace(".","",$joinPaymentDetail['priceBeforeTax']));
            $paymentDetailModel->tax = str_replace(",",".",str_replace(".","",$joinPaymentDetail['taxRate']));
            $paymentDetailModel->paymentAmount = str_replace(",",".",str_replace(".","",$joinPaymentDetail['payment']));
            $totalPaymentAmount += $paymentDetailModel->paymentAmount;
            
            $outstanding = str_replace(",",".",str_replace(".","",$joinPaymentDetail['outstanding']));
            $advancedPayment = str_replace(",",".",str_replace(".","",$joinPaymentDetail['advancedPayment']));
           
            $refNums = $joinPaymentDetail['refNum'];
//            
//            
//            $connection = MdlDb::getDbConnection();
//            $sql = "SELECT PPNImportAmount, PPHImportAmount
//            FROM tr_goodsreceiptcost 
//            WHERE goodsReceiptNum = '". $PPN ."' ";
//            $command = $connection->createCommand($sql);        
//            $models = $command->queryOne();
//            $Totalpajakbydimuka += $models['PPNImportAmount'] + $models['PPHImportAmount'];
           
            if (!$paymentDetailModel->save()) {
                print_r($paymentDetailModel->getErrors());
                $transaction->rollBack();
                return false;
            }
            
            
            $connection = MdlDb::getDbConnection();
            $sql = "DELETE a
            FROM tr_journaldetail a
            JOIN tr_journalhead b on a.journalHeadID = b.journalHeadID
            WHERE b.refNum = '" . $refNums ."' AND b.transactionType = 'Import Duty'";
            $command= $connection->createCommand($sql);
            $command->execute();

            TrJournalHead::deleteAll('refNum = :refNum AND transactionType = :transactionType', [":refNum" => $refNums,":transactionType" => "Import Duty"]);



            $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
            $mode = 'import duty'; //goods receipt
            $command->bindValue(':refNum', $refNums);
            $command->bindValue(':mode', $mode);
            $command->queryAll();

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
        
        
        //JOURNAL RECORD
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
        $mode = 15; //goods receipt
        $command->bindValue(':refNum',  $model->supplierPaymentNum);
        $command->bindValue(':mode', $mode);
        $command->queryAll();
       
        
//        $headID = NULL;
//        if(!TrJournalhead::newData($headID, $model->supplierPaymentDate, 'Forwarder Payment', 
//                $model->supplierPaymentNum, $model->additionalInfo))
//        {
//            $transaction->rollBack();
//            return false;
//        }
//        
//        
//       
//        $journalDetail = [
//            [   //Hutang kpd PPJK
//                'COANo' => MsCoasetting::findCoa('HutangPPJK'),
//                'currencyID' => $model->currencyID,
//                'rate' => $model->rate,
//                'debit' => $totalPaymentAmount,
//                'credit' => 0
//            ]
//        ];
//        if ($model->adminFeeAmount > 0)
//        {
//            array_push($journalDetail, [
//                //By transfer bank
//                'COANo' => MsCoaSetting::findCoa('ByTxBank'),
//                'currencyID' => $model->currencyID,
//                'rate' => $model->adminFeeRate,
//                'debit' => $model->adminFeeAmount,
//                'credit' => 0
//            ]);
//        }
//         if($Totalpajakbydimuka > 0)
//        {
//            array_push($journalDetail, [
//                     //UangMukaPajak
//                     'COANo' => MsCoaSetting::findCoa('UangMukaPajak'),
//                     'currencyID' => $model->currencyID,
//                     'rate' => $model->rate,
//                     'debit' => $Totalpajakbydimuka,
//                     'credit' => 0
//             ]);
//
//             array_push($journalDetail, [
//                     //PajakByDimuka
//                     'COANo' => MsCoaSetting::findCoa('Pajakbydimuka'),
//                     'currencyID' => $model->currencyID,
//                     'rate' => $model->rate,
//                     'debit' => 0,
//                     'credit' => $Totalpajakbydimuka
//             ]);
//        }
//        array_push($journalDetail, [
//            //Bank / Kas
//            'COANo' => $model->coaNo,
//            'currencyID' => $model->currencyID,
//            'rate' => $model->rate,
//            'debit' => 0,
//            'credit' => $totalPaymentAmount
//        ]);
//        if($model->adminFeeAmount > 0)
//        {
//            if($model->coaNo == $model->adminFeePaymentCoa && $Totalpajakbydimuka > 0 )
//            {
//                $journalDetail[4]['credit'] = $journalDetail[4]['credit'] + $model->adminFeeAmount;
//            } elseif ($model->coaNo == $model->adminFeePaymentCoa && $Totalpajakbydimuka == 0 )
//            {
//                $journalDetail[2]['credit'] = $journalDetail[2]['credit'] + $model->adminFeeAmount;
//            } else {
//                
//                array_push($journalDetail, [
//                    //Bank / Kas Fee
//                    'COANo' => $model->adminFeePaymentCoa,
//                    'currencyID' => $model->currencyID,
//                    'rate' => $model->adminFeeRate,
//                    'debit' => 0,
//                    'credit' => $model->adminFeeAmount
//                ]);
//            }
//        }
//        
//        foreach ($journalDetail AS $detail)
//        {
//            if (!TrJournaldetail::newData($headID, $detail['COANo'], $detail['currencyID'], $detail['rate'], 
//                    $detail['debit'], $detail['credit']))
//            {
//                $transaction->rollBack();
//                return false;
//            }
//        }
//        //END OF JOURNAL RECORD
        
        
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
