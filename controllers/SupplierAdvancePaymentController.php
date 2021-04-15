<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsCoa;
use app\models\MsCoasetting;
use app\models\TrCustomeradvancebalancedetail;
use app\models\TrCustomeradvancebalancehead;
use app\models\TrJournaldetail;
use app\models\TrJournalhead;
use app\models\TrSupplieradvancebalancehead;
use app\models\TrSupplieradvancepayment;
use app\models\TrSupplierpaymenthead;
use kartik\form\ActiveForm;
use mPDF;
use Yii;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SupplierAdvancePaymentController extends MainController
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
        $model = new TrSupplieradvancepayment();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->supplierAdvancePaymentDate = "$model->startDate to $model->endDate";
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
        $model = new TrSupplieradvancepayment();
        $model->supplierAdvancePaymentDate = date('d-m-Y');
        $model->rate = '0,00';
        $model->amount = '0,00';
        $model->adminFeeRate = '0,00';
        $model->adminFeeAmount = '0,00';
        $model->treasuryCOA = MsCoasetting::findCOA('UangMukaSupplier');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
           

            if(!$this->saveModel($model, true)) { 
                return false;
            }
            
            return $this->redirect(['index']);
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
      
    public function saveModel($model, $trans) {
        $transaction = Yii::$app->db->beginTransaction();
        
        
        $data = Yii::$app->request->post();
        
        if ($trans){
            $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
            $modelMonth = date("m",strtotime($model->supplierAdvancePaymentDate)) - 1;
            $tempModel = TrSupplieradvancepayment::find()
                ->where('YEAR(supplierAdvancePaymentDate) LIKE :supplierAdvancePaymentDate',[
                    ':supplierAdvancePaymentDate' => date("Y",strtotime($model->supplierAdvancePaymentDate))
            ])
            //->orderBy('supplierAdvancePaymentNum DESC')
		    ->orderBy([new Expression("CAST(SUBSTRING(supplierAdvancePaymentNum, '-3', '3') AS UNSIGNED) DESC")])
            ->one();
            $tempTransNum = "";
			
            if (empty($tempModel)){
                $tempTransNum = "QJA/SAP/".substr(date("Y",strtotime($model->supplierAdvancePaymentDate)), -2)."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->supplierAdvancePaymentNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/SAP/".substr(date("Y",strtotime($model->supplierAdvancePaymentDate)), -2)."/".$month[$modelMonth]."/".$temp;
            }

            $model->supplierAdvancePaymentNum = $tempTransNum;
        }    
			
            $model->supplierAdvancePaymentDate = AppHelper::convertDateTimeFormat($model->supplierAdvancePaymentDate, 'd-m-Y', 'Y-m-d');
            $model->rate = str_replace(",",".",str_replace(".","",$model->rate));
            $model->amount = str_replace(",",".",str_replace(".","",$model->amount));
            $model->adminFeeRate = str_replace(",",".",str_replace(".","",$model->adminFeeRate));
            $model->adminFeeAmount = str_replace(",",".",str_replace(".","",$model->adminFeeAmount));
            $model->supplierID = $data['supplierID'];
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
        
        TrJournalHead::deleteAll('refNum = :refNum AND transactionType = :transactionType', [":refNum" => $model->refNum,":transactionType" => "Supplier Advanced Payment"]);
        
        $idCustomerAdvance = TrCustomeradvancebalancedetail::find()->where(['refNum' => $model->refNum])->one();
        TrCustomeradvancebalancedetail::deleteAll('refNum = :refNum', [":refNum" => $model->refNum]);
        TrCustomeradvancebalancehead::deleteAll('balanceHeadID = :balanceHeadID', [":balanceHeadID" => $idCustomerAdvance['balanceHeadID']]);
        
        
        if($model->save()){
            $journalHeadID = '';
            
            if (!TrJournalhead::newData($journalHeadID, $model->supplierAdvancePaymentDate, 'Supplier Advanced Payment', $model->supplierAdvancePaymentNum, $model->additionalInfo)) {
                $transaction->rollBack();
                return false;
            }

            if (!TrJournaldetail::newData($journalHeadID, $model->treasuryCOA, $model->currencyID, $model->rate, floatval($model->amount), 0)) {
                $transaction->rollBack();
                return false;
            }     

            $coa = MsCoa::findOne($model->paymentCOA); 
            if($coa->currencyID == 'IDR') {
                $rate = 1;
                $amount = floatval($model->amount) * $model->rate;
            } else {
                $rate = $model->rate;
                $amount = floatval($model->amount);
            }
            
            if (!TrJournaldetail::newData($journalHeadID, $model->paymentCOA, $coa->currencyID, $rate, 0, $amount)) {
                $transaction->rollBack();
                return false;
            }
            
            if (floatval($model->adminFeeAmount) > 0) {
                if (!TrJournaldetail::newData($journalHeadID, MsCoasetting::findCOA('ByTxbank'), 'IDR', 1, floatval($model->adminFeeRate)*floatval($model->adminFeeAmount), 0)) {
                    $transaction->rollBack();
                    return false;
                }
                
                if (!TrJournaldetail::newData($journalHeadID, $model->adminFeePaymentCoa, $model->adminFeeCurrency, floatval($model->adminFeeRate), 0, floatval($model->adminFeeAmount))) {
                    $transaction->rollBack();
                    return false;
                }
            }
        } else {
            $transaction->rollBack();
            return false;
        }
        
        
        
        if (!TrSupplieradvancebalancehead::newData($model->refNum, $model->supplierID, $model->supplierAdvancePaymentDate, floatval($model->amount))) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }

    public function actionCheckrefnum(){
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];
            $POTotal = $data['POTotal'];

            $modelPayment = TrSupplierpaymenthead::find()
                            ->select([new Expression('SUM(paymentAmount) as paymentAmount')])
                            ->leftJoin('tr_goodsreceipthead', 'tr_goodsreceipthead.goodsReceiptNum = tr_supplierpaymenthead.refNum')
                            ->where('tr_goodsreceipthead.refNum = :refNum',[':refNum' => $refNum])
                            ->one();
            if(is_null($modelPayment->paymentAmount)){
                $supplierPaymentAmount = 0;
                $modelAdvancedPayment = TrSupplieradvancepayment::find()
                                        ->select([new Expression('SUM(amount) as amount')])
                                        ->where('refNum = :refNum',[':refNum' => $refNum])
                                        ->one();
                if(is_null($modelAdvancedPayment->amount)){
                    $outstanding = $POTotal;
                }
                else{
                    $outstanding = $POTotal - $modelAdvancedPayment->amount;
                }
            }
            else{
                $outstanding = $POTotal - $modelPayment->paymentAmount;
            }
            return Json::encode($outstanding);
        }
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            
            
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
        $model = $this->findModel($id);
        
        $prevJournalHead = TrJournalhead::findOne(['refNum' => $id, 'transactionType' => 'Supplier Advanced Payment']);
        if ($prevJournalHead != NULL) {
            $prevJournalHead->delete();
        }
        
        $prevAdvance = TrSupplieradvancebalancehead::find()
                        ->joinWith('balanceDetail')
                        ->where(['refNum' => $model->refNum])
                        ->andWhere(['tr_supplieradvancebalancehead.supplierID' => $model->supplierID])->one();
                
        if ($prevAdvance != NULL) {
            $prevAdvance->delete();
            foreach ($prevAdvance->balanceDetail as $detail) {
                $detail->delete();
            }
        } 
        
        $model->delete();
        
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = TrSupplieradvancepayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
     public function actionPrints($id = null)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT cs.supplierName,spPay.*
                FROM tr_supplieradvancepayment as spPay
                LEFT JOIN ms_supplier cs on cs.supplierID= spPay.supplierID
                WHERE spPay.supplierAdvancePaymentNum = "'.$id.'"';
        
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
