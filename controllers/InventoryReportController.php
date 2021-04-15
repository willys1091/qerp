<?php
namespace app\controllers;
//use app\controllers\Html;


use app\components\AppHelper;
use app\components\MdlDb;
use app\components\XFormatter;
use app\components\XFormatter2;
use app\models\InventoryReport;
use app\models\MsSetting;
use app\models\TrPurchaseorderhead;
use mPDF;
use PHPExcel_Worksheet_Drawing;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class InventoryReportController extends MainController
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

    //Index
    public function actionIndex()
    {
        $connection = MdlDb::getDbConnection();
        $model = new InventoryReport;
        $model->monthYear = date('m-Y');
        $model->monthPicker = date('m-Y');
        $model->month =  date('m-Y');
        
        $model->load(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($model);
        }
        
        if (Yii::$app->request->post()) {
            $_report = Yii::$app->request->post('InventoryReport');                     
            $typeReport = $_report['typeReport'];
            $dateS = $_report['dateS'];
            $dateE = $_report['dateE'];
            $productID = $_report['productID'];
            $batchNumber = $_report['batchNumber'];
            $goodsReceiptNum = $_report['goodsReceiptNum'];
            $periode = $_report['periode'];
            $monthYear = $_report['monthYear'];
            $month = $_report['month'];
            $productIDStock = $_report['productIDStock'];
            
            if(isset($_POST['btnPrint_PDF'])) {

                $url = \yii\helpers\Url::to(['inventory-report/print',
                    'type' => $typeReport,
                    'dateS' => $dateS,
                    'dateE' => $dateE,
                    'productID' => $productID,
                    'goodsReceiptNum' => $goodsReceiptNum,
                    'periode' => $periode,
                    'monthYear' => $monthYear,
                    'month' => $month,
                    'productOOT' => $_report['productOOT'],
                    'productIDStock' => $productIDStock,
                    'batchNumber' => $batchNumber
                ]);
                $redirectTo = \yii\helpers\Url::to(['inventory-report/']);
                return "<script>
                            var newWindow = window.open('$url','name','height=600,width=1024');
                            if (window.focus) {
                                newWindow.focus();
                            }
                            window.location.href = '$redirectTo';
                        </script>";
                    } 
        }
        $periode = $connection->createCommand('SELECT DISTINCT year(purchaseOrderDate) as year from tr_purchaseorderhead')->queryAll();
        return $this->render('index',[
            'model' => $model, 
            'periode' => $periode,
        ]);        
    }
    
    //Print Report
    public function actionPrint($type, $dateS = NULL, $dateE = NULL,$productID = NULL, $goodsReceiptNum = NULL, $periode = NULL, $monthYear = NULL, $month = NULL, $productIDStock = NULL, $batchNumber = NULL)
    {
        $connection = MdlDb::getDbConnection();
        $this->layout = false;
        $dateS = date('Y-m-d', strtotime($dateS));
        $dateE = date('Y-m-d', strtotime($dateE));
        $model2 = '';
        $model3 = '';
        $model4 = '';
        
        if($type == 'Kartu Persediaan Barang')
        {
            return $this->actionPrintKartuPersedianBarang($productIDStock, $periode);
        }
        elseif ($type == 'Laporan OOT')
        {
          
            return $this->actionPrintLaporanOOT(Yii::$app->request->get('productOOT'), Yii::$app->request->get('monthYear'));    
        }
        elseif ($type == 'Kartu Import')
        {
            $sql = 'SELECT d.hsCode, b.currencyID, DATE_FORMAT(a.pibDate, "%d %M %Y") as PIBdate, DATE_FORMAT(b.purchaseOrderDate, "%d %M %Y") as POdate, d.productName, a.goodsReceiptNum, e.supplierName, year(b.purchaseOrderDate) as year
                    , month(a.goodsReceiptDate) as month, day(a.goodsReceiptDate) as day
                    , d.origin, g.uomName, b.purchaseOrderNum, k.purchaseOrderNum, k.price as sellPrice, k.discount
                    , a.invoiceNum, b.taxRate, DATE_FORMAT(a.invoiceDate, "%d-%m-%y") as invoiceDate, b.shipmentType
                    , a.AWBNum, DATE_FORMAT(a.AWBDate, "%d-%m-%y") as AWBDate, a.PPJK, a.pibNumber, a.pibSubmitCode
                    , FLOOR(h.taxPercentage) as taxPercentage, j.importDutyAmount, j.PPNImportAmount, j.PPHImportAmount
                    , j.otherCostAmount, j.taxInvoiceAmount, c.qty, c.batchNumber, a.SKINumber, i.paymentDue, l.supplierName as ppjk
                    , a.pibRate, SUM(c.qty * k.price * (100 - k.discount) / 100 * (100 + b.taxRate) / 100) as nilai_invoice,  (IFNULL(j.importDutyAmount,0) + IFNULL(j.PPNImportAmount,0) + IFNULL(j.PPHImportAmount,0) + IFNULL(j.otherCostAmount,0) +  IFNULL(j.taxInvoiceAmount,0)) as total
                    FROM tr_goodsreceipthead a 
                    LEFT JOIN tr_purchaseorderhead b ON b.purchaseOrderNum = a.refNum 
                    LEFT JOIN tr_goodsreceiptdetail c ON c.goodsReceiptNum = a.goodsReceiptNum 
                    LEFT JOIN ms_product d ON d.productID = c.productID 
                    LEFT JOIN ms_supplier e ON e.supplierID = b.supplierID 
                    LEFT JOIN ms_productdetail f ON f.productID = c.productID
                    LEFT JOIN ms_uom g ON g.uomID = f.uomID 
                    LEFT JOIN ms_hscode h ON h.hsCode = d.hsCode 
                    LEFT JOIN ms_paymentdue i ON i.ID = b.paymentDue 
                    LEFT JOIN tr_goodsreceiptcost j ON j.goodsReceiptNum = a.goodsReceiptNum
                    LEFT JOIN tr_purchaseorderdetail k ON k.purchaseOrderNum = b.purchaseOrderNum AND k.productID = c.productID
                    LEFT JOIN ms_supplier l ON l.supplierID = a.PPJK
                    WHERE a.goodsReceiptNum = "'.$goodsReceiptNum.'" 
                    GROUP BY a.goodsReceiptNum ';
            
            $sqlHead = 'SELECT a.batchNumber,a.qty, b.productName, e.uomName FROM tr_goodsreceiptdetail a 
                        LEFT JOIN ms_product b on b.productID = a.productID
                        LEFT JOIN ms_productdetail d ON d.productID = b.productID
                        LEFT JOIN ms_uom e ON e.uomID = d.uomID 
                        WHERE a.goodsReceiptNum = "'.$goodsReceiptNum.'" ';
            $command = $connection->createCommand($sqlHead); 
            $model4 = $command->queryAll(); 
            
            $view = 'report_view_kartu_import';
        }
        elseif ($type == 'Import Realization Report (BPOM)')
        {
            return $this->actionPrintImportRealization($monthYear, $month, 1);
            
            $sql = 'SELECT * FROM Ms_product';
            $view = 'report_view_import_realization';
        }
        elseif ($type == 'Import Realization Report (MENPERINDAG)')
        {
            return $this->actionPrintImportRealization($monthYear, $month, 2);
            
            $sql = 'SELECT * FROM Ms_product';
            $view = 'report_view_import_realization';
        }
        elseif ($type == 'Purchase Order')
        {
            $sql = 'SELECT a.purchaseOrderDate, a.purchaseOrderNum, b.contactPerson, f.productName, '
                    .'c.qty, c.price, b.supplierName, g.uomName, h.packingTypeName, e.paymentDueName, a.additionalInfo FROM tr_purchaseorderhead a '
                    .'INNER JOIN ms_supplier b ON b.supplierID = a.supplierID   '
                    .'INNER JOIN tr_purchaseorderdetail c ON c.purchaseOrderNum = a.purchaseOrderNum    '
                    .'INNER JOIN ms_productdetail d ON d.productID = c.productID '
                    .'LEFT JOIN lk_paymentdue e ON e.paymentDueID = a.paymentDue '
                    .'INNER JOIN ms_product f ON f.productID = c.productID '
                    .'INNER JOIN ms_uom g ON g.uomID = d.uomID '
                    .'INNER JOIN ms_packingtype h ON h.packingTypeID = d.packingTypeID '
                    .'WHERE a.purchaseOrderNum = "QJA/PO/17/IV/004"';
            $view = 'report_view_purchase_order';        
        }
        $command = $connection->createCommand($sql); 
        $model = $command->queryAll(); 
        $companyDirector = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "CompanyDirector"')->queryOne();
        $pharmacistName = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PharmacistName"')->queryOne();
        $pharmacistNumber = $connection->createCommand('SELECT value1 FROM ms_setting WHERE key1 = "PharmacistNumber"')->queryOne();
        
        $location= Html::img('assets_b/images/location.png',['height' => '15px', 'width' => '15px']);
        $imagePhone = Html::img('assets_b/images/phone.png',['height' => '15px', 'width' => '15px']);
        $imageFax = Html::img('assets_b/images/fax.png',['height' => '15px', 'width' => '15px']); 
        $phone1 = MsSetting::findOne(['key1' => 'Phone1']);
        $phone2 = MsSetting::findOne(['key1' => 'Phone2']);
        $phone3 = MsSetting::findOne(['key1' => 'Phone3']);
        $phone4 = MsSetting::findOne(['key1' => 'Phone4']);
        $fax = MsSetting::findOne(['key1' => 'Fax']);
        $address = MsSetting::findOne(['key1' => 'OfficeAddress']);
    
        
        
        $content = $this->renderPartial($view, [
            'type' => $type,
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'model4' => $model4,
            'model5' => $model3,
            'periode' => $periode,
            'companyDirector' => $companyDirector,
            'pharmacistName' => $pharmacistName,
            'pharmacistNumber' => $pharmacistNumber,
            'location' => $location,
            'fax' => $fax,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'phone3' => $phone3,
            'phone4' => $phone4,
            'imageFax' => $imageFax,
            'imagePhone' => $imagePhone,
            'address' => $address,
        ]);     

        $mpdf = new mPDF('', // mode - default ''
            'A4', // format - A4, default ''
            0, // font size - default 0
            '', // default font family
            '5', // margin_left
            '5', // margin right
            '5', // margin top
            '5', // margin bottom
            '0', // margin header
            '5', // margin footer
            'P'     // P = portrait, L = landscape
        );

        $mpdf->SetHeader('');
//      $mpdf->SetFooter('{PAGENO}');
        $mpdf->WriteHTML($content);

        $mpdf->debug = true;
        $mpdf ->Output('report.pdf','I');
        exit;
    }
    
    public function actionPrintKartuPersedianBarang ($id, $year)
    {
        $stockIn = "SELECT 'in' AS flow, DAY(stock.transactionDate) AS day, MONTH(stock.transactionDate) AS month,
        stock.batchNumber, stock.inQty, GR.refNum AS noPO, uom.uomName,
        (
            SELECT SUM(inQty - outQty) FROM tr_stockcard
            WHERE productID = stock.productID AND transactionDate <= stock.transactionDate
            ORDER BY transactionDate ASC
        ) AS overall,
        (
            SELECT supplier.supplierName
            FROM ms_product AS p LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = p.supplierID
            WHERE productID = stock.productID
        ) AS supplierName,
        UNIX_TIMESTAMP(transactionDate) AS unixTimeStamp
        FROM tr_stockcard AS stock
        LEFT JOIN tr_goodsreceipthead AS GR ON GR.goodsReceiptNum = stock.refNum
        LEFT JOIN ms_productdetail AS product ON product.productID = stock.productID
        LEFT JOIN ms_uom AS uom ON uom.uomID = product.uomID
        WHERE ".($id ? "stock.productID = $id AND " : "")."stock.refNum LIKE 'QJA/GR%' AND transactionDate LIKE '$year%';";
        
        $stockOut = "SELECT 'out' AS flow, DAY(stock.transactionDate) AS day, MONTH(stock.transactionDate) AS month,
        stock.transactionDate, stock.batchNumber, stock.outQty, GD.refNum AS noDO, uom.uomName,
        (
            SELECT SUM(inQty - outQty) FROM tr_stockcard
            WHERE productID = stock.productID AND transactionDate <= stock.transactionDate
            ORDER BY transactionDate ASC
        ) AS overall,
        (
            SELECT customer.customerName
            FROM tr_salesorderhead AS so LEFT JOIN ms_customer AS customer ON customer.customerID = so.customerID
            WHERE so.salesOrderNum = GD.refNum
        ) AS customerName,
        UNIX_TIMESTAMP(transactionDate) AS unixTimeStamp
        FROM tr_stockcard AS stock
        LEFT JOIN tr_goodsdeliveryhead AS GD ON GD.goodsDeliveryNum = stock.refNum
        LEFT JOIN ms_productdetail AS product ON product.productID = stock.productID
        LEFT JOIN ms_uom AS uom ON uom.uomID = product.uomID
        WHERE ".($id ? "stock.productID = $id AND " : "")."stock.refNum LIKE 'QJA/GD%' AND transactionDate LIKE '$year%';";
        
        $connection = MdlDb::getDbConnection();
        
        $modelIn = $connection->createCommand($stockIn)->queryAll();
        $modelOut = $connection->createCommand($stockOut)->queryAll();
        $models = ArrayHelper::merge($modelIn, $modelOut);
        $models2 = usort($models, function($first,$second){
            return $first['unixTimeStamp'] > $second['unixTimeStamp'];
        });
        
        $productName = $connection->createCommand("SELECT productName FROM ms_product WHERE productID = $id")
            ->queryOne()['productName'];
        
        $phpExcel = new \PHPExcel();
        $phpExcel->setActiveSheetIndex(0);
        $xSheet = $phpExcel->getActiveSheet();
        
        $xSheet->getRowDimension('2')->setRowHeight(30);
        
        $xDrawing = new PHPExcel_Worksheet_Drawing();
        $xDrawing->setName('Thumb');
        $xDrawing->setDescription('Thumbnail Image');
        $xDrawing->setPath(Yii::$app->basePath . '/assets_b/images/image.jpg');
        $xDrawing->setWidth(75);
        $xDrawing->setCoordinates('A1');
        //$xDrawing->setOffsetX(82);
        $xDrawing->setWorksheet($phpExcel->getActiveSheet());
        
        $xSheet->setTitle('Kartu Persediaan Barang')
            ->setCellValue('B2', 'PT. Qwinjaya Aditama')
            ->setCellValue('A4', 'Kartu Persediaan Barang')
            ->setCellValue('A5', "Nama Barang : $productName")
            ->setCellValue('J5', "Tahun : $year")
            //Set Table Header
            ->setCellValue('A6', 'Tgl/Bln')
            ->setCellValue('B6', 'No. PO')
            ->setCellValue('C6', 'Pemasok')
            ->setCellValue('D6', 'No. Batch')
            ->setCellValue('E6', 'Masuk')
            ->setCellValue('F6', 'Tgl/Bln')
            ->setCellValue('G6', 'No. DO')
            ->setCellValue('H6', 'Pelanggan')
            ->setCellValue('I6', 'No. Batch')
            ->setCellValue('J6', 'Keluar')
            ->setCellValue('K6', 'Sisa');
        
        $xSheet->getColumnDimension('A')->setWidth(12.71);
        $xSheet->getColumnDimension('B')->setWidth(15.71);
        $xSheet->getColumnDimension('C')->setWidth(28.71);
        $xSheet->getColumnDimension('D')->setWidth(18.71);
        $xSheet->getColumnDimension('E')->setWidth(12.71);
        $xSheet->getColumnDimension('F')->setWidth(10.71);
        $xSheet->getColumnDimension('G')->setWidth(15.71);
        $xSheet->getColumnDimension('H')->setWidth(28.71);
        $xSheet->getColumnDimension('I')->setWidth(18.71);
        $xSheet->getColumnDimension('J')->setWidth(12.71);
        $xSheet->getColumnDimension('K')->setWidth(12.71); 
        
        $xSheet->getRowDimension('2')->setRowHeight(30);
        $xSheet->getRowDimension('4')->setRowHeight(27);
        $xSheet->getRowDimension('5')->setRowHeight(28);
        $xSheet->getRowDimension('6')->setRowHeight(20);
        $xSheet->mergeCells('A4:K4');
        
        $xSheet->getStyle('B2')->applyFromArray(XFormatter::$companyTitle);
        $xSheet->getStyle('A4')->applyFromArray(XFormatter::$title);
        $xSheet->getStyle('A5')->applyFromArray(XFormatter::$parameter);
        $xSheet->getStyle('J5')->applyFromArray(XFormatter::$parameter);
        $xSheet->getStyle('A6:K6')->applyFromArray(XFormatter::$tableHeader);
        
        //sort($models);
        //Yii::$app->response->format = 'json';
        //return $models;
        
        
        $row=7;
        foreach ($models as $model)
        {
            if ($model['flow'] == 'in')
            {
                $xSheet->setCellValue('A'.$row, $model['day'].'/'.$model['month']); 
                $xSheet->setCellValue('B'.$row, $model['noPO']);
                $xSheet->setCellValue('C'.$row, $model['supplierName']);
                $xSheet->setCellValue('D'.$row, $model['batchNumber']);
                $xSheet->setCellValue('E'.$row, $model['inQty'].' '.$model['uomName']);
            } else
            {
                $xSheet->setCellValue('F'.$row, $model['day'].'/'.$model['month']); 
                $xSheet->setCellValue('G'.$row, $model['noDO']);
                $xSheet->setCellValue('H'.$row, $model['customerName']);
                $xSheet->setCellValue('I'.$row, $model['batchNumber']);
                $xSheet->setCellValue('J'.$row, $model['outQty'].' '.$model['uomName']);
            }
            
            $xSheet->setCellValue('K'.$row, $model['overall'].' '.$model['uomName']);
            
            $row++;
        }
        $row -= 1;
        
        $xSheet->getStyle('A7:K'.$row)->applyFromArray(XFormatter::$alignCenter);
        $xSheet->getStyle('E7:E'.$row)->applyFromArray(XFormatter::$alignRight);
        $xSheet->getStyle('J7:J'.$row)->applyFromArray(XFormatter::$alignRight);
        
        $xSheet->getStyle('A6:K'.$row)->applyFromArray(XFormatter::$allBorder);
        $xSheet->getStyle('F7:F'.$row)->applyFromArray(XFormatter::$borderLeftDouble);
        $xSheet->getStyle('K7:K'.$row)->applyFromArray(XFormatter::$borderLeftDouble);
        $xSheet->getStyle('A6:K6')->applyFromArray(XFormatter::$borderLineDouble);
        
        $xSheet->getStyle('A6:K'.$row)->applyFromArray(XFormatter::$borderOutline);
        
//        header('Content-Type: application/vnd.ms-excel');
//        $filename = "MyExcelReport_".date("d-m-Y-His").".xls";
//        header('Content-Disposition: attachment;filename='.$filename .' ');
//        header('Cache-Control: max-age=0');
//        
//        $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
//        $xWriter->save('php://output');
        
        
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
    
    public function actionPrintImportRealization ($monthYear, $month, $flag)
    {
        $year = explode('-', $monthYear)[1];
        
        $startDate = strtotime("01-$monthYear");
        $lastDayOfMonth = date('t', strtotime("01-$month-$year"));
        $endDate = strtotime("$lastDayOfMonth-$month");
        
        $startMonth = strtoupper(AppHelper::$monthsNameId[date('n',$startDate)]);
        $endMonth = strtoupper(AppHelper::$monthsNameId[date('n', $endDate)]);
        
//        var_dump(date('Y-m-d', $startDate));
//        var_dump(date('Y-m-d', $endDate));
//        die();
        
        $connection = MdlDb::getDbConnection();
        $query = "SELECT cost.lsNo, DATE_FORMAT(cost.lsDate, '%d-%m-%Y') as lsDate,cost.CIF, cost.FOB, cost.CNF,head.goodsReceiptNum, product.productName, receipt.hsCode, receipt.qty, uom.uomName, POD.price - POD.discount AS price, POH.currencyID,
        supplier.country, 'IDCGK' AS destinationPort, head.pibNumber, head.pibDate
        FROM tr_goodsreceiptdetail AS receipt
        LEFT JOIN ms_product AS product ON product.productID = receipt.productID
        LEFT JOIN ms_productdetail AS productDetail ON productDetail.productID = product.productID
        LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = product.productID
        LEFT JOIN ms_uom AS uom ON uom.uomID = productDetail.uomID
        LEFT JOIN tr_goodsreceipthead AS head ON head.goodsReceiptNum = receipt.goodsReceiptNum
        LEFT JOIN tr_purchaseorderdetail AS POD ON POD.purchaseOrderNum = head.refNum AND POD.productID = receipt.productID
        LEFT JOIN tr_purchaseorderhead AS POH ON POH.purchaseOrderNum = head.refNum
        LEFT JOIN tr_goodsreceiptcost AS cost ON cost.goodsReceiptNum = head.goodsReceiptNum
        WHERE head.goodsReceiptDate BETWEEN '".date('Y-m-d', $startDate)."' AND '".date('Y-m-d', $endDate)."'
        AND POH.isImport = 1 AND receipt.goodsReceiptNUM IN (SELECT refNum FROM tr_stockcard);";
        
        $models = $connection->createCommand($query)->queryAll();
        
        $phpExcel = new \PHPExcel();
        $phpExcel->setActiveSheetIndex(0);
        $xSheet = $phpExcel->getActiveSheet();
        
        if($flag == 2){
            $xSheet->setTitle('Laporan Realisasi Import')
                ->setCellValue('A1', 'LAPORAN REALISASI IMPORT API-U '.$year)->mergeCells('A1:P1')
                ->setCellValue('A2', "PERIODE $startMonth - $endMonth")->mergeCells('A2:P2')
                ->setCellValue('A3', "PT. QWINJAYA ADITAMA")->mergeCells('A3:P3')
                //Set Table Header
                ->setCellValue('A5', 'No')->mergeCells('A5:A6')
                ->setCellValue('B5', 'Uraian Barang')->mergeCells('B5:B6')
                ->setCellValue('C5', 'Pos Tarif/HS 10 Digit')->mergeCells('C5:C6')
                ->setCellValue('D5', 'Volume')->mergeCells('D5:D6')
                ->setCellValue('E5', 'Satuan')->mergeCells('E5:E6')
                ->setCellValue('F5', 'Hrg. Satuan')->mergeCells('F5:F6')
                ->setCellValue('G5', 'Kurs')->mergeCells('G5:G6')
                ->setCellValue('H5', 'Nilai CIF')->mergeCells('H5:H6')
                ->setCellValue('I5', 'Nilai FOB')->mergeCells('I5:I6')
                ->setCellValue('J5', 'Nilai CNF')->mergeCells('J5:J6')
                ->setCellValue('K5', 'Negara Asal')->mergeCells('K5:K6')
                ->setCellValue('L5', 'Pelabuhan Tujuan')->mergeCells('L5:L6')
                ->setCellValue('M5', 'L/S')->mergeCells('M5:N5')
                ->setCellValue('M6', 'No.')
                ->setCellValue('N6', 'Tgl.')
                ->setCellValue('O5', 'PIB')->mergeCells('O5:P5')
                ->setCellValue('O6', 'No.')
                ->setCellValue('P6', 'Tgl.');

            $xSheet->getStyle('A1:A3')->applyFromArray(XFormatter2::$title);
            $xSheet->getStyle('A5:P6')->applyFromArray(XFormatter2::$tableHeader);

            $xSheet->getRowDimension('5')->setRowHeight(30);
            $xSheet->getRowDimension('5')->setRowHeight(17);
            $xSheet->getRowDimension('6')->setRowHeight(17);
            $xSheet->getColumnDimension('A')->setWidth(5.71);
            $xSheet->getColumnDimension('B')->setWidth(40.71);
            $xSheet->getColumnDimension('C')->setWidth(25.71);
            $xSheet->getColumnDimension('D')->setWidth(10.71);
            $xSheet->getColumnDimension('E')->setWidth(10.71);
            $xSheet->getColumnDimension('F')->setWidth(15.71);
            $xSheet->getColumnDimension('G')->setWidth(7.71);
            $xSheet->getColumnDimension('H')->setWidth(15.71);
            $xSheet->getColumnDimension('I')->setWidth(20.71);
            $xSheet->getColumnDimension('J')->setWidth(15.71);
            $xSheet->getColumnDimension('K')->setWidth(15.71);
            $xSheet->getColumnDimension('L')->setWidth(18.71);
            $xSheet->getColumnDimension('M')->setWidth(15.71);
            $xSheet->getColumnDimension('N')->setWidth(15.71);
            $xSheet->getColumnDimension('O')->setWidth(20.71);
            $xSheet->getColumnDimension('P')->setWidth(20.71);

            $row=7;
            $initRow = $row;
            foreach ($models as $model)
            {
                $xSheet->setCellValue("A$row", $row - $initRow + 1); 
                $xSheet->setCellValue("B$row", $model['productName']);
                $xSheet->setCellValue("C$row", $model['hsCode']);
                $xSheet->setCellValue("D$row", $model['qty']);
                $xSheet->setCellValue("E$row", $model['uomName']);
                $xSheet->setCellValue("F$row", number_format($model['price'],0,",","."));
                $xSheet->setCellValue("G$row", $model['currencyID']);
                $xSheet->setCellValue("H$row", $model['CIF']);
                $xSheet->setCellValue("I$row", $model['FOB']);
                $xSheet->setCellValue("J$row", $model['CNF']);
                $xSheet->setCellValue("K$row", $model['country']);
                $xSheet->setCellValue("L$row", $model['destinationPort']);
                $xSheet->setCellValue("M$row", $model['lsNo']);
                $xSheet->setCellValue("N$row", $model['lsDate']);
                $xSheet->setCellValue("O$row", $model['pibNumber']);
                $xSheet->setCellValue("P$row", $model['pibDate']);

                $row++;
            }
            $row -= 1;

            $xSheet->getStyle("A$initRow:P$row")->applyFromArray(XFormatter2::$alignMiddle);
            $xSheet->getStyle("C$initRow:E$row")->applyFromArray(XFormatter2::$alignCenter);
            $xSheet->getStyle("G$initRow:G$row")->applyFromArray(XFormatter2::$alignCenter);
            $xSheet->getStyle("H$initRow:J$row")->applyFromArray(XFormatter2::$alignRight);
            $xSheet->getStyle("K$initRow:K$row")->applyFromArray(XFormatter2::$alignCenter);
            $xSheet->getStyle("M$initRow:P$row")->applyFromArray(XFormatter2::$alignCenter);
            $xSheet->getStyle("A5:P$row")->applyFromArray(XFormatter2::$allBorder);
            $xSheet->getRowDimension($row+3)->setRowHeight(73);
            $xSheet->setCellValue('N'.($row+3), 'PT. Qwinjaya Aditama');
            $xSheet->getStyle('N'.($row+3))->applyFromArray(XFormatter2::$footerAttribution);
            
           
            $xDrawing = new PHPExcel_Worksheet_Drawing();
            $xDrawing->setName('Thumb');
            $xDrawing->setDescription('Thumbnail Image');
            $xDrawing->setPath(Yii::$app->basePath . '/assets_b/images/logonew.png');
            $xDrawing->setWidth(90);
            $xDrawing->setCoordinates('M'.($row+3));
            $xDrawing->setOffsetX(12);
            $xDrawing->setWorksheet($phpExcel->getActiveSheet());

            $xSheet->getStyle('M'.($row+5).':P'.($row+5));
            
        } else {
            
            $xSheet->setTitle('Laporan Realisasi Import')
                ->setCellValue('A1', 'LAPORAN REALISASI IMPORT API-U '.$year)->mergeCells('A1:k1')
                ->setCellValue('A2', "PERIODE $startMonth - $endMonth")->mergeCells('A2:k2')
                ->setCellValue('A3', "PT. QWINJAYA ADITAMA")->mergeCells('A3:k3')
                //Set Table Header
                ->setCellValue('A5', 'No')->mergeCells('A5:A6')
                ->setCellValue('B5', 'Uraian Barang')->mergeCells('B5:B6')
                ->setCellValue('C5', 'Pos Tarif/HS 10 Digit')->mergeCells('C5:C6')
                ->setCellValue('D5', 'Volume')->mergeCells('D5:D6')
                ->setCellValue('E5', 'Satuan')->mergeCells('E5:E6')
                ->setCellValue('F5', 'Hrg. Satuan')->mergeCells('F5:F6')
                ->setCellValue('G5', 'Kurs')->mergeCells('G5:G6')
                ->setCellValue('H5', 'Negara Asal')->mergeCells('H5:H6')
                ->setCellValue('I5', 'Pelabuhan Tujuan')->mergeCells('I5:I6')
                ->setCellValue('J5', 'PIB')->mergeCells('J5:K5')
                ->setCellValue('J6', 'No.')
                ->setCellValue('K6', 'Tgl.');

            $xSheet->getStyle('A1:A3')->applyFromArray(XFormatter2::$title);
            $xSheet->getStyle('A5:K6')->applyFromArray(XFormatter2::$tableHeader);

            $xSheet->getRowDimension('5')->setRowHeight(30);
            $xSheet->getRowDimension('5')->setRowHeight(17);
            $xSheet->getRowDimension('6')->setRowHeight(17);
            $xSheet->getColumnDimension('A')->setWidth(5.71);
            $xSheet->getColumnDimension('B')->setWidth(40.71);
            $xSheet->getColumnDimension('C')->setWidth(25.71);
            $xSheet->getColumnDimension('D')->setWidth(10.71);
            $xSheet->getColumnDimension('E')->setWidth(10.71);
            $xSheet->getColumnDimension('F')->setWidth(15.71);
            $xSheet->getColumnDimension('G')->setWidth(7.71);
            $xSheet->getColumnDimension('H')->setWidth(15.71);
            $xSheet->getColumnDimension('I')->setWidth(25.71);
            $xSheet->getColumnDimension('J')->setWidth(20.71);
            $xSheet->getColumnDimension('K')->setWidth(20.71);
         
            $row=7;
            $initRow = $row;
            foreach ($models as $model)
            {
                $xSheet->setCellValue("A$row", $row - $initRow + 1); 
                $xSheet->setCellValue("B$row", $model['productName']);
                $xSheet->setCellValue("C$row", $model['hsCode']);
                $xSheet->setCellValue("D$row", $model['qty']);
                $xSheet->setCellValue("E$row", $model['uomName']);
                $xSheet->setCellValue("F$row", number_format($model['price'],0,",","."));
                $xSheet->setCellValue("G$row", $model['currencyID']);
                $xSheet->setCellValue("H$row", $model['country']);
                $xSheet->setCellValue("I$row", $model['destinationPort']);
                $xSheet->setCellValue("J$row", $model['pibNumber']);
                $xSheet->setCellValue("K$row", $model['pibDate']);

                $row++;
            }
            $row -= 1;

            $xSheet->getStyle("A$initRow:P$row")->applyFromArray(XFormatter2::$alignMiddle);
            $xSheet->getStyle("C$initRow:E$row")->applyFromArray(XFormatter2::$alignCenter);
            $xSheet->getStyle("G$initRow:G$row")->applyFromArray(XFormatter2::$alignCenter);
            $xSheet->getStyle("H$initRow:K$row")->applyFromArray(XFormatter2::$alignCenter);
            $xSheet->getStyle("F$row")->getNumberFormat()->setFormatCode('0.00'); 
            $xSheet->getStyle("A5:K$row")->applyFromArray(XFormatter2::$allBorder);

            $xSheet->getRowDimension($row+3)->setRowHeight(73);
            $xSheet->setCellValue('I'.($row+3), 'PT. Qwinjaya Aditama');
            $xSheet->getStyle('I'.($row+3))->applyFromArray(XFormatter2::$footerAttribution);
            
            $xDrawing = new PHPExcel_Worksheet_Drawing();
            $xDrawing->setName('Thumb');
            $xDrawing->setDescription('Thumbnail Image');
            $xDrawing->setPath(Yii::$app->basePath . '/assets_b/images/logonew.png');
            $xDrawing->setWidth(90);
            $xDrawing->setCoordinates('H'.($row+3));
            $xDrawing->setOffsetX(12);
            $xDrawing->setWorksheet($phpExcel->getActiveSheet());

            $xSheet->getStyle('H'.($row+5).':K'.($row+5));
        }
        
        
//        
//        header('Content-Type: application/vnd.ms-excel');
//        $filename = "Laporan Realisasi Import ".date("d-m-Y-His").".xls";
//        header('Content-Disposition: attachment;filename='.$filename .' ');
//        header('Cache-Control: max-age=0');
//        
//        $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
//        $xWriter->save('php://output');
//        
//        
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       // header('Content-Type: application/vnd.ms-excel');
        $filename = "Laporan Realisasi Import ".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        
        $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        ob_end_clean();
        $xWriter->save('php://output');
        die();
    }
    
    public function actionPrintLaporanOOT ($id, $monthYear)
    {
        $year = explode('-', $monthYear)[1];
        $strStartDate= strtotime("01-$monthYear");
        $lastDayOfMonth = date('t', $strStartDate);
        $startDate = date('Y-m-d', $strStartDate);
        $endDate = date('Y-m-d', strtotime("$lastDayOfMonth-$monthYear"));
        
   
        
        $connection = MdlDb::getDbConnection();
        $initialStockQuery = "SELECT 'initial' AS flow, stock.transactionDate,
        @qty:=(
            SELECT IFNULL(SUM(inQty - outQty), 0) FROM tr_stockcard
            WHERE productID = stock.productID AND batchNumber = stock.batchNumber AND transactionDate < '$startDate'
            GROUP BY batchNumber, manufactureDate, expiredDate
            ORDER BY transactionDate ASC
        ) AS saldoAwalBulan,
        stock.batchNumber AS batchAwal, supplier.supplierName, stock.expiredDate,
        0 AS inQty, 0 AS outQty, 0 AS saldoAkhir
        FROM tr_stockcard AS stock
        LEFT JOIN ms_product AS product ON product.productID = stock.productID
        LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = product.productID
        WHERE stock.productID = $id
        AND transactionDate < '$startDate'
        GROUP BY stock.batchNumber, stock.manufactureDate, stock.expiredDate
        HAVING @qty > 0;";
        
        $finalStockQuery = "SELECT 'final' AS flow, stock.transactionDate,
        @qty:=(
            SELECT IFNULL(SUM(inQty - outQty), 0) FROM tr_stockcard
            WHERE productID = stock.productID AND batchNumber = stock.batchNumber AND transactionDate < '$startDate'
            GROUP BY batchNumber, manufactureDate, expiredDate
            ORDER BY transactionDate ASC
        ) AS saldoAkhir,
        stock.batchNumber AS batchAkhir, supplier.supplierName, stock.expiredDate,
        0 AS inQty, 0 AS outQty, 0 AS saldoAwalBulan
        FROM tr_stockcard AS stock
        LEFT JOIN ms_product AS product ON product.productID = stock.productID
        LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = product.productID
        WHERE stock.productID = $id
        AND transactionDate < '$startDate'
        GROUP BY stock.batchNumber, stock.manufactureDate, stock.expiredDate
        HAVING @qty > 0;";
        
        $stockQuery = "SELECT IF(stock.refNum LIKE 'QJA/GR%', 'in', 'out') AS flow, stock.transactionDate, 0 AS saldoAwalBulan,
        supplier.supplierName, stock.inQty, stock.outQty, stock.batchNumber, stock.expiredDate,0 AS saldoAkhir,
        IF(stock.refNum LIKE 'QJA/GD%', customer.customerName, NULL) AS destination,
        IF(stock.refNum LIKE 'QJA/GR%', receipt.invoiceNum, delivery.invoiceNum) AS invoiceNum
        FROM tr_stockcard AS stock
        LEFT JOIN ms_product AS product ON product.productID = stock.productID
        LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = product.productID
        LEFT JOIN tr_goodsreceipthead AS receipt ON receipt.goodsReceiptNum = stock.refNum
        LEFT JOIN tr_goodsdeliveryhead AS delivery ON delivery.goodsdeliveryNum = stock.refNum
        LEFT JOIN tr_salesorderhead AS SO ON SO.salesOrderNum = delivery.refNum
        LEFT JOIN ms_customer AS customer ON customer.customerID = SO.customerID
        WHERE stock.productID = $id AND product.flagOOT = 1 AND stock.transactionDate BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'
        ORDER BY stock.batchNumber, stock.transactionDate ASC, stock.inQty;";
        
        $initialStocks = $connection->createCommand($initialStockQuery)->queryAll();
        $stockTransactions = $connection->createCommand($stockQuery)->queryAll();
        $finalStocks = $connection->createCommand($finalStockQuery)->queryAll();
        $models = ArrayHelper::merge($initialStocks, $stockTransactions);
        $models = ArrayHelper::merge($models, $finalStocks);
        
        //Yii::$app->response->format = 'json';
        //return $models;
        
        $phpExcel = new \PHPExcel();
        $phpExcel->setActiveSheetIndex(0);
        $xSheet = $phpExcel->getActiveSheet();
        $xSheet->setTitle('Laporan Stock OOT')
            //Set Table Header
            ->setCellValue('A1', 'tanggal')
            ->setCellValue('B1', 'saldoawal_bulan')
            ->setCellValue('C1', 'batch_awal')
            ->setCellValue('D1', 'no_faktur masuk')
            ->setCellValue('E1', 'sumber')
            ->setCellValue('F1', 'jum_masuk')
            ->setCellValue('G1', 'batch_masuk')
            ->setCellValue('H1', 'no_faktur keluar')
            ->setCellValue('I1', 'tujuan')
            ->setCellValue('J1', 'jum_keluar')
            ->setCellValue('K1', 'batch_keluar')
            ->setCellValue('L1', 'saldo_akhir')
            ->setCellValue('M1', 'batch_akhir')
            ->setCellValue('N1', 'expired');
        
        $xSheet->getColumnDimension('A')->setWidth(10.71);
        $xSheet->getColumnDimension('B')->setWidth(18.71);
        $xSheet->getColumnDimension('C')->setWidth(13.71);
        $xSheet->getColumnDimension('D')->setWidth(18.71);
        $xSheet->getColumnDimension('E')->setWidth(15.71);
        $xSheet->getColumnDimension('F')->setWidth(13.71);
        $xSheet->getColumnDimension('G')->setWidth(15.71);
        $xSheet->getColumnDimension('H')->setWidth(18.71);
        $xSheet->getColumnDimension('I')->setWidth(15.71);
        $xSheet->getColumnDimension('J')->setWidth(13.71);
        $xSheet->getColumnDimension('K')->setWidth(15.71);
        $xSheet->getColumnDimension('L')->setWidth(13.71);
        $xSheet->getColumnDimension('M')->setWidth(13.71);
        $xSheet->getColumnDimension('N')->setWidth(13.71);
        
        $row=2;
        $initRow = $row;
        foreach ($models as $model)
        {
            $xSheet->setCellValue('A'.$row, $model['transactionDate']); 
            $xSheet->setCellValue('B'.$row, $model['saldoAwalBulan']);
            $xSheet->setCellValue('F'.$row, $model['inQty']);
            $xSheet->setCellValue('J'.$row, $model['outQty']);
            $xSheet->setCellValue('L'.$row, $model['saldoAkhir']);
            $xSheet->setCellValue('N'.$row, $model['expiredDate']);
            
            if ($model['flow'] == 'initial')
            {
                $xSheet->setCellValue('C'.$row, $model['batchAwal']);
            } else if ($model['flow'] == 'in')
            {
                $xSheet->setCellValue('D'.$row, $model['invoiceNum']); 
                $xSheet->setCellValue('E'.$row, $model['supplierName']);
                $xSheet->setCellValue('G'.$row, $model['batchNumber']);
            } else if ($model['flow'] == 'out')
            {
                $xSheet->setCellValue('H'.$row, $model['invoiceNum']); 
                $xSheet->setCellValue('I'.$row, $model['destination']);
                $xSheet->setCellValue('K'.$row, $model['batchNumber']);
            } else if ($model['flow'] == 'final')
            {
                $xSheet->setCellValue('M'.$row, $model['batchAkhir']);
            }
            
            $row++;
        }
        $row -= 1;
        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Laporan Stock OOT ".date("d-m-Y H:i:s").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        
        $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        ob_end_clean();
        $xWriter->save('php://output');
        die();
    }
    
    function sortArrayByKey(&$array, $key, $string = false, $asc = true)
    {
        if ($string) {
            usort($array, function ($a, $b) use(&$key, &$asc) {
                if ($asc)
                    return strcmp(strtolower($a{$key}), strtolower($b{$key}));
                else
                    return strcmp(strtolower($b{$key}), strtolower($a{$key}));
            });
        }else {
            usort($array, function ($a, $b) use(&$key, &$asc) {
                if ($a[$key] == $b{$key}) {
                    return 0;
                }
                if ($asc)
                    return ($a{$key} < $b{$key}) ? -1 : 1;
                else
                    return ($a{$key} > $b{$key}) ? -1 : 1;
            });
        }
    }

}



