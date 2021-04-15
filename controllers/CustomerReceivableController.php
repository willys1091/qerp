<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSetting;
use app\models\TrCustomerreceivablehead;
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
 * CustomerReceivableController implements the CRUD actions for TrCustomerreceivablehead model.
 */
class CustomerReceivableController extends MainController
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
     * Lists all TrCustomerreceivablehead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrCustomerreceivablehead();

        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrCustomerreceivablehead model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->view->params['browse'] = true;
        $model = TrCustomerreceivablehead::find()
                ->where('customerID = :customerID',[':customerID' => $id])
                ->one();

        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrCustomerreceivablehead::find()
                                        ->select(['refNum','receivableDate','currency','rate','amount'])
                                        ->joinWith('receivableDetail')
                                        ->where('customerID = :customerID',[':customerID' => $id]),
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Creates a new TrCustomerreceivablehead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrCustomerreceivablehead();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->receivableNum]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TrCustomerreceivablehead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->receivableNum]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionPrint($id)
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT c.customerName, c.npwpAddress, c.npwp, d.productName, e.uomName, b.price, b.qty, f.paymentName '
               .'FROM tr_salesorderhead a '
               .'INNER JOIN tr_salesorderdetail b ON b.salesOrderNum = a.salesOrderNum '
               .'INNER JOIN ms_customer c ON c.customerID = a.customerID '
               .'INNER JOIN ms_product d ON d.productID = b.productID '
               .'INNER JOIN ms_uom e ON e.uomID = b.uomID '
               .'INNER JOIN lk_paymentmethod f ON f.paymentID = a.paymentID '
               .'WHERE a.salesOrderNum = "'.$id.'"';
        $model = $connection->createCommand($sql)->queryAll();
        
        $content = $this->render('report_receivable',[
            'model' => $model,
        ]);
        
        //return $content;
        
        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        $mpdf->Output('report.pdf','I');
    }
    
    public function actionPrintReceivable($customerID)
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        $sql = "SELECT x.*
        FROM (
            SELECT detail.receivableNum, refNum AS transactionRefNum, head.receivableDate AS transactionDate, detail.currency,
            ref.num AS originRefNum, ref.customerID, ref.hasVat,
                CAST(IF(ref.hasVat=1, detail.amount/110*100, detail.amount) AS DECIMAL(18,2)) AS subTotal,
            CAST(IF(ref.hasVat=1, detail.amount/110*10, 0) AS DECIMAL(18,2)) AS tax,
                @grandTotal := detail.amount AS grandTotal,
                @advancedPaymentAmount := (
                    SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
                    FROM tr_customeradvancebalancedetail AS advPaymentDetail
                    LEFT JOIN tr_customeradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
                    WHERE advPaymentDetail.refNum = detail.refNum
            ) AS advancedPaymentAmount,
            @previousPayment := (
                SELECT CAST(IFNULL(SUM(payment.paymentAmount), 0) AS DECIMAL(18, 2))
                FROM tr_customerpayment AS payment
                WHERE payment.refNum = detail.refNum
            ) AS previousPayment,
                CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
            FROM tr_customerreceivabledetail AS detail
            LEFT JOIN tr_customerreceivablehead AS head ON detail.receivableNum = head.receivableNum
            INNER JOIN (
                SELECT d.receivableNum,
                cshead.customerID,
                sohead.salesorderNum AS num,
                IF(sohead.taxRate > 0, 1, 0) AS hasVat,
                sohead.grandTotal
                FROM tr_customerreceivabledetail AS d
                LEFT JOIN tr_customerreceivablehead AS csHead on d.receivableNum=csHead.receivableNum
                LEFT JOIN tr_goodsdeliveryhead AS deliveryHead ON deliveryHead.goodsDeliveryNum = d.refNum
                LEFT JOIN tr_salesorderhead AS sohead ON sohead.salesOrderNum = deliveryHead.refNum
            ) AS ref ON ref.receivableNum = detail.receivableNum
                ) AS x
                LEFT JOIN ms_customer AS customer ON customer.customerID = x.customerID
                LEFT JOIN (
            SELECT cust.customerID,
                    IFNULL(office.contactPerson, custDetail.contactPerson) AS contactPerson, 
                    IFNULL(office.street, custDetail.street) AS street,
                    IFNULL(office.phone, custDetail.phone) AS phone
                    FROM ms_customer AS cust
                    LEFT JOIN ms_customerdetail AS office ON office.customerID = cust.customerID AND office.addressType = 'office'
                    LEFT JOIN ms_customerdetail AS custDetail ON custDetail.customerID = cust.customerID
                    LIMIT 1
                ) AS pic ON pic.customerID = customer.customerID
                WHERE x.outstandingAmount > 0 AND x.customerID = $customerID";
        
        $model = $connection->createCommand($sql)->queryAll();
        $content = $this->render('report_receivable',[
            'model' => $model,
            'customerID' => $customerID
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
    /**
     * Deletes an existing TrCustomerreceivablehead model.
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
     * Finds the TrCustomerreceivablehead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrCustomerreceivablehead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrCustomerreceivablehead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
