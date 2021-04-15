<?php

namespace app\models;

use app\components\AppHelper;
use app\components\MdlDb;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

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
class TrGoodsreceipthead extends ActiveRecord
{
    public $getID;
    public $reference;
    public $from;
    public $refDate;
    public $status;
    public $goodsReceiptTime;
    public $joinGoodsReceiptDetail;
    public $joinHsCodeDetail;
    public $sources, $hsCode, $productname, $shipment, $startDate, $endDate, $shipmentDate;
    public $transactionRefNum, $transactionDate, $originalRefNum, 
            $grandTotal, $advancedPaymentAmount, $previousPayment, $outstandingAmount, $total,$supplierID, $supplierName, $country, $officeNumber, $street;
    
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
            [['goodsReceiptNum', 'refNum', 'transType', 'warehouseID', 'goodsReceiptDate'], 'required'],
            [['goodsReceiptTime', 'AWBDate', 'createdDate', 'editedDate','sources','hsCode','productname','shipment', 'shipmentDate', 'supplierName', 'supplierID', 'transactionRefNum','transactionDate','originalRefNum'], 'safe'],
            [['PPJK'], 'integer'],
            [['goodsReceiptNum', 'refNum', 'transType', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['deliveryNum', 'AWBNum'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
            [['joinGoodsReceiptDetail', 'joinHsCodeDetail','startDate','endDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goodsReceiptNum' => 'Goods Receipt Number',
            'refNum' => 'Transaction Number',
            'transType' => 'Transaction Type',
            'from' => 'From',
            'refDate' => 'Transaction Date',
            'goodsReceiptDate' => 'Goods Receipt Date',
            'goodsReceiptTime' => 'Goods Receipt Time',
            'warehouseID' => 'Warehouse',
            'deliveryNum' => 'Delivery Number',
            'AWBNum' => 'AWB Number',
            'AWBDate' => 'AWB Date',
            'PPJK' => 'PPJK / Courier',
            'additionalInfo' => 'Additional Information',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'productname' => 'Product Name',
            'sources' => 'Supplier',
            'shipment' => 'Shipment Date',
            'country' => 'Country',
            'officeNumber' => 'OfficeNumber',
            'street' => 'Street',
            'total' => 'Payable Total',
            'supplierID' => 'Supplier Name'
        ];
    }
	
	public function search($params)
    {
        //joined table of Purchase Order, Sales Return, and Stock Transfer
        //display only when qty of refNum detail > qty of goods receipt detail
        $this->load($params);
       // var_dump($params);
        
        if($this->refNum == NULL){
            $refNum = "";
        } else {
            $refNum = $this->refNum;
        }
        if($this->transType == NULL) {
            $transType = "";                    
        } else { 
            $transType = "AND a.transType LIKE ('%" . $this->transType . "%')";
        }
        
        $filterSources = '';
        if($this->sources != NULL) $filterSources = " and a.sources LIKE ('%". $this->sources ."%')";
        
        $filterHsCode = '';
        if($this->hsCode != NULL) $filterHsCode = " and a.hsCode LIKE ('%". $this->hsCode ."%')";
        
        $filterProduct = '';
        if($this->productname != NULL) $filterProduct = " and a.productname LIKE ('%". $this->productname ."%')";
        
        
        $start = date('Y-m-d',strtotime($this->startDate));
        $end = date('Y-m-d',strtotime($this->endDate));
        $filterDate = '';
        if($this->endDate != NULL ) 
        $filterDate = " and a.shipment  >= '".$start."' AND a.shipment  <= '".$end."' ";
   
        $sql = "SELECT * FROM (
                SELECT pd.qty, uom.uomName, a.shipmentDate AS shipment, a.purchaseOrderNum AS refNum, COALESCE(d.transType,'Purchase Order') transType,GROUP_CONCAT(DISTINCT e.productname ORDER BY e.productname ASC SEPARATOR ', \n') AS productname, e.hsCode, a.createdDate as createdDate,d.warehouseID, c.supplierName as sources, a.revitionNotes as notes
                FROM tr_purchaseorderhead a
                LEFT JOIN tr_purchaseorderdetail pd on a.purchaseOrderNum = pd.purchaseOrderNum
                LEFT JOIN ms_uom uom on uom.uomID = pd.uomID
                LEFT JOIN(
					SELECT b.refNum, SUM(qty) 'qty', a.hsCode, a.productID, b.transtype, b.warehouseID
                    FROM tr_goodsreceiptdetail a
                    JOIN tr_goodsreceipthead b ON a.goodsReceiptNum = b.goodsReceiptNum
                    GROUP BY b.refNum
                )d ON a.purchaseOrderNum = d.refNum
                LEFT JOIN ms_supplier c on c.supplierID = a.supplierID
                LEFT JOIN ms_product e on e.productID = pd.productID
                GROUP BY a.purchaseOrderNum
                        HAVING sum(pd.qty) > IFNULL((SELECT sum(gd.qty) 
                        FROM tr_goodsreceipthead b 
                        JOIN tr_goodsreceiptdetail gd ON b.goodsReceiptNum = gd.goodsReceiptNum 
                        WHERE b.refNum=a.purchaseOrderNum GROUP BY b.refNum),0)     

                UNION
                SELECT pd.qty, uom.uomName, f.shipmentDate AS shipment, a.salesReturnNum AS refNum, COALESCE(b.transType,'Sales Return') transType, e.productname, d.hsCode,a.createdDate as createdDate,b.warehouseID, c.customerName as sources,a.additionalInfo as notes
                FROM tr_salesreturnhead a
                LEFT JOIN tr_salesreturndetail pd on a.salesReturnNum = pd.salesReturnNum
                LEFT JOIN ms_uom uom on uom.uomID = pd.uomID
                LEFT JOIN tr_goodsreceipthead b on a.salesReturnNum = b.refNum 
                LEFT JOIN(
					SELECT b.refNum, SUM(qty) 'qty', a.hsCode, a.productID
                    FROM tr_goodsreceiptdetail a
                    JOIN tr_goodsreceipthead b ON a.goodsReceiptNum = b.goodsReceiptNum
                    GROUP BY b.refNum
                )d ON a.salesReturnNum = d.refNum
                LEFT JOIN ms_customer c on c.customerID = a.customerID
                LEFT JOIN ms_product e on e.productID = d.productID
                LEFT JOIN tr_purchaseorderhead f on b.refNum = f.purchaseOrderNum 
                GROUP BY a.salesReturnNum
                        HAVING sum(pd.qty) > IFNULL((SELECT sum(gd.qty) 
                        FROM tr_goodsreceipthead b 
                        JOIN tr_goodsreceiptdetail gd ON b.goodsReceiptNum = gd.goodsReceiptNum 
                        WHERE b.refNum=a.salesReturnNum 
                        GROUP BY b.refNum),0)
                        
               

                UNION
                SELECT pd.qtyInStock , uom.uomName, g.shipmentDate AS shipment, a.stockTransferNum AS refNum, COALESCE(b.transType,'Stock Transfer') transType, f.productname, e.hsCode,a.createdDate as createdDate,b.warehouseID, d.warehouseName as sources, a.notes as notes
                FROM tr_stocktransferhead a
                LEFT JOIN tr_stocktransferdetail pd on a.stockTransferNum = pd.stockTransferNum
                LEFT JOIN ms_uom uom on uom.uomID = pd.uomID
                LEFT JOIN tr_goodsdeliveryhead c on a.stockTransferNum = c.refNum
                LEFT JOIN tr_goodsreceipthead b on a.stockTransferNum = b.refNum 
                LEFT JOIN(
					SELECT b.refNum, SUM(qty) 'qty', a.hsCode, a.productID
                    FROM tr_goodsreceiptdetail a
                    JOIN tr_goodsreceipthead b ON a.goodsReceiptNum = b.goodsReceiptNum
                    GROUP BY b.refNum
                )e ON a.stockTransferNum = e.refNum
                LEFT JOIN ms_warehouse d on d.warehouseID = a.sourceWarehouseID
                LEFT JOIN ms_product f on f.productID = e.productID
                LEFT JOIN tr_purchaseorderhead g on b.refNum = g.purchaseOrderNum 
                GROUP BY a.stockTransferNum
                        HAVING sum(pd.qtyTransfer) > IFNULL((SELECT sum(gd.qty) 
                        FROM tr_goodsreceipthead b 
                        JOIN tr_goodsreceiptdetail gd ON b.goodsReceiptNum = gd.goodsReceiptNum 
                        WHERE b.refNum=a.stockTransferNum 
                        GROUP BY b.refNum),0)
                ) a
                WHERE a.refNum like '%".$refNum."%'
                ".$transType
                .$filterSources
                .$filterHsCode
                .$filterProduct
                .$filterDate;
        
        $sqlCount = "SELECT count(*) FROM (
                SELECT  a.shipmentDate AS shipment, a.purchaseOrderNum AS refNum, COALESCE(d.transType,'Purchase Order') transType,  e.productname, d.hsCode, d.goodsReceiptDate,d.warehouseID, c.supplierName as sources
                FROM tr_purchaseorderhead a
                LEFT JOIN tr_purchaseorderdetail pd on a.purchaseOrderNum = pd.purchaseOrderNum
                
                LEFT JOIN ms_supplier c on c.supplierID = a.supplierID
                LEFT JOIN(
					SELECT b.refNum, SUM(qty) 'qty', a.hsCode, a.productID, b.transtype, b.warehouseID, b.goodsreceiptDate
                    FROM tr_goodsreceiptdetail a
                    JOIN tr_goodsreceipthead b ON a.goodsReceiptNum = b.goodsReceiptNum
                    GROUP BY b.refNum
                )d ON a.purchaseOrderNum = d.refNum
                LEFT JOIN ms_product e on e.productID = d.productID
                GROUP BY a.purchaseOrderNum
                        HAVING sum(pd.qty) > IFNULL((SELECT sum(gd.qty) 
                        FROM tr_goodsreceipthead b 
                        JOIN tr_goodsreceiptdetail gd ON b.goodsReceiptNum = gd.goodsReceiptNum 
                        WHERE b.refNum=a.purchaseOrderNum GROUP BY b.refNum),0)     

                UNION
                SELECT f.shipmentDate AS shipment, a.salesReturnNum AS refNum, COALESCE(b.transType,'Sales Return') transType,  e.productname, d.hsCode,b.goodsReceiptDate,b.warehouseID, c.customerName as sources
                FROM tr_salesreturnhead a
                LEFT JOIN tr_salesreturndetail pd on a.salesReturnNum = pd.salesReturnNum
                LEFT JOIN tr_goodsreceipthead b on a.salesReturnNum = b.refNum 
                LEFT JOIN ms_customer c on c.customerID = a.customerID
                LEFT JOIN(
					SELECT b.refNum, SUM(qty) 'qty', a.hsCode, a.productID
                    FROM tr_goodsreceiptdetail a
                    JOIN tr_goodsreceipthead b ON a.goodsReceiptNum = b.goodsReceiptNum
                    GROUP BY b.refNum
                )d ON a.salesReturnNum = d.refNum
                LEFT JOIN ms_product e on e.productID = d.productID
                LEFT JOIN tr_purchaseorderhead f on b.refNum = f.purchaseOrderNum 
                GROUP BY a.salesReturnNum
                        HAVING sum(pd.qty) > IFNULL((SELECT sum(gd.qty) 
                        FROM tr_goodsreceipthead b 
                        JOIN tr_goodsreceiptdetail gd ON b.goodsReceiptNum = gd.goodsReceiptNum 
                        WHERE b.refNum=a.salesReturnNum 
                        GROUP BY b.refNum),0)
             
                UNION
                SELECT g.shipmentDate AS shipment, a.stockTransferNum AS refNum, COALESCE(b.transType,'Stock Transfer') transType, f.productname, e.hsCode,b.goodsReceiptDate,b.warehouseID, d.warehouseName as sources
                FROM tr_stocktransferhead a
                LEFT JOIN tr_stocktransferdetail pd on a.stockTransferNum = pd.stockTransferNum
                LEFT JOIN tr_goodsdeliveryhead c on a.stockTransferNum = c.refNum
                LEFT JOIN tr_goodsreceipthead b on a.stockTransferNum = b.refNum 
                LEFT JOIN(
					SELECT b.refNum, SUM(qty) 'qty', a.hsCode, a.productID
                    FROM tr_goodsreceiptdetail a
                    JOIN tr_goodsreceipthead b ON a.goodsReceiptNum = b.goodsReceiptNum
                    GROUP BY b.refNum
                )e ON a.stockTransferNum = e.refNum
                LEFT JOIN ms_warehouse d on d.warehouseID = a.sourceWarehouseID
                LEFT JOIN ms_product f on f.productID = e.productID
                LEFT JOIN tr_purchaseorderhead g on b.refNum = g.purchaseOrderNum 
                GROUP BY a.stockTransferNum
                        HAVING sum(pd.qtyTransfer) > IFNULL((SELECT sum(gd.qty) 
                        FROM tr_goodsreceipthead b 
                        JOIN tr_goodsreceiptdetail gd ON b.goodsReceiptNum = gd.goodsReceiptNum 
                        WHERE b.refNum=a.stockTransferNum 
                        GROUP BY b.refNum),0)
                ) a
                WHERE a.refNum like '%".$refNum."%'
                ".$transType
                .$filterSources
                .$filterHsCode
                .$filterProduct
                .$filterDate;
        
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
                    'asc' => ['a.refNum' => SORT_ASC],
                    'desc' => ['a.refNum' => SORT_DESC],      
                    'label' => 'refNum'
                ],
                'transType' => [
                    'asc' => ['transType' => SORT_ASC],
                    'desc' => ['transType' => SORT_DESC],
                ],
                'hsCode' => [
                    'asc' => ['hsCode' => SORT_ASC],
                    'desc' => ['hsCode' => SORT_DESC],
                ],
                'sources' => [
                    'asc' => ['sources' => SORT_ASC],
                    'desc' => ['sources' => SORT_DESC],
                ],
                'productname' => [
                    'asc' => ['productname' => SORT_ASC],
                    'desc' => ['productname' => SORT_DESC],
                ],
                'shipment' => [
                    'asc' => ['shipment' => SORT_ASC],
                    'desc' => ['shipment' => SORT_DESC],
                ]
            ]
        ]);

        return $dataProvider;
    }
    
    
    public function searchUnpaidPPJK ()
    {
//         $queryGR = TrGoodsreceipthead::find()
//                ->select(['SUM(tr_goodsreceiptcost.importDutyAmount + tr_goodsreceiptcost.PPNImportAmount + tr_goodsreceiptcost.PPHImportAmount
//                 + IF(tr_goodsreceiptcost.otherCostAmount IS NULL, 0, tr_goodsreceiptcost.otherCostAmount)
//                 + IF(tr_goodsreceiptcost.taxInvoiceAmount IS NULL, 0, tr_goodsreceiptcost.taxInvoiceAmount)) AS total','ms_supplier.supplierName', 'ms_supplier.country','ms_supplier.street', 'ms_supplier.officeNumber', 'PPJK'])
//                ->joinWith('goodsReceiptCost')
//                ->joinWith('supplier')
//                ->where('tr_goodsreceiptcost.goodsReceiptNum is not null')
//                ->andWhere('tr_goodsreceipthead.PPJK =  ms_supplier.supplierID')
//                ->andWhere('ms_supplier.isForwarder =  1')
//                ->andWhere("(importDutyAmount + PPNImportAmount + PPHImportAmount + IF(otherCostAmount IS NULL, 0, otherCostAmount) + IF(taxInvoiceAmount IS NULL, 0, taxInvoiceAmount))"
//                        . " - (SELECT SUM(paymentAmount) FROM tr_supplierpaymentdetail WHERE refNum = tr_goodsreceipthead.goodsReceiptNum) > 0 "
//                        . " OR (SELECT SUM(paymentAmount) FROM tr_supplierpaymentdetail WHERE refNum = tr_goodsreceipthead.goodsReceiptNum) IS NULL")
//                ->groupBy(['tr_goodsreceipthead.PPJK'])
//                ->having('total > 0');
//
//        $dataProvider = new ActiveDataProvider([
//                'query' => $queryGR,
//                'pagination' => [
//                    'pageSize' => 10
//                ],
//         
//            ]);
//        
//        return $dataProvider;
//        
        $filterSupplier = '';
        if($this->supplierID != NULL) $filterSupplier = " and x.supplierID = $this->supplierID";
        $sql = "SELECT sum(x.grandTotal), SUM(x.outstandingAmount) AS payableTotal, x.supplierID, 
                supplier.supplierName, supplier.isForwarder, supplier.country, 
                                CONCAT(LEFT(supplier.street, 60), IF(LENGTH(supplier.street) > 60, '...','')) AS street,
                                supplier.officeNumber
                FROM (
                        SELECT refNum AS transactionRefNum, head.payableDate AS transactionDate, detail.currency,
                        ref.num AS originalRefNum, ref.supplierID, ref.hasVat, 

                        @grandTotal := ref.grandTotal AS grandTotal,
                        @advancedPaymentAmount := (
                            SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
                            FROM tr_supplieradvancebalancedetail AS advPaymentDetail
                            LEFT JOIN tr_supplieradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
                            WHERE advPaymentDetail.refNum = detail.refNum AND SUBSTR(advPaymentDetail.refNum, 5, 2) = 'FP'
                        ) AS advancedPaymentAmount,
                        @previousPayment := (
                            SELECT CAST(IFNULL(SUM(paymentDetail.paymentAmount), 0) AS DECIMAL(18, 2))
                            FROM tr_supplierpaymenthead AS paymentHead
                            LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
                            WHERE paymentDetail.refNum = detail.refNum AND SUBSTR(paymentHead.supplierPaymentNum, 5, 2) = 'FP'
                        ) AS previousPayment,
                        CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
                        FROM tr_supplierpayabledetail AS detail
                        LEFT JOIN tr_supplierpayablehead AS head ON detail.payableNum = head.payableNum
                        INNER JOIN (
                            SELECT d.payableDetailID,
                            CASE 
                                WHEN receiptHead.PPJK IS NOT NULL THEN receiptHead.PPJK
                                WHEN poni.supplierID IS NOT NULL THEN poni.supplierID
                                ELSE '-'
                            END AS supplierID,
                            CASE 
                                WHEN poHead.purchaseOrderNum IS NOT NULL THEN poHead.purchaseOrderNum
                                WHEN poni.purchaseOrderNonInventoryNum IS NOT NULL THEN poni.purchaseOrderNonInventoryNum
                                ELSE '-'
                                END AS num,
                            CASE
                                WHEN poHead.hasVat IS NOT NULL THEN poHead.hasVat
                                WHEN poni.hasVat IS NOT NULL THEN poni.hasVat
                                ELSE 0
                            END AS hasVat,
                            cost.importDutyAmount + cost.PPNImportAmount + cost.PPHImportAmount 
                            AS grandTotal
                            FROM tr_supplierpayabledetail AS d
                            LEFT JOIN tr_goodsreceipthead AS receiptHead ON receiptHead.goodsReceiptNum = d.refNum
                            LEFT JOIN tr_goodsreceiptcost AS cost ON cost.goodsReceiptNum = receiptHead.goodsReceiptNum
                            LEFT JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = receiptHead.refNum
                            LEFT JOIN tr_purchaseordernoninventoryhead AS poni ON poni.purchaseOrderNonInventoryNum = d.refNum
                        ) AS ref ON ref.payableDetailID = detail.payableDetailID
                ) x
                LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = x.supplierID
                WHERE supplierName IS NOT NULL AND floor(x.outstandingAmount) > 0 
                $filterSupplier
                GROUP BY x.supplierID";

        $counter = "SELECT COUNT(*) FROM ($sql) y";
        $count = Yii::$app->db->createCommand($counter)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'key' => 'supplierID',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => ['supplierID' => SORT_ASC],
                'attributes' => [
                    'supplierID' => [
                        'asc' => ['supplierName' => SORT_ASC],
                        'desc' => ['supplierName' => SORT_DESC],
                    ],
                    
                ]
            ]
        ]);
        return $dataProvider;
    }
    
    public function searchBrowse()
    {
        $query = self::find()
            ->select('tr_goodsreceipthead.goodsReceiptNum, tr_goodsreceipthead.goodsReceiptDate, tr_goodsreceipthead.refNum')
            ->where('transType = "Purchase Order"')
            ->joinWith('journal')
            ->where('tr_journalhead.refNum is not null')
            ->andFilterWhere(['like', 'tr_goodsreceipthead.refNum', $this->refNum])
            ->andFilterWhere(['=', "DATE_FORMAT(tr_goodsreceipthead.goodsReceiptDate, '%d-%m-%Y')", $this->goodsReceiptDate]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['tr_goodsreceipthead.goodsReceiptDate' => SORT_DESC],
                'attributes' => ['tr_goodsreceipthead.goodsReceiptDate']
            ]
        ]);

        return $dataProvider;
    }
    public function getJournal()
    {
        return $this->hasMany(TrJournalhead::className(), ['refNum' => 'goodsReceiptNum']);
    }
    public function getStockHPP()
    {
        return $this->hasOne(StockHpp::className(), ['refNum' => 'goodsReceiptNum']);
    }
    public function getPurchaseOrder()
    {
        return $this->hasOne(TrPurchaseorderhead::className(), ['purchaseOrderNum' => 'refNum']);
    }
    public function getGoodsReceiptCost()
    {
        return $this->hasMany(TrGoodsreceiptcost::className(), ['goodsReceiptNum' => 'goodsReceiptNum']);
    }
    public function getGoodsReceiptDetails()
    {
        return $this->hasMany(TrGoodsreceiptdetail::className(), ['goodsReceiptNum' => 'goodsReceiptNum']);
    }
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(TrPurchaseorderdetail::className(), ['purchaseOrderNum' => $getID]);
    }
    public function getWarehouse()
    {
        return $this->hasMany(MsWarehouse::className(), ['warehouseID' => 'warehouseID']);
    }
    public function getSupplier()
    {
        return $this->hasMany(MsSupplier::className(), ['supplierID' => 'PPJK']);
    }
	
	public function getSupplierppjk()
    {
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'PPJK']);
    }
    
    
    public function getRefNum() {
        $url = null;
        if ($this->transType == "Purchase Order") {
           $url = Url::to(["purchase/view", "id" => $this->refNum]);
        } 

        if ($url) {
            return Html::a($this->refNum, $url, [
                        'target' => '_blank',
                        'data-pjax' => '0',
                        'class' => 'asdasd'
            ]);
        } else {
            return $this->refNum;
        }
    }
    
    
    
    public function afterFind(){
        parent::afterFind();
        
        $this->joinGoodsReceiptDetail = [];
        $i = 0;
        $post =Yii::$app->request->get();
        $proceed = true;
                
        if(count($post) > 0 && isset($post['id'])){
            $getID = $post['id'];
            $this->refNum = $getID;

            if (strpos($getID, 'PO') !== false){
                $sql = "SELECT a.purchaseOrderDate,b.supplierName from tr_purchaseorderhead a
                        join ms_supplier b on a.supplierID=b.supplierID
                        where a.purchaseOrderNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sql);
                $headResult = $temp->queryAll();
                $this->refDate = date('d-m-Y');
                foreach ($headResult as $result) {
                    $this->from = $result['supplierName'];
                    $this->refDate = $result['purchaseOrderDate'];
                }

                $sqlDetail = "SELECT a.productID,b.productName,b.hsCode,a.uomID,c.uomName,a.qty,d.packingTypeID,e.packingTypeName,d.uomQty from tr_purchaseorderdetail a
                    join ms_product b on a.productID=b.productID
                    join ms_productdetail d on b.productID=d.productID
                    join ms_uom c on a.uomID=c.uomID
                    join ms_packingtype e on d.packingTypeID=e.packingTypeID
                    where a.purchaseOrderNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlDetail);
                $detailResult = $temp->queryAll();
            }
            else if (strpos($getID, 'SR') !== false){
                $sql = "SELECT a.salesReturnDate,b.customerName from tr_salesreturnhead a
                        join ms_customer b on a.customerID=b.customerID
                        where a.salesReturnNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sql);
                $headResult = $temp->queryAll();
                $this->refDate = date('d-m-Y');
                foreach ($headResult as $result) {
                    $this->from = $result['customerName'];
                    $this->refDate = $result['salesReturnDate'];
                }

                $sqlDetail = "SELECT a.productID,b.productName,b.hsCode,a.uomID,c.uomName,a.qty,d.packingTypeID,e.packingTypeName,d.uomQty from tr_salesreturndetail a
                    join ms_product b on a.productID=b.productID
                    join ms_productdetail d on b.productID=d.productID
                    join ms_uom c on a.uomID=c.uomID
                    join ms_packingtype e on d.packingTypeID=e.packingTypeID
                    where a.salesReturnNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlDetail);
                $detailResult = $temp->queryAll();
            }
            else if (strpos($getID, 'ST') !== false){
                $sql = "SELECT a.stockTransferDate,a.destinationWarehouseID,b.warehouseName from tr_stocktransferhead a
                        join ms_warehouse b on a.sourceWarehouseID=b.warehouseID
                        where a.stockTransferNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sql);
                $headResult = $temp->queryAll();
                $this->refDate = date('d-m-Y');
                foreach ($headResult as $result) {
                    $this->from = $result['warehouseName'];
                    $this->refDate = $result['stockTransferDate'];
                    $this->warehouseID = $result['destinationWarehouseID'];
                }

                $sqlDetail = "SELECT a.productID,b.productName,b.hsCode,d.uomID,c.uomName,a.qtyTransfer as qty,d.packingTypeID,e.packingTypeName,d.uomQty from tr_stocktransferdetail a
                    join ms_product b on a.productID=b.productID
                    join ms_productdetail d on b.productID=d.productID
                    join ms_uom c on d.uomID=c.uomID
                    join ms_packingtype e on d.packingTypeID=e.packingTypeID
                    where a.stockTransferNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlDetail);
                $detailResult = $temp->queryAll();
            }
            else {
                $sql = "SELECT a.purchaseOrderDate,b.supplierName from tr_purchaseorderhead a
                        join ms_supplier b on a.supplierID=b.supplierID
                        where a.purchaseOrderNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sql);
                $headResult = $temp->queryAll();
                $this->refDate = date('d-m-Y');
                foreach ($headResult as $result) {
                    $this->from = $result['supplierName'];
                    $this->refDate = $result['purchaseOrderDate'];
                }

                $sqlDetail = "SELECT a.productID,b.productName,b.hsCode,a.uomID,c.uomName,a.qty,d.packingTypeID,e.packingTypeName,d.uomQty from tr_purchaseorderdetail a
                    join ms_product b on a.productID=b.productID
                    join ms_productdetail d on b.productID=d.productID
                    join ms_uom c on a.uomID=c.uomID
                    join ms_packingtype e on d.packingTypeID=e.packingTypeID
                    where a.purchaseOrderNum='".$getID."'";
                $connection = MdlDb::getDbConnection();
                $temp = $connection->createCommand($sqlDetail);
                $detailResult = $temp->queryAll();
            }
            
            if ($proceed) {
                foreach ($detailResult as $joinGoodsReceiptDetail) {
					$qtyGoods = 0;

					$sqlGoods = "SELECT g.productID,sum(g.qty) as qty from tr_goodsreceipthead a
								join tr_goodsreceiptdetail g on a.goodsReceiptNum=g.goodsReceiptNum
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
						$qtyOutstanding = "0,00";

					
					if($qtyOutstanding != 0){
						$this->joinGoodsReceiptDetail[$i]["productID"] = $joinGoodsReceiptDetail['productID'];
						$this->joinGoodsReceiptDetail[$i]["productName"] = $joinGoodsReceiptDetail['productName'];
						$this->joinGoodsReceiptDetail[$i]["uomID"] = $joinGoodsReceiptDetail['uomID'];
						$this->joinGoodsReceiptDetail[$i]["uomName"] = $joinGoodsReceiptDetail['uomName'];
						$this->joinGoodsReceiptDetail[$i]["qty"] = $qtyOutstanding;
						$this->joinGoodsReceiptDetail[$i]["packID"] = $joinGoodsReceiptDetail['packingTypeID'];
						$this->joinGoodsReceiptDetail[$i]["packName"] = $joinGoodsReceiptDetail['packingTypeName'];
						$this->joinGoodsReceiptDetail[$i]["packQty"] = number_format($joinGoodsReceiptDetail['uomQty'], 4, ',', '.');
						$this->joinGoodsReceiptDetail[$i]["qtyReceived"] = "0,00";
						$this->joinGoodsReceiptDetail[$i]["batchNumber"] = "";
						$this->joinGoodsReceiptDetail[$i]["hsCode"] = $joinGoodsReceiptDetail['hsCode'];
						$this->joinGoodsReceiptDetail[$i]["manufactureDate"] = "";
						$this->joinGoodsReceiptDetail[$i]["expireDate"] = "";
						$this->joinGoodsReceiptDetail[$i]["retestDate"] = "";
						$this->joinGoodsReceiptDetail[$i]["temperature"] = "";
						$this->joinGoodsReceiptDetail[$i]["notes"] = "";
						$this->joinGoodsReceiptDetail[$i]["condition"] = "checked";


						$i += 1;
					}
					
					//Yii::trace(Json::encode($this->joinGoodsReceiptDetail), 'DBG');
				}
            }
            
        }
        
    }
}
