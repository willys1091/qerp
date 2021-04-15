<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\ControllerUAC;
use app\components\MdlDb;
use app\components\ReportEngine;
use app\models\MsCoa;
use app\models\MsCurrency;
use app\models\MsSetting;
use kartik\widgets\ActiveForm;
use PHPExcel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * CoaController implements the CRUD actions for MsCoa model.
 */
class CoaController extends MainController
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
     * Lists all MsCoa models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$acc = explode('-', ControllerUAC::masterAction(Yii::$app->user->identity->userRoleID, Yii::$app->controller->id));
        $dataProvider = new ActiveDataProvider([
            'query' => MsCoa::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            //'create' => $acc[0],
            //'template' => $acc[1]
        ]);
    }

    /**
     * Displays a single MsCoa model.
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
        $model = new MsCoa();
        $model->load(Yii::$app->request->queryParams);
    
        $this->layout = 'browseLayout';
        return $this->render('browse', [
                'model' => $model
        ]);
    }
    public function actionCheckcurrency()
    {
        $result = [];
        $currencyRate = 0;
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $coaArray = $data['coaNo'];
            $coaNo = explode(" ",$coaArray);
            $coaModel = MsCoa::findOne(['coaNo' => $coaNo[0]]);
            
            if ($coaModel !== null){
                $currencyID = $coaModel->currencyID;
                $result['currencyID'] = $currencyID;
                $currencyModel = MsCurrency::findOne($currencyID);
                if ($coaModel !== null){
                    $result['currencyRate'] = $currencyModel->rate;
                }
            }
        }

        return Json::encode($result);
    }
    
    
    public function actionGetcurrencyid()
    {
        $currencyId = '';
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $coaArray = $data['coaNo'];
            $coaNo = explode(" ",$coaArray)[0];
            $coaModel = MsCoa::findOne(['coaNo' => $coaNo]);
            
            if ($coaModel !== null){
                $currencyId = $coaModel->currencyID;
            }
        }

        return Json::encode($currencyId);
    }

    /**
     * Creates a new MsCoa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $ordinal)
    {
        $model = new MsCoa();
        $model->coaNo = $id;
        $model->ordinal = $ordinal;
        
        $model->flagActive = 1;
        $model->coaLevel = 4;
        $model->createdBy = Yii::$app->user->identity->username;
        $model->createdDate = new Expression('NOW()');
        $model->editedBy = Yii::$app->user->identity->username;
        $model->editedDate = new Expression('NOW()');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        } 
    }
    public function actionSave($id, $ordinal)
    {
        $model = new MsCoa();
        $model->coaNo = $id;
        $model->ordinal = $ordinal;
        $model->flagActive = 1;
        $model->coaLevel = 4;
        $model->createdBy = Yii::$app->user->identity->username;
        $model->createdDate = new Expression('NOW()');
        $model->editedBy = Yii::$app->user->identity->username;
        $model->editedDate = new Expression('NOW()');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['iindex']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsCoa model.
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
            $model->flagActive = 1;
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                        'model' => $model,
            ]);
        }
    }
    
    public function actionGetall($id)
    {
        $coaIni = explode('.', $id)[0];
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $result = MsCoa::find()
                ->select(['ms_coa.description AS name'])
                ->where("coaNo LIKE '".$coaIni."%'")
                ->asArray()
                ->all();
        
        return $result;
    }
    
    /**
     * Deletes an existing MsCoa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $connection = MdlDb::getDbConnection();
        $sql = "SELECT coaNo
        FROM ms_coa
        where coaNo = '" . $model->coaNo . "' ";
        $temp = $connection->createCommand($sql);
        $headResult = $temp->queryAll();
    
        $model->flagActive = 0;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the MsCoa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsCoa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsCoa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
//    public function actionPrint()
//    {   
//        $filter = $model->coaNo;
//       
//        $query1 = MsCoa::find()
//            ->select(['coaNo', 'coaLevel', 'description'])
//            ->orderBy(['coaNo' => SORT_DESC])->all();
//        $headers = [
//
//            "coaNo" => [
//                "label" => Yii::t("app", "Coa Number"),
//                "type" => "string",
//            ],
//            "coaLevel" => [
//                "label" => Yii::t("app", "Coa Level"),
//                "type" => "string",
//            ],
//            "description" => [
//                "label" => Yii::t("app", "Description"),
//                "type" => "string",
//            ],
//            
//
//        ];
//
//            ReportEngine::downloadReport($filter, $query1, $headers, "Stock Card Sample");
//            return null;
//    }
    
      public function actionPrint(){
                $this->layout = false;
                $connection = MdlDb::getDbConnection();

                $companyAddress = MsSetting::findOne(['key1' => 'OfficeAddress']);
                $companyCity = MsSetting::findOne(['key1' => 'City']);
                $izinPBF = MsSetting::findOne(['key1' => 'IjinPedagangFarmasi']);
                $izinSIKA = MsSetting::findOne(['key1' => 'PharmacistNumber']);
                
                  
                  
                $sql = "select coaNo, coaLevel, description
                        from ms_coa 
                        order by coaNo";

                $command = $connection->createCommand($sql);
                $model = $command->queryAll();
                
               
                $objPHPExcel = new PHPExcel();
                $sheet=0;
                $objPHPExcel->setActiveSheetIndex($sheet);        

                $objPHPExcel->getActiveSheet()->setTitle('xxx')
               
                    ->setCellValue('B2', 'Coa Level')
                    ->setCellValue('C2', 'Coa Number')
                    ->setCellValue('D2', 'Description');

                

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );


                $styleRight = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

                $styleLeft = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

                $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($style)->getFont()->setBold(true);
                //$objPHPExcel->getActiveSheet()->getStyle('A2:V2')->applyFromArray($style)->getFont()->setBold(true);


                $row=3;
                foreach ($model as $model) {  
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("20");

                    $objPHPExcel->getActiveSheet()->getStyle('A3:V'.$row)->getAlignment()->setWrapText(true); 
               
                     $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $model['coaLevel']);
                    //IN
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $model['coaNo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $model['description']);
                    $row++;
                }
                
                    header('Content-Type: application/vnd.ms-excel');
        
                    $filename = "Coa Export.xlsx";
                    header('Content-Disposition: attachment;filename='.$filename .' ');
                    header('Cache-Control: max-age=0');
                    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    ob_end_clean();
                    $objWriter->save('php://output');        
                    die();     
            }
        
}
