<?php
namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSetting;
use app\models\StockCard;
use app\models\TrGoodsdeliverydetail;
use app\models\TrGoodsdeliveryhead;
use app\models\TrGoodsreceiptdetail;
use app\models\TriWulanReport;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;


class TriwulanReportController extends MainController
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
     * Lists all TrSamplereceipthead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TriWulanReport;
        $model->load(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($model);
        }
        
        if (Yii::$app->request->post()) {
            $_report = Yii::$app->request->post('TriWulanReport');
            $year = $_report['year'];
            $periode = $_report['periode'];

            if(isset($_POST['btnPrint_PDF'])) {

                $url = Url::to(['triwulan-report/print-excel', 
                    'year' => $year, 
                    'periode' => $periode, 
                    ]);
                $redirectTo = Url::to(['triwulan-report/']);
                return "<script>
                            var newWindow = window.open('$url','name','height=600,width=1024');
                            if (window.focus) {
                                newWindow.focus();
                            }
                             window.location.href = '$redirectTo';
                        </script>";
            } 
        } 
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    
    public function actionPrintExcel($year, $periode){
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        if($periode == '1'){
            $periodeText = "JANUARI - MARET";
            $quartal = "01";
        }
        else if($periode == '2'){
            $periodeText = "APRIL - JUNI";
            $quartal = "04";
        }
        else if($periode == '3'){
            $periodeText = "JULI - SEPTEMBER";
            $quartal = "07";
        }
        else if($periode == '4'){
            $periodeText = "OKTOBER - DESEMBER";
            $quartal = "10";
        }

        $objPHPExcel = new PHPExcel();
        $sheet=0;
        $objPHPExcel->setActiveSheetIndex($sheet);    
        
        $companyAddress = MsSetting::findOne(['key1' => 'OfficeAddress']);
        $companyCity = MsSetting::findOne(['key1' => 'City']);
        $izinPBF = MsSetting::findOne(['key1' => 'IjinPedagangFarmasi']);
        $izinSIKA = MsSetting::findOne(['key1' => 'PharmacistNumber']);
        
        //<editor-fold defaultstate="collapsed" desc="HEADER">
        $objPHPExcel->getActiveSheet()->setTitle('Triwulan')
            ->setCellValue('A1', 'LAPORAN TRI WULAN PENDISTRIBUSIAN BAHAN OBAT')
            ->setCellValue('A2', 'PERIODE: '.$periodeText.' TAHUN '.$year)
            ->setCellValue('A3', 'PBF PT QWINJAYA ADITAMA')                
            ->setCellValue('A4', 'ALAMAT KANTOR, GUDANG, LABORATORIUM: '.$companyAddress->value1.', '.$companyCity->value1)
            ->setCellValue('A5', 'NOMOR IZIN PBF: '.$izinPBF->value1)
            ->setCellValue('A6', 'APOTEKER PENANGGUNG JAWAB / SIKA: '.$izinSIKA->value1)
            ->setCellValue('A9', 'Periode Triwulan')
            ->setCellValue('B9', 'Tahun Periode')
            ->setCellValue('C9', 'Nama Bahan Baku')
            ->setCellValue('D9', 'Nama Produsen')
            ->setCellValue('E9', 'Negara Produsen')
            ->setCellValue('F9', 'Stok Awal (kg)')
            ->setCellValue('G9', 'Pemasukan')
            ->setCellValue('N9', 'Pengeluaran')
            ->setCellValue('V9', 'Stok Akhir')
            ->setCellValue('G10', 'Sumber')
            ->setCellValue('G11', 'Impor')
            ->setCellValue('H11', 'PBF Lain')
            ->setCellValue('I10', 'No Faktur')
            ->setCellValue('J10', 'Tgl Masuk')
            ->setCellValue('K10', 'Batch Number')
            ->setCellValue('L10', 'Jumlah (kg)')
            ->setCellValue('M10', 'Tgl Kadaluarwa')
            ->setCellValue('N10', 'Nama Sarana')
            ->setCellValue('O10', 'Alamat Sarana')
            ->setCellValue('P10', 'Jenis Sarana')
            ->setCellValue('Q10', 'No Faktur')
            ->setCellValue('R10', 'Tgl Keluar')
            ->setCellValue('S10', 'Batch Number')
            ->setCellValue('T10', 'Jumlah (kg)')
            ->setCellValue('U10', 'Tgl Kadaluarsa');
        //</editor-fold>
        
        //<editor-fold defaultstate="collapsed" desc="CELLS FORMATTING">
        $objPHPExcel->getActiveSheet()->mergeCells('A1:V1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:V2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:V3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:V4');
        $objPHPExcel->getActiveSheet()->mergeCells('A5:V5');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:V6');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:A11');
        $objPHPExcel->getActiveSheet()->mergeCells('B9:B11');
        $objPHPExcel->getActiveSheet()->mergeCells('C9:C11');
        $objPHPExcel->getActiveSheet()->mergeCells('D9:D11');
        $objPHPExcel->getActiveSheet()->mergeCells('E9:E11');
        $objPHPExcel->getActiveSheet()->mergeCells('F9:F11');
        $objPHPExcel->getActiveSheet()->mergeCells('V9:V11');
        $objPHPExcel->getActiveSheet()->mergeCells('G9:M9');
        $objPHPExcel->getActiveSheet()->mergeCells('N9:U9');
        $objPHPExcel->getActiveSheet()->mergeCells('G10:H10');
        $objPHPExcel->getActiveSheet()->mergeCells('I10:I11');
        $objPHPExcel->getActiveSheet()->mergeCells('J10:J11');
        $objPHPExcel->getActiveSheet()->mergeCells('K10:K11');
        $objPHPExcel->getActiveSheet()->mergeCells('L10:L11');
        $objPHPExcel->getActiveSheet()->mergeCells('M10:M11');
        $objPHPExcel->getActiveSheet()->mergeCells('N10:N11');
        $objPHPExcel->getActiveSheet()->mergeCells('O10:O11');
        $objPHPExcel->getActiveSheet()->mergeCells('P10:P11');
        $objPHPExcel->getActiveSheet()->mergeCells('Q10:Q11');
        $objPHPExcel->getActiveSheet()->mergeCells('R10:R11');
        $objPHPExcel->getActiveSheet()->mergeCells('S10:S11');
        $objPHPExcel->getActiveSheet()->mergeCells('T10:T11');
        $objPHPExcel->getActiveSheet()->mergeCells('U10:U11');


        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font'  => array(
            'bold'  => true,
            'size'  => 12,
            
             )
        );
        
         $styles = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font'  => array(
            'size'  => 10,
            
             ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
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

        
        $objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray($style)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2:V2')->applyFromArray($style)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3:V3')->applyFromArray($style)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4:V4')->applyFromArray($style)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5:V5')->applyFromArray($style)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A6:V6')->applyFromArray($style)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A9:V9')->applyFromArray($style)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A10:V10')->applyFromArray($style)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A11:V11')->applyFromArray($style)->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth("15");
        //</editor-fold>

        
    
        $stockCards = StockCard::find()
            ->where("DATE(transactionDate) BETWEEN '$year-$quartal-01' AND LAST_DAY(DATE_ADD('$year-$quartal-01', INTERVAL 2 MONTH))")
            ->joinWith('product')
            ->orderBy("ms_product.productName, transactionDate")
            ->all();
        
        $receiptInvoices = [];
        $row=12;
        
        foreach ($stockCards as $sc)
        { 
           
            //<editor-fold defaultstate="collapsed" desc="FORMATTING">
            $objPHPExcel->getActiveSheet()->getStyle('A9:V'.$row)->getAlignment()->setWrapText(true); 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $periodeText); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $year)->getStyle('A9:V'.$row)->applyFromArray($styles);
            //</editor-fold>
            
            $receipt = null;
            $grQty = 0;
            $delivery = null;
            
            if (substr($sc->refNum, 4, 2) == 'GR')
            {
                $delivered = TrGoodsdeliverydetail::find()
                    ->select('tr_goodsdeliveryhead.goodsDeliveryDate')
                    ->joinWith('goodsDeliveryHead')
                    ->where([
                        'productID' => $sc->productID, 
                        'batchNumber' => $sc->batchNumber
                    ])
                    ->andWhere("(DATE(goodsDeliveryDate)) BETWEEN '$year-$quartal-01' AND LAST_DAY(DATE_ADD('$year-$quartal-01', INTERVAL 2 MONTH))")
                    ->andWhere("goodsDeliveryDate >= '".date('Y-m-d H:i:s', strtotime($sc->transactionDate))."'")
                    ->one();
               
                $dates = date('Y-m-d H:i:s', strtotime($sc->transactionDate));
                $stocks= StockCard::find()
                    ->where([
                        'productID' => $sc->productID, 
                        'batchNumber' => $sc->batchNumber
                    ])
                    ->Andwhere("transactionDate >  '$dates'")
                    ->one();
                $ref = $stocks['refNum'];
                //echo '<pre>',var_dump($delivered) , var_dump($sc->refNum) ,var_dump($delivered['goodsDeliveryDate']), '</pre>';
                if (!$delivered || $delivered == NULL)
                {
                    $receipt = TrGoodsreceiptdetail::find()
                        ->joinWith('goodsReceiptHead')
                        ->where([
                            'tr_goodsreceipthead.goodsReceiptNum' => $sc->refNum, 
                            'productID' => $sc->productID,
                            'batchNumber' => $sc->batchNumber,
							'qty' => $sc->inQty
                        ])->one();
                  
                    $one = 1;
                    $grQty = $receipt->qty;
                    //echo  $grQty;    
                } 
                /*elseif($delivered['goodsDeliveryDate'] && substr($ref, 4, 2) != 'GD'){
                    
                    $receipt = TrGoodsreceiptdetail::find()
                        ->joinWith('goodsReceiptHead')
                        ->where([
                            'tr_goodsreceipthead.goodsReceiptNum' => $sc->refNum, 
                            'productID' => $sc->productID,
                            'batchNumber' => $sc->batchNumber
                        ])->one();
                  
                    $grQty = $receipt->qty;
                }*/
            } else 
            {
                $delivery = TrGoodsdeliverydetail::findOne([
                    'goodsDeliveryNum' => $sc->refNum, 
                    'productID' => $sc->productID, 
                    'batchNumber' => $sc->batchNumber
                ]);
            
                $grs = TrGoodsdeliveryhead::getGoodsReceipt($sc->batchNumber, $delivery->qty, $delivery->goodsDeliveryHead->goodsDeliveryDate);
                if ($grs)
                {
                    $gr = $grs[0];
                    $num = $gr['refNum'];
                    $rDate = date('Y-m-d', strtotime($gr['goodsReceiptDate']));
                    
                    $receipt = TrGoodsreceiptdetail::find()
                    ->joinWith('goodsReceiptHead')
                    ->where([
                        'tr_goodsreceipthead.goodsReceiptNum' => $num, 
                        'productID' => $sc->productID,
                        'batchNumber' => $sc->batchNumber
                    ])
                    ->andWhere("(goodsReceiptDate) BETWEEN '$year-$quartal-01' AND LAST_DAY(DATE_ADD('$year-$quartal-01', INTERVAL 2 MONTH))")
                    ->one();
                    
                    if (
                        ($rDate >= "$year-$quartal-01") 
                        && ($rDate <= date('Y-m-t', strtotime("$year-$quartal-01 +2 months")))
                        && !in_array($num, $receiptInvoices)
                    ){
                        $grQty = $receipt->qty;
                       
                        $receiptInvoices[] = $num;
                    
                    } else {
                        $receipt = null;
                    }
                }
            }
            
            
            if ($receipt)
            {
                $transactionDate = date('Y-m-d H:i:s', strtotime(
                        StockCard::find()->select('transactionDate')->where(['refNum' => $receipt->goodsReceiptNum])->scalar()
                ));

                
            } else {
                $transactionDate = date('Y-m-d H:i:s', strtotime($sc->transactionDate));
               
            } 
            
          
            $startStock = StockCard::find()
                ->select(['SUM(inQty - outQty)'])
                ->where("transactionDate < '$transactionDate' AND batchNumber = '$sc->batchNumber' AND productID = '$sc->productID'" )
                ->scalar(); 
            
            $gr = $grs[0];
            $num = $gr['refNum'];
            $dataDetail = TrGoodsreceiptdetail::find()
                    ->joinWith('goodsReceiptHead')
                    ->where("tr_goodsreceipthead.goodsReceiptDate < '$transactionDate' AND batchNumber = '$sc->batchNumber' AND productID = '$sc->productID'" )
                    ->orderBy(['tr_goodsreceipthead.goodsReceiptDate' => SORT_DESC])
                    ->one();
            
            
             //echo '<pre>' , var_dump($sc->batchNumber), var_dump($dataDetail), '</pre>';
            
            if (!$startStock) {
                $startStock = 0;
            }
            
            
            $endStock = ($startStock + $grQty) - $delivery->qty;
            

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $sc->product->productName);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $sc->product->supplier->supplierName);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $sc->product->supplier->country);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $startStock );
            
            // <editor-fold defaultstate="collapsed" desc="RECEIPT IN">
            if ($receipt || $one)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $receipt->goodsReceiptHead->SKINumber);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $receipt->product->supplier->supplierName);
				//$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $receipt->goodsReceiptHead->supplierppjk->supplierName);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $receipt->goodsReceiptHead->invoiceNum);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $receipt->goodsReceiptHead->goodsReceiptDate);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $receipt->batchNumber);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $grQty);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $receipt->expiredDate);
                
                
                if(!$receipt){
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dataDetail->goodsReceiptHead->SKINumber);
				    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dataDetail->product->supplier->supplierName);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dataDetail->goodsReceiptHead->invoiceNum);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dataDetail->goodsReceiptHead->goodsReceiptDate);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dataDetail->batchNumber);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dataDetail->expiredDate);
                    
                }
            } elseif(!$receipt  && $startStock > 0){
                
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dataDetail->goodsReceiptHead->SKINumber);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dataDetail->product->supplier->supplierName);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dataDetail->goodsReceiptHead->invoiceNum);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $dataDetail->goodsReceiptHead->goodsReceiptDate);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dataDetail->batchNumber);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dataDetail->expiredDate);
      
                
            }
             //</editor-fold>
            
            // <editor-fold defaultstate="collapsed" desc="DELIVERY OUT">
            if ($delivery)
            {
                $d = $delivery;
                
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $d->goodsDeliveryHead->customerDetail->customer->customerName);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $d->goodsDeliveryHead->customerDetail->street);
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $d->goodsDeliveryHead->customerDetail->addressType);
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $d->goodsDeliveryNum);
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $d->goodsDeliveryHead->goodsDeliveryDate);
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $d->batchNumber);
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $d->qty);
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $d->expiredDate);

                //<editor-fold defaultstate="collapsed" desc="FORMATTING">
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleLeft);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleRight);
                //</editor-fold>
            }
            //</editor-fold>
            
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $endStock);
            
            if ($delivery || $receipt) $row++ ;
        }
        $row3 = $row + 2;
        $row8 = $row + 8;
        $row9 = $row + 9;
		$row10 = $row + 10;
        $dateNow = date("d-M-Y");
        
        $pharmacistNumber = AppHelper::getSetting('PharmacistNumber', 'Pharmacist Number');
        $pharmacistName = AppHelper::getSetting('PharmacistName', 'Pharmacist Name');
        $companyDirector =  AppHelper::getSetting('CompanyDirector', 'Company Director');
       
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row3 , 'Penanggung Jawab');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row8, $pharmacistName);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row9, $pharmacistNumber);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row9, '#This is Computer Generated Quotation and Signature is not Required');
       
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row3 , 'Jakarta, '.$dateNow);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row8, $companyDirector);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row9, 'Direktur Utama');
        //die();
        //<editor-fold defaultstate="collapsed" desc="RESPONSE">
        header('Content-Type: application/vnd.ms-excel');
        
        $filename = "Triwulan".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');       
        //</editor-fold>
        die();
        
    }
    
    public function actionTest()
    {
        
    }
}




