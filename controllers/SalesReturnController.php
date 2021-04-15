<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\TrCustomeradvancebalancedetail;
use app\models\TrCustomeradvancebalancehead;
use app\models\TrSalesreturndetail;
use app\models\TrSalesreturnhead;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * SalesReturnController implements the CRUD actions for TrSalesreturnhead model.
 */
class SalesReturnController extends MainController
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
     * Lists all TrSalesreturnhead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrSalesreturnhead();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->salesReturnDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrSalesreturnhead model.
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
     * Creates a new TrSalesreturnhead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrSalesreturnhead();
        $model->salesReturnDate = date('d-m-Y');
        $model->grandTotal = "0,00";
        $model->joinSalesReturnDetail = [];

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
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing TrSalesreturnhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        var_dump($model);
//        yii::$app->end();

        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if($this->saveModel($model, false)){
                $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionPrint($id)
    {
        $this->layout = false;
        $connection =  MdlDb::getDbConnection();
        $sql = 'SELECT f.fullName, a.salesReturnNum, a.fakturNum, a.salesReturnDate, YEAR(a.salesReturnDate) as year, 
                MONTH(a.salesReturnDate) as month, 
                DAY(a.salesReturnDate) as day, d.customerName, d.npwpAddress, d.npwp, c.productName, b.qty, 
                b.uomID, e.uomName, b.HPP, SUM(floor(b.qty) * b.HPP) as subtotal, a.additionalInfo 
                FROM tr_salesreturnhead a 
                INNER JOIN tr_salesreturndetail b ON b.salesReturnNum = a.salesReturnNum 
                INNER JOIN ms_product c ON c.productID = b.productID 
                INNER JOIN ms_customer d ON d.customerID = a.customerID 
                INNER JOIN ms_uom e ON e.uomID = b.uomID
                INNER JOIN ms_user f ON f.username = a.createdBy
                where a.salesReturnNum = "'.$id.'" '
               .'GROUP BY b.productID';
        $model = $connection->createCommand($sql)->queryAll();
        $content = $this->render('report_view',[
            'model' => $model,
        ]);

        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        $mpdf->Output('report.pdf','I');
    }

    /**
     * Deletes an existing TrSalesreturnhead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        TrSalesreturndetail::deleteAll('salesReturnNum = :salesReturnNum', [":salesReturnNum" => $id]);
        
        $idCustomerAdvance = TrCustomeradvancebalancedetail::find()->where(['refNum' => $id])->one();
        TrCustomeradvancebalancedetail::deleteAll('refNum = :refNum', [":refNum" => $id]);
        TrCustomeradvancebalancehead::deleteAll('balanceHeadID = :balanceHeadID', [":balanceHeadID" => $idCustomerAdvance['balanceHeadID']]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the TrSalesreturnhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrSalesreturnhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrSalesreturnhead::findOne($id)) !== null ) {
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
        $modelMonth = date("m",strtotime($model->salesReturnDate)) - 1;
       
        if ($newTrans){
            $tempModel = TrSalesreturnhead::find()
            ->where('YEAR(salesReturnDate) LIKE :salesReturnDate',[
                    ':salesReturnDate' => date("Y",strtotime($model->salesReturnDate))
            ])
            ->orderBy('salesReturnNum DESC')
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/SR/".substr(date("Y",strtotime($model->salesReturnDate)), -2)."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->salesReturnNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/SR/".substr(date("Y",strtotime($model->salesReturnDate)), -2)."/".$month[$modelMonth]."/".$temp;
            }
            
            $model->salesReturnNum = $tempTransNum;
            
           
        }
        

        $model->salesReturnDate = AppHelper::convertDateTimeFormat($model->salesReturnDate, 'd-m-Y', 'Y-m-d H:i:s');
        $model->grandTotal = str_replace(",",".",str_replace(".","",$model->grandTotal));
        
        if (!$model->save()) {
             print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }
        $idCustomerAdvance = TrCustomeradvancebalancedetail::find()->where(['refNum' => $model->salesReturnNum])->one();
        TrSalesreturndetail::deleteAll('salesReturnNum = :salesReturnNum', [":salesReturnNum" => $model->salesReturnNum]);
        TrCustomeradvancebalancedetail::deleteAll('refNum = :refNum', [":refNum" => $model->salesReturnNum]);
        TrCustomeradvancebalancehead::deleteAll('balanceHeadID = :balanceHeadID', [":balanceHeadID" => $idCustomerAdvance['balanceHeadID']]);
        
        $advanceBalance =  new TrCustomeradvancebalancehead();
        $advanceBalance->balanceDate = $model->salesReturnDate;
        $advanceBalance->customerID =  $model->customerID;
        $advanceBalance->balanceHeadID;
        
         if (!$advanceBalance->save()) {
             print_r($advanceBalance->getErrors());
            $transaction->rollBack();
            return false;
        }
        
        foreach ($model->joinSalesReturnDetail as $salesDetail) {
            $salesDetailModel = new TrSalesreturndetail();
            $salesDetailModel->salesReturnNum = $model->salesReturnNum;
            $salesDetailModel->refNum = $salesDetail['refNum'];
            $salesDetailModel->productID = $salesDetail['productID'];
            $salesDetailModel->uomID = $salesDetail['uomID'];
            $salesDetailModel->qty = str_replace(",",".",str_replace(".","",$salesDetail['returnedQty']));
            $salesDetailModel->HPP = str_replace(",",".",str_replace(".","",$salesDetail['HPP']));
            $salesDetailModel->VAT = $salesDetail['taxValue'];
            $salesDetailModel->totalAmount = str_replace(",",".",str_replace(".","",$salesDetail['subtotal']));
            $salesDetailModel->notes = $salesDetail['notes'];
            
            $advanceBalanceDetail = new TrCustomeradvancebalancedetail();
            $advanceBalanceDetail->refNum = $model->salesReturnNum;
            $advanceBalanceDetail->amount = str_replace(",",".",str_replace(".","",$salesDetail['subtotal']));
            $advanceBalanceDetail->balanceHeadID = $advanceBalance->balanceHeadID;
            
            
            if (!$salesDetailModel->save()) {
                $transaction->rollBack();
                return false;
            }
            if (!$advanceBalanceDetail->save()) {
                $transaction->rollBack();
                return false;
            }
        }
        $transaction->commit();
        return true; 
        
//         $arrayInfo = json::encode($purchaseDetailModel->getErrors());
//                throw new Exception("Gagal Menyimpan engan error: $arrayInfo");
//                //return false;
//            }
//        }
//        
//        $transaction->commit();
//        return true;

    }
}
