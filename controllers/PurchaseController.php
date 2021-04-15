<?php
namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSetting;
use app\models\MsUser;
use app\models\TrPurchaseorderdetail;
use app\models\TrPurchaseorderhead;
use app\models\TrSalesorderdetail;
use app\models\TrSalesorderhead;
use Exception;
use kartik\widgets\ActiveForm;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PurchaseController implements the CRUD actions for TrPurchaseorderhead model.
 */
class PurchaseController extends MainController
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
        $model = new TrPurchaseorderhead();
        $model->startDate = date('1-m-Y'); //'01-01-2017'
        $model->endDate = date('d-m-Y');
        $model->purchaseOrderDate = "$model->startDate to $model->endDate";
        
        $model->startDates = date('1-m-Y'); //'01-01-2017'
        $model->endDates = date('d-m-Y');
        $model->supplierpaymentDate = "$model->startDates to $model->endDates";
        $model->load(Yii::$app->request->queryParams);

        return $this->render(Yii::$app->user->identity->userRole == 'ACCOUNTING-FETI' || Yii::$app->user->identity->userRole == 'ACCOUNTING'  ? 'index_' : 'index', [
            'model' => $model,
        ]);
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionPrint($id)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        /*$sql = 'SELECT a.supplierID, a.purchaseOrderDate, a.purchaseOrderNum, a.contactPerson, a.contactPersonCC, 
                a.packingType, a.shipmentType,  a.deliveryType, a.currencyID,
                b.supplierName, b.country, b.province, b.city, b.street, g.uomName, h.packingTypeName, e.paymentDue, a.additionalInfo, 
                f.productName, f.origin, f.productSubcategoryID, c.qty, c.price, (c.qty * c.price) as amount
                FROM tr_purchaseorderhead a 
                INNER JOIN ms_supplier b ON b.supplierID = a.supplierID
                INNER JOIN tr_purchaseorderdetail c ON c.purchaseOrderNum = a.purchaseOrderNum    
                INNER JOIN ms_productdetail d ON d.productID = c.productID 
                LEFT JOIN ms_paymentdue e ON e.ID = a.paymentDue 
                INNER JOIN ms_product f ON f.productID = c.productID 
                INNER JOIN ms_uom g ON g.uomID = d.uomID 
                INNER JOIN ms_packingtype h ON h.packingTypeID = d.packingTypeID
                WHERE a.purchaseOrderNum = "'.$id.'"';*/
        $sql = "SELECT head.revitionNotes, head.supplierID, head.purchaseOrderDate, head.purchaseOrderNum, head.contactPerson, head.contactPersonCC,
        head.packingType, head.shipmentType, head.deliveryType, head.currencyID, head.createdBy,
        supplier.supplierName, supplier.country, supplier.province, supplier.city, supplier.street,
        uom.uomID, uom.uomName, packing.packingTypeName, paymentDue.paymentDue, head.additionalInfo,
        product.hsCode, product.productName, product.origin, product.productSubcategoryID, detail.qty, (detail.price - (detail.price * detail.discount / 100.00)) price, detail.qty * (detail.price - (detail.price * detail.discount / 100.00)) AS amount
        FROM tr_purchaseorderhead AS head
        LEFT JOIN ms_paymentdue AS paymentDue ON paymentDue.ID = head.paymentDue
        LEFT JOIN tr_purchaseorderdetail AS detail ON detail.purchaseoRderNum = head.purchaseorderNum
        LEFT JOIN ms_product AS product ON product.productID = detail.productID
        LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = product.supplierID
        LEFT JOIN ms_productdetail AS productDetail ON productDetail.productID = product.productID
        LEFT JOIN ms_uom AS uom ON uom.uomID = detail.uomID
        LEFT JOIN ms_packingtype AS packing ON packing.packingTypeID = productDetail.packingTypeID
        WHERE head.purchaseOrderNum = '$id'";
        
        $command = $connection->createCommand($sql);        
        $model = $command->queryAll();

//        $city = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "City"')->queryOne();
//        $companyAttn = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyAttn"')->queryOne();
//        $companyAttnEmail = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyAttnEmail"')->queryOne();
//        $companyDirector = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyDirector"')->queryOne();
//        $companyName = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyName"')->queryOne();
//        $country = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Country"')->queryOne();
//        $fax = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Fax"')->queryOne();
//        $kecamatan = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Kecamatan"')->queryOne();
//        $kelurahan = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Kelurahan"')->queryOne();
//        $officeAddress = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "OfficeAddress"')->queryOne();
//        $pharmacistName = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PharmacistName"')->queryOne();
//        $pharmacistNumber = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PharmacistNumber"')->queryOne();
//        $phone1 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone1"')->queryOne();
//        $phone2 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone2"')->queryOne();
//        $phone3 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone3"')->queryOne();
//        $phone4 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone4"')->queryOne();
//        $postalCode = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PostalCode"')->queryOne();
//        $province = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Province"')->queryOne();
        
        
        
        $location= Html::img('assets_b/images/location.png',['height' => '15px', 'width' => '15px']);
        $imagePhone = Html::img('assets_b/images/phone.png',['height' => '15px', 'width' => '15px']);
        $imageFax = Html::img('assets_b/images/fax.png',['height' => '15px', 'width' => '15px']); 
        $phone1 = MsSetting::findOne(['key1' => 'Phone1']);
        $phone2 = MsSetting::findOne(['key1' => 'Phone2']);
        $phone3 = MsSetting::findOne(['key1' => 'Phone3']);
        $phone4 = MsSetting::findOne(['key1' => 'Phone4']);
        $NPWP = MsSetting::findOne(['key1' => 'NPWP']);
        $fax = MsSetting::findOne(['key1' => 'Fax']);
        $company = MsSetting::findOne(['key1' => 'CompanyName']);
        $address = MsSetting::findOne(['key1' => 'OfficeAddress']);
        $streets= MsSetting::findOne(['key1' => 'Street']);
        $kel= MsSetting::findOne(['key1' => 'Kelurahan']);
        $kec= MsSetting::findOne(['key1' => 'Kecamatan']);
        $city= MsSetting::findOne(['key1' => 'City']);
        $province= MsSetting::findOne(['key1' => 'Province']);
        $postalCode= MsSetting::findOne(['key1' => 'PostalCode']);
        $country= MsSetting::findOne(['key1' => 'Country']);
         
        $footer =   '<div style="text-align: left; font-size: 15px; ">'.$location." $address->value1<br>" 
                    .$imagePhone.' '. $phone1->value1 .', '. $phone2->value1 .', '. $phone3->value1 .'<br>'.$imagePhone.' '. $phone4->value1 .' &nbsp;&nbsp;&nbsp; <br>'.$imageFax.' '. $fax->value1 .'</div>
                    ';
//        foreach ($model as $row) {
//           $created =  $row['createdBy'];
//        }
//        
//        $details = MsUser::findOne(['username' => $created]);
//        $createdBy = $details->fullName;
        
        $view = 'report_view_purchase_order';
        $content = $this->renderPartial($view, [
            'model' => $model,
            'location' => $location,
            'city' => $city,
            'province' => $province,
            'companyAttn' => $companyAttn,
            'companyAttnEmail' => $companyAttnEmail,
            'companyDirector' => $companyDirector,
            'companyName' => $companyName,
            'countrys' => $country,
            'fax' => $fax,
            'streets' => $streets,
            'kec' => $kec,
            'kel' => $kel,
            'address' => $address,
            'pharmacistName' => $pharmacistName,
            'pharmacistNumber' => $pharmacistNumber,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'phone3' => $phone3,
            'phone4' => $phone4,
            'company' => $company,
            'NPWP' => $NPWP,
            'postalCode' => $postalCode,
            'imageFax' => $imageFax,
            'imagePhone' => $imagePhone,
            'footer' => $footer,
        ]); 
                
        $imageCompany = Html::img('assets_b/images/office_building.png',['height' => '12px', 'width' => '12px']);
        $imagePhone = Html::img('assets_b/images/canva-call-icon-MACQYneSATM.png',['height' => '12px', 'width' => '12px']);
        $imageFax = Html::img('assets_b/images/fax_machine.png',['height' => '12px', 'width' => '12px']); 
      
        
        
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
        //$mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($content);
        $mpdf->Output('report.pdf','I');
        exit;
    }
    
    public function actionBrowseincomplete()
    {
        $this->view->params['browse'] = true;
        $model = new TrPurchaseorderhead();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                'query' => TrPurchaseorderhead::find()
                    ->select(new Expression('tr_purchaseorderhead.*,(
                            SELECT IFNULL(SUM(advPayment.amount), 0)
                            FROM tr_supplieradvancepayment AS advPayment
                            WHERE advPayment.refNum = tr_purchaseorderhead.purchaseOrderNum AND advPayment.supplierID = tr_purchaseorderhead.supplierID
                        ) AS advancedPaymentAmount,
                        (
                            SELECT IFNULL(SUM(paymentDetail.paymentAmount), 0)
                            FROM tr_supplierpaymenthead AS paymentHead
                            LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
                            WHERE paymentDetail.refNum = tr_purchaseorderhead.purchaseOrderNum AND paymentHead.supplierID = tr_purchaseorderhead.supplierID 
                        ) AS previousPayment,
                        CAST((SELECT tr_purchaseorderhead.grandTotal - advancedPaymentAmount - previousPayment) AS DECIMAL(18,2)) AS outstandingAmount'))
                    ->joinWith('goodsReceipt')
                    ->joinWith('supplier')
                    ->joinWith('supplierAdvancePayment')
                    ->andFilterWhere(['like', 'purchaseOrderNum', $model->purchaseOrderNum])
                    ->andFilterWhere(['=', "DATE_FORMAT(purchaseOrderDate, '%d-%m-%Y')", $model->purchaseOrderDate])
                    ->andFilterWhere(['=', 'grandTotal', $model->grandTotal])
                    ->andFilterWhere(['like', 'ms_supplier.supplierName', $model->supplierID])
                    ->andWhere('tr_goodsreceipthead.refNum IS NULL')
                    ->andWhere('tr_supplieradvancepayment.refNum IS NULL')
                    ->having('outstandingAmount > -1')
                ,
                'sort' => [
                    'defaultOrder' => ['purchaseOrderNum' => SORT_DESC],
                    'attributes' => ['purchaseOrderNum', 'purchaseOrderDate', 'grandTotal', 'supplierID']
                ]
            ]);

        $this->layout = 'browseLayout';
        return $this->render('browse', [
                'dataProvider' => $dataProvider,
                'model' => $model
        ]);
    }
        
    public function actionBrowseForAdvancePayment()
    {
        $this->view->params['browse'] = true;
        $model = new TrPurchaseorderhead(); 
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrPurchaseorderhead::find()
                                        ->joinWith('goodsReceipt')
                                        ->andFilterWhere(['like', 'purchaseOrderNum', $model->purchaseOrderNum])
                                        ->andFilterWhere(['=', "DATE_FORMAT(purchaseOrderDate, '%d-%m-%Y')", $model->purchaseOrderDate])
                                        ->andFilterWhere(['=', 'grandTotal', $model->grandTotal])
                                        ->andFilterWhere(['=', 'supplierID', $model->supplierID])
                                        ->andWhere('tr_goodsreceipthead.refNum IS NULL'),
                            'sort' => [
                                    'defaultOrder' => ['purchaseOrderNum' => SORT_DESC],
                                    'attributes' => ['purchaseOrderNum', 'purchaseOrderDate', 'grandTotal', 'supplierID']
                            ]
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browse', [
                'dataProvider' => $dataProvider,
                'model' => $model
        ]);
    }    
    
    public function actionBrowsesample()
    {
        $this->view->params['browse'] = true;
        $model = new TrPurchaseorderhead();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrPurchaseorderhead::find()
                                        ->andFilterWhere(['like', 'purchaseOrderNum', $model->purchaseOrderNum])
                                        ->andFilterWhere(['=', "DATE_FORMAT(purchaseOrderDate, '%d-%m-%Y')", $model->purchaseOrderDate])
                                        ->andFilterWhere(['=', 'grandTotal', $model->grandTotal])
                                        ->andFilterWhere(['=', 'supplierID', $model->supplierID]),
                            'sort' => [
                                    'defaultOrder' => ['purchaseOrderNum' => SORT_DESC],
                                    'attributes' => ['purchaseOrderNum']
                            ]
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browse', [
                'dataProvider' => $dataProvider,
                'model' => $model
        ]);
    }
    public function actionBrowsebyyear($filter)
    {
        $this->view->params['browse'] = true;
        $model = new TrPurchaseorderhead();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrPurchaseorderhead::find()
                            ->where('year(purchaseOrderDate) = :year',[':year' => $filter])
                            ->andFilterWhere(['=', "DATE_FORMAT(purchaseOrderDate, '%d-%m-%Y')", $model->purchaseOrderDate])
                            ->andFilterWhere(['=', 'purchaseOrderNum', $model->purchaseOrderNum]),
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browse_by_year', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'filter' => $filter
        ]);
    }
    /**
     * Creates a new TrPurchaseorderhead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrPurchaseorderhead();
        $model->paymentID = 2;
        $model->purchaseOrderDate = date('d-m-Y');
        $model->shipmentDate = date('d-m-Y');
        $model->joinPurchaseOrderDetail = [];
        $model->grandTotal = "0,00";
        $model->rate = "1.00";
        $model->taxRate = "0.00";
        $previousPOModel = TrPurchaseorderhead::find()->orderBy(['createdDate' => SORT_DESC])->one();
        $model->additionalInfo = $previousPOModel == null ? "" : $previousPOModel->additionalInfo;

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
    public function actionCheck()
    {
        $products = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];
            $modelDetail = TrSalesorderdetail::find()
                            ->where('salesOrderNum = :refNum',[
                                    ':refNum' => $refNum
                            ])
                            ->all();
          
            $supplierID = $modelDetail[0]->product->supplier->supplierID;
            foreach($modelDetail as $detail)
            {
                if ($supplierID && $supplierID != $detail->product->supplier->supplierID) $supplierID = null;
                
                $products[] = [
                    'productID' => $detail->productID,
                    'productName' => $detail->product->productName,
                    'uomID' => $detail->uomID,
                    'uomName' => $detail->uom->uomName,
                    'qty' => $detail->qty,
                    'price' => $detail->price,
                    'discount' => $detail->discount,
                    'subTotal' => $detail->subTotal,
                ];
            }
            
            $result = [
                'supplierID' => $supplierID,
                'products' => $products
            ];
            
            return Json::encode($result);
        }
    }
    public function actionChecksample()
    {
        $purchaseDetail = [];
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];
            $modelDetail = TrPurchaseorderdetail::find()
                            ->where('purchaseOrderNum = :refNum',[
                                    ':refNum' => $refNum
                            ])
                            ->all();
          

            $i = 0;
            
            foreach ($modelDetail as $purchaseDetail) {
                $result[$i]["productID"] = $purchaseDetail->productID;
                $result[$i]["productName"] = $purchaseDetail->product->productName;
                $result[$i]["uomID"] = $purchaseDetail->uomID;
                $result[$i]["uomName"] = $purchaseDetail->uom->uomName;
                $result[$i]["batchNo"] = ""; 
                $result[$i]["manufactureDate"] = ""; 
                $result[$i]["expiredDate"] = "";
                $result[$i]["retestDate"] = "";
                $result[$i]["qty"] = "0,00";
                $i += 1;
            } 
            
            return Json::encode($result);
        }
    }
    public function actionChecksalesdetail()
    {
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];
            $modelDetail = TrSalesorderhead::find()
                            ->where('salesOrderNum = :refNum',[
                                    ':refNum' => $refNum
                            ])
                            ->all();
          

            $i = 0;
            
            foreach ($modelDetail as $joinPurchaseOrderDetail) {
                $result[$i]["currencyID"] = $joinPurchaseOrderDetail->currencyID;
                $result[$i]["rate"] = $joinPurchaseOrderDetail->rate;
            } 
            
            return Json::encode($result);
        }
    }

    /**
     * Updates an existing TrPurchaseorderhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       
	    $contactCC = explode(',', $model->contactPersonCC);
        //$contactCC = str_Replace(' ', '',$contactCC);
        $model->contactPersonCC = $contactCC;
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            
            
            if ($this->saveModel($model, false)) {
                $model->save();
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model,
               
        ]);
    
    }
    
    public function actionUpdateAccounting($id)
    {
        $model = $this->findModel($id);
        $model->supplierpaymentDate = AppHelper::convertDateTimeFormat($model->supplierpaymentDate, 'Y-m-d', 'd-m-Y');
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            
            $model->supplierpaymentDate = AppHelper::convertDateTimeFormat($model->supplierpaymentDate, 'd-m-Y', 'Y-m-d');
            if ($model->save()) {
                
                return $this->redirect(['index']);
            }
        }

        return $this->render('update-accounting', [
                'model' => $model,
               
        ]);
    
    }

    /**
     * Deletes an existing TrPurchaseorderhead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        TrPurchaseorderdetail::deleteAll('purchaseOrderNum = :purchaseOrderNum', [":purchaseOrderNum" => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrPurchaseorderhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrPurchaseorderhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrPurchaseorderhead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function saveModel($model, $newTrans)
    {
       
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        $model->grandTotal = str_replace(",",".",str_replace(".","",$model->grandtotal));
   
        if ($newTrans){
            $tempModel = TrPurchaseorderhead::find()
            ->where('SUBSTRING(purchaseOrderNum, 5, 2) LIKE :purchaseOrderDate',[
                    ':purchaseOrderDate' => date("y",strtotime($model->purchaseOrderDate))
            ])
            ->orderBy([new Expression("CAST(SUBSTRING(purchaseOrderNum, 7) AS UNSIGNED) DESC")])
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/".date("y",strtotime($model->purchaseOrderDate))."0001";
            }
            else{
                $temp = substr($tempModel->purchaseOrderNum,-4,4)+1;
                $temp = str_pad($temp,4,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/".date("y",strtotime($model->purchaseOrderDate)).$temp;
            }
            
            $model->purchaseOrderNum = $tempTransNum;
        }

        if($model->isImport == 1){
            $model->taxRate = "0,00";
        }
        else{
            if($model->hasVAT == 1){
                $model->taxRate = "10,00";
            }
            else
                $model->taxRate = "0,00";
        }
       
        $model->purchaseOrderDate = AppHelper::convertDateTimeFormat($model->purchaseOrderDate, 'd-m-Y', 'Y-m-d');
        $model->shipmentDate = AppHelper::convertDateTimeFormat($model->shipmentDate, 'd-m-Y', 'Y-m-d');
        $model->rate = str_replace(",",".",str_replace(".","",$model->rate));
        $model->taxRate = str_replace(",",".",str_replace(".","",$model->taxRate));
        if($model->contactPersonCC != ""){
            $contactPersonStr = implode(",", $model->contactPersonCC);
            $model->contactPersonCC = $contactPersonStr;
        }
        
                
        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }

        TrPurchaseorderdetail::deleteAll('purchaseOrderNum = :purchaseOrderNum', [":purchaseOrderNum" => $model->purchaseOrderNum]);
        
        if (empty($model->joinPurchaseOrderDetail) || !is_array($model->joinPurchaseOrderDetail) || count($model->joinPurchaseOrderDetail) < 1) {
            $transaction->rollBack();
            return false;
        }

        
        
       
        foreach ($model->joinPurchaseOrderDetail as $purchaseDetail) {
            
          
            if($purchaseDetail['discount'] == NULL || $purchaseDetail['discount'] == ''){
                $discount = 0.00;
            } else {
                $discount = $purchaseDetail['discount'];
            }
            
            $purchaseDetailModel = new TrPurchaseorderdetail();
            $purchaseDetailModel->purchaseOrderNum = $model->purchaseOrderNum;
            $purchaseDetailModel->productID = $purchaseDetail['productID'];
            $purchaseDetailModel->uomID = $purchaseDetail['uomID'];
            $purchaseDetailModel->qty = str_replace(",",".",str_replace(".","",$purchaseDetail['qty']));
            $purchaseDetailModel->price = str_replace(",",".",str_replace(".","",$purchaseDetail['price']));
            $purchaseDetailModel->discount = str_replace(",",".",str_replace(".","",$discount));
            $purchaseDetailModel->subTotal = str_replace(",",".",str_replace(".","",$purchaseDetail['subTotal']));
            $purchaseDetailModel->notes = "";
            
            //var_dump($purchaseDetailModel->discount); die();

            if (!$purchaseDetailModel->save()) {
                $transaction->rollBack();
                $arrayInfo = json::encode($purchaseDetailModel->getErrors());
                throw new Exception("Gagal Menyimpan engan error: $arrayInfo");
                //return false;
            }
        }
        
        $transaction->commit();
        return true;
    }
}
