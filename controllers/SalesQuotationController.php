<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSetting;
use app\models\MsUser;
use app\models\TrSalesquotationdetail;
use app\models\TrSalesquotationhead;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * SalesquotationController implements the CRUD actions for TrSalesquotationhead model.
 */
class SalesQuotationController extends MainController
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

    public function actionIndex()
    {
        $model = new TrSalesquotationhead();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->salesQuotationDate = "$model->startDate to $model->endDate";
        
        $model->load(Yii::$app->request->queryParams);

		return $this->render(Yii::$app->user->identity->userRole != 'DIRECTOR' ? 'index' : 'index_', [
            'model' => $model,
        ]);
    }

    public function actionPrint($id){
        $this->layout = false;
        $connection =  MdlDb::getDbConnection();
        $sql = 'SELECT DATE_FORMAT(a.salesQuotationDate,"%d %M %Y") as salesQuotationDate, a.customerID, a.delivery, a.payment, c.customerName, c.email, a.contactPerson, d.productName, b.qty, e.uomName, f.uomQty, b.priceOffer '
               .', d.origin, g.packingTypeName, a.currencyID, a.additionalInfo, a.createdBy, a.cc, a.attachment, b.subTotal '
               .'FROM tr_salesquotationhead a '
               .'INNER JOIN tr_salesquotationdetail b ON b.salesQuotationNum = a.salesQuotationNum '
               .'INNER JOIN ms_customer c ON c.customerID = a.customerID '
               .'INNER JOIN ms_product d ON d.productID = b.productID '
               .'INNER JOIN ms_uom e ON e.uomID = b.uomID '
               .'INNER JOIN ms_productdetail f ON f.productID = d.productID '
               .'INNER JOIN ms_packingtype g ON g.packingTypeID = f.packingTypeID '
               .'WHERE a.salesQuotationNum = "'.$id.'"';
        $model = $connection->createCommand($sql)->queryAll();
        
        foreach ($model as $row) {
           $created =  $row['createdBy'];
        }
        
        $details = MsUser::findOne(['username' => $created]);
        $director = MsUser::findOne(['userRole' => 'DIRECTOR']);
        $createdBy = $details->fullName;
        
        
        $companyAttnEmail = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyAttnEmail"')->queryOne();
        $companyDirector = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyDirector"')->queryOne();
        
        $location= Html::img('assets_b/images/location.png',['height' => '15px', 'width' => '15px']);
        $imagePhone = Html::img('assets_b/images/phone.png',['height' => '15px', 'width' => '15px']);
        $imageFax = Html::img('assets_b/images/fax.png',['height' => '15px', 'width' => '15px']); 
        $phone1 = MsSetting::findOne(['key1' => 'Phone1']);
        $phone2 = MsSetting::findOne(['key1' => 'Phone2']);
        $phone3 = MsSetting::findOne(['key1' => 'Phone3']);
        $phone4 = MsSetting::findOne(['key1' => 'Phone4']);
        $directorPhone = MsSetting::findOne(['key1' => 'CellPhone']);
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
        
       
        
      
        
        $content = $this->render('report_view_sales_quotation',[
            'model' => $model,
            'details'=>$details,
            'director' =>$director,
            'footer' => $footer,
            'created' => $createdBy,
            'location' => $location,
            'city' => $city,
            'province' => $province,
            'companyAttnEmail' => $companyAttnEmail,
            'companyDirector' => $companyDirector,
            'countrys' => $country,
            'fax' => $fax,
            'streets' => $streets,
            'kec' => $kec,
            'kel' => $kel,
            'address' => $address,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'phone3' => $phone3,
            'phone4' => $phone4,
            'company' => $company,
            'NPWP' => $NPWP,
            'postalCode' => $postalCode,
            'imageFax' => $imageFax,
            'imagePhone' => $imagePhone,
            'directorPhone' =>$directorPhone,
            'id' => $id
        ]);
        $mpdf = new mPDF('',    // mode - default ''
                        'A4',    // format - A4, default ''
                        0,     // font size - default 0
                        '',    // default font family
                        '5',    // margin_left
                        '5',    // margin right
                        '5',     // margin top
                        '5',    // margin bottom
                        '0',     // margin header
                        '5',     // margin footer
                        'P'     // P = portrait, L = landscape
                );
        
        $mpdf->WriteHTML($content);
        //$mpdf->SetHTMLFooter($footer);
        $mpdf->Output('report.pdf','I');
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionBrowse()
    {
        $this->view->params['browse'] = true;
        $model = new TrSalesquotationhead();
        $model->load(Yii::$app->request->queryParams);

        $this->layout = 'browseLayout';
        return $this->render('browse', [
                'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new TrSalesquotationhead();
        $model->joinSalesQuotationDetail = [];
        $model->salesQuotationDate = date('d-m-Y');
        $model->grandTotal = "0,00";
        $model->additionalInfo = " 1. The quotation is valid for Fourteen (14) days from the date of submission. <br>
                                   2. The above price is excluding Value Added Tax (10% of sales price)  ";
 
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->createdDate = new Expression('NOW()');
            $model->editedDate = new Expression('NOW()');
            $model->createdBy = Yii::$app->user->identity->username;
            $model->editedBy = Yii::$app->user->identity->username;
            var_dump($model->currencyID);
            //die();
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
     * Updates an existing TrSalesquotationhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contactCC = explode(',', $model->cc);
        //$contactCC = str_Replace(' ', '',$contactCC);
        $model->cc = $contactCC;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $POST = Yii::$app->request->post('TrSalesquotationhead');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            
            if ($this->saveModel($model, false)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model
        ]);
    }

    /**
     * Deletes an existing TrSalesquotationhead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        TrSalesquotationDetail::deleteAll('salesQuotationNum = :salesQuotationNum', [':salesQuotationNum' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrSalesquotationhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrSalesquotationhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrSalesquotationhead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function saveModel($model, $newTrans)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        //$month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $modelMonth = date("m",strtotime($model->salesQuotationDate));
      
        if ($newTrans){
            $tempModel = TrSalesquotationhead::find()
            ->where('YEAR(salesQuotationDate) LIKE :salesQuotationDate',[
                    ':salesQuotationDate' => date("Y",strtotime($model->salesQuotationDate))
		])->orderBy(new Expression('substring(salesQuotationNum, -3,3) DESC'))
            ->one();
			
            $tempTransNum = "";
            
          
            if (empty($tempModel)){
                $tempTransNum = "QJA".substr(date("Y",strtotime($model->salesQuotationDate)), -2)."001";
               
            }
            else{
                $temp = substr($tempModel->salesQuotationNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA".substr(date("Y",strtotime($model->salesQuotationDate)), -2)."".$temp;
                  
            }
           
            $model->salesQuotationNum = $tempTransNum;
        }
        
        $model->salesQuotationDate = AppHelper::convertDateTimeFormat($model->salesQuotationDate, 'd-m-Y', 'Y-m-d H:i:s');
        $model->grandTotal = str_replace(",",".",str_replace(".","",$model->grandTotal));
        //$model->currencyID;
        if($model->cc != ""){
            $contactPersonStr = implode(",", $model->cc);
            $model->cc = $contactPersonStr;
        }
       
        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }

        TrSalesquotationdetail::deleteAll('salesQuotationNum = :salesQuotationNum', [":salesQuotationNum" => $model->salesQuotationNum]);
        
        if (empty($model->joinSalesQuotationDetail) || !is_array($model->joinSalesQuotationDetail) || count($model->joinSalesQuotationDetail) < 1) {
            $transaction->rollBack();
            return false;
        }

        foreach ($model->joinSalesQuotationDetail as $salesDetail) {
            $salesDetailModel = new TrSalesquotationdetail();
            $salesDetailModel->salesQuotationNum = $model->salesQuotationNum;
            $salesDetailModel->productID = $salesDetail['productID'];
            $salesDetailModel->uomID = $salesDetail['uomID'];
            $salesDetailModel->qty = str_replace(",",".",str_replace(".","",$salesDetail['qty']));
            $salesDetailModel->priceOffer = str_replace(",",".",str_replace(".","",$salesDetail['price']));
            $salesDetailModel->discount = str_replace(",",".",str_replace(".","",$salesDetail['discount']));
            $salesDetailModel->tax = "10.00";
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


    public function actionGetContactPerson()
    {
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $id = $data['id'];

            $model = $this->findModel($id);

            $data = array();
            foreach ($detailModels as $detailModel) {
                $temp["id"] = $detailModel->contactPerson;
                $temp["text"] = $detailModel->contactPerson;
                array_push($data, $temp);
            }
        }

        return \yii\helpers\Json::encode($data);
    }

}
