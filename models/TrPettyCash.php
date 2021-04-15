<?php

namespace app\models;

use app\components\AppHelper;
use app\components\ExcelFormatter;
use mPDF;
use PHPExcel_IOFactory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\Query;


/**
 * This is the model class for table "tr_petty_cash".
 *
 * @property string $pettyCashNum
 * @property string $pettyCashDate
 * @property string $voucher
 * @property string $notes
 * @property string $drAmount
 * @property string $crAmount
 */
class TrPettyCash extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $startDate, $endDate, $fileUpload, $balance;
    public static function tableName()
    {
        return 'tr_pettycash';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['pettyCashDate','startDate', 'endDate','drAmount', 'crAmount'], 'safe'],
            [[ 'voucher'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 255],
            [['pettyCashNum'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pettyCashNum' => 'Petty Cash Num',
            'pettyCashDate' => 'Petty Cash Date',
            'voucher' => 'Voucher',
            'notes' => 'Notes',
            'drAmount' => 'Debit',
            'crAmount' => 'Credit',
        ];
    }
    
    public function searchs()
    {
      
        $query = self::find();
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['pettyCashDate' => SORT_ASC],
                'attributes' => [
                    'pettyCashDate', 
                    'pettyCashNum', 
                    'voucher',
                    'notes',
                    'drAmount',
                    'crAmount'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
    
    public function search($filter,$isDownload = false)
    {       
        
        $convertedDateFrom = AppHelper::convertDateTimeFormat($filter->startDate, 'd-m-Y', 'Y-m-d');
        $convertedDateTo = AppHelper::convertDateTimeFormat($filter->endDate, 'd-m-Y', 'Y-m-d'); 
        
        $query1 = self::find()
            ->select(['pettyCashNum',
                new Expression("'' AS voucher"),
                'pettyCashDate' =>  new Expression("'" . $filter->startDate  . "'"),
                'notes' =>  new Expression("'-- Previous Balance -- '"),
                'drAmount' => new Expression('IFNULL(SUM(drAmount),0)'),
                'crAmount'=> new Expression('IFNULL(SUM(crAmount),0)'),
                'balance'=> new Expression('IFNULL(SUM(IFNULL((drAmount),0) - IFNULL((crAmount),0)),0)')])
            ->where(['<', "pettyCashDate", $convertedDateFrom]) ;
         
        $query2 = self::find()
            ->select(['pettyCashNum',
                'voucher',
                'DATE_FORMAT(pettyCashDate, "%d-%m-%Y")',
                'notes',
                'drAmount' => new Expression('IFNULL((drAmount),0)'),
                'crAmount'=> new Expression('IFNULL((crAmount),0)'),
                'balance'=> new Expression('IFNULL(SUM((drAmount - crAmount )),0)')])
            ->where(['>=', "DATE(pettyCashDate)", $convertedDateFrom])
            ->andFilterWhere(['<=', "DATE(pettyCashDate)", $convertedDateTo])
            ->groupBy(['pettyCashDate','voucher']);
       
        $unions = $query1->orderBy(['pettyCashDate' => SORT_DESC])->union($query2)->orderBy(['pettyCashDate' => SORT_DESC]);
        if (!$isDownload) {
            $dataProvider = new ActiveDataProvider([
            'query' =>  $unions,//$filter->productName ? $unions : $query2,
            'sort' => [
                'defaultOrder' => ['pettyCashDate' => SORT_DESC],

                ],
                'pagination' => [
                    'pageSize' => 0
                ]
            ]);
        }
        ////<editor-fold defaultstate="collapsed" desc="FORMATTING">
//        } else {
//            $unions = (new Query)->from(['dummy_name' => $query1->union($query2)]);
//            //<editor-fold defaultstate="collapsed" desc="FORMATTING">
////            $phpExcel = new \PHPExcel();
////            $sheet=0;
////            $phpExcel->setActiveSheetIndex($sheet);
////            $xSheet = $phpExcel->getActiveSheet();
////            $xSheet->getColumnDimension('A')->setWidth(5);
////            $xSheet->getColumnDimension('B')->setWidth(20);
////            $xSheet->getColumnDimension('C')->setWidth(30);
////            $xSheet->getColumnDimension('D')->setWidth(20);
////            $xSheet->getColumnDimension('E')->setWidth(20);
////            $xSheet->getColumnDimension('F')->setWidth(20);
////            $xSheet->getColumnDimension('G')->setWidth(20);
////           
////            $phpExcel->getActiveSheet()->setTitle('Petty Cash Report')
////                ->setCellValue('A1', 'PT.QWINJAYA ADITAMA')
////                ->setCellValue('A2', 'Bukti Pembayaran Kas')
////                ->setCellValue('G2', date('M-y'))
////                //Set Table Header
////                ->setCellValue('A3', 'No')
////                ->setCellValue('B3', 'Tanggal')
////                ->setCellValue('C3', 'Kode')
////                ->setCellValue('D3', 'Keterangan')
////                ->setCellValue('E3', 'Debit')
////                ->setCellValue('F3', 'Credit')
////                ->setCellValue('G3', 'Saldo')
////                ;
////            $xSheet->mergeCells('A1:B1');
////            $xSheet->mergeCells('A2:B2');
////           
////            //Set Table Header Style
////            $xSheet->getStyle('A3')->applyFromArray(ExcelFormatter::$tableHeader);
////            $xSheet->getStyle('B3')->applyFromArray(ExcelFormatter::$tableHeader);
////            $xSheet->getStyle('C3')->applyFromArray(ExcelFormatter::$tableHeader);
////            $xSheet->getStyle('D3')->applyFromArray(ExcelFormatter::$tableHeader);
////            $xSheet->getStyle('E3')->applyFromArray(ExcelFormatter::$tableHeader);
////            $xSheet->getStyle('F3')->applyFromArray(ExcelFormatter::$tableHeader);
////            $xSheet->getStyle('G3')->applyFromArray(ExcelFormatter::$tableHeader);
////            $xSheet->getStyle('G2')->applyFromArray(ExcelFormatter::$alignRight);
////            $row=4;
////            $total = 0;
////            $dTotal = 0;
////            $cTotal = 0; 
////            $no = 1;
////            foreach ($unions->each() as $model) {
////                $debit = number_format($model['drAmount'],0,",",".");
////                $credit = number_format($model['crAmount'],0,",",".");
////                $dTotal += $model['drAmount'];
////                $cTotal += $model['crAmount'];
////                
////                $total+=$model['drAmount'] - $model['crAmount'];
////               
////                $xSheet->setCellValue('A'.$row, $no);
////                $xSheet->setCellValue('B'.$row, $model['pettyCashDate']);
////                $xSheet->setCellValue('C'.$row, $model['voucher']);
////                $xSheet->setCellValue('D'.$row, $model['notes']);
////                $xSheet->setCellValue('E'.$row,'Rp. '.$debit);
////                $xSheet->setCellValue('F'.$row,'Rp. '.$credit);
////                $xSheet->setCellValue('G'.$row,'Rp. '.number_format($total,0,",","."));
////               
////                $xSheet->getStyle('A'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
////                $xSheet->getStyle('B'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
////                $xSheet->getStyle('C'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
////                $xSheet->getStyle('D'.$row)->applyFromArray(ExcelFormatter::$alignLeft);
////                $xSheet->getStyle('E'.$row)->applyFromArray(ExcelFormatter::$alignRight);
////                $xSheet->getStyle('F'.$row)->applyFromArray(ExcelFormatter::$alignRight);
////                $xSheet->getStyle('G'.$row)->applyFromArray(ExcelFormatter::$alignRight);
////                $row++;
////                $no++;
////            }
////           
////            $xSheet->setCellValue('E'.$row,'Rp. '.number_format($dTotal,0,",","."));
////            $xSheet->setCellValue('F'.$row,'Rp. '.number_format($cTotal,0,",","."));
////            $xSheet->setCellValue('G'.$row,'Rp. '.number_format($total,0,",","."));
////            $xSheet->getStyle('A'.$row.':G'.$row)->applyFromArray(ExcelFormatter::$tableHeader);
////            $xSheet->getStyle('A4:G'.($row-1))->applyFromArray(ExcelFormatter::$outerBorder);
////            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
////           // header('Content-Type: application/vnd.ms-excel');
////            $filename = "Daily PettyCash".date("d-m-Y-His").".xlsx";
////            header('Content-Disposition: attachment;filename='.$filename .' ');
////            header('Cache-Control: max-age=0');
////
////            $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
////            ob_end_clean();
////            $xWriter->save('php://output');
////            exit();
//                 //</editor-fold>
//           
//            
//            $query = self::find()
//            ->select(['pettyCashNum',
//                'voucher',
//                'DATE_FORMAT(pettyCashDate, "%d-%m-%Y")',
//                'notes',
//                'drAmount' => new Expression('IFNULL((drAmount),0)'),
//                'crAmount'=> new Expression('IFNULL((crAmount),0)'),
//                'balance'=> new Expression('IFNULL(SUM((drAmount - crAmount )),0)')])
//            ->where(['>=', "DATE(pettyCashDate)", $convertedDateFrom])
//            ->andFilterWhere(['<=', "DATE(pettyCashDate)", $convertedDateTo])
//            ->groupBy(['pettyCashDate','voucher'])
//            ->all();
//            
//           
//            $content = $this->render('report_payable',[
//                'model' => $query,
//            ]);
//          
//            
//            $mpdf = new mPDF;
//            $mpdf->WriteHTML($content);
//            $mpdf->Output('report_petty.pdf','I');
//            
//        }
         //</editor-fold>
        return $dataProvider;
    }
   
    
    
    
    
    public static function getPettyNum($pettyNum) {
  
        $model = self::find()->where(['voucher' => $pettyNum])->one();

        if (isset($model)) {
            $pettyNum = -1;
        }
     
        return $pettyNum;
    }
    
    public function saveUpload($inputFileName, &$counter, &$errMsg) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $lastID = 0;
            $lastName = '';

            for ($row = 2; $row <= $highestRow; ++$row) {
                $errVal = '';
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($rowData[0][1] != '') {
                // Tgl 
                    $tanggal = (!is_null($rowData[0][1]) ? $rowData[0][1] : "");  

                // PettyNum
                    $kode = -1;
                    $pettyNum = strval(!is_null($rowData[0][2]) ? $rowData[0][2] : "");
                    
                    if (strlen($pettyNum) > 3) {
                      
                        $kode = $this->getPettyNum($pettyNum);
                    
                    }

                    if ($kode == -1) {
                        $errVal .= Yii::t('app', 'Code is duplicate in your data, ');
                    }
                    
                // Tgl Lahir
                    $keterangan = (!is_null($rowData[0][3]) ? $rowData[0][3] : "");  
                    
                // Tgl Lahir
                    $debit = (!is_null($rowData[0][4]) ? $rowData[0][4] : "");  
                    
                // Tgl Lahir
                    $credit = (!is_null($rowData[0][5]) ? $rowData[0][5] : "");  
                   
                    if ($errVal == '') {
                     
                            $pettyModel = new TrPettyCash();
                            $pettyModel->pettyCashDate = AppHelper::convertDateTimeFormat($tanggal, 'd-m-Y', 'Y-m-d');
                            $pettyModel->voucher = $kode;
                            $pettyModel->notes = $keterangan;
                            $pettyModel->drAmount =str_replace(",",".",str_replace(".","",$debit));
                            $pettyModel->crAmount = str_replace(",",".",str_replace(".","",$credit));

                            if ($pettyModel->save()) {
                                $lastID = $pettyModel->pettyCashNum;
                            } else {
                                if ($errMsg == '') {
                                    $cRow = $row - 1;
                                    $errMsg = Yii::t('app', '- Excel Row ') . $cRow . ' ';
                                }
                                //$errMsg .= Yii::t('app', ' Failed to save product');
                                AppHelper::showVarDump($pettyModel->getErrors());
                                $errMsg .= $pettyModel->getErrors();
                            }
                        
                        $counter += 1;
                    } else {
                        $cRow = $row - 1;
                        $errMsg .= Yii::t('app', '- Excel Row ') . $cRow . " : " . $errVal . "<br>";
                    }
                }
            }

            if ($errMsg == '') {
                $transaction->commit();
            } else {
                $transaction->rollback();
            }
        } catch (Exception $ex) {
            $transaction->rollback();
            $errMsg = $ex->getMessage();
        }

        unlink($inputFileName);
        return true;
    }
}
