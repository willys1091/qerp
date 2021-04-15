<?php

namespace app\models;

use app\components\AppHelper;
use app\components\ExcelFormatter;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "stock_card".
 *
 * @property string $ID
 * @property string $refNum
 * @property string $transactionDate
 * @property integer $productID
 * @property integer $warehouseID

 * @property string $inQty
 * @property string $outQty
 * @property integer $flagStatus
 */
class StockCard extends \yii\db\ActiveRecord
{
    public $expiredOrRetestDate;
    public $productName;
    public $warehouseName;
    public $startDate, $endDate, $invoiceNum;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_stockcard';
    }

    /**
     * @inheritdoc
     */
    

    public function rules()
    {
        return [
            [['refNum', 'transactionDate', 'productID', 'warehouseID', 'inQty', 'outQty', 'flagStatus'], 'required'],
            [['inQty', 'outQty'], 'number'],
            [['transactionDate','manufactureDate','expiredDate','retestDate', 'expiredOrRetestDate','productName','startDate', 'endDate','invoiceNum'], 'safe'],
            [['productID', 'warehouseID'], 'integer'],
            [['refNum'], 'string', 'max' => 50],
            [['batchNumber'], 'string', 'max' => 100],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['warehouseID'], 'exist', 'skipOnError' => true, 'targetClass' => MsWarehouse::className(), 'targetAttribute' => ['warehouseID' => 'warehouseID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'refNum' => 'Reference Number',
            'batchNumber' => 'Batch Number',
            'transactionDate' => 'Transaction Date',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'expiredOrRetestDate' => 'Expired / Retest Date',
            'productID' => 'Product',
            'warehouseID' => 'Warehouse',
            
            'inQty' => 'Qty In',
            'outQty' => 'Qty Out',
            'flagStatus' => 'Flag Status',
        ];
    }
    public function getParentProduct(){
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
    
    public function getProduct()
    {
        return $this->getParentProduct();
    }
    
    
    public function getParentGoodsreceipt(){
        return $this->hasOne(TrGoodsreceipthead::className(), ['goodsReceiptNum' => 'refNum']);
    }
    
    public function getParentGoodsdelivery(){
        return $this->hasOne(TrGoodsdeliveryhead::className(), ['goodsDeliveryNum' => 'refNum']);
    }
    
    public function getParentProductDetail(){
        return $this->hasOne(MsProductdetail::className(), ['productID' => 'productID']);
    }
    
    public function getParentUom(){
        return $this->hasOne(MsUom::className(), ['uomID' => 'productID']);
    }
    public function search($filter,$isDownload = false, $isDownloadPdf = false)
    {       
        $convertedDateFrom = AppHelper::convertDateTimeFormat($filter->startDate, 'd-m-Y', 'Y-m-d');
        $convertedDateTo = AppHelper::convertDateTimeFormat($filter->endDate, 'd-m-Y', 'Y-m-d'); 
        
         $query1 = self::find()
            ->select([new Expression("'-- Previous Balance --' AS refNum"),
                'transactionDate' =>  new Expression("'" . $filter->startDate  . "'"),
                'DATE_FORMAT(tr_goodsreceipthead.goodsReceiptDate, "%d-%m-%Y") AS goodsReceiptDate',
                'DATE_FORMAT(tr_goodsdeliveryhead.goodsDeliveryDate, "%d-%m-%Y") AS goodsDeliveryDate' ,
                'DATE_FORMAT(tr_stockcard.expiredDate, "%d-%m-%Y") AS expiredReceipt' ,
                'DATE_FORMAT(tr_stockcard.expiredDate, "%d-%m-%Y") AS expiredDelivery' ,
                'tr_stockcard.productID',
                'ms_warehouse.warehouseID',
                'ms_productcategory.productCategoryName',
                'ms_uom.uomName',
                'ms_product.productName',
                'ms_packingtype.packingTypeName',
                'tr_goodsreceipthead.refNum AS refNums',
                'ms_supplier.supplierName',
                'ms_supplier.country',
                'tr_goodsdeliveryhead.invoiceNum',
                'tr_salesorderhead.customerOrderNum',
                'inQty' => new Expression('IFNULL((inQty),0)'),
                'outQty'=> new Expression('IFNULL((outQty),0)'),
                'balance'=> new Expression('IFNULL(SUM((inQty - outQty )),0)'),
                'tr_stockcard.batchNumber'])
            ->where(['=', 'tr_stockcard.productID', $filter->productID])
            ->andFilterWhere(['LIKE', 'ms_product.productName', $filter->productName])
            ->andFilterWhere(['=', 'tr_stockcard.warehouseID', $filter->warehouseID])
            ->andFilterWhere(['<', "DATE(transactionDate)", $convertedDateFrom])
            ->joinWith('parentProduct')
         
            ->joinWith('parentProduct.supplier')
            ->joinWith('parentProduct.parentCategory')
            ->joinWith('parentProductDetail.packingType')
            ->joinWith('parentWarehouse')
            ->joinWith('parentGoodsreceipt')
            ->joinWith('parentGoodsdelivery')
            ->joinWith('parentGoodsdelivery.salesOrder')
            ->joinWith('parentProductDetail.uom')  ;
         
        $query2 = self::find()
            ->select(['tr_stockcard.refNum',
                'DATE_FORMAT(transactionDate, "%d-%m-%Y")',
                'DATE_FORMAT(tr_goodsreceipthead.goodsReceiptDate, "%d-%m-%Y") AS goodsReceiptDate' ,
                'DATE_FORMAT(tr_goodsdeliveryhead.goodsDeliveryDate, "%d-%m-%Y") AS goodsDeliveryDate' ,
                'DATE_FORMAT(tr_stockcard.expiredDate, "%d-%m-%Y") AS expiredReceipt' ,
                'DATE_FORMAT(tr_stockcard.expiredDate, "%d-%m-%Y") AS expiredDelivery' ,
                'tr_stockcard.productID',
                'ms_warehouse.warehouseID',
                'ms_productcategory.productCategoryName',
                'ms_uom.uomName',
                'ms_product.productName',
                'ms_packingtype.packingTypeName',
                'tr_goodsreceipthead.refNum AS refNums',
                'ms_supplier.supplierName',
                'ms_supplier.country',
                'tr_goodsdeliveryhead.invoiceNum',
                'tr_salesorderhead.customerOrderNum',
                'inQty' => new Expression('IFNULL(SUM((inQty)),0)'),
                'outQty'=> new Expression('IFNULL(SUM((outQty)),0)'),
                'balance'=> new Expression('IFNULL(SUM((inQty - outQty )),0)'),
                'tr_stockcard.batchNumber'])
          
            ->where(['=', 'tr_stockcard.productID', $filter->productID])
            ->andFilterWhere(['LIKE', 'ms_product.productName', $filter->productName])
            ->andFilterWhere(['=', 'tr_stockcard.warehouseID', $filter->warehouseID])
            ->andFilterWhere(['>=', "DATE(transactionDate)", $convertedDateFrom])
            ->andFilterWhere(['<=', "DATE(transactionDate)", $convertedDateTo])
            ->joinWith('parentProduct')
            ->joinWith('parentProduct.supplier')
            ->joinWith('parentProduct.parentCategory')
            ->joinWith('parentProductDetail.packingType')
            ->joinWith('parentWarehouse')
            ->joinWith('parentGoodsreceipt')
            ->joinWith('parentGoodsdelivery')
            ->joinWith('parentGoodsdelivery.salesOrder')
            ->joinWith('parentProductDetail.uom')
            ->groupBy(['transactionDate','refNum']);
       
        $unions = $query1->orderBy(['transactionDate' => SORT_DESC])->union($query2)->orderBy(['transactionDate' => SORT_DESC]);
        if (!$isDownload && !$isDownloadPdf) {
            $dataProvider = new ActiveDataProvider([
            'query' =>  $unions,//$filter->productName ? $unions : $query2,
            'sort' => [
                'defaultOrder' => ['transactionDate' => SORT_DESC],

                ],
                'pagination' => [
                    'pageSize' => 0
                ]
            ]);
        }
        
        if ($isDownloadPdf) {
            $dataProvider = $query1->orderBy(['transactionDate' => SORT_DESC])->union($query2)->orderBy(['transactionDate' => SORT_DESC])->all();
        }
        
        if ($isDownload) {
            $unions = (new Query)->from(['dummy_name' => $query1->union($query2)]);
            
            $phpExcel = new \PHPExcel();
            $sheet=0;
            $phpExcel->setActiveSheetIndex($sheet);
            $xSheet = $phpExcel->getActiveSheet();

            $xSheet->getColumnDimension('B')->setWidth(20);
            $xSheet->getColumnDimension('C')->setWidth(30);
            $xSheet->getColumnDimension('D')->setWidth(20);
            $xSheet->getColumnDimension('E')->setWidth(20);
            $xSheet->getColumnDimension('F')->setWidth(20);
            $xSheet->getColumnDimension('G')->setWidth(20);
            $xSheet->getColumnDimension('H')->setWidth(20);
            $xSheet->getColumnDimension('I')->setWidth(20);
            $xSheet->getColumnDimension('J')->setWidth(20);
            $xSheet->getColumnDimension('K')->setWidth(10);
           
            $phpExcel->getActiveSheet()->setTitle('Sales Report')
                ->setCellValue('C5', 'KARTU PERSEDIAAN BAHAN BAKU')
                ->setCellValue('B10', 'No Surat Pesanan')
                ->setCellValue('B6', 'Nama Bahan Baku')
                ->setCellValue('B7', 'Bentuk Sediaan')
                ->setCellValue('B8', 'Bentuk Kemasan')
                ->setCellValue('I6', 'Nama Pabrik Pembuat')
                ->setCellValue('I7', 'Satuan')
                ->setCellValue('I8', 'Tahun')
                ->setCellValue('D10', 'Penerimaan')
                ->setCellValue('C10', 'DO / Faktur Number')
                ->setCellValue('F10', 'Pengeluaran')
                ->setCellValue('D11', 'Tgl')
                ->setCellValue('E11', 'Jumlah')
                ->setCellValue('F11', 'Tgl')
                ->setCellValue('G11', 'Jumlah')
                ->setCellValue('H10', 'Sisa Persediaan')
                ->setCellValue('I10', 'Batch Number')
                ->setCellValue('J10', 'Exp.Date')
                ->setCellValue('K10', 'Paraf');

            $xSheet->mergeCells('C5:J5');
            $xSheet->mergeCells('C9:G9');
            $xSheet->mergeCells('D10:E10');
            $xSheet->mergeCells('F10:G10');
            $xSheet->mergeCells('H10:H11');
            $xSheet->mergeCells('B10:B11');
            $xSheet->mergeCells('C10:C11');
            $xSheet->mergeCells('I10:I11');
            $xSheet->mergeCells('J10:J11');
            $xSheet->mergeCells('K10:K11');
            
            //$xSheet->getStyle('B1')->applyFromArray(ExcelFormatter::$companyLogo);
            //Set Style Header Text
            $xSheet->getStyle('C5')->applyFromArray(ExcelFormatter::$companyTitle);
            $xSheet->getStyle('F9')->applyFromArray(ExcelFormatter::$title);

            //Set Table Header Style
            $xSheet->getStyle('B10:B11')->applyFromArray(ExcelFormatter::$tableHeader);
            $xSheet->getStyle('C10:C11')->applyFromArray(ExcelFormatter::$tableHeader);
            $xSheet->getStyle('D10:K10')->applyFromArray(ExcelFormatter::$tableHeader);

            $row=12;
            $total = 0;
            foreach ($unions->each() as $model) {
                if($model['customerOrderNum']){
                    $xSheet->setCellValue('B'.$row, $model['customerOrderNum']); 
                    
                } else {
                    $xSheet->setCellValue('B'.$row, $model['refNums']); 
                }
                $xSheet->setCellValue('C6', ':  '.$model['productName']);
                $xSheet->setCellValue('C7', ':  '.$model['productCategoryName']);
                $xSheet->setCellValue('C8', ':  '.$model['packingTypeName']);
                $xSheet->setCellValue('J6', ':  '.$model['supplierName']);
                $xSheet->setCellValue('J7', ':  '.$model['uomName']);
                $xSheet->setCellValue('J8', ':  '.date('Y'));
                $xSheet->setCellValue('C'.$row, $model['refNum']);
                $xSheet->setCellValue('D'.$row, $model['goodsReceiptDate']);
                $xSheet->setCellValue('E'.$row, $model['inQty']);
                $xSheet->setCellValue('I'.$row, $model['batchNumber']);
                $xSheet->setCellValue('F'.$row, $model['goodsDeliveryDate']);
                $xSheet->setCellValue('G'.$row, $model['outQty']);
                $xSheet->setCellValue('H'.$row, $total+=$model['inQty'] - $model['outQty']);
                if($model['expiredReceipt']){
                    $xSheet->setCellValue('J'.$row, $model['expiredReceipt']);
                } else {
                    $xSheet->setCellValue('J'.$row, $model['expiredDelivery']);
                }
               
                $xSheet->getStyle('B'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
                $xSheet->getStyle('C'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
                $xSheet->getStyle('D'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
                $xSheet->getStyle('E'.$row)->applyFromArray(ExcelFormatter::$alignRight);
                $xSheet->getStyle('F'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
                $xSheet->getStyle('G'.$row)->applyFromArray(ExcelFormatter::$alignRight);
                $xSheet->getStyle('H'.$row)->applyFromArray(ExcelFormatter::$alignRight);
                $xSheet->getStyle('J'.$row)->applyFromArray(ExcelFormatter::$alignCenter);
                $row++;
            }
            $xSheet->getStyle('K11:K11')->applyFromArray(ExcelFormatter::$tableHeader);
            $xSheet->getStyle('J11:J11')->applyFromArray(ExcelFormatter::$tableHeader);
            $xSheet->getStyle('I11:I11')->applyFromArray(ExcelFormatter::$tableHeader);
            $xSheet->getStyle('F11:G11')->applyFromArray(ExcelFormatter::$tableHeader);
            $xSheet->getStyle('D11:E11')->applyFromArray(ExcelFormatter::$tableHeader);
            $xSheet->getStyle('H11:H11')->applyFromArray(ExcelFormatter::$tableHeader);
            $xSheet->getStyle('B12:K'.($row-1))->applyFromArray(ExcelFormatter::$outerBorder);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
           // header('Content-Type: application/vnd.ms-excel');
            $filename = "Stock Card Report".date("d-m-Y-His").".xlsx";
            header('Content-Disposition: attachment;filename='.$filename .' ');
            header('Cache-Control: max-age=0');

            $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
            ob_end_clean();
            $xWriter->save('php://output');
            exit();
        }
        return $dataProvider;
    }

    public function searchStockMoreThreeMonth ()
    {
        $sql = "Se";


$dataProvider = new SqlDataProvider([
    'sql' => $sql,
    'key' => 'supplierID',
    'totalCount' => $count,
    'pagination' => [
        'pageSize' => 10
    ],
    
]);
return $dataProvider;
    }
   
    public function getParentWarehouse(){
        return $this->hasOne(MsWarehouse::className(), ['warehouseID' => 'warehouseID']);
    }
}
