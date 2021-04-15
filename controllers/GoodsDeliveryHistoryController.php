<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\StockCard;
use app\models\StockHpp;
use app\models\TrCustomerpayment;
use app\models\TrCustomerreceivabledetail;
use app\models\TrCustomerreceivablehead;
use app\models\TrGoodsdeliverydetail;
use app\models\TrGoodsdeliveryhead;
use app\models\TrGoodsdeliveryheadhistory;
use app\models\TrJournalhead;
use kartik\widgets\ActiveForm;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * GoodsDeliveryHistoryController implements the CRUD actions for TrGoodsdeliveryheadhistory model.
 */
class GoodsDeliveryHistoryController extends MainController
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
     * Lists all TrGoodsdeliveryheadhistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrGoodsdeliveryheadhistory();
        //$model->goodsDeliveryDate = date('d-m-Y');
        $model->startDate  = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->goodsDeliveryDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('hasEditable')) {
            $sampleID = Yii::$app->request->post('editableKey');
           
            $type =  Yii::$app->request->post('editableAttribute');
            if($type != goodsDeliveryNum){
                Yii::trace($sampleID, 'TESTSAMPLE');
                Yii::trace($GDNum, 'TESTSAMPLE');
                $modelSample = TrGoodsdeliveryheadhistory::findOne($sampleID);
                $posted = current($_POST['TrGoodsdeliveryheadhistory']);
                $statusID = $posted['deliveryStatus'];
                $modelSample->deliveryStatus = $statusID;
                $modelSample->goodsDeliveryDate = AppHelper::convertDateAndTimeFormat($modelSample->goodsDeliveryDate.' '.$modelSample->goodsDeliveryTime, 'd-m-Y H:i', 'Y-m-d H:i');

                $modelSample->save();
            } else {
                Yii::trace($sampleID, 'TESTGD');
                $modelSample = TrGoodsdeliveryheadhistory::findOne($sampleID);
                $modelSampleDetail = TrGoodsdeliverydetail::find()->where(['goodsDeliveryNum' => $sampleID])->all();
                
                $posted = current($_POST['TrGoodsdeliveryheadhistory']);
                $statusID = $posted['goodsDeliveryNum'];
                $checkGD = TrGoodsdeliveryheadhistory::findOne($statusID);
                
                if(!$checkGD){
                    Yii::trace($statusID, 'TRUE');
                    $modelSample->goodsDeliveryNum = $statusID;
                    $modelSample->goodsDeliveryDate = AppHelper::convertDateAndTimeFormat($modelSample->goodsDeliveryDate.' '.$modelSample->goodsDeliveryTime, 'd-m-Y H:i', 'Y-m-d H:i');


                    TrJournalhead::updateAll(['refNum' => $statusID], ['and',['=','refNum',$sampleID], ['=','transactionType','Sales Invoice']]);
                    foreach ($modelSampleDetail as $value) {

                        $productID = $value['productID'];
                        $batchNum = $value['batchNumber'];
                        StockCard::updateAll(['refNum' => $statusID], ['and',['=','refNum',$sampleID], ['=','productID',$productID], ['=','batchNumber',$batchNum]]);
                    }
                    TrCustomerreceivabledetail::updateAll(['refNum' => $statusID], ['=','refNum',$sampleID]);
                    TrCustomerpayment::updateAll(['refNum' => $statusID], ['=','refNum',$sampleID]);
                    TrGoodsdeliverydetail::updateAll(['goodsDeliveryNum' => $statusID], ['=','goodsDeliveryNum',$sampleID]);
                    $modelSample->save();   
                } else {
                    Yii::trace($statusID, 'GAGAL');
                    //return false;
                }
                
            }
           
            $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrGoodsdeliveryheadhistory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionUpdate($id)
    {   $connection = Yii::$app->db;
        $model = $this->findModel($id);
     
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
           $model->goodsDeliveryDate =  AppHelper::convertDateTimeFormat($model->goodsDeliveryDate, 'd-m-Y', 'Y-m-d H:i');
           
           $model->deliveryStatus;
           $model->customerDetailID;
           $model->warehouseID;
           $model->shipmentBy;
           $model->deliveryNum;
            if ($model->save()) {
                StockCard::deleteAll('refNum = :refNum', [":refNum" => $id]);
                
                $mode = 2;
                $command = $connection->createCommand('call sp_insert_stockcard(:refNum,:transactionDates,:mode)');
                $command->bindParam(':refNum', $id);
                $command->bindParam(':transactionDates', $model->goodsDeliveryDate);
                $command->bindParam(':mode', $mode);
                $command->execute(); 
                
                return $this->redirect(['index']);
            } else {
                print_r($model->getErrors());
                return false;
            }
        }
        return $this->render('update', [
                'model' => $model
        ]);
    }
    public function actionPrint($id)
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT a.goodsDeliveryNum, a.refNum, year(a.goodsDeliveryDate) as year, month(a.goodsDeliveryDate) as month, day(a.goodsDeliveryDate) as day, a.customerDetailID, d.customerName, c.street, c.city, c.country,
                c.phone, c.fax, c.postalCode, a.shipmentBy, b.productID, e.productName, e.origin, packingType.packingTypeName, f.uomName, b.uomID, b.qty, b.batchNumber, b.notes, a.additionalInfo, d.npwpAddress,
                DATE_FORMAT(b.manufactureDate,"%d %b %Y") as manufactured, DATE_FORMAT(b.expiredDate,"%d %b %Y") as expired, DATE_FORMAT(b.retestDate,"%d %b %Y") as retest,
                officeDetail.country AS officeCountry, officeDetail.city AS officeCity, officeDetail.street AS officeStreet, 
                officeDetail.postalCode AS officePostalCode, officeDetail.phone AS officePhone, officeDetail.fax AS officeFax
                FROM tr_goodsdeliveryhead a
                LEFT JOIN tr_goodsdeliverydetail b ON a.goodsDeliveryNum = b.goodsDeliveryNum
                LEFT JOIN ms_customerdetail c ON a.customerDetailID = c.customerDetailID
                LEFT JOIN ms_customerdetail AS officeDetail ON officeDetail.customerDetailID = 
                (
                    SELECT customerDetailID FROM ms_customerdetail
                    WHERE customerID = c.customerID AND (addressType = "office" OR addressType LIKE "%office%")
                    LIMIT 1
                )
                LEFT JOIN ms_customer d ON d.customerID = c.customerID
                LEFT JOIN ms_product e ON e.productID = b.productID
                LEFT JOIN ms_productdetail productDetail ON productDetail.productID = b.productID
                LEFT JOIN ms_packingtype packingType ON packingType.packingTypeID = productDetail.packingTypeID
                LEFT JOIN ms_uom f ON f.uomID = b.uomID
                WHERE a.goodsDeliveryNum = "'.$id.'"';
        $command = $connection->createCommand($sql);
        $model = $command->queryAll();
        $city = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "City"')->queryOne();
        $companyName = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyName"')->queryOne();
        $country = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Country"')->queryOne();
        $fax = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Fax"')->queryOne();
        $kecamatan = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Kecamatan"')->queryOne();
        $kelurahan = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Kelurahan"')->queryOne();
        $officeAddress = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "OfficeAddress"')->queryOne();
        $pharmacistName = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PharmacistName"')->queryOne();
        $pharmacistNumber = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PharmacistNumber"')->queryOne();
        $phone1 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone1"')->queryOne();
        $phone2 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone2"')->queryOne();
        $phone3 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone3"')->queryOne();
        $phone4 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone4"')->queryOne();
        $postalCode = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PostalCode"')->queryOne();
        $province = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Province"')->queryOne();
        $ipbbbNo = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "IPBBBFNo"')->queryOne();
              
        $content = $this->renderPartial('report_view_surat_jalan',[
            'model' => $model,
            'city' => $city,
            'companyName' => $companyName,
            'country' => $country,
            'fax' => $fax,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'officeAddress' => $officeAddress,
            'pharmacistName' => $pharmacistName,
            'pharmacistNumber' => $pharmacistNumber,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'phone3' => $phone3,
            'phone4' => $phone4,
            'postalCode' => $postalCode,
            'province' => $province,
            'ipbbbNo' => $ipbbbNo,
        ]);
        
        //$mpdf = new mPDF('utf-8', [210, 297]);
		$mpdf = new mPDF('utf-8', [210, 262]);
        $mpdf->tableMinSizePriority = false;
		
        $mpdf->WriteHTML($content);
        
        
        $mpdf->Output('report.pdf','I');
    }
    public function actionPrintfaktur($id)
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        $sqlHead = 'SELECT cd.customerDetailID, cd.phone, mc.customerID,mc.tax, mc.customerName,mc.dueDate,mc.npwp,mc.npwpAddress, 
                gd.invoiceNum, gd.goodsDeliveryNum, so.customerOrderNum, date_format(gd.goodsDeliveryDate, "%d-%b-%Y") as date,gd.additionalInfo, gd.goodsDeliveryDate as gdDate
                from tr_goodsdeliveryhead gd
                join tr_salesorderhead so on gd.refNum=so.salesOrderNum
                join ms_customer mc on so.customerID=mc.customerID
                JOIN ms_customerdetail cd on mc.customerID = cd.customerID
                where gd.goodsDeliveryNum = "'.$id.'"';
        $command = $connection->createCommand($sqlHead);        
        $modelHead = $command->queryOne();
        
        $sqlDetail = 'SELECT mp.productName,mp.origin,mu.uomName,gdd.qty, gdd.batchNumber, sod.price,sod.discount
                    from tr_goodsdeliverydetail gdd
                    join tr_goodsdeliveryhead gd on gd.goodsDeliveryNum=gdd.goodsDeliveryNum
                    join tr_salesorderhead so on gd.refNum=so.salesOrderNum
                    join tr_salesorderdetail sod on so.salesOrderNum=sod.salesOrderNum and gdd.productID=sod.productID
                    join ms_product mp on gdd.productID=mp.productID
                    join ms_uom mu on gdd.uomID=mu.uomID
                    where gd.goodsDeliveryNum = "'.$id.'"';
        $command = $connection->createCommand($sqlDetail);        
        $modelDetail = $command->queryAll();
        $pharmacistName = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PharmacistName"')->queryOne();
        $pharmacistNumber = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PharmacistNumber"')->queryOne();

        $view = 'report_test';
        $content = $this->render($view, [
           'modelHead' => $modelHead,
           'modelDetail' => $modelDetail,
            'pharmacistName' => $pharmacistName,
            'pharmacistNumber' => $pharmacistNumber
        ]);  

        $mpdf = new mPDF;
        
        //$mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($content);

        //$mpdf->debug = true;
        $mpdf ->Output('report.pdf','I');
        exit;
    }
    /**
     * Deletes an existing TrGoodsdeliveryheadhistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $data = TrGoodsdeliverydetail::find()->where(['goodsDeliveryNum' => $id])->all();
        $payment = TrCustomerreceivabledetail::find()->where(['refNum' => $id])->all();
        foreach ($payment as $pay){
           $payNum =  $pay['receivableNum'];
           TrCustomerreceivablehead::deleteAll('receivableNum = :receivableNum', [":receivableNum" => $payNum]);
           
        }
        TrCustomerreceivabledetail::deleteAll('refNum = :refNum', [":refNum" => $id]);
        foreach ($data as $row) {
            $batchNum = $row['batchNumber'];
            $product  = $row['productID'];
            $qty  = $row['qty'];
            
            $stockHpp = StockHpp::find()->where(['productID' => $product, 'batchNumber'=> $batchNum])->one();
            $stockHpp->qtyStock = $stockHpp['qtyStock'] + $qty;
            $stockHpp->save();
        }
        TrGoodsdeliverydetail::deleteAll('goodsDeliveryNum = :goodsDeliveryNum', [":goodsDeliveryNum" => $id]);
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the TrGoodsdeliveryheadhistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrGoodsdeliveryheadhistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrGoodsdeliveryheadhistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException("The requested model doesn't exist");
        }
    }
}
