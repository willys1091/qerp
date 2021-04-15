<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use app\components\MdlDb;
use yii\data\SqlDataProvider;

/**
 * This is the model class for table "tr_goodsdeliveryhead".
 *
 * @property string $goodsDeliveryNum
 * @property string $refNum
 * @property string $goodsDeliveryDate
 * @property string $deliveryNum
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrGoodsdeliveryhead extends \yii\db\ActiveRecord
{
    public $customerID;
    public $customerName;
    public $sendTo;
    public $joinGoodsDeliveryDetail;
    public $joinStockDetail;
    public $goodsDeliveryTime;
    public $status;
    public $HPP;
    public $filterDate;
    public $filterRefNum;
    public $filterTransType;
    public $filterpoNum;
    public $filterStatus;
    public $destination;
    public $filterTo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_goodsdeliveryhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsDeliveryNum', 'refNum', 'transType', 'goodsDeliveryDate', 'warehouseID'], 'required'],
            [['goodsDeliveryDate', 'goodsDeliveryTime', 'createdDate', 'editedDate','customerName', 'sendTo'], 'safe'],
            [['goodsDeliveryNum', 'refNum', 'invoiceNum', 'transType', 'shipmentBy', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['deliveryNum'], 'string', 'max' => 200],
            [['additionalInfo'], 'string', 'max' => 45],
            [['status'], 'string'],
            [['customerDetailID','deliveryStatus'], 'integer'],
            [['joinGoodsDeliveryDetail', 'joinStockDetail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goodsDeliveryNum' => 'Goods Delivery Number',
            'refNum' => 'Transaction Number',
            'invoiceNum' => 'Invoice Number',
            'poNum' => 'PO Number',
            'transType' => 'Transaction Type',
            'goodsDeliveryDate' => 'Goods Delivery Date',
            'goodsDeliveryTime' => 'Goods Delivery Time',
            'customerDetailID' => 'Delivery Address',
            'deliveryNum' => 'Delivery Number',
            'deliveryStatus' => 'Delivery Status',
            'shipmentBy' => 'Shipment By',
            'warehouseID' => 'Warehouse',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'sendTo' => 'Delivery to',
            'uomName' => 'Uom'
        ];
    }
    public function getGoodsDeliveryDetails()
    {
        return $this->hasMany(TrGoodsdeliverydetail::className(), ['goodsDeliveryNum' => 'goodsDeliveryNum']);
    }
    public function getSalesOrder()
    {
        return $this->hasOne(TrSalesorderhead::className(), ['salesOrderNum' => 'refNum']);
    }
    public function getCustomerPayment()
    {
        return $this->hasOne(TrCustomerpayment::className(), ['refNum' => 'goodsDeliveryNum']);
    }
    
    public function getCustomerDetail()
    {
        return $this->hasOne(MsCustomerdetail::className(), ['customerDetailID' => 'customerDetailID']);
    }
    
    public function search($params)
    {
        $this->load($params);
        if($this->refNum == NULL) {
            $filterRefNum = "";
        } else {
            $filterRefNum = $this->refNum;
        }
        if($this->goodsDeliveryDate == NULL) {
            $filterDate = "";
        } else {
            $filterDate = "AND a.goodsDeliveryDate = ". $this->goodsDeliveryDate;
        }
        if($this->transType == NULL) {
            $filterTransType = "";
        } else {
            $filterTransType = "AND a.transtype LIKE ('%" . $this->transType . "%')";
        }
        if($this->status == NULL) {
            $filterStatus = "";
        } else {
            $filterStatus = "AND a.status ='" .$this->status. "'";
        }
        
        if($this->destination == NULL) {
            $filterTo = "";
        } else {
            $filterTo = "AND a.destination LIKE ('%" . $this->destination . "%')";
        }

        $sql = "SELECT * FROM (
                    SELECT e.uomName, sd.qty, d.productName,d.origin, a.salesOrderNum AS refNum,a.customerOrderNum as poNum, b.invoiceNum,'Sales Order' as transType, b.goodsDeliveryDate, b.additionalInfo, 'Outstanding' as status, c.customerName as destination
                    FROM tr_salesorderhead a
                    JOIN tr_salesorderdetail sd on a.salesOrderNum = sd.salesOrderNum
                    LEFT JOIN tr_goodsdeliveryhead b on a.salesOrderNum = b.refNum
                    LEFT JOIN ms_customer c on c.customerID = a.customerID
                    LEFT JOIN ms_product d on d.productID = sd.productID
                    LEFT JOIN ms_uom e on e.uomID = sd.uomID
                    GROUP BY a.salesOrderNum
                    HAVING sum(sd.qty) > IFNULL((SELECT sum(gd.qty) FROM tr_goodsdeliveryhead b JOIN tr_goodsdeliverydetail gd ON b.goodsDeliveryNum = gd.goodsDeliveryNum WHERE b.refNum = a.salesOrderNum GROUP BY b.refNum),0)

                    -- UNION
                    -- SELECT e.uomName, sd.qty, d.productName,d.origin, a.purchaseReturnNum AS refNum,'' as poNum,b.invoiceNum ,'Purchase Return' as transType, b.goodsDeliveryDate, b.additionalInfo, 'Outstanding' as status, c.supplierName as destination
                    -- FROM tr_purchasereturnhead a
                    -- JOIN tr_purchasereturndetail sd on a.purchaseReturnNum = sd.purchaseReturnNum
                    -- LEFT JOIN tr_goodsdeliveryhead b on a.purchaseReturnNum = b.refNum
                    -- LEFT JOIN ms_supplier c on c.supplierID = a.supplierID
                    -- LEFT JOIN ms_product d on d.productID = sd.productID
                    -- LEFT JOIN ms_uom e on e.uomID = sd.uomID
                    -- GROUP BY a.purchaseReturnNum
                    -- HAVING sum(sd.qty) > IFNULL((SELECT sum(gd.qty) FROM tr_goodsdeliveryhead b JOIN tr_goodsdeliverydetail gd ON b.goodsDeliveryNum = gd.goodsDeliveryNum WHERE b.refNum = a.purchaseReturnNum GROUP BY b.refNum),0)

                    -- UNION
                    -- SELECT e.uomName, sd.qtyTransfer AS qty, d.productName,d.origin, a.stockTransferNum AS refNum,'' as poNum,b.invoiceNum,'Stock Transfer' as transType, b.goodsDeliveryDate, b.additionalInfo, 'Outstanding' as status, c.warehouseName as destination
                    -- FROM tr_stocktransferhead a
                    -- JOIN tr_stocktransferdetail sd on a.stockTransferNum = sd.stockTransferNum
                    -- LEFT JOIN tr_goodsdeliveryhead b on a.stockTransferNum = b.refNum
                    -- LEFT JOIN ms_warehouse c on c.warehouseID = a.destinationWarehouseID
                    -- LEFT JOIN ms_product d on d.productID = sd.productID
                    -- LEFT JOIN ms_uom e on e.uomID = sd.uomID
                    -- GROUP BY a.stockTransferNum
                    -- HAVING sum(sd.qtyTransfer) > IFNULL((SELECT sum(gd.qty) FROM tr_goodsdeliveryhead b JOIN tr_goodsdeliverydetail gd ON b.goodsDeliveryNum = gd.goodsDeliveryNum WHERE b.refNum = a.stockTransferNum GROUP BY b.refNum),0)
                ) a
                WHERE a.refNum LIKE '%". $filterRefNum ."%' 
                " .$filterDate. "
                " .$filterTransType. "
                " .$filterStatus . "
                " .$filterTo;
        
        $sqlCount = "SELECT COUNT(*) FROM (
                        SELECT d.productName,d.origin, a.salesOrderNum AS refNum, 'Sales Order' as transType, b.goodsDeliveryDate, b.additionalInfo, 'Outstanding' as status, c.customerName as destination
                        FROM tr_salesorderhead a
                        JOIN tr_salesorderdetail sd on a.salesOrderNum = sd.salesOrderNum
                        LEFT JOIN tr_goodsdeliveryhead b on a.salesOrderNum = b.refNum
                        LEFT JOIN ms_customer c on c.customerID = a.customerID
                        LEFT JOIN ms_product d on d.productID = sd.productID
                        GROUP BY a.salesOrderNum
                        HAVING sum(sd.qty) > IFNULL((SELECT sum(gd.qty) FROM tr_goodsdeliveryhead b JOIN tr_goodsdeliverydetail gd ON b.goodsDeliveryNum = gd.goodsDeliveryNum WHERE b.refNum = a.salesOrderNum GROUP BY b.refNum),0)

                        UNION
                        SELECT d.productName,d.origin, a.purchaseReturnNum AS refNum,'Purchase Return' as transType, b.goodsDeliveryDate, b.additionalInfo, 'Outstanding' as status, c.supplierName as destination
                        FROM tr_purchasereturnhead a
                        JOIN tr_purchasereturndetail sd on a.purchaseReturnNum = sd.purchaseReturnNum
                        LEFT JOIN tr_goodsdeliveryhead b on a.purchaseReturnNum = b.refNum
                        LEFT JOIN ms_supplier c on c.supplierID = a.supplierID
                        LEFT JOIN ms_product d on d.productID = sd.productID
                        GROUP BY a.purchaseReturnNum
                        HAVING sum(sd.qty) > IFNULL((SELECT sum(gd.qty) FROM tr_goodsdeliveryhead b JOIN tr_goodsdeliverydetail gd ON b.goodsDeliveryNum = gd.goodsDeliveryNum WHERE b.refNum = a.purchaseReturnNum GROUP BY b.refNum),0)

                        UNION
                        SELECT d.productName, d.origin, a.stockTransferNum AS refNum,'Stock Transfer' as transType, b.goodsDeliveryDate, b.additionalInfo, 'Outstanding' as status, c.warehouseName as destination
                        FROM tr_stocktransferhead a
                        JOIN tr_stocktransferdetail sd on a.stockTransferNum = sd.stockTransferNum
                        LEFT JOIN tr_goodsdeliveryhead b on a.stockTransferNum = b.refNum
                        LEFT JOIN ms_warehouse c on c.warehouseID = a.destinationWarehouseID
                        LEFT JOIN ms_product d on d.productID = sd.productID
                        GROUP BY a.stockTransferNum
                        HAVING sum(sd.qtyTransfer) > IFNULL((SELECT sum(gd.qty) FROM tr_goodsdeliveryhead b JOIN tr_goodsdeliverydetail gd ON b.goodsDeliveryNum = gd.goodsDeliveryNum WHERE b.refNum = a.stockTransferNum GROUP BY b.refNum),0)
                    ) a
                    WHERE a.refNum LIKE '%". $filterRefNum ."%' 
                    " .$filterDate. "
                    " .$filterTransType. "
                    " .$filterStatus. "
                    " .$filterTo;
        
        $count = Yii::$app->db->createCommand($sqlCount)->queryScalar();

    $dataProvider = new SqlDataProvider([
        'sql' => $sql,
        'totalCount' => $count,
        'key' => 'refNum',
        'pagination' => [
            'pageSize' => 10
        ]
    ]);
        
    $dataProvider->setSort([
        'defaultOrder' => ['refNum' => SORT_DESC],
        'attributes' => [
            'refNum' => [
                'asc' => ['refNum' => SORT_ASC],
                'desc' => ['refNum' => SORT_DESC],      
                'label' => 'refNum'
            ],
            'poNum' => [
                'asc' => ['poNum' => SORT_ASC],
                'desc' => ['poNum' => SORT_DESC],      
                'label' => 'poNum'
            ],      
            'transType' => [
                'asc' => ['transType' => SORT_ASC],
                'desc' => ['transType' => SORT_DESC],
                'label' => 'transType'
            ],
            'destination' => [
                'asc' => ['destination' => SORT_ASC],
                'desc' => ['destination' => SORT_DESC],
            ]
        ]
    ]);

        return $dataProvider;
    }
    public function searchBrowse()
    {
        $query = self::find()
            ->select('tr_goodsdeliveryhead.goodsDeliveryNum, tr_goodsdeliveryhead.goodsDeliveryDate, tr_goodsdeliveryhead.refNum')
            ->where('transType = "Sales Order"')
            ->andFilterWhere(['like', 'tr_goodsdeliveryhead.refNum', $this->refNum])
            ->andFilterWhere(['=', "DATE_FORMAT(tr_goodsdeliveryhead.goodsDeliveryDate, '%d-%m-%Y')", $this->goodsDeliveryDate]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['tr_goodsdeliveryhead.goodsDeliveryDate' => SORT_DESC],
                'attributes' => ['tr_goodsdeliveryhead.goodsDeliveryDate']
            ]
        ]);

        return $dataProvider;


    }
    
    public function afterFind(){
        parent::afterFind();

        $this->joinGoodsDeliveryDetail = [];
        $i = 0;
        $post =Yii::$app->request->get();
        if(count($post) > 0 && isset($post['id'])){
            $getID = $post['id'];
            $this->refNum = $getID;

            if (strpos($getID, 'SO') !== false){
                $sqlSales = "SELECT a.productID,b.productName,a.uomID,c.uomName,a.qty,d.packingTypeID,e.packingTypeName,d.uomQty from tr_salesorderdetail a
                    join ms_product b on a.productID=b.productID
                    join ms_productdetail d on b.productID=d.productID
                    join ms_uom c on a.uomID=c.uomID
                    join ms_packingtype e on d.packingTypeID=e.packingTypeID
                    where a.salesOrderNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlSales);
                $salesResult = $temp->queryAll();

                $modelSendTo = TrSalesorderhead::find()
                                    ->select('tr_salesorderhead.customerID, ms_customer.customerName')
                                    ->joinWith('customer')
                                    ->where(['salesOrderNum' => $getID])
                                    ->one();
                $this->customerID = $modelSendTo->customerID;
                $this->sendTo = $modelSendTo->customerName;

                // echo "<pre>";
                // var_dump($salesResult);
                // echo "</pre>";
                // yii::$app->end();
            }
            else if (strpos($getID, 'PR') !== false){
                $sqlSales = "SELECT a.productID,b.productName,d.uomID,c.uomName,SUM(a.qty) as qty,d.packingTypeID,e.packingTypeName,d.uomQty from tr_purchasereturndetail a
                    join ms_product b on a.productID=b.productID
                    join ms_productdetail d on b.productID=d.productID
                    join ms_uom c on a.uomID=c.uomID
                    join ms_packingtype e on d.packingTypeID=e.packingTypeID
                    where a.purchaseReturnNum='".$getID."'
                    group by a.productID";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlSales);
                $salesResult = $temp->queryAll();

                $modelSendTo = TrPurchasereturnhead::find()
                                    ->select('ms_supplier.supplierName')
                                    ->joinWith('supplier')
                                    ->where(['purchaseReturnNum' => $getID])
                                    ->one();
                $this->customerID = 0;
                $this->sendTo = $modelSendTo->supplierName;
            }
            else if (strpos($getID, 'ST') !== false){
                $sqlSales = "SELECT a.productID,b.productName,d.uomID,c.uomName,a.qtyTransfer as qty,d.packingTypeID,e.packingTypeName,d.uomQty from tr_stocktransferdetail a
                    join ms_product b on a.productID=b.productID
                    join ms_productdetail d on b.productID=d.productID
                    join ms_uom c on d.uomID=c.uomID
                    join ms_packingtype e on d.packingTypeID=e.packingTypeID
                    where a.stockTransferNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlSales);
                $salesResult = $temp->queryAll();

                $modelSendTo = TrStocktransferhead::find()
                                    ->select('ms_warehouse.warehouseName,tr_stocktransferhead.sourceWarehouseID')
                                    ->joinWith('destinationWarehouse')
                                    ->where(['stockTransferNum' => $getID])
                                    ->one();
                $this->customerID = 0;
                $this->sendTo = $modelSendTo->warehouseName;
                $this->warehouseID = $modelSendTo->sourceWarehouseID;
            }

            foreach ($salesResult as $joinGoodsReceiptDetail) {
                $manufactureDate = "";
                $expiredDate = "";
                $retestDate = "";
                $qtyGoods = 0;

                $sqlGoods = "SELECT g.productID,sum(g.qty) as qty from tr_goodsdeliveryhead a
                            join tr_goodsdeliverydetail g on a.goodsDeliveryNum=g.goodsDeliveryNum
                            where a.refNum='".$getID."' and g.productID='".$joinGoodsReceiptDetail['productID']."'
                            group by g.productID";
                $connectionGoods = MdlDb::getDbConnection();
                $tempGoods = $connectionGoods->createCommand($sqlGoods);
                $goodsResult = $tempGoods->queryAll();
                if(sizeof($goodsResult) > 0){
                    $qtyGoods = $goodsResult[0]['qty'];
                }
                if($joinGoodsReceiptDetail['qty']-$qtyGoods >= 0){
                    $qtyOutstanding = $joinGoodsReceiptDetail['qty']-$qtyGoods;
                }
                else
                    $qtyOutstanding = $joinGoodsReceiptDetail['qty']; 

                if (strpos($getID, 'ST') !== false){
                    $modelHPP = StockHPP::find()
                                ->where('warehouseID = :warehouseID',[':warehouseID' => $this->warehouseID])
                                ->andWhere('productID = :productID',[':productID' => $joinGoodsReceiptDetail['productID']])
                                ->orderBy('expiredDate DESC')
                                ->one();
                    $manufactureDate = AppHelper::convertDateTimeFormat($modelHPP->manufactureDate, 'Y-m-d H:i:s', 'd-m-Y');
                    $expiredDate = AppHelper::convertDateTimeFormat($modelHPP->expiredDate, 'Y-m-d H:i:s', 'd-m-Y');
                    $this->HPP = $modelHPP->HPP;
                }

                $this->joinGoodsDeliveryDetail[$i]["productID"] = $joinGoodsReceiptDetail['productID'];
                $this->joinGoodsDeliveryDetail[$i]["productName"] = $joinGoodsReceiptDetail['productName'];
                $this->joinGoodsDeliveryDetail[$i]["uomID"] = $joinGoodsReceiptDetail['uomID'];
                $this->joinGoodsDeliveryDetail[$i]["uomName"] = $joinGoodsReceiptDetail['uomName'];
                $this->joinGoodsDeliveryDetail[$i]["availableQty"] = "0,00";
                $this->joinGoodsDeliveryDetail[$i]["qtyOutstanding"] = $qtyOutstanding;
                $this->joinGoodsDeliveryDetail[$i]["packID"] = $joinGoodsReceiptDetail['packingTypeID'];
                $this->joinGoodsDeliveryDetail[$i]["packName"] = $joinGoodsReceiptDetail['packingTypeName'];
                $this->joinGoodsDeliveryDetail[$i]["packQty"] = $joinGoodsReceiptDetail['uomQty'];
                $this->joinGoodsDeliveryDetail[$i]["qty"] = "0,00";
                $this->joinGoodsDeliveryDetail[$i]["batchNumberID"] = "";
                $this->joinGoodsDeliveryDetail[$i]["batchNumber"] = "";
                $this->joinGoodsDeliveryDetail[$i]["manufactureDate"] = $manufactureDate;
                $this->joinGoodsDeliveryDetail[$i]["expiredDate"] = $expiredDate;
                $this->joinGoodsDeliveryDetail[$i]["retestDate"] = $retestDate;
                $this->joinGoodsDeliveryDetail[$i]['notes'] = '';
                
                $i += 1;
            }  
        }
    } 
    
    public static function getGoodsReceipt($batchNumber, $qty, $date)
    {
        $date = date('Y-m-d H:i:s', strtotime($date));
        
        //FIND SEMUA RECEIPT DENGAN BATCHNUBER
        $receipts =  TrGoodsreceiptdetail::find()
            ->select(['tr_goodsreceiptdetail.*'])
            ->joinWith('goodsReceiptHead')
            ->where(['batchNumber' => $batchNumber])
            ->all();
        //FIND SEMUA DELIVERY DENGAN $batchNumber dan SEBELUM TGL $date
        $deliveries =  TrGoodsdeliverydetail::find()
            ->select(['tr_goodsdeliverydetail.*'])
            ->joinWith('goodsDeliveryHead')
            ->where("(tr_goodsdeliveryhead.goodsDeliveryDate) < '$date' AND batchNumber = '$batchNumber' ")
            ->all();
        
        //ITERATE KE SETIAP RECEIPT
        foreach($deliveries as $delivery)
        {
            $qtyNeed = abs($delivery->qty);
            foreach ($receipts as $receipt)
            {
                $availableQty = $receipt->qty;
                if ($availableQty > 0)
                {
                    $receipt->qty = max(0, $availableQty - $qtyNeed);
                    $qtyNeed = max(0, $qtyNeed - $availableQty);
                }
                
                if ($qtyNeed == 0) break;
            }
        }
        
        
        //FIND GR
        $grs = [];
        $qtyNeed = abs($qty);
        foreach ($receipts as $receipt)
        {
            $availableQty = $receipt->qty;
            if ($availableQty > 0)
            {
                $receipt->qty = max(0, $availableQty - $qtyNeed);
                $qtyNeed = max(0, $qtyNeed - $availableQty);
                $receiptNum = $receipt->goodsReceiptNum;
                
                if (array_key_exists("$receiptNum", $grs))
                {
                     $grs["$receiptNum"]['qty'] = $grs["$receiptNum"]['qty'] + ($availableQty - $receipt->qty);
                } else 
                {
                    $grs["$receiptNum"] = [
                        'refNum' => $receiptNum,
                        'qty' => $availableQty - $receipt->qty,
                        'goodsReceiptDate' => $receipt->goodsReceiptHead->goodsReceiptDate,
                    ];
                }
            }

            if ($qtyNeed == 0) break;
        }
        
        return array_values($grs);
    }
    
}
