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
class SalesReportController extends MainController
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
            $dateS = $_report['dateStart'];          
            $dateE = $_report['dateEnd'];    
            $customerID = $_report['customerID'];
            $productID = $_report['productID'];
            $supplierID = $_report['supplierID'];
            $typeReport= $_report['typeReport'];
           
          

            if(isset($_POST['btnPrint_PDF']))
            {
                $url = \yii\helpers\Url::to(['sales-report/print-sales', 'dateS' => $dateS, 'dateE' => $dateE,
                                'type' => $typeReport,'productID' => $productID, 'customerID' => $customerID, 'supplierID' => $supplierID]);
                $redirectTo = \yii\helpers\Url::to(['sales-report/']);
                $this->view->registerJS("newwindow=window.open('$url', 'name');if (window.focus) {newwindow.focus()}window.location.href = '$redirectTo';");
                
            } 
        }else{
            $model->dateStart = date("01-m-Y");
            $model->dateEnd = date("d-m-Y");
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
    
    public function actionPrintSales ($dateS, $dateE, $type, $productID, $customerID, $supplierID )
    {
        $model = new SalesReport();
        $data = $model->printSales($dateS, $dateE, $type, $customerID, $productID, $supplierID);
        $phpExcel = new \PHPExcel();
        $sheet=0;
        $phpExcel->setActiveSheetIndex($sheet);
        $xSheet = $phpExcel->getActiveSheet();

        $xSheet->getColumnDimension('B')->setWidth(50);
        $xSheet->getColumnDimension('C')->setWidth(20);
        $xSheet->getColumnDimension('D')->setWidth(30);
        $xSheet->getColumnDimension('E')->setWidth(20);
        $xSheet->getColumnDimension('F')->setWidth(20);
        $xSheet->getColumnDimension('G')->setWidth(20);
        $xSheet->getColumnDimension('H')->setWidth(20);  

        $xDrawing = new \PHPExcel_Worksheet_Drawing();
        $xDrawing->setName('Thumb');
        $xDrawing->setDescription('Thumbnail Image');
        $xDrawing->setPath(Yii::$app->basePath . '/assets_b/images/logonew.png');
        $xDrawing->setHeight(80);
        $xDrawing->setWidth(120);
        $xDrawing->setCoordinates('D1');
        $xDrawing->setOffsetX(82);
        $xDrawing->setWorksheet($phpExcel->getActiveSheet());
        
        if($type == 'Product'){
            $phpExcel->getActiveSheet()->setTitle('Sales Report')
                ->setCellValue('B8', 'PT. Qwinjaya Aditama')
                ->setCellValue('B9', 'Sales Report By Product ')
                ->setCellValue('B10', $dateS.' - '.$dateE)
                //Set Table Header
                ->setCellValue('B11', 'Product')
                ->setCellValue('C11', 'Delivery Date')
                ->setCellValue('D11', 'Customer')
                ->setCellValue('E11', 'Origin')
                ->setCellValue('F11', 'Price')
                ->setCellValue('G11', 'Qty')
                ->setCellValue('H11', 'Sub Total');
        } elseif ($type == 'Customer'){
            $phpExcel->getActiveSheet()->setTitle('Sales Report')
                ->setCellValue('B8', 'PT. Qwinjaya Aditama')
                ->setCellValue('B9', 'Sales Report By Customer')
                ->setCellValue('B10', $dateS.' - '.$dateE)
                //Set Table Header
                ->setCellValue('B11', 'Customer')
                ->setCellValue('C11', 'Delivery Date')
                ->setCellValue('D11', 'Product')
                ->setCellValue('E11', 'Origin')
                ->setCellValue('F11', 'Price')
                ->setCellValue('G11', 'Qty')
                ->setCellValue('H11', 'Sub Total');
        } elseif ($type == 'Supplier'){
            $phpExcel->getActiveSheet()->setTitle('Sales Report')
                ->setCellValue('B8', 'PT. Qwinjaya Aditama')
                ->setCellValue('B9', 'Sales Report By Supplier')
                ->setCellValue('B10', $dateS.' - '.$dateE)
                //Set Table Header
                ->setCellValue('B11', 'Supplier')
                ->setCellValue('C11', 'Delivery Date')
                ->setCellValue('D11', 'Product')
                ->setCellValue('E11', 'Origin')
                ->setCellValue('F11', 'Price')
                ->setCellValue('G11', 'Qty')
                ->setCellValue('H11', 'Sub Total');
        }
       
        $xSheet->mergeCells('B8:H8');
        $xSheet->mergeCells('B9:H9');
        $xSheet->mergeCells('B10:H10');
        $xSheet->getStyle('F1')->applyFromArray(ExcelFormatter::$companyLogo);
        //Set Style Header Text
        $xSheet->getStyle('B8')->applyFromArray(ExcelFormatter::$companyTitle);
        $xSheet->getStyle('B9')->applyFromArray(ExcelFormatter::$title);
        $xSheet->getStyle('B10')->applyFromArray(ExcelFormatter::$title);
        //Set Table Header Style
        $xSheet->getStyle('B11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('C11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('D11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('E11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('F11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('G11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('H11')->applyFromArray(ExcelFormatter::$tableHeader);

        $row=12;
        $total = 0;
        foreach ($data as $model)
        {
            if (is_decimal($model['qty'])) {
               $qty =  number_format($model['qty'], 4, '.', ',');
            } else {
               $qty =  number_format($model['qty'], 0, ',', '.');
            }
            if($type == 'Product'){
                $xSheet->setCellValue('B'.$row, $model['productName']); 
                $xSheet->setCellValue('C'.$row, $model['goodsDeliveryDate']);
                $xSheet->setCellValue('D'.$row, $model['customerName']);
                $xSheet->setCellValue('E'.$row, $model['origin']);
                $xSheet->setCellValue('F'.$row, number_format($model['price'],0,",","."));
                $xSheet->setCellValue('G'.$row, $qty.' '.$model['uomName']);
                $xSheet->setCellValue('H'.$row, number_format($model['subTotal'],0,",","."));
            } elseif ($type == 'Customer'){
                $xSheet->setCellValue('B'.$row, $model['customerName']); 
                $xSheet->setCellValue('C'.$row, $model['goodsDeliveryDate']);
                $xSheet->setCellValue('D'.$row, $model['productName']);
                $xSheet->setCellValue('E'.$row, $model['origin']);
                $xSheet->setCellValue('F'.$row, number_format($model['price'],0,",","."));
                $xSheet->setCellValue('G'.$row, $qty.' '.$model['uomName']);
                $xSheet->setCellValue('H'.$row, number_format($model['subTotal'],0,",","."));
            } elseif ($type == 'Supplier'){
                $xSheet->setCellValue('B'.$row, $model['supplierName']); 
                $xSheet->setCellValue('C'.$row, $model['goodsDeliveryDate']);
                $xSheet->setCellValue('D'.$row, $model['productName']);
                $xSheet->setCellValue('E'.$row, $model['origin']);
                $xSheet->setCellValue('F'.$row, number_format($model['price'],0,",","."));
                $xSheet->setCellValue('G'.$row, $qty.' '.$model['uomName']);
                $xSheet->setCellValue('H'.$row, number_format($model['subTotal'],0,",","."));
            }
            $total += $model['subTotal'];
            $xSheet->getStyle('B'.$row)->applyFromArray(ExcelFormatter::$alignLeft);
            $xSheet->getStyle('C'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
            $xSheet->getStyle('D'.$row)->applyFromArray(ExcelFormatter::$alignLeft);
            $xSheet->getStyle('E'.$row)->applyFromArray(ExcelFormatter::$alignRight);
            $xSheet->getStyle('F'.$row)->applyFromArray(ExcelFormatter::$alignRight);
            $xSheet->getStyle('G'.$row)->applyFromArray(ExcelFormatter::$alignRight);
            $xSheet->getStyle('H'.$row)->applyFromArray(ExcelFormatter::$alignRight);

            $row++;
        }
        
        $xSheet->setCellValue('G'.$row, "TOTAL");
        $xSheet->setCellValue('H'.$row, number_format($total,0,",","."));
        
        $xSheet->getStyle('G'.$row)->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('H'.$row)->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('H'.$row)->applyFromArray(ExcelFormatter::$alignRight);
        $xSheet->getStyle('B12:H'.($row))->applyFromArray(ExcelFormatter::$outerBorder);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       // header('Content-Type: application/vnd.ms-excel');
        $filename = "Sales Report".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        
        $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        ob_end_clean();
        $xWriter->save('php://output');
        exit();
    }
    
    
    
}


