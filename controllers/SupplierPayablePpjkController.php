<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSetting;
use app\models\TrGoodsreceipthead;
use app\models\TrSupplierpayablehead;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * SupplierPayablePpjkController implements the CRUD actions for TrSupplierpayablehead model.
 */
class SupplierPayablePpjkController extends MainController
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
     * Lists all TrSupplierpayablehead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrGoodsreceipthead();
        $model->startDate  = date('1-m-Y');
        $model->endDate = date('d-m-Y'); 
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrSupplierpayablehead model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->view->params['browse'] = true;
        $model = TrSupplierpayablehead::find()
                ->where('payableNum = :payableNum',[':payableNum' => $id])
                ->one();
                
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrSupplierpayablehead::find()
                                        ->select(['refNum','payableDate','currency','rate','amount'])
                                        ->joinWith('payableDetail')
                                        ->where('tr_supplierpayablehead.payableNum = :payableNum',[':payableNum' => $id]),
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Creates a new TrSupplierpayablehead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrSupplierpayablehead();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payableNum]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TrSupplierpayablehead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payableNum]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TrSupplierpayablehead model.
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
     * Finds the TrSupplierpayablehead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrSupplierpayablehead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrSupplierpayablehead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPrint($supplierID, $isForwarder)
    {
       
        
//        $model->load(Yii::$app->request->get());
//        $id = $model->id;
//        $contactPerson = $model->contactPerson;
//        $invoice = $model->invoice;
        
     
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        $type = $isForwarder == 1 ? 'FP' : 'SP';

       $sql = "SELECT *
                FROM (
                SELECT refNum AS transactionRefNum, head.payableDate AS transactionDate, detail.currency,
                ref.num AS originalRefNum, ref.supplierID, ref.hasVat, 

                @grandTotal := ref.grandTotal AS grandTotal,
                @advancedPaymentAmount := (
                    SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
                    FROM tr_supplieradvancebalancedetail AS advPaymentDetail
                    LEFT JOIN tr_supplieradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
                    WHERE advPaymentDetail.refNum = detail.refNum AND SUBSTR(advPaymentDetail.refNum, 5, 2) = 'FP'
                ) AS advancedPaymentAmount,
                @previousPayment := (
                    SELECT CAST(IFNULL(SUM(paymentDetail.paymentAmount), 0) AS DECIMAL(18, 2))
                    FROM tr_supplierpaymenthead AS paymentHead
                    LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
                    WHERE paymentDetail.refNum = detail.refNum AND SUBSTR(paymentHead.supplierPaymentNum, 5, 2) = 'FP'
                ) AS previousPayment,
                CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
                FROM tr_supplierpayabledetail AS detail
                LEFT JOIN tr_supplierpayablehead AS head ON detail.payableNum = head.payableNum
                INNER JOIN (
                    SELECT d.payableDetailID,
                    CASE 
                        WHEN receiptHead.PPJK IS NOT NULL THEN receiptHead.PPJK
                        WHEN poni.supplierID IS NOT NULL THEN poni.supplierID
                        ELSE '-'
                    END AS supplierID,
                    CASE 
                        WHEN poHead.purchaseOrderNum IS NOT NULL THEN poHead.purchaseOrderNum
                        WHEN poni.purchaseOrderNonInventoryNum IS NOT NULL THEN poni.purchaseOrderNonInventoryNum
                        ELSE '-'
                        END AS num,
                    CASE
                        WHEN poHead.hasVat IS NOT NULL THEN poHead.hasVat
                        WHEN poni.hasVat IS NOT NULL THEN poni.hasVat
                        ELSE 0
                    END AS hasVat,
                    cost.importDutyAmount + cost.PPNImportAmount + cost.PPHImportAmount 
                    AS grandTotal
                    FROM tr_supplierpayabledetail AS d
                    LEFT JOIN tr_goodsreceipthead AS receiptHead ON receiptHead.goodsReceiptNum = d.refNum
                    LEFT JOIN tr_goodsreceiptcost AS cost ON cost.goodsReceiptNum = receiptHead.goodsReceiptNum
                    LEFT JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = receiptHead.refNum
                    LEFT JOIN tr_purchaseordernoninventoryhead AS poni ON poni.purchaseOrderNonInventoryNum = d.refNum
                ) AS ref ON ref.payableDetailID = detail.payableDetailID
                ) x
                WHERE  floor(x.outstandingAmount) > 0  AND supplierID = $supplierID";
       
        $pay = TrSupplierpayablehead::$payableTotal = 0;

        $modelHead = $connection->createCommand($sql)->queryAll();
        $content = $this->render('report_payable',[
            'payableTotal' => $pay,
            'modelHead' => $modelHead,
			'supplierID' => $supplierID
            
            
        ]);
        $imageCompany = Html::img('assets_b/images/office_building.png',['height' => '12px', 'width' => '12px']);
        $imagePhone = Html::img('assets_b/images/canva-call-icon-MACQYneSATM.png',['height' => '12px', 'width' => '12px']);
        $imageFax = Html::img('assets_b/images/fax_machine.png',['height' => '12px', 'width' => '12px']); 
        $phone1 = MsSetting::findOne(['key1' => 'Phone1']);
        $phone2 = MsSetting::findOne(['key1' => 'Phone2']);
        $phone3 = MsSetting::findOne(['key1' => 'Phone3']);
        $phone4 = MsSetting::findOne(['key1' => 'Phone4']);
        $fax = MsSetting::findOne(['key1' => 'Fax']);
        $address = strtok(MsSetting::findOne(['key1' => 'OfficeAddress'])->value1, "\n");
         $mpdf = new mPDF('',    // mode - default ''
                        'A4',    // format - A4, default ''
                        0,     // font size - default 0
                        '',    // default font family
                        '13',    // margin_left
                        '13',    // margin right
                        '5',     // margin top
                        '10',    // margin bottom
                        '0',     // margin header
                        '5',     // margin footer
                        'L'     // P = portrait, L = landscape
                );
         $mpdf->AddPage('L');
        $mpdf->WriteHTML($content);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->Output('report.pdf','I');
        
    }
}
