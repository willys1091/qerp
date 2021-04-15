<?php
namespace app\controllers;

use Yii;
use mPDF;
use yii\data\SqlDataProvider;
use app\models\SampleStockCard;
use app\models\SamplingReport;
use app\models\TrSampledeliveryhead;
use app\models\TrSampledeliverydetail;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\components\AppHelper;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\components\MdlDb;
use kartik\mpdf\Pdf;
use app\components\ExcelFormatter;

/**
 * SampleReceiptController implements the CRUD actions for TrSamplereceipthead model.
 */
class SamplingReportController extends MainController
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

    /**
     * Lists all TrSamplereceipthead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new SamplingReport();
        $model->load(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($model);
        }
        
        if (Yii::$app->request->post()) {
            $_report = Yii::$app->request->post('SamplingReport');
            $dateS = $_report['dateStart'];          
            $dateE = $_report['dateEnd'];            
            $typeReport= $_report['typeReport'];
            $customerID = $_report['customerID'];
            $productID = $_report['productID'];
            $supplierID = $_report['supplierID'];

            if(isset($_POST['btnPrint_PDF']))
            {
                $url = \yii\helpers\Url::to(['sampling-report/print-sampling', 'dateS' => $dateS, 'dateE' => $dateE,
                                'type' => $typeReport,'productID' => $productID, 'idC' => $customerID, 'idS' => $supplierID]);
                $redirectTo = \yii\helpers\Url::to(['sampling-report/']);
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
    
    public function actionPrintSampling($dateS, $dateE, $type, $productID, $idC, $idS)
    { 
        $connection = MdlDb::getDbConnection();
        $this->dateFrom = date('Y-m-d', strtotime($dateS));
        $this->dateTo = date('Y-m-d', strtotime($dateE));
        $filterCS = '';
        if($idC != NULL) $filterCS = " and a.customerID LIKE ('%". $idC ."%')";
        
        
        if($type == 'Sample Stock Position'){
            $this->actionPrintSampleStockPosition($productID);
        }
        else if ($type == 'List of Sample For Customer') { 
            if($productID != ''){
            $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                 . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" '
                 . 'AND c.`productID` = "'.$productID.'"'
                 . $filterCS;;
            $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" '
                 . 'AND c.`productID` = "'.$productID.'"'
                 . $filterCS;
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" '
                . $filterCS;
                $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" '
                . $filterCS;
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'customerName',
                'sampleDeliveryDate',
                'productName', 
                'batchNumber',
                'origin', 
                'qty',
                'notes',
                'statusName'   
            ];
            $view = 'report_view_list_of_sample_for_customer';
        }
        else if ($type == 'Sample Receipt') {
            if($idS != '') {
            $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                    .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                    .'FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                        .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                        .'FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);               
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'sampleReceiptDate',
                'productName',
                'batchNumber', 
                'origin',
                'refNum', 
                'qty',
                'notes'   
            ];
            $view = 'report_view_sample_receipt';        
        }
        else if ($type == 'Sample Delivery') {
            if($idC != ''){
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$this->dateFrom.'" and "'.$this->dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'sampleDeliveryDate',
                'refNum', 
                'customerName',
                'batchNumber', 
                'origin',
                'qty',
                'notes',
                'statusName'
            ];
            $view = 'report_view_sample_delivery';                
        }
        
        return $this->render($view, [
            'model' => $command->queryAll(),
            'dateS' => $dateS,
            'dateE' => $dateE,
            'type' => $type,
            'productID' => $productID,
            'idC' => $idC,
            'idS' => $idS
        ]);
    }
    
    public function actionPrintSampleStockPosition ($productID, $dateFrom = null, $dateTo = null)
    {
        $connection = MdlDb::getDbConnection();
        
        if (!$dateFrom)
        {
            $dateFrom = $this->dateFrom;
        }
        if (!$dateTo)
        {
            $dateTo = $this->dateTo;
        }
        
        if($productID != ''){
//            $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate, uom.uomName
//                    FROM tr_stockcardsample a 
//                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
//                    INNER JOIN ms_product c ON c.productID = a.productID
//                    INNER JOIN ms_productdetail pDetail ON pDetail.productID = c.productID
//                    INNER JOIN ms_uom uom ON uom.uomID = pDetail.uomID
//                    INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
//                                INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				
//                                GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
//                    WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
//                   . 'and a.productID = "'.$productID.'"';
            $sql = 'SELECT product.productName, stock.batchNumber, product.origin, 
                    (
                        SELECT IFNULL(SUM(stockSum.inQty - IF(stock.outQty > 0 AND stockSum.refNum = stock.refNum, 0, stockSum.outQty)), 0) 
                        FROM tr_stockcardsample stockSum WHERE stockSum.productID = stock.productID 
                        AND stockSum.batchNumber = stock.batchNumber AND stockSum.transactionDate <= stock.transactionDate
                    ) AS jumlah, stock.outQty, productDetail.productDetailID,
                    stock.refNum, IFNULL(srHead.notes, sdHead.notes) AS notes, IFNULL(stock.expiredDate, stock.retestDate) AS expiredDate
                    FROM tr_stockcardsample AS stock
                    LEFT JOIN tr_samplereceipthead AS srHead ON srHead.sampleReceiptNum = stock.refNum
                    LEFT JOIN tr_sampledeliveryhead AS sdHead ON sdHead.sampleDeliveryNum = stock.refNum
                    LEFT JOIN ms_product AS product ON product.productID = stock.productID
                    LEFT JOIN ms_productdetail AS productDetail ON productDetail.productID = product.productID
                    LEFT JOIN ms_uom AS uom ON uom.uomID = productDetail.uomID
                    WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                   . 'and stock.productID = "'.$productID.'"';
            $sqlCount = 'SELECT COUNT(*)
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				
                                    GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                        . 'and a.productID = "'.$productID.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
        }
        else {
            $sql = 'SELECT product.productName, stock.batchNumber, product.origin, 
                    (
                        SELECT IFNULL(SUM(stockSum.inQty - IF(stock.outQty > 0 AND stockSum.refNum = stock.refNum, 0, stockSum.outQty)), 0) 
                        FROM tr_stockcardsample stockSum WHERE stockSum.productID = stock.productID 
                        AND stockSum.batchNumber = stock.batchNumber AND stockSum.transactionDate <= stock.transactionDate
                    ) AS jumlah, stock.outQty, productDetail.productDetailID,
                    stock.refNum, IFNULL(srHead.notes, sdHead.notes) AS notes, IFNULL(stock.expiredDate, stock.retestDate) AS expiredDate
                    FROM tr_stockcardsample AS stock
                    LEFT JOIN tr_samplereceipthead AS srHead ON srHead.sampleReceiptNum = stock.refNum
                    LEFT JOIN tr_sampledeliveryhead AS sdHead ON sdHead.sampleDeliveryNum = stock.refNum
                    LEFT JOIN ms_product AS product ON product.productID = stock.productID
                    LEFT JOIN ms_productdetail AS productDetail ON productDetail.productID = product.productID
                    LEFT JOIN ms_uom AS uom ON uom.uomID = productDetail.uomID
                    WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'"';
            $sqlCount = 'SELECT COUNT(*)
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				
                                    GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
        }
            
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'productName',
            'batchNumber',
            'origin', 
            'jumlah',
            'outQty', 
            'refNum',
            'notes',
            'expiredDate'   
        ];
        $view = 'report_view_sample_stock_position';

        $model = $command->queryAll();

        $phpExcel = new \PHPExcel();
        $sheet=0;
        $phpExcel->setActiveSheetIndex($sheet);
        $xSheet = $phpExcel->getActiveSheet();

        $xSheet->getColumnDimension('B')->setWidth(20);
        $xSheet->getColumnDimension('C')->setWidth(20);
        $xSheet->getColumnDimension('D')->setWidth(20);
        $xSheet->getColumnDimension('E')->setWidth(20);
        $xSheet->getColumnDimension('F')->setWidth(20);
        $xSheet->getColumnDimension('G')->setWidth(20);
        $xSheet->getColumnDimension('H')->setWidth(20);
        $xSheet->getColumnDimension('I')->setWidth(20);        

        $xDrawing = new \PHPExcel_Worksheet_Drawing();
        $xDrawing->setName('Thumb');
        $xDrawing->setDescription('Thumbnail Image');
        $xDrawing->setPath(Yii::$app->basePath . '/assets_b/images/logonew.png');
        $xDrawing->setHeight(80);
        $xDrawing->setWidth(120);
        $xDrawing->setCoordinates('E1');
        $xDrawing->setOffsetX(82);
        $xDrawing->setWorksheet($phpExcel->getActiveSheet());

        $phpExcel->getActiveSheet()->setTitle('Sample Stock Position')
            ->setCellValue('B8', 'PT. Qwinjaya Aditama')
            ->setCellValue('B9', 'Sample Stock Position')
            //Set Table Header
            ->setCellValue('B11', 'Product')
            ->setCellValue('C11', 'Batch')
            ->setCellValue('D11', 'Origin')
            ->setCellValue('E11', 'Stock')
            ->setCellValue('F11', 'Out')
            ->setCellValue('G11', 'Reff')
            ->setCellValue('H11', 'Remarks')
            ->setCellValue('I11', 'Exp. Date');

        $xSheet->mergeCells('B8:I8');
        $xSheet->mergeCells('B9:I9');

        $xSheet->getStyle('E1')->applyFromArray(ExcelFormatter::$companyLogo);
        //Set Style Header Text
        $xSheet->getStyle('B8')->applyFromArray(ExcelFormatter::$companyTitle);
        $xSheet->getStyle('B9')->applyFromArray(ExcelFormatter::$title);
        
        //Set Table Header Style
        $xSheet->getStyle('B11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('C11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('D11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('E11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('F11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('G11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('H11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('I11')->applyFromArray(ExcelFormatter::$tableHeader);


        $row=12;
        foreach ($model as $model)
        {
            $xSheet->setCellValue('B'.$row, $model['productName']); 
            $xSheet->setCellValue('C'.$row, $model['batchNumber']);
            $xSheet->setCellValue('D'.$row, $model['origin']);
            $xSheet->setCellValue('E'.$row, $model['jumlah'].' '.$model['uomName']);
            $xSheet->setCellValue('F'.$row, $model['outQty'].' '.$model['uomName']);
            $xSheet->setCellValue('G'.$row, $model['refNum']);
            $xSheet->setCellValue('H'.$row, $model['notes']);
            $xSheet->setCellValue('I'.$row, $model['expiredDate']);

            $xSheet->getStyle('B'.$row)->applyFromArray(ExcelFormatter::$alignLeft);
            $xSheet->getStyle('C'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
            $xSheet->getStyle('D'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
            $xSheet->getStyle('E'.$row)->applyFromArray(ExcelFormatter::$alignRight);
            $xSheet->getStyle('F'.$row)->applyFromArray(ExcelFormatter::$alignRight);
            $xSheet->getStyle('G'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
            $xSheet->getStyle('H'.$row)->applyFromArray(ExcelFormatter::$alignLeft);
            $xSheet->getStyle('I'.$row)->applyFromArray(ExcelFormatter::$alignRight);


            $row++;
        }
        $xSheet->getStyle('B12:I'.($row-1))->applyFromArray(ExcelFormatter::$outerBorder);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       // header('Content-Type: application/vnd.ms-excel');
        $filename = "MyExcelReport_".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        
        $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        ob_end_clean();
        $xWriter->save('php://output');
        die();
    }
    
    public function actionExcelreceipt($dateS, $dateE, $type, $productID, $idC, $idS)
    { 
         $connection = MdlDb::getDbConnection();
         $dateFrom = date('Y-m-d', strtotime($dateS));
         $dateTo = date('Y-m-d', strtotime($dateE));
         
         if($type == 'Sample Stock Position'){
            if($productID != ''){
                $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                       . 'and a.productID = "'.$productID.'"';
                $sqlCount = 'SELECT COUNT(*)
                            FROM tr_stockcardsample a 
                            INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                            INNER JOIN ms_product c ON c.productID = a.productID
                            INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                            WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                            . 'and a.productID = "'.$productID.'"';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            else{
                $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*)
                            FROM tr_stockcardsample a 
                            INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                            INNER JOIN ms_product c ON c.productID = a.productID
                            INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                            WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } 
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'batchNumber',
                'origin', 
                'jumlah',
                'outQty', 
                'refNum',
                'notes',
                'expiredDate'   
            ];
            $view = 'report_view_sample_stock_position';             
        }
        elseif ($type == 'List of Sample For Customer') { 
            if($productID != ''){
            $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                 . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                 . 'AND a.`customerID` = "'.$idC.'"'
                 . 'AND c.`productID` = "'.$productID.'"';
            $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                 . 'AND a.`customerID` = "'.$idC.'"'
                 . 'AND c.`productID` = "'.$productID.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'customerName',
                'sampleDeliveryDate',
                'productName', 
                'batchNumber',
                'origin', 
                'qty',
                'notes',
                'statusName'   
            ];
            $view = 'report_view_list_of_sample_for_customer';
        }
        elseif ($type == 'Sample Receipt') {
            if($idS != '') {
            $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                    .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                    .'FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                        .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                        .'FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);               
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'sampleReceiptDate',
                'productName',
                'batchNumber', 
                'origin',
                'refNum', 
                'qty',
                'notes'   
            ];
            $view = 'report_view_sample_receipt';        
        }
        elseif ($type == 'Sample Delivery') {
            if($idC != ''){
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'sampleDeliveryDate',
                'refNum', 
                'customerName',
                'batchNumber', 
                'origin',
                'qty',
                'notes',
                'statusName'
            ];
            $view = 'report_view_sample_delivery';                
    }
    
    $model = $command->queryAll();
    
        //header("Content-type: application/vnd-ms-excel");
 
        //Mendefinisikan nama file ekspor "hasil-export.xls"
        //header("Content-Disposition: attachment; filename=tutorialweb-export.xls");
        


        $objPHPExcel = new \PHPExcel();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
                 
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Thumb');
        $objDrawing->setDescription('Thumbnail Image');
        $objDrawing->setPath($_SERVER["DOCUMENT_ROOT"] . '/ptkd_qerp/assets_b/images/logonew.png');
        $objDrawing->setHeight(100);
        $objDrawing->setWidth(150);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
        $objPHPExcel->getActiveSheet()->setTitle('Sheet 1') 
            ->setCellValue('B1', 'Sample Receipt')
            ->setCellValue('A1', 'PT Qwinjaya Aditama')
            ->setCellValue('A2', 'Date Received')
            ->setCellValue('B2', 'Product Name')
            ->setCellValue('C2', 'No. Batch')
            ->setCellValue('D2', 'Principal')
            ->setCellValue('E2', 'Reff No.')
            ->setCellValue('F2', 'Qty')
            ->setCellValue('G2', 'Remarks');
        
        $objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
        
        $style = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        
        $styleRight = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        
        $styleLeft = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        $styleLogo = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
        		)
   		);
        
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleLogo);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style);
        
            
                 
         $row=3;
                                
                foreach ($model as $foo) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, date('d-m-Y', strtotime($foo['sampleReceiptDate']))); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['productName']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['batchNumber']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['origin']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['refNum']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['qty']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['notes']);
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleLeft);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleLeft);                    
                    
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "MyExcelReport_".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');      
        die();
    }
    
    public function actionExceldelivery($dateS, $dateE, $type, $productID, $idC, $idS)
    { 
         $connection = MdlDb::getDbConnection();
         $dateFrom = date('Y-m-d', strtotime($dateS));
         $dateTo = date('Y-m-d', strtotime($dateE));
         
         if($type == 'Sample Stock Position'){
            if($productID != ''){
                $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                       . 'and a.productID = "'.$productID.'"';
                $sqlCount = 'SELECT COUNT(*)
                            FROM tr_stockcardsample a 
                            INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                            INNER JOIN ms_product c ON c.productID = a.productID
                            INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                            WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                            . 'and a.productID = "'.$productID.'"';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            else{
                $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*)
                            FROM tr_stockcardsample a 
                            INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                            INNER JOIN ms_product c ON c.productID = a.productID
                            INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                            WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } 
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'batchNumber',
                'origin', 
                'jumlah',
                'outQty', 
                'refNum',
                'notes',
                'expiredDate'   
            ];
            $view = 'report_view_sample_stock_position';             
        }
        elseif ($type == 'List of Sample For Customer') { 
            if($productID != ''){
            $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                 . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                 . 'AND a.`customerID` = "'.$idC.'"'
                 . 'AND c.`productID` = "'.$productID.'"';
            $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                 . 'AND a.`customerID` = "'.$idC.'"'
                 . 'AND c.`productID` = "'.$productID.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'customerName',
                'sampleDeliveryDate',
                'productName', 
                'batchNumber',
                'origin', 
                'qty',
                'notes',
                'statusName'   
            ];
            $view = 'report_view_list_of_sample_for_customer';
        }
        elseif ($type == 'Sample Receipt') {
            if($idS != '') {
            $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                    .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                    .'FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                        .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                        .'FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);               
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'sampleReceiptDate',
                'productName',
                'batchNumber', 
                'origin',
                'refNum', 
                'qty',
                'notes'   
            ];
            $view = 'report_view_sample_receipt';        
        }
        elseif ($type == 'Sample Delivery') {
            if($idC != ''){
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'sampleDeliveryDate',
                'refNum', 
                'customerName',
                'batchNumber', 
                'origin',
                'qty',
                'notes',
                'statusName'
            ];
            $view = 'report_view_sample_delivery';                
    }
    
    $model = $command->queryAll();
    
//    header("Content-type: application/vnd-ms-excel");
 
    // Mendefinisikan nama file ekspor "hasil-export.xls"
//    header("Content-Disposition: attachment; filename=tutorialweb-export.xls");
        


        $objPHPExcel = new \PHPExcel();
        $sheet=0;
        $objPHPExcel->setActiveSheetIndex($sheet);
                 
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Thumb');
        $objDrawing->setDescription('Thumbnail Image');
        $objDrawing->setPath($_SERVER["DOCUMENT_ROOT"] . '/ptkd_qerp/assets_b/images/logonew.png');
        $objDrawing->setHeight(100);
        $objDrawing->setWidth(150);
        $objDrawing->setCoordinates('A1');
//        $offsetX = $maxWidth - $objDrawing->getWidth();
//        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
        $objPHPExcel->getActiveSheet()->setTitle('xxx') 
            ->setCellValue('B1', 'Despatch of Sample Report')
            ->setCellValue('A1', 'PT Qwinjaya Aditama')
            ->setCellValue('A2', 'Product Name')
            ->setCellValue('B2', 'Delivery Date')
            ->setCellValue('C2', 'Reff No')
            ->setCellValue('D2', 'Customer Name')
            ->setCellValue('E2', 'No. Batch')
            ->setCellValue('F2', 'Origin')
            ->setCellValue('G2', 'Qty')
            ->setCellValue('H2', 'Notes')
            ->setCellValue('I2', 'Status');
        
        $objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
        
        $style = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        
        $styleRight = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        
        $styleLeft = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        $styleLogo = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
        		)
   		);
        
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleLogo);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style);
                        
         $row=3;
                                
                foreach ($model as $foo) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['productName']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,date('d-m-Y', strtotime($foo['sampleDeliveryDate'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['refNum']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['customerName']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['batchNumber']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['origin']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['qty']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['notes']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo['statusName']);
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleLeft);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($styleLeft);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($style);
                    
                    
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "MyExcelReport_".date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');           
    }
    
    public function actionExcellistsampleofcustomer($dateS, $dateE, $type, $productID, $idC, $idS)
    { 
         $connection = MdlDb::getDbConnection();
         $dateFrom = date('Y-m-d', strtotime($dateS));
         $dateTo = date('Y-m-d', strtotime($dateE));
         
         if($type == 'Sample Stock Position'){
            if($productID != ''){
                $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                       . 'and a.productID = "'.$productID.'"';
                $sqlCount = 'SELECT COUNT(*)
                            FROM tr_stockcardsample a 
                            INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                            INNER JOIN ms_product c ON c.productID = a.productID
                            INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                            WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                            . 'and a.productID = "'.$productID.'"';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            else{
                $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*)
                            FROM tr_stockcardsample a 
                            INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                            INNER JOIN ms_product c ON c.productID = a.productID
                            INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                            WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } 
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'batchNumber',
                'origin', 
                'jumlah',
                'outQty', 
                'refNum',
                'notes',
                'expiredDate'   
            ];
            $view = 'report_view_sample_stock_position';             
        }
        elseif ($type == 'List of Sample For Customer') { 
            if($productID != ''){
            $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                 . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                 . 'AND a.`customerID` = "'.$idC.'"'
                 . 'AND c.`productID` = "'.$productID.'"';
            $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                 . 'AND a.`customerID` = "'.$idC.'"'
                 . 'AND c.`productID` = "'.$productID.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'customerName',
                'sampleDeliveryDate',
                'productName', 
                'batchNumber',
                'origin', 
                'qty',
                'notes',
                'statusName'   
            ];
            $view = 'report_view_list_of_sample_for_customer';
        }
        elseif ($type == 'Sample Receipt') {
            if($idS != '') {
            $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                    .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                    .'FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                        .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                        .'FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);               
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'sampleReceiptDate',
                'productName',
                'batchNumber', 
                'origin',
                'refNum', 
                'qty',
                'notes'   
            ];
            $view = 'report_view_sample_receipt';        
        }
        elseif ($type == 'Sample Delivery') {
            if($idC != ''){
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'sampleDeliveryDate',
                'refNum', 
                'customerName',
                'batchNumber', 
                'origin',
                'qty',
                'notes',
                'statusName'
            ];
            $view = 'report_view_sample_delivery';                
    }
    
    $model = $command->queryAll();
    
//    header("Content-type: application/vnd-ms-excel");
 
    // Mendefinisikan nama file ekspor "hasil-export.xls"
//    header("Content-Disposition: attachment; filename=tutorialweb-export.xls");
        


        $objPHPExcel = new \PHPExcel();
        $sheet=0;
        $objPHPExcel->setActiveSheetIndex($sheet);
                 
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
      
        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Thumb');
        $objDrawing->setDescription('Thumbnail Image');
        $objDrawing->setPath($_SERVER["DOCUMENT_ROOT"] . '/ptkd_qerp/assets_b/images/logonew.png');
        $objDrawing->setHeight(100);
        $objDrawing->setWidth(150);
        $objDrawing->setCoordinates('A1');
//        $offsetX = $maxWidth - $objDrawing->getWidth();
//        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
        $objPHPExcel->getActiveSheet()->setTitle('xxx') 
            ->setCellValue('B1', 'List of Sample For Customer')
            ->setCellValue('A1', 'PT Qwinjaya Aditama')
            ->setCellValue('A2', 'Customer Name')
            ->setCellValue('B2', 'Delivery Date')
            ->setCellValue('C2', 'Product Name')
            ->setCellValue('D2', 'No. Batch')
            ->setCellValue('E2', 'Origin')
            ->setCellValue('F2', 'Qty')
            ->setCellValue('G2', 'Notes')
            ->setCellValue('H2', 'Status');
                    
        $objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
        
        $style = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        
        $styleRight = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        
        $styleLeft = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
   		);
        $styleLogo = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
        		)
   		);
        
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleLogo);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style);
                        
         $row=3;
                                
                foreach ($model as $foo) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['customerName']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,date('d-m-Y', strtotime($foo['sampleDeliveryDate'])));
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['productName']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['batchNumber']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['origin']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['qty']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['notes']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['statusName']);
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleLeft);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style);
                                       
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "MyExcelReport_".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');        
        die();
    }
    
    public function actionExcel2($dateS, $dateE, $type, $productID, $idC, $idS)
    { 
         $connection = MdlDb::getDbConnection();
         $dateFrom = date('Y-m-d', strtotime($dateS));
         $dateTo = date('Y-m-d', strtotime($dateE));
         
        $filterCS = '';
        if($idC != NULL) $filterCS = " and a.customerID LIKE ('%". $idC ."%')";
         
         if($type == 'Sample Stock Position'){
            if($productID != ''){
                $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                       . 'and a.productID = "'.$productID.'"'
                       .$idC;
                $sqlCount = 'SELECT COUNT(*)
                            FROM tr_stockcardsample a 
                            INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                            INNER JOIN ms_product c ON c.productID = a.productID
                            INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                            WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                            . 'and a.productID = "'.$productID.'"'
                            .$idC;;
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            else{
                $sql = 'SELECT c.productName, b.batchNumber, c.origin, d.jumlah, a.outQty, a.refNum, b.notes, b.expiredDate
                        FROM tr_stockcardsample a 
                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                        INNER JOIN ms_product c ON c.productID = a.productID
                        INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                    INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                        WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*)
                            FROM tr_stockcardsample a 
                            INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 
                            INNER JOIN ms_product c ON c.productID = a.productID
                            INNER JOIN ( SELECT SUM(a.outQty) as jumlah, a.refNum FROM tr_stockcardsample a 
                                        INNER JOIN tr_sampledeliverydetail b ON b.sampleDeliveryNum = a.refNum 				GROUP BY b.expiredDate ) d ON d.refNum = a.refNum 
                            WHERE cast(`transactionDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } 
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'batchNumber',
                'origin', 
                'jumlah',
                'outQty', 
                'refNum',
                'notes',
                'expiredDate'   
            ];
            $view = 'report_view_sample_stock_position';             
        }
        elseif ($type == 'List of Sample For Customer') { 
            if($productID != ''){
            $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                 . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                 . 'AND c.`productID` = "'.$productID.'"'
                 .$idC;
            $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                 . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                 . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                 . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                 . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                 . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                 . 'AND c.`productID` = "'.$productID.'"'
                 .$idC;;
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.`customerID`, b.`customerName`, a.`sampleDeliveryDate`, c.`productID`, d.`productName`, c.`batchNumber`, '
                . 'd.`origin`, c.`qty`, c.`notes`, c.`statusID`, e.`statusName` FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                .$idC;
                $sqlCount = 'SELECT COUNT(*) FROM `tr_sampledeliveryhead` a '
                . 'INNER JOIN `ms_customer` b ON a.`customerID` = b.`customerID` '
                . 'INNER JOIN `tr_sampledeliverydetail` c ON a.`sampleDeliveryNum` = c.`sampleDeliveryNum` '
                . 'INNER JOIN `ms_product` d ON c.`productID` = d.`productID`'
                . 'INNER JOIN `lk_status` e ON c.`statusID` = e.`statusID` '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                .$idC;
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'customerName',
                'sampleDeliveryDate',
                'productName', 
                'batchNumber',
                'origin', 
                'qty',
                'notes',
                'statusName'   
            ];
            $view = 'report_view_list_of_sample_for_customer';
        }
        elseif ($type == 'Sample Receipt') {
            if($idS != '') {
            $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                    .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                    .'FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                    . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                    . 'INNER JOIN ms_product c ON b.productID = c.productID '
                    . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                    . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                    . 'AND a.supplierID = "'.$idS.'"';
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT a.sampleReceiptDate, c.productName, ' 
                        .'b.batchNumber, d.supplierName, c.origin, a.refNum, b.qty, a.notes '
                        .'FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_samplereceipthead a '
                        . 'INNER JOIN tr_samplereceiptdetail b ON a.sampleReceiptNum = b.sampleReceiptNum '
                        . 'INNER JOIN ms_product c ON b.productID = c.productID '
                        . 'INNER JOIN ms_supplier d ON a.supplierID = d.supplierID '
                        . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);               
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'sampleReceiptDate',
                'productName',
                'batchNumber', 
                'origin',
                'refNum', 
                'qty',
                'notes'   
            ];
            $view = 'report_view_sample_receipt';        
        }
        elseif ($type == 'Sample Delivery') {
            if($idC != ''){
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" '
                . 'AND a.`customerID` = "'.$idC.'"';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            } else {
                $sql = 'SELECT c.productName, a.sampleDeliveryDate, a.refNum, d.customerName,'
                . 'b.batchNumber, c.origin, b.qty, b.notes, e.statusName FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $sqlCount = 'SELECT COUNT(*) FROM tr_sampledeliveryhead a '
                . 'INNER JOIN tr_sampledeliverydetail b ON a.sampleDeliveryNum = b.sampleDeliveryNum '
                . 'INNER JOIN ms_product c ON b.productID = c.productID '
                . 'INNER JOIN ms_customer d ON a.customerID = d.customerID '
                . 'INNER JOIN lk_status e ON b.statusID = e.statusID '
                . 'WHERE cast(a.`createdDate` as date) BETWEEN "'.$dateFrom.'" and "'.$dateTo.'" ';
                $command = $connection->createCommand($sql);
                $command2 = $connection->createCommand($sqlCount);
            }
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'productName',
                'sampleDeliveryDate',
                'refNum', 
                'customerName',
                'batchNumber', 
                'origin',
                'qty',
                'notes',
                'statusName'
            ];
            $view = 'report_view_sample_delivery';                
    }
    
    $model = $command->queryAll();
    
    $objPHPExcel = new \PHPExcel();
    $sheet=0;
    $objPHPExcel->setActiveSheetIndex($sheet);
    $style = array(
        		'alignment' => array(
            		'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        		)
            );
        
    $styleRight = array(
                    'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
            );
        
    $styleLeft = array(
                    'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
            );
    $styleTitle = array(
                    'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP,
                    )
            );
    $objDrawing = new \PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Thumb');
    $objDrawing->setDescription('Thumbnail Image');
    $objDrawing->setPath(Yii::$app->basePath.'/assets_b/images/logonew.png');
    $objDrawing->setHeight(60);
    $objDrawing->setWidth(90);
    
    if ($type == 'Sample Stock Position') {                 
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);        

        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
        
        $objPHPExcel->getActiveSheet()->setTitle('xxx')
            ->setCellValue('B1', 'PT Qwinjaya Aditama')
            ->setCellValue('B2', 'Sample Stock Position')            
            ->setCellValue('A4', 'Product Name')
            ->setCellValue('B4', 'No. Batch')
            ->setCellValue('C4', 'origin')
            ->setCellValue('D4', 'jumlah')
            ->setCellValue('E4', 'Out Qty')
            ->setCellValue('F4', 'refNum')
            ->setCellValue('G4', 'notes')
            ->setCellValue('H4', 'expired Date');
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
        
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($style);
                     
        $row = 5;
        foreach ($model as $foo) {  
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['productName']); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['batchNumber']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['origin']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['jumlah']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['outQty']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['refNum']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['notes']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,date('d-m-Y', strtotime($foo['expiredDate'])));

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style);
            $row++ ;
        }
    } elseif ($type == 'Sample Receipt') {
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);        

        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setTitle('xxx') 
            ->setCellValue('B1', 'PT Qwinjaya Aditama')
            ->setCellValue('B2', 'Sample Receipt')
            ->setCellValue('A4', 'Date Received')
            ->setCellValue('B4', 'Product Name')
            ->setCellValue('C4', 'No. Batch')
            ->setCellValue('D4', 'Principal')
            ->setCellValue('E4', 'Reff No.')
            ->setCellValue('F4', 'Qty')
            ->setCellValue('G4', 'Remarks');

        $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($style);

        $row = 5;
        foreach ($model as $foo) {  

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, date('d-m-Y', strtotime($foo['sampleReceiptDate']))); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['productName']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['batchNumber']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['origin']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['refNum']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['qty']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['notes']);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleLeft);                    

            $row++ ;
        }
    } elseif ($type == 'Sample Delivery') {
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setTitle('xxx') 
            ->setCellValue('B1', 'PT Qwinjaya Aditama')
            ->setCellValue('B2', 'Despatch of Sample Report')
            ->setCellValue('A4', 'Product Name')
            ->setCellValue('B4', 'Delivery Date')
            ->setCellValue('C4', 'Reff No')
            ->setCellValue('D4', 'Customer Name')
            ->setCellValue('E4', 'No. Batch')
            ->setCellValue('F4', 'Origin')
            ->setCellValue('G4', 'Qty')
            ->setCellValue('H4', 'Notes')
            ->setCellValue('I4', 'Status');

        $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($style);

        $row = 5;
        foreach ($model as $foo) {  
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['productName']); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,date('d-m-Y', strtotime($foo['sampleDeliveryDate'])));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['refNum']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['customerName']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['batchNumber']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['origin']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['qty']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['notes']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo['statusName']);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$row)->applyFromArray($style);
            $row++ ;
        }
    } elseif ($type == 'List of Sample For Customer') {
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        $objDrawing->setCoordinates('A1');
        //        $offsetX = $maxWidth - $objDrawing->getWidth();
        //        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setTitle('xxx') 
            ->setCellValue('B1', 'PT Qwinjaya Aditama')
            ->setCellValue('B2', 'List of Sample For Customer')
            ->setCellValue('A4', 'Customer Name')
            ->setCellValue('B4', 'Delivery Date')
            ->setCellValue('C4', 'Product Name')
            ->setCellValue('D4', 'No. Batch')
            ->setCellValue('E4', 'Origin')
            ->setCellValue('F4', 'Qty')
            ->setCellValue('G4', 'Notes')
            ->setCellValue('H4', 'Status');

        $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleTitle);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($style);

        $row = 5;
        foreach ($model as $foo) {  
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['customerName']); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,date('d-m-Y', strtotime($foo['sampleDeliveryDate'])));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['productName']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['batchNumber']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['origin']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['qty']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['notes']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['statusName']);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($style);
            $row++ ;
        }
    }

    header('Content-Type: application/vnd.ms-excel');
    $filename = "ExcelReport_".$type."_".date("d-m-Y-His").".xlsx";
    header('Content-Disposition: attachment;filename='.$filename .' ');
    header('Cache-Control: max-age=0');
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    $objWriter->save('php://output'); 
    die();
    }
}


