<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSetting;
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
 * SupplierPayableController implements the CRUD actions for TrSupplierpayablehead model.
 */
class SupplierPayableController extends MainController
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
        $model = new TrSupplierpayablehead();
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
        CAST(IF(ref.hasVat=1, detail.amount/110*100, detail.amount) AS DECIMAL(18,2)) AS subTotal,
        CAST(IF(ref.hasVat=1, detail.amount/110*10, 0) AS DECIMAL(18,2)) AS tax,
        @grandTotal := detail.amount AS grandTotal,
        @advancedPaymentAmount := (
            SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
            FROM tr_supplieradvancebalancedetail AS advPaymentDetail
            LEFT JOIN tr_supplieradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
            WHERE advPaymentDetail.refNum = detail.refNum AND SUBSTR(advPaymentDetail.refNum, 5, 2) = '$type'
        ) AS advancedPaymentAmount,
        @previousPayment := (
            SELECT CAST(IFNULL(SUM(paymentDetail.paymentAmount), 0) AS DECIMAL(18, 2))
            FROM tr_supplierpaymenthead AS paymentHead
            LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
            WHERE paymentDetail.refNum = detail.refNum AND SUBSTR(paymentHead.supplierPaymentNum, 5, 2) = '$type'
        ) AS previousPayment,
        CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
        FROM tr_supplierpayabledetail AS detail
        LEFT JOIN tr_supplierpayablehead AS head ON detail.payableNum = head.payableNum
        INNER JOIN (
            SELECT d.payableDetailID,
            CASE 
                WHEN poHead.supplierID IS NOT NULL THEN poHead.supplierID
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
            CASE 
                WHEN poHead.grandTotal IS NOT NULL THEN poHead.grandTotal
                WHEN poni.grandTotal IS NOT NULL THEN poni.grandTotal
                ELSE 0
            END AS grandTotal
            FROM tr_supplierpayabledetail AS d
            LEFT JOIN tr_goodsreceipthead AS receiptHead ON receiptHead.goodsReceiptNum = d.refNum
            LEFT JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = receiptHead.refNum
            LEFT JOIN tr_purchaseordernoninventoryhead AS poni ON poni.purchaseOrderNonInventoryNum = d.refNum
        ) AS ref ON ref.payableDetailID = detail.payableDetailID
        ) x
        WHERE  x.outstandingAmount > 0 AND supplierID = $supplierID";
       
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
        $footer =   '<div style="text-align: center; font-size: 14px">'.$imageCompany. " $address, Jakarta 11520, Indonesia<br>" 
                    .$imagePhone.' '. $phone1->value1 .', '. $phone2->value1 .', '. $phone3->value1 .', '. $phone4->value1 .' &nbsp;&nbsp;&nbsp;'.$imageFax.' '. $fax->value1 .'</div>
                    <div style="border-bottom:1px solid black;"></div>
                    <div style="border-bottom:5px solid #76A84D; margin-top:2px;"></div>
                    <div style="border-bottom:5px solid black;"></div>';
        
        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->Output('report.pdf','I');
        
    }
}
