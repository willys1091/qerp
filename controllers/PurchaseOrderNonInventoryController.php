<?php
namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSetting;
use app\models\TrJournalhead;
use app\models\TrPurchaseordernoninventorydetail;
use app\models\TrPurchaseordernoninventoryhead;
use app\models\TrSupplierpayabledetail;
use app\models\TrSupplierpayablehead;
use mPDF;
use yii\helpers\Json;
use Yii;
use yii\db\Exception;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * PurchaseOrderNonInventoryController implements the CRUD actions for TrPurchaseordernoninventoryhead model.
 */
class PurchaseOrderNonInventoryController extends MainController
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
     * Lists all TrPurchaseordernoninventoryhead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrPurchaseordernoninventoryhead();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->purchaseOrderNonInventoryDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrPurchaseordernoninventoryhead model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TrPurchaseordernoninventoryhead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrPurchaseordernoninventoryhead();
        $model->purchaseOrderNonInventoryDate = date('d-m-Y');
        $model->joinPurchaseOrderDetail = [];
        $model->rate = "1,00";
        $model->grandTotal = "0,00";
        $model->amount = "0,00";

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
// 				  $journalRefNum = $model->purchaseOrderNonInventoryNum;
//                $connection = MdlDb::getDbConnection();
//                $command = $connection->createCommand('call sp_insert_journal(:refNum, :mode)');
//                $mode = 13; //purchase order non inventory
//
//                $command->bindParam(':refNum', $journalRefNum);
//                $command->bindParam(':mode', $mode);
//                $command->execute();
//
//                //input to payable
//                $connection = MdlDb::getDbConnection();
//                $command = $connection->createCommand('call sp_insert_payablereceivable(:refNum, :mode)');
//                $mode = 5; //po non inventory
//
//                $command->bindParam(':refNum', $journalRefNum);
//                $command->bindParam(':mode', $mode);
//                $command->execute();
                $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }
    /**
     * Updates an existing TrPurchaseordernoninventoryhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing TrPurchaseordernoninventoryhead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        TrPurchaseordernoninventorydetail::deleteAll('purchaseOrderNonInventoryNum = :refNum', [":refNum" => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    protected function saveModel($model, $newTrans)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $model->grandTotal = str_replace(",",".",str_replace(".","",$model->grandTotal));
        $modelMonth = date("m",strtotime($model->purchaseOrderNonInventoryDate)) - 1;

        
        if ($newTrans){
            $tempModel = TrPurchaseordernoninventoryhead::find()
            ->where('YEAR(purchaseOrderNonInventoryDate) LIKE :purchaseOrderNonInventoryDate',[
                    ':purchaseOrderNonInventoryDate' => date("Y",strtotime($model->purchaseOrderNonInventoryDate))
            ])
            ->orderBy(new Expression('substring(purchaseOrderNonInventoryNum, -3,3) DESC'))
            ->one();
            
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/PONI/".substr(date("Y",strtotime($model->purchaseOrderNonInventoryDate)), -2)."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->purchaseOrderNonInventoryNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/PONI/".substr(date("Y",strtotime($model->purchaseOrderNonInventoryDate)), -2)."/".$month[$modelMonth]."/".$temp;
            }
            
            $model->purchaseOrderNonInventoryNum = $tempTransNum;
        }
        $model->purchaseOrderNonInventoryDate = AppHelper::convertDateTimeFormat($model->purchaseOrderNonInventoryDate, 'd-m-Y', 'Y-m-d');
        $journalRefNum = $model->purchaseOrderNonInventoryNum;
        $model->rate = str_replace(",",".",str_replace(".","",$model->rate));
       
        if (!$model->save()) {
             print_r($model->getErrors());
             $arrayInfo = Json::encode($model->getErrors());
                throw new Exception("Gagal Menyimpan engan error: $arrayInfo");
            $transaction->rollBack();
            return false;
        }

        TrPurchaseordernoninventorydetail::deleteAll('purchaseOrderNonInventoryNum = :refNum', [":refNum" => $model->purchaseOrderNonInventoryNum]);
        
        if (empty($model->joinPurchaseOrderDetail) || !is_array($model->joinPurchaseOrderDetail) || count($model->joinPurchaseOrderDetail) < 1) {
            $transaction->rollBack();
            return false;
        }


        foreach ($model->joinPurchaseOrderDetail as $purchaseDetail) {
            $purchaseDetailModel = new TrPurchaseordernoninventorydetail();
            $purchaseDetailModel->purchaseOrderNonInventoryNum = $model->purchaseOrderNonInventoryNum;
            $purchaseDetailModel->productID = $purchaseDetail['productID'];
            $purchaseDetailModel->uomID = $purchaseDetail['uomID'];
            $purchaseDetailModel->qty = str_replace(",",".",str_replace(".","",$purchaseDetail['qty']));
            $purchaseDetailModel->price = str_replace(",",".",str_replace(".","",$purchaseDetail['price']));
            $purchaseDetailModel->discount = str_replace(",",".",str_replace(".","",$purchaseDetail['discount']));
            $purchaseDetailModel->subtotal = str_replace(",",".",str_replace(".","",$purchaseDetail['subtotal']));


            if (!$purchaseDetailModel->save()) {
                print_r($purchaseDetailModel->getErrors());
                $transaction->rollBack();
                return false;
            }
        }
        $transaction->commit();
        return true;
    }

    public function actionDeleteReference($id)
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

        TrJournalhead::delete('refNum = :refNum', [":refNum" => $id]);
    
        $modelPayable = TrSupplierpayabledetail::findOne(['refNum' => $model->$id]);
        $payableNum = $modelPayable->payableNum;
        TrSupplierpayabledetail::delete('refNum = :refNum', [":refNum" => $model->$id]);
        TrSupplierpayablehead::delete('payableNum = :payableNum', [":payableNum" => $payableNum]);

    }

    /**
     * Finds the TrPurchaseordernoninventoryhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrPurchaseordernoninventoryhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrPurchaseordernoninventoryhead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPrint($id){
        $this->layout = false;
        $connection =  MdlDb::getDbConnection();
        $sql = "SELECT *
                FROM `tr_purchaseordernoninventoryhead` 
                LEFT JOIN `tr_purchaseordernoninventorydetail` ON `tr_purchaseordernoninventoryhead`.`purchaseOrderNonInventoryNum` = `tr_purchaseordernoninventorydetail`.`purchaseOrderNonInventoryNum` 
                LEFT JOIN `ms_supplier` ON `tr_purchaseordernoninventoryhead`.`supplierID` = `ms_supplier`.`supplierID` 
                LEFT JOIN `ms_suppliercontactdetail` ON `ms_supplier`.`supplierID` = `ms_suppliercontactdetail`.`supplierID` 
                LEFT JOIN `ms_uom` ON `tr_purchaseordernoninventorydetail`.`uomID` = `ms_uom`.`uomID`
                LEFT JOIN `ms_product` ON `tr_purchaseordernoninventorydetail`.`productID` = `ms_product`.`productID` 
                WHERE `tr_purchaseordernoninventoryhead`.`purchaseOrderNonInventoryNum`='$id'";
        $model = $connection->createCommand($sql)->queryAll();
      
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
        
        $content = $this->render('report_view_poni',[
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
}
