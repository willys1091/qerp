<?php
namespace app\controllers;

use app\components\AppHelper;
use app\components\ExcelFormatter;
use app\components\MdlDb;
use app\models\SalesReport;
use app\models\SampleStockCard;
use app\models\SamplingReport;
use app\models\TrSampledeliverydetail;
use app\models\TrSampledeliveryhead;
use kartik\mpdf\Pdf;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * SalesReportController implements the CRUD actions for TrSamplereceipthead model.
 */
class SalesReportRecapController extends MainController
{
    private $dateFrom;
    private $dateTo;
    
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
        $model = new SalesReport();
        $model->load(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($model);
        }
        
        if (Yii::$app->request->post()) {
            $_report = Yii::$app->request->post('SalesReport');
            $yearsS = $_report['yearsS'];   
            $yearsE = $_report['yearsE']; 
            $customerID = $_report['customerID'];
            $productID = $_report['productID'];
            $supplierID = $_report['supplierID'];
            $typeReport= $_report['typeReport'];
           
         
            if(isset($_POST['btnPrint_PDF']))
            {
                $url = \yii\helpers\Url::to(['sales-report-recap/print-sales-recap', 'yearsS' => $yearsS, 'yearsE' => $yearsE,
                                'type' => $typeReport]);
                $redirectTo = \yii\helpers\Url::to(['sales-report-recap/']);
                $this->view->registerJS("newwindow=window.open('$url', 'name');if (window.focus) {newwindow.focus()}window.location.href = '$redirectTo';");
                
            } 
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
    
    public function actionPrintSalesRecap ($yearsS, $yearsE, $type)
    {
        $model = new SalesReport();
        $dataYear = \app\models\TrGoodsdeliveryhead::find()->select(['dates' => 'YEAR(goodsDeliveryDate)'])
            ->where('YEAR(goodsDeliveryDate)  between '.$yearsS.'  AND '.$yearsE.' ')
            ->groupBy('YEAR(goodsDeliveryDate)')
            ->asArray()->all();
        
        $alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');
        $phpExcel = new \PHPExcel();
        $sheet=0;
        $phpExcel->setActiveSheetIndex($sheet);
        $xSheet = $phpExcel->getActiveSheet();
        $xSheet->getColumnDimension('B')->setWidth(70);
        
        $xDrawing = new \PHPExcel_Worksheet_Drawing();
        $xDrawing->setName('Thumb');
        $xDrawing->setDescription('Thumbnail Image');
        $xDrawing->setPath(Yii::$app->basePath . '/assets_b/images/logonew.png');
        $xDrawing->setHeight(80);
        $xDrawing->setWidth(120);
        $xDrawing->setCoordinates('B1');
        $xDrawing->setOffsetX(195);
        $xDrawing->setWorksheet($phpExcel->getActiveSheet());
        
        if($type == 'Product'){
            $counts = 2;
            foreach ($dataYear as $rowss) {
                $xSheet->getColumnDimension($alpha[$counts])->setWidth(30); 
                $phpExcel->getActiveSheet()->setTitle('Sales Report')
                    ->setCellValue('B7', 'PT. Qwinjaya Aditama')
                    ->setCellValue('B8', 'Sales Report By Product ')
                    ->setCellValue('B11', 'Product')
                    ->setCellValue($alpha[$counts].'11', $rowss['dates']);
                $xSheet->getStyle($alpha[$counts].'11')->applyFromArray(ExcelFormatter::$tableHeader);
          
                $dataSales = $model->dataSalesRecap($yearsS,$yearsE, $type, $customerID, $productID, $supplierID);
               
                $rowx=12;
                foreach ($dataSales as $modelx)
                {
                    $dataModel = $model->printSalesRecap($rowss['dates'], $type, $modelx['customerID'], $modelx['productID'], $modelx['supplierID']);
                                
//                                echo "<pre>";
//                                  var_dump($result);
//                                echo "</pre>";
                    $xSheet->setCellValue('B'.$rowx, $modelx['name']); 
                    
                    foreach ($dataModel as $values) {
                        $xSheet->setCellValue($alpha[$counts].$rowx, number_format($values['total'],0,",","."));
                    }
                    $xSheet->getStyle('B'.$rowx)->applyFromArray(ExcelFormatter::$alignLeft);
                    $xSheet->getStyle($alpha[$counts].$rowx)->applyFromArray(ExcelFormatter::$alignRight);
                    $rowx++;
                } 
                $xSheet->getStyle('B12:'.$alpha[$counts].($rowx-1))->applyFromArray(ExcelFormatter::$outerBorder);
                $counts ++;
            }
        } elseif ($type == 'Customer'){
            $counts = 2;
            foreach ($dataYear as $rowss) {
                $xSheet->getColumnDimension($alpha[$counts])->setWidth(30); 
                $phpExcel->getActiveSheet()->setTitle('Sales Report')
                    ->setCellValue('B7', 'PT. Qwinjaya Aditama')
                    ->setCellValue('B8', 'Sales Report By Customer')
                    ->setCellValue('B11', 'Customer')
                    ->setCellValue($alpha[$counts].'11', $rowss['dates']);
                $xSheet->getStyle($alpha[$counts].'11')->applyFromArray(ExcelFormatter::$tableHeader);
                $dataSales = $model->dataSalesRecap($yearsS,$yearsE, $type, $customerID, $productID, $supplierID);
            
                $rowx=12;
                foreach ($dataSales as $modelx)
                {
                    $dataModel = $model->printSalesRecap($rowss['dates'], $type, $modelx['customerID'], $modelx['productID'], $modelx['supplierID']);
                    $xSheet->setCellValue('B'.$rowx, $modelx['name']); 
                    foreach ($dataModel as $values) {
                        $xSheet->setCellValue($alpha[$counts].$rowx, number_format($values['total'],0,",","."));
                    }
                    $xSheet->getStyle('B'.$rowx)->applyFromArray(ExcelFormatter::$alignLeft);
                    $xSheet->getStyle($alpha[$counts].$rowx)->applyFromArray(ExcelFormatter::$alignRight);
                    $rowx++;
                } 
                $xSheet->getStyle('B12:'.$alpha[$counts].($rowx-1))->applyFromArray(ExcelFormatter::$outerBorder);
                $counts ++;
            }
            
        } elseif ($type == 'Supplier'){
            $counts = 2;
            foreach ($dataYear as $rowss) {
                $xSheet->getColumnDimension($alpha[$counts])->setWidth(30); 
                $phpExcel->getActiveSheet()->setTitle('Sales Report')
                    ->setCellValue('B7', 'PT. Qwinjaya Aditama')
                    ->setCellValue('B8', 'Sales Report By Supplier')
                    ->setCellValue('B11', 'Supplier')
                    ->setCellValue($alpha[$counts].'11', $rowss['dates']);
                $xSheet->getStyle($alpha[$counts].'11')->applyFromArray(ExcelFormatter::$tableHeader);
                $dataSales = $model->dataSalesRecap($yearsS,$yearsE, $type, $customerID, $productID, $supplierID);
            
                $rowx=12;
                foreach ($dataSales as $modelx)
                {
                    $dataModel = $model->printSalesRecap($rowss['dates'], $type, $modelx['customerID'], $modelx['productID'], $modelx['supplierID']);
                    $xSheet->setCellValue('B'.$rowx, $modelx['name']); 
                    foreach ($dataModel as $values) {
                        $xSheet->setCellValue($alpha[$counts].$rowx, number_format($values['total'],0,",","."));
                    }
                    $xSheet->getStyle('B'.$rowx)->applyFromArray(ExcelFormatter::$alignLeft);
                    $xSheet->getStyle($alpha[$counts].$rowx)->applyFromArray(ExcelFormatter::$alignRight);
                    $rowx++;
                } 
                $xSheet->getStyle('B12:'.$alpha[$counts].($rowx-1))->applyFromArray(ExcelFormatter::$outerBorder);
                $counts ++;
            }
        }

        $xSheet->getStyle('B1')->applyFromArray(ExcelFormatter::$companyLogo);
        //Set Style Header Text
        $xSheet->getStyle('B7')->applyFromArray(ExcelFormatter::$companyTitle);
        $xSheet->getStyle('B8')->applyFromArray(ExcelFormatter::$title);
        $xSheet->getStyle('B9')->applyFromArray(ExcelFormatter::$title);
        //Set Table Header Style
        $xSheet->getStyle('B11')->applyFromArray(ExcelFormatter::$tableHeader);
        
       
//       
//        $row=12;
//        foreach ($data as $model)
//        {
//            
//            
//            if($type == 'Customer'){
//                $xSheet->setCellValue('B'.$row, $model['customerName']); 
//                $xSheet->setCellValue('C'.$row, number_format($model['total'],0,",","."));
//                
//            } elseif ($type == 'Supplier'){
//                $xSheet->setCellValue('B'.$row, $model['supplierName']); 
//                $xSheet->setCellValue('C'.$row, number_format($model['total'],0,",","."));
//            }
//            
//
//            $xSheet->getStyle('B'.$row)->applyFromArray(ExcelFormatter::$alignLeft);
//            $xSheet->getStyle('C'.$row)->applyFromArray(ExcelFormatter::$alignRight);
//
//            $row++;
//        }
//        $xSheet->getStyle('B12:C'.($row-1))->applyFromArray(ExcelFormatter::$outerBorder);
        //die();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $filename = "Sales Report".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        
        $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        ob_end_clean();
        $xWriter->save('php://output');
        exit();
    }
    
    
    
}


