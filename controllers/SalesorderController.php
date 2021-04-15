<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\MsSetting;
use app\models\TrSalesorderhead;
use app\models\TrSalesorderdetail;
use app\models\TrSalesquotationhead;
use app\models\TrSalesquotationdetail;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\Response;
use app\components\MdlDb;
use app\components\AppHelper;
use mPDF;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * SalesorderController implements the CRUD actions for TrSalesorderhead model.
 */
class SalesOrderController extends MainController
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
     * Lists all TrSalesorderhead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrSalesorderhead();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->salesOrderDate = "$model->startDate to $model->endDate";
        //$model->salesOrderDate = $model->startDate.' - '.$model->endDate;
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }
    public function actionPrint($id){
        $this->layout = false;
        $connection =  MdlDb::getDbConnection();
        $sql = 'SELECT DATE_FORMAT(a.salesOrderDate,"%d %M %Y") as salesOrderDate, c.customerName, c.email, a.contactPerson, d.productName, b.qty, e.uomName, b.price, b.subTotal '
               .', d.origin, g.packingTypeName, a.additionalInfo '
               .'FROM tr_salesorderhead a '
               .'INNER JOIN tr_salesorderdetail b ON b.salesOrderNum = a.salesOrderNum '
               .'INNER JOIN ms_customer c ON c.customerID = a.customerID '
               .'INNER JOIN ms_product d ON d.productID = b.productID '
               .'INNER JOIN ms_uom e ON e.uomID = b.uomID '
               .'INNER JOIN ms_productdetail f ON f.productID = d.productID '
               .'INNER JOIN ms_packingtype g ON g.packingTypeID = f.packingTypeID '
               .'WHERE a.salesOrderNum = "'.$id.'"';
        $model = $connection->createCommand($sql)->queryAll();
        $companyAttnEmail = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyAttnEmail"')->queryOne();
        $companyDirector = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyDirector"')->queryOne();
        $fax = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Fax"')->queryOne();
        $phone1 = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "Phone1"')->queryOne();
        $content = $this->render('report_view_sales_order',[
            'model' => $model,
            'director' => $companyDirector,
            'email' => $companyAttnEmail,
            'fax' => $fax,
            'phone' => $phone1,
        ]);
        
        $imageCompany = Html::img('assets_b/images/office_building.png',['height' => '12px', 'width' => '12px']);
        $imagePhone = Html::img('assets_b/images/canva-call-icon-MACQYneSATM.png',['height' => '12px', 'width' => '12px']);
        $imageFax = Html::img('assets_b/images/fax_machine.png',['height' => '12px', 'width' => '12px']); 
        
        $address = strtok(MsSetting::findOne(['key1' => 'OfficeAddress'])->value1, "\n");
        $footer =   '<div style="text-align: center; font-size: 14px">'.$imageCompany." $address, Jakarta 11520, Indonesia<br>" 
                    .$imagePhone.' + 62 21 580 2720, 583 57791, 583 06107 &nbsp;&nbsp;&nbsp;'.$imageFax.' +62 21 583 550 60 </div>';
        
        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->Output('report.pdf','I');
    }

    /**
     * Displays a single TrSalesorderhead model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionBrowse()
    {
        $this->view->params['browse'] = true;
        $model = new TrSalesorderhead();
        $model->load(Yii::$app->request->queryParams);
    
        $dataProvider = new ActiveDataProvider([
                            'query' => TrSalesorderhead::find()
                                        ->andFilterWhere(['like', 'salesOrderNum', $model->salesOrderNum])
                                        ->andFilterWhere(['=', 'customerID', $model->customerID])
                                        ->andFilterWhere(['like', 'grandTotal', $model->grandTotal])
                                        ->andFilterWhere(['=', "DATE_FORMAT(salesOrderDate, '%d-%m-%Y')", $model->salesOrderDate]),
                            'sort' => [
                                        'defaultOrder' => ['salesOrderNum' => SORT_ASC],
                                        'attributes' => ['salesOrderNum']
                                    ],
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browse', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionBrowseFromPurchase()
    {
        $this->view->params['browse'] = true;
        $model = new TrSalesorderhead();
        $model->load(Yii::$app->request->queryParams);
    
        $dataProvider = new ActiveDataProvider([
                            'query' => TrSalesorderhead::find()
                                        ->joinWith('purchaseOrder')
                                        ->joinWith('customer')
                                        ->select(['salesOrderDate','salesOrderNum', 'ms_customer.customerID', 'tr_salesorderhead.grandTotal'])
                                        ->andFilterWhere(['like', 'salesOrderNum', $model->salesOrderNum])
                                        ->andFilterWhere(['like', 'ms_customer.customerName', $model->customerName])
                                        ->andFilterWhere(['like', 'grandTotal', $model->grandTotal])
                                        ->andFilterWhere(['=', "DATE_FORMAT(salesOrderDate, '%d-%m-%Y')", $model->salesOrderDate])
                                        ->andWhere('tr_purchaseorderhead.refNum IS NULL'),
                            'sort' => [
                                        'defaultOrder' => ['salesOrderNum' => SORT_DESC],
                                        'attributes' => [
                                            'salesOrderDate',
                                            'salesOrderNum',
                                            'customerName' => [
                                                'ASC' => ['ms_customer.customerName' => SORT_ASC],
                                                'DESC' => ['ms_customer.customerName' => SORT_DESC]
                                            ],
                                            'grandTotal'
                                        ]
                                    ],
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browse_from_purchase', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionBrowseEmptyPayment()
    {
        $this->view->params['browse'] = true;
        $model = new TrSalesorderhead();
        $model->load(Yii::$app->request->queryParams);
    
        $dataProvider = new ActiveDataProvider([
                            'query' => TrSalesorderhead::find()
                                        ->joinWith('customer')
                                        ->joinWith('goodsDelivery')
                                        ->joinWith('advancedPayment')
                                        ->where('tr_customeradvancepayment.refNum is null')
                                        ->AndWhere('tr_goodsdeliveryhead.refNum is null')
                                        ->andFilterWhere(['like', 'salesOrderNum', $model->salesOrderNum])
                                        ->andFilterWhere(['like', 'refNum', $model->refNum])
                                        ->andFilterWhere(['like', 'ms_customer.customerName', $model->customerName])
                                        ->andFilterWhere(['like', 'grandTotal', $model->grandTotal])
                                        ->andFilterWhere(['=', "DATE_FORMAT(salesOrderDate, '%d-%m-%Y')", $model->salesOrderDate]),
                            'sort' => [
                                'defaultOrder' => ['salesOrderDate' => SORT_DESC],
                                'attributes' => [
                                    'salesOrderDate', 
                                    'salesOrderNum',
                                    'customerName' => [
                                        'ASC' => ['ms_customer.customerName' => SORT_ASC],
                                        'DESC' => ['ms_customer.customerName' => SORT_DESC]
                                    ],
                                    'grandTotal'
                                ]
                            ],
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browse', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionCheck()
    {
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];

            $modelDetail = TrSalesquotationdetail::find()
                ->where('salesQuotationNum = :refNum',[
                        ':refNum' => $refNum
                ])->all();
            $modelHead = TrSalesquotationhead::find()
                ->where('salesQuotationNum = :refNum',[
                        ':refNum' => $refNum
                ])->one();
            
       
        
            $result = [];
            foreach ($modelDetail as $joinSalesOrderDetail) {
                $index = 0;
                $orderDetail = AppHelper::findArrayByKey($result, 'productID', $joinSalesOrderDetail->productID, $index);
                if ($orderDetail)
                {
                    if ($joinSalesOrderDetail->priceOffer < $orderDetail['price'])
                    {
                        if($modelHead->currencyID == 'IDR' || $modelHead->currencyID == NULL){
                            $result[$index]['price'] = $joinSalesOrderDetail->priceOffer;
                        } else {
                            $result[$index]['price'] = 0.00;
                        }
                        
                        
                        $result[$index]['discount'] = $joinSalesOrderDetail->discount;
                    }
                } else
                {
                    if ($modelHead->currencyID == 'IDR' || $modelHead->currencyID == NULL) {
                        $prices = $joinSalesOrderDetail->priceOffer;
                    } else {
                        $prices = 0.00;
                    }
                    $newObj = [
                        'productID' => $joinSalesOrderDetail->productID,
                        'productName' => $joinSalesOrderDetail->product->productName,
                        'uomID' => $joinSalesOrderDetail->uomID,
                        'uomName' => $joinSalesOrderDetail->uom->uomName,
                        'qty' => 0,
                        'price' => $prices,
                        'discount' => $joinSalesOrderDetail->discount,
                        'taxValue' => $joinSalesOrderDetail->tax,
                        'tax' => $joinSalesOrderDetail->tax > 0 ? 'checked' : '',
                        'priceOffer' => 0
                    ];
                    
                    array_push($result, $newObj);
                }
            }
            
            
            Yii::$app->response->format = 'json';
            return $result;
        }
    }
    
    public function actionGetproductbyqty ($id, $productID, $qty)
    {
        $connection = MdlDb::getDbConnection();
        $query = "SELECT * FROM tr_salesquotationdetail
        WHERE salesQuotationNum = '$id' AND productID = $productID AND qty <= $qty
        ORDER BY qty DESC LIMIT 1;";
        
        
        $model = $connection->createCommand($query)->queryOne();
        
        if (!$model)
        {
            $query = "SELECT * FROM tr_salesquotationdetail
            WHERE salesQuotationNum = '$id' AND productID = $productID AND qty >= $qty
            ORDER BY qty ASC LIMIT 1;";
            
            $model = $connection->createCommand($query)->queryOne();
        }
        
        Yii::$app->response->format = 'json';
        return $model;
    }
    
    public function actionCheckdelivery()
    {
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];
            
            $modelDetail = TrSalesquotationdetail::find()
                            ->where('salesQuotationNum = :refNum',[
                                    ':refNum' => $refNum
                            ])
                            ->all();
            
            $i = 0;
            foreach ($modelDetail as $joinSalesOrderDetail) {
                $result[$i]["productID"] = $joinSalesOrderDetail->productID;
                $result[$i]["productName"] = $joinSalesOrderDetail->product->productName;
                $result[$i]["uomID"] = $joinSalesOrderDetail->uomID;
                $result[$i]["uomName"] = $joinSalesOrderDetail->uom->uomName;
                $result[$i]["qty"] = $joinSalesOrderDetail->qty;
                $result[$i]["discount"] = "0,00";
                $result[$i]["price"] = $joinSalesOrderDetail->priceOffer;
                $result[$i]["taxValue"] = $joinSalesOrderDetail->tax;
                $result[$i]["tax"] = ($joinSalesOrderDetail->tax > 0 ? "checked" : "");
                $result[$i]["priceOffer"] = $joinSalesOrderDetail->subTotal;

                $i += 1;
            } 
            return \yii\helpers\Json::encode($result);
        }
    }
    public function actionChecksample()
    {
        $salesDetail = [];
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];
            $modelDetail = TrSalesorderdetail::find()
                            ->where('salesOrderNum = :refNum',[
                                    ':refNum' => $refNum
                            ])
                            ->all();
          

            $i = 0;
            
            foreach ($modelDetail as $salesDetail) {
                $result[$i]["productID"] = $salesDetail->productID;
                $result[$i]["productName"] = $salesDetail->product->productName;
                $result[$i]["uomID"] = $salesDetail->uomID;
                $result[$i]["uomName"] = $salesDetail->uom->uomName;
                $result[$i]["batchNumberID"] = ""; 
                $result[$i]["batchNumber"] = ""; 
                $result[$i]["outstandingQty"] = "0,00";
                $result[$i]["qty"] = "0,00";
                $result[$i]["manufactureDate"] = ""; 
                $result[$i]["expiredDate"] = "";
                $result[$i]["retestDate"] = "";
                $result[$i]["notes"] = "";
                $i += 1;
            } 
            
            return \yii\helpers\Json::encode($result);
        }
    }
    /**
     * Creates a new TrSalesorderhead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrSalesorderhead();
        $model->joinSalesOrderDetail = [];
        $model->salesOrderDate = date('d-m-Y');
        $model->dueDate = date('d-m-Y');
        $model->grandTotal = "0,00";

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->createdDate = new Expression('NOW()');
            $model->editedDate = new Expression('NOW()');
            $model->createdBy = Yii::$app->user->identity->username;
            $model->editedBy = Yii::$app->user->identity->username;
            $model->paymentID = 2;
            $model->taxID = 2;
            ($model->tax == 'false') ? $model->taxRate = "0,00" : $model->taxRate = "10,00";
            $model->taxRate = str_replace(",",".",str_replace(".","",$model->taxRate));
           
            if($this->saveModel($model, true)){
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing TrSalesorderhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
                'model' => $model
        ]);
    }

    /**
     * Deletes an existing TrSalesorderhead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        TrSalesorderDetail::deleteAll('salesOrderNum = :salesOrderNum', [':salesOrderNum' => $id]);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the TrSalesorderhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrSalesorderhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrSalesorderhead::findOne($id)) !== null) {
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
        $modelMonth = date("m",strtotime($model->salesOrderDate)) - 1;

        if ($newTrans){
            $tempModel = TrSalesorderhead::find()
            ->where("SUBSTRING_INDEX(SUBSTRING_INDEX(salesOrderNum, '/', 3), '/', -1) LIKE :y",[
                    ':y' => date("y",strtotime($model->salesOrderDate))
            ])
            ->orderBy([new Expression("CAST(SUBSTRING(salesOrderNum, '-3', '3') AS UNSIGNED) DESC")])
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/SO/".substr(date("Y",strtotime($model->salesOrderDate)), -2)."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->salesOrderNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/SO/".substr(date("Y",strtotime($model->salesOrderDate)), -2)."/".$month[$modelMonth]."/".$temp;
            }
            
            $model->salesOrderNum = $tempTransNum;
        }
        
        $model->dueDate = AppHelper::convertDateTimeFormat($model->dueDate, 'd-m-Y', 'Y-m-d H:i:s');
        $model->salesOrderDate = AppHelper::convertDateTimeFormat($model->salesOrderDate, 'd-m-Y', 'Y-m-d H:i:s');
        $model->grandTotal = str_replace(",",".",str_replace(".","",$model->grandTotal));
        
        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }
        
        TrSalesorderdetail::deleteAll('salesOrderNum = :salesOrderNum', [":salesOrderNum" => $model->salesOrderNum]);

        if (empty($model->joinSalesOrderDetail) || !is_array($model->joinSalesOrderDetail) || count($model->joinSalesOrderDetail) < 1) {
            $transaction->rollBack();
            return false;
        }
        ($model->tax == 'false') ? $rate = "0.00" : $rate = "10.00";
            
        foreach ($model->joinSalesOrderDetail as $salesDetail) {
            $salesDetailModel = new TrSalesorderdetail();
            $salesDetailModel->salesOrderNum = $model->salesOrderNum;
            $salesDetailModel->productID = $salesDetail['productID'];
            $salesDetailModel->uomID = $salesDetail['uomID'];
            $salesDetailModel->qty = str_replace(",",".",str_replace(".","",$salesDetail['qty']));
            $salesDetailModel->price = str_replace(",",".",str_replace(".","",$salesDetail['price']));
            $salesDetailModel->discount = str_replace(",",".",str_replace(".","",$salesDetail['discount']));
            $salesDetailModel->tax = $rate;
            $salesDetailModel->subTotal = str_replace(",",".",str_replace(".","",$salesDetail['priceOffer']));
            $salesDetailModel->notes = "";

            if (!$salesDetailModel->save()) {
                $transaction->rollBack();
                return false;
            }
        }
        
        
        $transaction->commit();
            
        return true;
    }
}
