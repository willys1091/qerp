<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsCoasetting;
use app\models\TrCustomeradvancebalancehead;
use app\models\TrCustomeradvancepayment;
use app\models\TrJournaldetail;
use app\models\TrJournalhead;
use kartik\form\ActiveForm;
use mPDF;
use Yii;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CustomerAdvancePaymentController extends MainController
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
        $model = new TrCustomeradvancepayment();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->custAdvancePaymentDate = "$model->startDate to $model->endDate";
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
        $model = new TrCustomeradvancepayment();

        $model->custAdvancePaymentDate = date('d-m-Y');
        $model->currencyID = "IDR";
        $model->rate = '1,00';
        $model->amount = '0,00';
        $model->adminFeeRate = '1,00';
        $model->adminFeeAmount = '0,00';
        $model->treasuryCOA = MsCoasetting::findCOA('UMPCustomer');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
            $modelMonth = date("m",strtotime($model->custAdvancePaymentDate)) - 1;
            $tempModel = TrCustomeradvancepayment::find()
                ->where('SUBSTRING(custAdvancePaymentNum, 9, 2) LIKE :custAdvancePaymentDate',[
                        ':custAdvancePaymentDate' => date("y",strtotime($model->custAdvancePaymentDate))
                ])
                ->orderBy([new Expression("CAST(SUBSTRING(custAdvancePaymentNum, '-3', '3') AS UNSIGNED) DESC")])
                ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/CAP/".date("y",strtotime($model->custAdvancePaymentDate))."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->custAdvancePaymentNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/CAP/".date("y",strtotime($model->custAdvancePaymentDate))."/".$month[$modelMonth]."/".$temp;
            }
            $model->custAdvancePaymentNum = $tempTransNum;
            $model->custAdvancePaymentDate = AppHelper::convertDateTimeFormat($model->custAdvancePaymentDate, 'd-m-Y', 'Y-m-d');

            $model->rate = str_replace(",",".",str_replace(".","",$model->rate));
            $model->amount = str_replace(",",".",str_replace(".","",$model->amount));
            $model->adminFeeRate = str_replace(",",".",str_replace(".","",$model->adminFeeRate));
            $model->adminFeeAmount = str_replace(",",".",str_replace(".","",$model->adminFeeAmount));
            $model->custID = $data['custID'];

            if(!$this->saveModel($model)) { 
                return false;
            }
            
            return $this->redirect(['index']);
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function saveModel($model) {
        $transaction = Yii::$app->db->beginTransaction();

        if($model->save()){
            $journalHeadID = '';
            if (!TrJournalhead::newData($journalHeadID, $model->custAdvancePaymentDate, 'Customer Advanced Payment', $model->custAdvancePaymentNum, $model->additionalInfo)) {
                $transaction->rollBack();
                return false;
            }
            
            if (!TrJournaldetail::newData($journalHeadID, $model->paymentCOA, $model->currencyID, $model->rate, floatval($model->amount), 0)) {
                $transaction->rollBack();
                return false;
            } 
            
            if (!TrJournaldetail::newData($journalHeadID, $model->treasuryCOA, $model->currencyID, $model->rate, 0, floatval($model->amount))) {
                $transaction->rollBack();
                return false;
            }

            if (floatval($model->adminFeeAmount) > 0) {
                if (!TrJournaldetail::newData($journalHeadID, MsCoasetting::findCOA('ByTxBank'), 'IDR', floatval($model->adminFeeRate), floatval($model->adminFeeRate) * floatval($model->adminFeeAmount), 0)) {
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

        if (!TrCustomeradvancebalancehead::newData($model->refNum, $model->custID, $model->custAdvancePaymentDate, floatval($model->amount))) {
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
            $transTotal = $data['transTotal'];

            $modelAdvancedPayment = TrCustomeradvancepayment::find()
                                        ->select([new Expression('SUM(amount) as amount')])
                                        ->where('refNum = :refNum',[':refNum' => $refNum])
                                        ->one();
            if(is_null($modelAdvancedPayment->amount)){
                $outstanding = $transTotal;
            }
            else{
                $outstanding = $transTotal - $modelAdvancedPayment->amount;
            }
            return \yii\helpers\Json::encode($outstanding);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->customerName = $model->parentCustomer->customerName;
        $model->adminFeeCurrency =  $model->adminFeeCoa->currencyID;
        
        if ($model->load(Yii::$app->request->post()) && $this->saveModel($model)) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $prevJournalHead = TrJournalhead::findOne(['refNum' => $id, 'transactionType' => 'Customer Advanced Payment']);
        if ($prevJournalHead != NULL) {
            $prevJournalHead->delete();
        }
        
        $prevAdvance = TrCustomeradvancebalancehead::find()
                        ->joinWith('balanceDetail')
                        ->where(['refNum' => $model->refNum])
                        ->andWhere(['tr_customeradvancebalancehead.customerID' => $model->custID])->one();
        
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
        if (($model = TrCustomeradvancepayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPrints($id = null)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT cs.customerName,csAdv.*
                FROM tr_customeradvancepayment csAdv
                LEFT JOIN ms_customer cs on cs.customerID = csAdv.custID
                WHERE custAdvancePaymentNum = "'.$id.'"';
        
        $command = $connection->createCommand($sql);        
        $model = $command->queryAll();
       
        $view = 'print_voucher';
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
