<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use app\components\MdlDb;
use yii\db\Expression;
use yii\data\SqlDataProvider;

/**
 * This is the model class for table "tr_goodsreceipthead".
 *
 * @property string $goodsReceiptNum
 * @property string $refNum
 * @property string $transType
 * @property string $goodsReceiptDate
 * @property string $deliveryNum
 * @property string $pibNumber
 * @property string $pibDate
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrGoodsreceiptheadhistory extends \yii\db\ActiveRecord
{
    public $getID;
    public $reference;
    public $from;
    public $refDate;
    public $goodsReceiptTime;
    public $goodsReceiptStatus;
    public $status;
    public $warehouseName;
    public $isImport;
    public $currency;
    public $rate;
    public $supplierID;
    public $taxTotal;
    public $grandTotal;
    public $advancePaymentNum;
    public $outstanding;
    public $joinGoodsReceiptDetail;
    public $joinHsCodeDetail;
    public $sources;
    public $transactionRefNum,$transactionDate,$originalRefNum;
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_goodsreceipthead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsReceiptNum', 'refNum', 'warehouseID', 'goodsReceiptDate', 'status'], 'required'],
            [['goodsReceiptTime', 'invoiceDate', 'AWBDate', 'pibDate', 'SKIDate', 'createdDate', 'editedDate','PPJK'], 'safe'],
            [['pibRate', 'pibAmount'], 'string'],
            [['goodsReceiptNum', 'refNum', 'transType', 'invoiceNum',  'SKINumber', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['deliveryNum', 'AWBNum', 'pibSubmitCode', 'pibNumber'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
            [['joinGoodsReceiptDetail','joinHsCodeDetail','sources', 'startDate', 'endDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goodsReceiptNum' => 'Goods Receipt Number',
            'refNum' => 'Reference Number',
            'transType' => 'Transaction Type',
            'from' => 'From',
            'goodsReceiptDate' => 'Goods Receipt Date',
            'goodsReceiptTime' => 'Goods Receipt Time',
            'deliveryNum' => 'Delivery Number',
            'AWBNum' => 'AWB Number',
            'AWBDate' => 'AWB Date',
            'SKINumber' => 'SKI Number',
            'SKIDate' => 'SKI Date',
            'warehouseID' => 'Warehouse',
            'warehouseName' => 'Warehouse',
            'PPJK' => 'PPJK / Courier',
            'pibNumber' => 'PIB Number',
            'pibDate' => 'PIB Date',
            'pibRate' => 'PIB Rate',
            'pibSubmitCode' => 'No Aju PIB',
            'pibAmount' => 'PIB Amount',
            'invoiceNum' => 'Invoice Number',
            'invoiceDate' => 'Invoice Date',
            'additionalInfo' => 'Additional Information',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'supplierID' => 'Supplier',
            'taxTotal' => 'Tax Total',
            'grandTotal' => 'Grand Total',
            'advancePaymentNum' => 'Total Advance Payment',
            'outstanding' => 'Outstanding',
            'status' => 'Status'
        ];
    }
    public function search($params)
    {
        $this->load($params); 
        $filterDate = '';
        $filterType = '';
        $filterSource = '';
        $filterStatus = '';

        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $filterDate = "AND DATE(a.goodsReceiptDate) >= '$start' AND DATE(a.goodsReceiptDate) <= '$end'";
        }
        if($this->transType)
        {
            $filterType = " and a.transType LIKE ('%" . $this->transType . "%')";
        }
        if($this->sources == NULL)
        {
            $filterSource = " and a.sources LIKE ('%" . $this->sources . "%')";
        }
        if($this->status == NULL || $this->status == '-')
        {
            $filterStatus = "";
        } elseif ($this->status == '0')
        {
            $filterStatus = "and a.status = '" . $this->status ."'";
        } elseif ($this->status == '1')
        {
            $filterStatus = " and a.status != '0'";
        }
        
        $sql = "select * from (
                    select distinct f.goodsReceiptNum AS import, a.goodsReceiptDate, a.goodsReceiptNum, a.transType, c.purchaseOrderNum, d.supplierName as sources, e.batchNumber, IFNULL(b.refNum,0) 'status' 
                    from tr_goodsreceipthead a
                    left join tr_journalhead b on b.refNum = a.goodsReceiptNum AND b.transactionType = 'Goods Receipt'
                    join tr_purchaseorderhead c on c.purchaseOrderNum = a.refNum
                    left join ms_supplier d on d.supplierID = c.supplierID
                    left join tr_goodsreceiptdetail e on e.goodsReceiptNum = a.goodsReceiptNum
                    left join tr_goodsreceiptcost f on f.goodsReceiptNum = a.goodsReceiptNum

                union
                select distinct f.goodsReceiptNum AS import, a.goodsReceiptDate, a.goodsReceiptNum, a.transType, c.salesReturnNum, d.customerName as sources, e.batchNumber, IFNULL(b.refNum,0) 'status' 
                from tr_goodsreceipthead a
                    left join tr_journalhead b on b.refNum = a.goodsReceiptNum
                    join tr_salesreturnhead c on c.salesReturnNum = a.refNum
                    left join ms_customer d on d.customerID = c.customerID
					left join tr_goodsreceiptdetail e on e.goodsReceiptNum = a.goodsReceiptNum
                    left join tr_goodsreceiptcost f on f.goodsReceiptNum = a.goodsReceiptNum
                    union
                select distinct f.goodsReceiptNum AS import, a.goodsReceiptDate, a.goodsReceiptNum, a.transType, c.stockTransferNum, d.warehouseName as sources, e.batchNumber, IFNULL(b.refNum,0) 'status' from tr_goodsreceipthead a
                    left join tr_journalhead b on b.refNum = a.goodsReceiptNum
                    join tr_stocktransferhead c on c.stockTransferNum = a.refNum
                    left join ms_warehouse d on d.warehouseID = c.sourceWarehouseID
					left join tr_goodsreceiptdetail e on e.goodsReceiptNum = a.goodsReceiptNum
                    left join tr_goodsreceiptcost f on f.goodsReceiptNum = a.goodsReceiptNum
                ) a  
                Where a.goodsReceiptNum LIKE ('%" . $this->goodsReceiptNum . "%') "
                .$filterDate
                .$filterType
                .$filterSource
                 .$filterStatus."GROUP BY a.goodsReceiptNum";
        
        $sqlCount = "select count(*) from (
                        select distinct a.goodsReceiptDate, a.goodsReceiptNum, a.transType, c.purchaseOrderNum, d.supplierName as sources, IFNULL(b.refNum,0) 'status' from tr_goodsreceipthead a
                        left join tr_journalhead b on b.refNum = a.goodsReceiptNum
                        join tr_purchaseorderhead c on c.purchaseOrderNum = a.refNum
                        left join ms_supplier d on d.supplierID = c.supplierID

                    union
                    select distinct a.goodsReceiptDate, a.goodsReceiptNum, a.transType, c.salesReturnNum, d.customerName as sources, IFNULL(b.refNum,0) 'status' from tr_goodsreceipthead a
                        left join tr_journalhead b on b.refNum = a.goodsReceiptNum
                        join tr_salesreturnhead c on c.salesReturnNum = a.refNum
                        left join ms_customer d on d.customerID = c.customerID

                        union
                    select distinct a.goodsReceiptDate, a.goodsReceiptNum, a.transType, c.stockTransferNum, d.warehouseName as sources, IFNULL(b.refNum,0) 'status' from tr_goodsreceipthead a
                        left join tr_journalhead b on b.refNum = a.goodsReceiptNum
                        join tr_stocktransferhead c on c.stockTransferNum = a.refNum
                        left join ms_warehouse d on d.warehouseID = c.sourceWarehouseID
                    ) a 
                    Where a.goodsReceiptNum LIKE ('%" . $this->goodsReceiptNum . "%')  "
                    .$filterDate
                    .$filterType
                    .$filterSource
                    .$filterStatus."GROUP BY a.goodsReceiptNum";
        
        $count = Yii::$app->db->createCommand($sqlCount)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'key' => 'goodsReceiptNum',
            'pagination' => [
                'pageSize' => 50
            ]
        ]);
        
        $dataProvider->setSort([
            'defaultOrder' => ['goodsReceiptDate' => SORT_DESC],
            'attributes' => [
                'goodsReceiptNum' => [
                    'asc' => ['goodsReceiptNum' => SORT_ASC],
                    'desc' => ['goodsReceiptNum' => SORT_DESC],
                ],
                'goodsReceiptDate' => [
                    'asc' => ['goodsReceiptDate' => SORT_ASC],
                    'desc' => ['goodsReceiptDate' => SORT_DESC],
                ],
                'transType' => [
                    'asc' => ['transType' => SORT_ASC],
                    'desc' => ['transType' => SORT_DESC],
                ],
                'sources' => [
                    'asc' => ['sources' => SORT_ASC],
                    'desc' => ['sources' => SORT_DESC],
                ],
                'status' => [
                    'asc' => ['Status' => SORT_ASC],
                    'desc' => ['Status' => SORT_DESC],
                ] 
            ]
        ]);
//        $query = self::find()
//            ->select('tr_goodsreceipthead.goodsReceiptNum, tr_goodsreceipthead.transType, tr_goodsreceipthead.goodsReceiptDate')
//            ->addSelect(new Expression('IFNULL(tr_journalhead.refNum,0) goodsReceiptStatus'))
//            ->joinWith('journal')
//            ->andFilterWhere(['like', 'tr_goodsreceipthead.goodsReceiptNum', $this->goodsReceiptNum])
//            ->andFilterWhere(['like', 'tr_goodsreceipthead.refNum', $this->refNum])
//            ->andFilterWhere(['like', 'tr_goodsreceipthead.transType', $this->transType])
//            ->andFilterWhere(['=', "DATE_FORMAT(tr_goodsreceipthead.goodsReceiptDate, '%d-%m-%Y')", $this->goodsReceiptDate]);

        return $dataProvider;
    }
    public function getJournal()
    {
        return $this->hasMany(TrJournalhead::className(), ['refNum' => 'goodsReceiptNum']);
    }
    public function getGoodsReceiptDetails()
    {
        return $this->hasMany(TrGoodsreceiptdetail::className(), ['goodsReceiptNum' => 'goodsReceiptNum']);
    }
    public function getPurchaseOrder()
    {
        return $this->hasOne(TrPurchaseorderhead::className(), ['purchaseOrderNum' => 'refNum']);
    }
    public function getSalesReturn()
    {
        return $this->hasOne(TrSalesreturnhead::className(), ['salesReturnNum' => 'refNum']);
    }
    public function getAdvancePayment()
    {
        return $this->hasOne(TrSupplieradvancepayment::className(), ['refNum' => 'refNum']);
    }
    public function getCurrency()
    {
        return $this->hasOne(MsCurrency::className(), ['currencyName' => 'currency']);
    }
    public function getWarehouse()
    {
        return $this->hasOne(MsWarehouse::className(), ['warehouseID' => 'warehouseID']);
    }
    public function afterFind(){
        parent::afterFind();
        $this->goodsReceiptDate = AppHelper::convertDateTimeFormat($this->goodsReceiptDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->invoiceDate = AppHelper::convertDateTimeFormat($this->invoiceDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->SKIDate = AppHelper::convertDateTimeFormat($this->SKIDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->joinGoodsReceiptDetail = [];
        $connection = MdlDb::getDbConnection();

        //if goods receipt is already in journal
        if($this->getJournal()->count() != 0){
            $this->status = 1;
            if($this->transType == "Purchase Order"){
                foreach ($this->getPurchaseOrder()->all() as $total) {
                    $this->rate = $total->rate;
                    $this->grandTotal = $total->grandTotal;
                    $this->supplierID = $total->supplierID;
                    $this->currency = $total->currencyID;
                    $this->isImport = $total->isImport;
                    
                }
            }
            else if($this->transType == "Sales Return"){
                foreach ($this->getSalesReturn()->all() as $total) {
                    $this->rate = "1,00";
                    $this->grandTotal = $total->grandTotal;
                    $this->currency = "IDR";
                    $this->isImport = 0;
                }
            }
            
            $this->advancePaymentNum = "0,00";
            if($this->getAdvancePayment()->all() > 0){
                foreach ($this->getAdvancePayment()->all() as $total) {
                    $this->advancePaymentNum = $total->amount / $this->rate;
                }
            }

            if($this->transType == "Purchase Order"){
                $sql = "SELECT a.goodsReceiptDetailID, b.invoiceDate, a.productID,d.productName,a.uomID,e.uomName,a.batchNumber,a.hsCode,a.manufactureDate,a.expiredDate,a.retestDate,a.qty,a.pack,f.packingTypeName,a.packQty,a.goodsCondition,c.price,c.discount,p.taxRate,c.subTotal
                    from tr_goodsreceiptdetail a join tr_goodsreceipthead b
                    on a.goodsReceiptNum=b.goodsReceiptNum
                    join tr_purchaseorderhead p
                    on b.refNum=p.purchaseOrderNum
                    join tr_purchaseorderdetail c 
                    on b.refNum=c.purchaseOrderNum and a.productID=c.productID
                    join ms_product d on a.productID=d.productID
                    left join ms_uom e on a.uomID=e.uomID
                    left join ms_packingtype f on a.pack=f.packingTypeID
                    where a.goodsReceiptNum='".$this->goodsReceiptNum."'";
            }
            else if($this->transType == "Sales Return"){
                $sql = "SELECT a.goodsReceiptDetailID, a.productID,d.productName,a.uomID,e.uomName,a.batchNumber,a.hsCode,a.manufactureDate,a.expiredDate,a.retestDate,a.qty,a.pack,f.packingTypeName,a.packQty,a.goodsCondition,c.HPP as price,'0,00' as discount,c.VAT as taxRate,c.totalAmount as subTotal
                    from tr_goodsreceiptdetail a join tr_goodsreceipthead b
                    on a.goodsReceiptNum=b.goodsReceiptNum
                    join tr_salesreturnhead p
                    on b.refNum=p.salesReturnNum
                    join tr_salesreturndetail c 
                    on b.refNum=c.salesReturnNum and a.productID=c.productID
                    join ms_product d on a.productID=d.productID
                    left join ms_uom e on a.uomID=e.uomID
                    left join ms_packingtype f on a.pack=f.packingTypeID
                    where a.goodsReceiptNum='".$this->goodsReceiptNum."'";
            }
            
            $temp = $connection->createCommand($sql);
            $headResult = $temp->queryAll();

            $i = 0;
            foreach ($headResult as $detailMenu) {
                
                
                $qtyOriginal = 0;

                if ($this->transType == "Purchase Order"){
                    $sqlOutstanding = "SELECT a.productID,sum(a.qty) as qtyOriginal from tr_purchaseorderdetail a
                                where a.purchaseOrderNum='".$this->refNum."' and a.productID='".$joinGoodsReceiptDetail['productID']."'
                                group by a.productID";
                }
                else if ($this->transType == "Sales Return"){
                    $sqlOutstanding = "SELECT a.productID,sum(a.qty) as qtyOriginal from tr_salesreturndetail a
                                where a.salesReturnNum='".$this->refNum."' and a.productID='".$joinGoodsReceiptDetail['productID']."'
                                group by a.productID";
                }
                else if ($this->transType == "Stock Transfer"){
                    $sqlOutstanding = "SELECT a.productID,sum(a.qtyTransfer) as qtyOriginal from tr_stocktransferdetail a
                                where a.stockTransferNum='".$this->refNum."' and a.productID='".$joinGoodsReceiptDetail['productID']."'
                                group by a.productID";
                }
                $connectionGoods = MdlDb::getDbConnection();
                $tempGoods = $connectionGoods->createCommand($sqlOutstanding);
                $goodsResult = $tempGoods->queryAll();
                if(sizeof($goodsResult) > 0){
                    $qtyOriginal = $goodsResult[0]['qtyOriginal'];
                }
                if($qtyOriginal - $joinGoodsReceiptDetail['qty'] >= 0){
                    $qtyOutstanding = $qtyOriginal - $joinGoodsReceiptDetail['qty'];
                }
                else
                    $qtyOutstanding = "0,00";
                
                $this->joinGoodsReceiptDetail[$i]["goodsReceiptDetailID"] = $detailMenu['goodsReceiptDetailID'];
                $this->joinGoodsReceiptDetail[$i]["productID"] = $detailMenu['productID'];
                $this->joinGoodsReceiptDetail[$i]["productName"] = $detailMenu['productName'];
                $this->joinGoodsReceiptDetail[$i]["uomID"] = $detailMenu['uomID'];
                $this->joinGoodsReceiptDetail[$i]["uomName"] = $detailMenu['uomName'];
                $this->joinGoodsReceiptDetail[$i]["qty"] = $qtyOutstanding;
                $this->joinGoodsReceiptDetail[$i]["qtyReceived"] = $detailMenu['qty'];
                $this->joinGoodsReceiptDetail[$i]["packID"] = $detailMenu['pack'];
                $this->joinGoodsReceiptDetail[$i]["packName"] = $detailMenu['packingTypeName'];
                $this->joinGoodsReceiptDetail[$i]["packQty"] = $detailMenu['packQty'];
                $this->joinGoodsReceiptDetail[$i]["batchNumber"] = $detailMenu['batchNumber'];
                $this->joinGoodsReceiptDetail[$i]["hsCode"] = $detailMenu['hsCode'];
                $this->joinGoodsReceiptDetail[$i]["manufactureDate"] = AppHelper::convertDateTimeFormat($detailMenu['manufactureDate'], 'Y-m-d H:i:s', 'd-m-Y');
                $this->joinGoodsReceiptDetail[$i]["expireDate"] = is_null($detailMenu['expiredDate'])? "":AppHelper::convertDateTimeFormat($detailMenu['expiredDate'], 'Y-m-d H:i:s', 'd-m-Y');
                $this->joinGoodsReceiptDetail[$i]["retestDate"] = is_null($detailMenu['retestDate'])? "":AppHelper::convertDateTimeFormat($detailMenu['retestDate'], 'Y-m-d H:i:s', 'd-m-Y');
                $this->joinGoodsReceiptDetail[$i]["condition"] = ($detailMenu['goodsCondition'] > 0 ? "checked" : "unchecked");
                $this->joinGoodsReceiptDetail[$i]["price"] = $detailMenu['price'];
                $this->joinGoodsReceiptDetail[$i]["discount"] = $detailMenu['discount'];
                $this->joinGoodsReceiptDetail[$i]["taxValue"] = $detailMenu['taxRate'];
                $this->joinGoodsReceiptDetail[$i]["tax"] = ($detailMenu['taxRate'] > 0 ? "checked" : "");
                $this->joinGoodsReceiptDetail[$i]["subTotal"] = $detailMenu['subTotal'];
                $i += 1;
            }
        }
        else{ //if goods receipt doesn't exist in journal yet
            $this->status = 0;
            $this->AWBDate = AppHelper::convertDateTimeFormat($this->AWBDate, 'Y-m-d H:i:s', 'd-m-Y');
            
            if ($this->transType == "Purchase Order"){
                $sql = "SELECT a.purchaseOrderDate,b.supplierName from tr_purchaseorderhead a
                        join ms_supplier b on a.supplierID=b.supplierID
                        where a.purchaseOrderNum='".$this->refNum."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sql);
                $headResult = $temp->queryAll();
                $this->refDate = date('d-m-Y');
                foreach ($headResult as $result) {
                    $this->from = $result['supplierName'];
                    $this->refDate = $result['purchaseOrderDate'];
                }
            }
            else if ($this->transType == "Sales Return"){
                $sql = "SELECT a.salesReturnDate,b.customerName from tr_salesreturnhead a
                        join ms_customer b on a.customerID=b.customerID
                        where a.salesReturnNum='".$this->refNum."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sql);
                $headResult = $temp->queryAll();
                $this->refDate = date('d-m-Y');
                foreach ($headResult as $result) {
                    $this->from = $result['customerName'];
                    $this->refDate = $result['salesReturnDate'];
                }
            }
            else if ($this->transType == "Stock Transfer"){
                $sql = "SELECT a.stockTransferDate,a.destinationWarehouseID,b.warehouseName from tr_stocktransferhead a
                        join ms_warehouse b on a.sourceWarehouseID=b.warehouseID
                        where a.stockTransferNum='".$this->refNum."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sql);
                $headResult = $temp->queryAll();
                $this->refDate = date('d-m-Y');
                foreach ($headResult as $result) {
                    $this->from = $result['warehouseName'];
                    $this->refDate = $result['stockTransferDate'];
                    $this->warehouseID = $result['destinationWarehouseID'];
                }
            }
            $sqlDetail = "SELECT a.goodsReceiptDetailID, a.productID,b.productName,a.batchNumber,a.hsCode,a.uomID,c.uomName,a.qty,a.pack,e.packingTypeName,a.packQty,a.manufactureDate,a.expiredDate,a.retestDate,a.goodsCondition from tr_goodsreceiptdetail a
                    join ms_product b on a.productID=b.productID
                    join ms_uom c on a.uomID=c.uomID
                    join ms_packingtype e on a.pack=e.packingTypeID
                    where a.goodsReceiptNum='".$this->goodsReceiptNum."'";
            $connection = MdlDb::getDbConnection();
            $temp = $connection->createCommand($sqlDetail);
            $detailResult = $temp->queryAll();

            $i = 0;
            foreach ($detailResult as $joinGoodsReceiptDetail) {
                $qtyOriginal = 0;

                if ($this->transType == "Purchase Order"){
                    $sqlOutstanding = "SELECT a.productID,sum(a.qty) as qtyOriginal from tr_purchaseorderdetail a
                                where a.purchaseOrderNum='".$this->refNum."' and a.productID='".$joinGoodsReceiptDetail['productID']."'
                                group by a.productID";
                }
                else if ($this->transType == "Sales Return"){
                    $sqlOutstanding = "SELECT a.productID,sum(a.qty) as qtyOriginal from tr_salesreturndetail a
                                where a.salesReturnNum='".$this->refNum."' and a.productID='".$joinGoodsReceiptDetail['productID']."'
                                group by a.productID";
                }
                else if ($this->transType == "Stock Transfer"){
                    $sqlOutstanding = "SELECT a.productID,sum(a.qtyTransfer) as qtyOriginal from tr_stocktransferdetail a
                                where a.stockTransferNum='".$this->refNum."' and a.productID='".$joinGoodsReceiptDetail['productID']."'
                                group by a.productID";
                }
                $connectionGoods = MdlDb::getDbConnection();
                $tempGoods = $connectionGoods->createCommand($sqlOutstanding);
                $goodsResult = $tempGoods->queryAll();
                if(sizeof($goodsResult) > 0){
                    $qtyOriginal = $goodsResult[0]['qtyOriginal'];
                }
                if($qtyOriginal - $joinGoodsReceiptDetail['qty'] >= 0){
                    $qtyOutstanding = $qtyOriginal - $joinGoodsReceiptDetail['qty'];
                }
                else
                    $qtyOutstanding = "0,00";
                
                $this->joinGoodsReceiptDetail[$i]["goodsReceiptDetailID"] = $joinGoodsReceiptDetail['goodsReceiptDetailID'];
                $this->joinGoodsReceiptDetail[$i]["productID"] = $joinGoodsReceiptDetail['productID'];
                $this->joinGoodsReceiptDetail[$i]["productName"] = $joinGoodsReceiptDetail['productName'];
                $this->joinGoodsReceiptDetail[$i]["uomID"] = $joinGoodsReceiptDetail['uomID'];
                $this->joinGoodsReceiptDetail[$i]["uomName"] = $joinGoodsReceiptDetail['uomName'];
                $this->joinGoodsReceiptDetail[$i]["qty"] = $qtyOriginal;
                $this->joinGoodsReceiptDetail[$i]["packID"] = $joinGoodsReceiptDetail['pack'];
                $this->joinGoodsReceiptDetail[$i]["packName"] = $joinGoodsReceiptDetail['packingTypeName'];
                $this->joinGoodsReceiptDetail[$i]["packQty"] = $joinGoodsReceiptDetail['packQty'];
                $this->joinGoodsReceiptDetail[$i]["qtyReceived"] = $joinGoodsReceiptDetail['qty'];
                $this->joinGoodsReceiptDetail[$i]["batchNumber"] = $joinGoodsReceiptDetail['batchNumber'];
                $this->joinGoodsReceiptDetail[$i]["hsCode"] = $joinGoodsReceiptDetail['hsCode'];
                $this->joinGoodsReceiptDetail[$i]["manufactureDate"] = AppHelper::convertDateTimeFormat($joinGoodsReceiptDetail['manufactureDate'], 'Y-m-d H:i:s', 'd-m-Y');
                $this->joinGoodsReceiptDetail[$i]["expireDate"] = is_null($joinGoodsReceiptDetail['expiredDate'])? "":AppHelper::convertDateTimeFormat($joinGoodsReceiptDetail['expiredDate'], 'Y-m-d H:i:s', 'd-m-Y');
                $this->joinGoodsReceiptDetail[$i]["retestDate"] = is_null($joinGoodsReceiptDetail['retestDate'])? "":AppHelper::convertDateTimeFormat($joinGoodsReceiptDetail['retestDate'], 'Y-m-d H:i:s', 'd-m-Y');
                $this->joinGoodsReceiptDetail[$i]["condition"] = $joinGoodsReceiptDetail['goodsCondition'] == 1? "checked" : "";

                $i += 1;
            }
        }
    }
}
