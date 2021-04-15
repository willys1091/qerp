<?php

namespace app\controllers;
use Yii;
use app\components\AppHelper;
use app\components\MdlDb;
use app\models\TrCustomeradvancebalancedetail;
use app\models\TrCustomeradvancebalancehead;
use app\models\TrCustomeradvancepayment;
use app\models\TrCustomerpayment;
use app\models\TrCustomerreceivabledetail;
use app\models\TrCustomerreceivablehead;
use app\models\TrGoodsdeliveryhead;
use app\models\TrJournalhead;
use app\models\TrSalesorderhead;
use kartik\widgets\ActiveForm;
use mPDF;

use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CustomerPaymentController implements the CRUD actions for TrCustomerpayment model.
 */
class CustomerPaymentController extends MainController
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
     * Lists all TrCustomerpayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrCustomerpayment();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->paymentTransactionDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new TrCustomerpayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */  public function actionView($id)
    {      
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCreate()
    {
        $model = new TrCustomerpayment();
        $model->paymentTransactionDate = date('d-m-Y');
        $model->createdBy = Yii::$app->user->identity->username;
        $model->editedBy = Yii::$app->user->identity->username;
        $model->adminFeeRate = '0,00';
        $model->adminFeeAmount = '0,00';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $existing = TrCustomerpayment::find()
                    ->where(['voucherNum' => $model->voucherNum])
                    ->one();
            
            if ($existing)
            {
                $model->errorMessages = [
                    "Voucher Number has already been used in payment number $existing->customerPaymentNum"
                ];
                return $this->render('create', [
                    'model' => $model
                ]);
            }

            $model->adminFeeRate = str_replace(",",".",str_replace(".","",$model->adminFeeRate));
            $model->adminFeeAmount = str_replace(",",".",str_replace(".","",$model->adminFeeAmount));
            if ($this->saveModel($model, true)) {
                return $this->redirect(['index']);
            }
            
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCheckrefnum()
    {
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];

            if (explode('/', $refNum)[0] == 'INIT')
            {
                $sqlGoods = " SELECT a.refNum, a.amount as price, b.customerID
                            from tr_customerreceivabledetail a join tr_customerreceivablehead b on a.receivableNum=b.receivableNum
                           where a.refNum='".$refNum."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlGoods);
                $headResult = $temp->queryAll();
                foreach ($headResult as $queryResult) {
                    $result["price"] = $queryResult['price'];
                    $result["customerID"] = $queryResult['customerID'];
                    $result["taxRate"] = 0.00;
                    $customerID = $queryResult['customerID'];

                    $transRefNum = $queryResult['refNum'];
                }
               
                $result["advancedPayment"] = 0;
                
                $modelPreviousPayment = TrCustomerpayment::find()
                    ->select([new Expression('SUM(paymentAmount) as paymentAmount')])
                    ->where('refNum = :refNum', [':refNum' => $refNum])
                    ->one();
                if (is_null($modelPreviousPayment->paymentAmount))
                    $result["previousPayment"] = 0;
                else
                    $result["previousPayment"] = $modelPreviousPayment->paymentAmount;
            } else 
            {
                $sqlGoods = "SELECT b.refNum,sum(a.qty*d.price*(100-d.discount)/100) as price,c.customerID,c.taxRate
                            from tr_goodsdeliverydetail a join tr_goodsdeliveryhead b on a.goodsDeliveryNum=b.goodsDeliveryNum
                            join tr_salesorderhead c on b.refNum=c.salesOrderNum
                            left join tr_salesorderdetail d on c.salesOrderNum=d.salesOrderNum and a.productID=d.productID
                            where a.goodsDeliveryNum='".$refNum."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlGoods);
                $headResult = $temp->queryAll();
                foreach ($headResult as $queryResult) {
                    $result["price"] = $queryResult['price'];
                    $result["customerID"] = $queryResult['customerID'];
                    $result["taxRate"] = $queryResult['taxRate'];
                    $customerID = $queryResult['customerID'];

                    $transRefNum = $queryResult['refNum'];
                }
                $modelAdvancedPayment = TrCustomeradvancebalancehead::find()
                                        ->select([new Expression('SUM(tr_customeradvancebalancedetail.amount) as amount')])
                                        ->joinWith('balanceDetail')
                                        ->where('refNum = :refNum',[':refNum' => $transRefNum])
                                        ->one();
                if(is_null($modelAdvancedPayment->amount))
                    $result["advancedPayment"] = 0;
                else
                    $result["advancedPayment"] = $modelAdvancedPayment->amount;

                $modelPreviousPayment = TrCustomerpayment::find()
                                        ->select([new Expression('SUM(paymentAmount) as paymentAmount')])
                                        ->where('refNum = :refNum',[':refNum' => $refNum])
                                        ->one();
                if(is_null($modelPreviousPayment->paymentAmount))
                    $result["previousPayment"] = 0;
                else
                    $result["previousPayment"] = $modelPreviousPayment->paymentAmount;
            }
            return \yii\helpers\Json::encode($result);
        }
    }

    public function actionOutstanding($filter,$filter2){
        $model = new TrCustomerpayment();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => TrCustomerpayment::find()
                        ->where(['=', 'refNum', $filter]),
        ]);

        $this->layout = 'browseLayout';
        return $this->render('outstanding', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TrCustomerpayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->paymentTransactionDate = date('d-m-Y');
        $model->createdBy = Yii::$app->user->identity->username;
        $model->editedBy = Yii::$app->user->identity->username;
        $model->adminFeeRate = '0,00';
        $model->adminFeeAmount = '0,00';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
//            $existing = TrCustomerpayment::find()
//                    ->where(['voucherNum' => $model->voucherNum])
//                    ->one();
//            
//            if ($existing)
//            {
//                $model->errorMessages = [
//                    "Voucher Number has already been used in payment number $existing->customerPaymentNum"
//                ];
//                return $this->render('create', [
//                    'model' => $model
//                ]);
//            }

            $model->adminFeeRate = str_replace(",",".",str_replace(".","",$model->adminFeeRate));
            $model->adminFeeAmount = str_replace(",",".",str_replace(".","",$model->adminFeeAmount));
            if ($this->saveModel($model, false)) {
                return $this->redirect(['index']);
            }
            
        }
        
       
            return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing TrCustomerpayment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
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

        $receivableDetailModel = TrCustomerreceivabledetail::find()
                            ->where('refNum = "'.$id.'"')
                            ->one();
        if ($receivableDetailModel) {
            $receivableNum = $receivableDetailModel->receivableNum;
            TrCustomerreceivabledetail::deleteAll('refNum = :refNum', [":refNum" => $id]);
            TrCustomerreceivablehead::deleteAll('receivableNum = :receivableNum', [":receivableNum" => $receivableNum]);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrCustomerpayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrCustomerpayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrCustomerpayment::findOne($id)) !== null) {
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
        $modelMonth = date("m",strtotime($model->paymentTransactionDate)) - 1;

        if ($newTrans){
            $tempModel = TrCustomerpayment::find()
            ->where('SUBSTRING(customerPaymentNum, 8, 2) LIKE :paymentTransactionDate',[
                    ':paymentTransactionDate' => date("y",strtotime($model->paymentTransactionDate))
            ])
            ->orderBy([new Expression("CAST(SUBSTRING(customerPaymentNum, -3, 3) AS UNSIGNED) DESC")])
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/CP/".date("y",strtotime($model->paymentTransactionDate))."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->customerPaymentNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/CP/".date("y",strtotime($model->paymentTransactionDate))."/".$month[$modelMonth]."/".$temp;
            }
            
            $model->customerPaymentNum = $tempTransNum;
        }

        $model->paymentTransactionDate = AppHelper::convertDateTimeFormat($model->paymentTransactionDate, 'd-m-Y', 'Y-m-d');
        $model->createdDate = new Expression('NOW()');
        $model->editedDate = new Expression('NOW()');
        $model->transactionAmount = str_replace(",",".",str_replace(".","",$model->transactionAmount));
        $model->paymentAmount = str_replace(",",".",str_replace(".","",$model->paymentAmount));
        $model->downpayment = str_replace(",",".",str_replace(".","",$model->downpayment));
        
        
        $model->adjustment ? $model->adjustment = str_replace(",",".",str_replace(".","",$model->adjustment)) : '';
        $advancedPayment = str_replace(",",".",str_replace(".","",$model->advancedPayment));

        $journalRefNum = $model->customerPaymentNum;

//        $modelGD = TrGoodsdeliveryhead::find()
//                    ->where('goodsDeliveryNum = :goodsDeliveryNum',[':goodsDeliveryNum' => $model->refNum])
//                    ->one();
        
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT * FROM tr_goodsdeliveryhead where goodsDeliveryNum = "'.$model->refNum.'"';
        
        $command = $connection->createCommand($sql);        
        $modelGD = $command->queryOne();
        
        
        $goodsRefNum = $modelGD['refNum'];

        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }

        if($advancedPayment > 0){
            $advancedBalanceHead = new TrCustomeradvancebalancehead();
            $advancedBalanceHead->balanceDate = new Expression('NOW()');
            $advancedBalanceHead->customerID = $model->customerID;
            if (!$advancedBalanceHead->save()) {
                print_r($advancedBalanceHead->getErrors());
                $transaction->rollBack();
                return false;
            }

            $advancedBalanceDetail = new TrCustomeradvancebalancedetail();
            $advancedBalanceDetail->balanceHeadID = $advancedBalanceHead->balanceHeadID;
            $advancedBalanceDetail->refNum = $goodsRefNum;
            $advancedBalanceDetail->amount = -($advancedPayment);
            if (!$advancedBalanceDetail->save()) {
                print_r($advancedBalanceDetail->getErrors());
                $transaction->rollBack();
                return false;
            }
        }
       
        if(!$newTrans){
            //delete from journal
   
            TrJournalhead::deleteAll('refNum = :refNum', [":refNum" => $model->customerPaymentNum]);
        }
        $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
        $mode = 7; //customer payment

        $command->bindParam(':refNum', $journalRefNum);
        $command->bindParam(':mode', $mode);
        $command->queryAll();

        //input to payable
        /*
        $connection = MdlDb::getDbConnection();
        $command = $connection->createCommand('call sp_insert_payablereceivable(:refNum, :mode)');
        $mode = 4; 

        $command->bindParam(':refNum', $journalRefNum);
        $command->bindParam(':mode', $mode);
        $command->execute();
        */
        
        $transaction->commit();
        return true;
    }
    
    public function actionPrints($id = null)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT cs.customerName,cp.*
                FROM tr_customerpayment as cp
                LEFT JOIN ms_customer cs on cs.customerID = cp.customerID
                WHERE customerPaymentNum = "'.$id.'"';
        
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
