<?php

namespace app\controllers;

use app\components\MdlDb;
use app\models\SampleDeliveryForm;
use app\models\SampleDeliveryHead;
use app\models\TrSampledeliveryhead;
use kartik\form\ActiveForm;
use mPDF;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * SampleDeliveryController implements the CRUD actions for SampleDeliveryHead model.
 */

class SampleDeliveryController extends MainController {
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $model = new SampleDeliveryHead();
        $model->dateSearchStart = date('1-m-Y');
        $model->dateSearchEnd = date('d-m-Y');
        $model->sampleDeliveryDate = "$model->dateSearchStart to $model->dateSearchEnd";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
                'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new SampleDeliveryForm();
        $model->sampleDeliveryDate = date('Y-m-d');

        Yii::info('asd');
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveModel($model)) {
                Yii::$app->session->setFlash('success', $model->sampleDeliveryNum.' created successfully');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', "Failed to create sample delivery");
            }
        }

        return $this->render('create', [
                'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id, 1);
        
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveModel()) {
                Yii::$app->session->setFlash('success', $model->sampleDeliveryNum.' updated successfully');
                return $this->redirect(['index']);
            } else {                
                Yii::$app->session->setFlash('error', "Failed to update sample delivery");
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', $model->sampleDeliveryNum .' deleted successfully');
        } else {
            Yii::$app->session->setFlash('error', "Failed to delete sample delivery");
        }

        return $this->redirect(['index']);
    }
    
    protected function findModel($id, $isForm = 0) {
        if (($model = $isForm == 1 ? SampleDeliveryForm::findOne($id) : SampleDeliveryHead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPrint($id)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT a.sampleDeliveryDate, a.sampleDeliveryNum, b.customerID, b.customerName, 
                b.npwpAddress, g.uomName, a.notes, 
                f.productName, f.origin, c.batchNumber, c.qty
                FROM tr_sampledeliveryhead a 
                INNER JOIN ms_customer b ON b.customerID = a.customerID
                INNER JOIN tr_sampledeliverydetail c ON c.sampleDeliveryNum = a.sampleDeliveryNum    
                INNER JOIN ms_product f ON f.productID = c.productID
                INNER JOIN ms_uom g ON g.uomID = c.uomID 
                WHERE a.sampleDeliveryNum = "'.$id.'"';
        $command = $connection->createCommand($sql);        
        $model = $command->queryAll();
        
        $city = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "City"')->queryOne();
        $companyAttn = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyAttn"')->queryOne();
        $companyAttnEmail = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyAttnEmail"')->queryOne();
        $companyDirector = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyDirector"')->queryOne();
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

        $headModel = TrSampledeliveryhead::findOne(['sampleDeliveryNum' => $id]);
        
        $view = 'report_sample_delivery';
        $content = $this->renderPartial($view, [
            'headModel' => $headModel,
            'model' => $model,
            'city' => $city,
            'companyAttn' => $companyAttn,
            'companyAttnEmail' => $companyAttnEmail,
            'companyDirector' => $companyDirector,
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
        ]); 
         
        $phoneArea = split(' ', $phone1['value1'])[0];
        $p1 = split(' ', $phone2['value1'])[0];
        $p2 = split(' ', $phone3['value1'])[0];
        $p3 = split(' ', $phone4['value1'])[0];
       
        $faxNum = $fax['value1'];
        
        
        $imageCompany = Html::img('assets_b/images/office_building.png',['height' => '12px', 'width' => '12px']) . ' '; 
        $footer =   '<div style="text-align: center; font-size: 14px; ">'.$imageCompany . $officeAddress['value1'].
                    ', <br>'.$province['value1'].' '.$postalCode['value1'].', '.$country['value1'].'<br>' 
                    ."Phone : +62 21 $phoneArea, $p1, $p2, $p3, &nbsp;&nbsp; Fax : $faxNum </div>";
        
        
        $mpdf = new mPDF('',    // mode - default ''
                        'A4',    // format - A4, default ''
                        0,     // font size - default 0
                        '',    // default font family
                        '20',    // margin_left
                        '20',    // margin right
                        '15',     // margin top
                        '5',    // margin bottom
                        '0',     // margin header
                        '5',     // margin footer
                        'P'     // P = portrait, L = landscape
                );
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($content);
        $mpdf ->Output('report.pdf','I');
        exit;
    }

}