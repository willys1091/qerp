<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use app\components\MdlDb;
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
class TrGoodsreceiptheadapproval extends \yii\db\ActiveRecord
{
    public $goodsReceiptDetailID;
    public $status;
    public $warehouseName;
    public $isImport;
    public $taxRate;
    public $currency;
    public $rate;
    public $supplierID;
    public $taxTotal;
    public $grandTotal;
    public $advancePaymentNum;
    public $hsCode;
    public $outstanding;
    public $goodsReceiptTime;
    public $joinGoodsReceiptDetail;
    public $sources;
    public $importDutyAmount, $PPNImportAmount, $PPHImportAmount, $otherCostAmount, $taxInvoiceAmount, $CIF, $CNF, $FOB, $lsDate, $lsNo;
    public $goodsReceiptCost;
    public $goodsReceiptDateHidden;    
    public $importDutyStatus;

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
            [['goodsReceiptNum', 'refNum'], 'required'],
            [['pibRate', 'pibDate'], 'required', 'on' => 'scenarioImport'],
            [['goodsReceiptDate', 'goodsReceiptTime', 'invoiceDate',  'createdDate', 'editedDate', 'warehouseID', 'SKIDate'], 'safe'],
            [['goodsReceiptNum', 'refNum', 'invoiceNum', 'taxInvoiceNum', 'transType', 'createdBy', 'editedBy'], 'string', 'max' => 50],
			[['SKINumber'], 'string', 'max' => 200],
            [['deliveryNum', 'pibSubmitCode', 'AWBNum', 'pibNumber'], 'string', 'max' => 20],
            [[ 'pibAmount', 'importDutyAmount', 'PPNImportAmount', 'PPHImportAmount','CIF', 'FOB', 'CNF', 'lsDate', 'lsNo','otherCostAmount', 'taxInvoiceAmount', ], 'safe'],
            [['pibRate'], 'string'],
            [['PPJK'], 'integer'],
            [['warehouseID','sources', 'startDate', 'endDate','importDutyStatus'], 'safe'],
            [['goodsReceiptDateHidden','warehouseName', 'currency', 'joinGoodsReceiptDetail','grandTotal', 'advancePaymentNum', 'outstanding'], 'safe'],
            [['additionalInfo'], 'string', 'max' => 200],
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
            'goodsReceiptDate' => 'Receipt Date',
            'deliveryNum' => 'Delivery Number',
            'warehouseID' => 'Warehouse',
            'warehouseName' => 'Warehouse',
            'pibNumber' => 'PIB Number',
            'pibDate' => 'PIB Date',
            'pibRate' => 'PIB Rate',
            'pibSubmitCode' => 'No Aju PIB',
            'pibAmount' => 'PIB Amount',
            'invoiceNum' => 'Invoice Number',
            'invoiceDate' => 'Invoice Date',
            'taxInvoiceNum' => 'Tax Invoice Number',
            'SKINumber' => 'POM/SKI Number',
            'SKIDate' => 'POM/SKI Date',
            'additionalInfo' => 'Additional Information',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'supplierID' => 'Supplier',
            'taxTotal' => 'Tax Total',
            'grandTotal' => 'Grand Total',
            'advancePaymentNum' => 'Total Advance Payment',
            'importDutyAmount' => 'Import Duty',
            'PPNImportAmount' => 'PPN Impor',
            'PPHImportAmount' => 'PPH Pasal 22 Impor',
            'otherCostAmount' => 'Other Costs',
            'taxInvoiceAmount' => 'Nilai Faktur Pajak',
            'PPJK' => 'PPJK',
            'lsNo' => 'LS No',
            'lsDate' => 'Ls Date',
            'importDutyStatus' => 'Status'
        ];
    }
    public function search($params)
    {
        $this->load($params);
        $filterDate = '';
        $filterNum = '';
        $filterTrans = '';
        $filterFrom = '';
        
        if ($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $filterDate = "AND a.goodsReceiptDate >= '$start' AND a.goodsReceiptDate <= '$end'";
        }
        if ($this->goodsReceiptNum)
        {
            $filterNum = $this->goodsReceiptNum;
        }
        if ($this->transType)
        {
            $filterTrans = " and a.transType LIKE ('%" .$this->transType. "%') ";
        }
        if ($this->sources)
        {
            $filterFrom = " and a.sources LIKE ('%" .$this->sources. "%') ";
        }
        
        $sql = "SELECT * FROM (
            SELECT DISTINCT grHead.goodsReceiptDate, grHead.goodsReceiptNum, grHead.transType, supplier.supplierName AS sources 
            FROM tr_goodsreceipthead AS grHead
            JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = grHead.refNum
            LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = poHead.supplierID 
            LEFT JOIN tr_goodsreceiptcost AS grCost ON grCost.goodsreceiptnum = grHead.goodsreceiptnum
            LEFT JOIN tr_journalhead AS journalHead ON journalHead.refNum = grHead.goodsReceiptNum AND journalHead.transactionType = 'Goods Receipt'
            WHERE (poHead.isimport = 1 AND journalHead.refNum IS NULL AND grCost.goodsreceiptnum IS NOT NULL) OR (poHead.isimport = 0 AND journalHead.refNum IS NULL)

            UNION

            SELECT DISTINCT grHead.goodsReceiptDate, grHead.goodsReceiptNum, grHead.transType, customer.customerName AS sources 
            FROM tr_goodsreceipthead AS grHead
            JOIN tr_salesreturnhead AS srHead ON srHead.salesReturnNum = grHead.refNum
            LEFT JOIN ms_customer AS customer ON customer.customerID = srHead.customerID   
            JOIN tr_journalhead AS journalhead ON journalhead.refNum = grHead.goodsReceiptNum
            WHERE journalhead.refNum IS NULL
            
            UNION
            
            SELECT DISTINCT grHead.goodsReceiptDate, grHead.goodsReceiptNum, grHead.transType, customer.customerName AS sources 
            FROM tr_goodsreceipthead AS grHead
            LEFT JOIN tr_salesreturnhead AS srHead ON srHead.salesReturnNum = grHead.refNum
            LEFT JOIN ms_customer AS customer ON customer.customerID = srHead.customerID   
            LEFT JOIN tr_journalhead AS journalhead ON journalhead.refNum = grHead.goodsReceiptNum
            WHERE grHead.transType = 'Sales Return' AND journalhead.refNum IS NULL
        ) a 
        WHERE a.goodsReceiptNum LIKE '%$filterNum%'
        ".$filterDate
        .$filterTrans
        .$filterFrom;
        
        $sqlCount = "SELECT COUNT(*) FROM (
            SELECT DISTINCT grHead.goodsReceiptDate, grHead.goodsReceiptNum, grHead.transType, supplier.supplierName AS sources 
            FROM tr_goodsreceipthead AS grHead
            JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = grHead.refNum
            LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = poHead.supplierID 
            LEFT JOIN tr_goodsreceiptcost AS grCost ON grCost.goodsreceiptnum = grHead.goodsreceiptnum
            LEFT JOIN tr_journalhead AS journalHead ON journalHead.refNum = grHead.goodsReceiptNum AND journalHead.transactionType = 'Goods Receipt'
            WHERE (poHead.isimport = 1 AND journalHead.refNum IS NULL AND grCost.goodsreceiptnum IS NOT NULL) OR (poHead.isimport = 0 AND journalHead.refNum IS NULL)

            UNION

            SELECT DISTINCT grHead.goodsReceiptDate, grHead.goodsReceiptNum, grHead.transType, customer.customerName AS sources 
            FROM tr_goodsreceipthead AS grHead
            JOIN tr_salesreturnhead AS srHead ON srHead.salesReturnNum = grHead.refNum
            LEFT JOIN ms_customer AS customer ON customer.customerID = srHead.customerID   
            JOIN tr_journalhead AS journalhead ON journalhead.refNum = grHead.goodsReceiptNum
            WHERE journalhead.refNum IS NULL
            
            UNION
            
            SELECT DISTINCT grHead.goodsReceiptDate, grHead.goodsReceiptNum, grHead.transType, customer.customerName AS sources 
            FROM tr_goodsreceipthead AS grHead
            LEFT JOIN tr_salesreturnhead AS srHead ON srHead.salesReturnNum = grHead.refNum
            LEFT JOIN ms_customer AS customer ON customer.customerID = srHead.customerID   
            LEFT JOIN tr_journalhead AS journalhead ON journalhead.refNum = grHead.goodsReceiptNum
            WHERE grHead.transType = 'Sales Return' AND journalhead.refNum IS NULL

        ) a 
        WHERE a.goodsReceiptNum LIKE '%$filterNum%'
        ".$filterDate
        .$filterTrans
        .$filterFrom;
        
        $count = Yii::$app->db->createCommand($sqlCount)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'key' => 'goodsReceiptNum',
            'pagination' => [
                'pageSize' => 20
            ],
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
                ]
            ]
        ]);

        return $dataProvider;
    }
    public function getGoodsReceiptDetails()
    {
        return $this->hasMany(TrGoodsreceiptdetail::className(), ['goodsReceiptNum' => 'goodsReceiptNum']);
    }
    public function getJournal()
    {
        return $this->hasMany(TrJournalhead::className(), ['refNum' => 'goodsReceiptNum']);
    }
    public function getPurchaseOrder()
    {
        return $this->hasOne(TrPurchaseorderhead::className(), ['purchaseOrderNum' => 'refNum']);
    }
    public function getSalesReturnDetail()
    {
        return $this->hasOne(TrSalesreturndetail::className(), ['salesReturnNum' => 'refNum']);
    }
    public function getAdvancePayment()
    {
        return $this->hasOne(TrSupplieradvancepayment::className(), ['refNum' => 'refNum']);
    }
    public function getHsCode()
    {
        return $this->hasOne(MsHscode::className(), ['hsCode' => 'hsCode']);
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
        
        $proceed = true;
        
        $this->goodsReceiptTime = date("H",strtotime($this->goodsReceiptDate)).":".date("i",strtotime($this->goodsReceiptDate));
        $this->goodsReceiptDate = AppHelper::convertDateTimeFormat($this->goodsReceiptDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->advancePaymentNum = "0,00";
        $costModel = TrGoodsreceiptcost::findOne(['goodsReceiptNum'=>$this->goodsReceiptNum]);
        if($costModel != null){
            $this->goodsReceiptCost = 1;
            $this->importDutyAmount = $costModel->importDutyAmount;
            $this->PPNImportAmount = $costModel->PPNImportAmount;
            $this->PPHImportAmount = $costModel->PPHImportAmount;
            $this->otherCostAmount = $costModel->otherCostAmount;
            $this->taxInvoiceAmount = $costModel->taxInvoiceAmount;
            $this->CIF = $costModel->CIF;
            $this->FOB = $costModel->FOB;
            $this->CNF = $costModel->CNF;
            $this->lsNo = $costModel->lsNo;
            $this->lsDate = $costModel->lsDate;
        }
        else{
            $this->goodsReceiptCost = 0;
            $this->importDutyAmount = 0;
            $this->PPNImportAmount = 0;
            $this->PPHImportAmount = 0;
            $this->otherCostAmount = 0;
            $this->taxInvoiceAmount = 0;
        }

        if($this->transType == "Purchase Order"){
            foreach ($this->getPurchaseOrder()->all() as $total) {
                $this->grandTotal = $total->grandTotal;
                $this->supplierID = $total->supplierID;
                $this->currency = $total->currencyID;
                $this->rate = $total->rate;
                $this->isImport = $total->isImport;
                $this->taxRate = $total->taxRate;
                $this->pibDate = AppHelper::convertDateTimeFormat($this->pibDate, 'Y-m-d H:i:s', 'd-m-Y');
                $this->CIF = $this->CIF;
                $this->FOB = $this->FOB;
                $this->CNF = $this->CNF;
                $this->lsNo = $this->lsNo;
                $this->lsDate = AppHelper::convertDateTimeFormat($this->lsDate, 'Y-m-d', 'd-m-Y');
            }

            if($this->getAdvancePayment()->all() > 0){
                $advance = $this->advancePayment;
                if($advance !== NULL) {
                    $this->advancePaymentNum = $advance->amount;
                } else {
                    $this->advancePaymentNum = 0;
                }
            }     
        }
        
        else if($this->transType == "Sales Return"){
            foreach ($this->getSalesReturnDetail()->all() as $total) {
                $this->grandTotal = $total->totalAmount;
                $this->currency = "IDR";
                $this->rate = 1;
                $this->isImport = false;
                $this->taxRate = $total->VAT;
            }

            $advancedPaymentModel = TrCustomeradvancepayment::find()
                                    ->select(['tr_customeradvancepayment.amount'])
                                    ->leftJoin('tr_salesorderhead', 'tr_salesorderhead.salesOrderNum = tr_customeradvancepayment.refNum')
                                    ->leftJoin('tr_goodsdeliveryhead', 'tr_goodsdeliveryhead.refNum = tr_salesorderhead.salesOrderNum')
                                    ->leftJoin('tr_salesreturndetail', 'tr_salesreturndetail.refNum = tr_goodsdeliveryhead.goodsDeliveryNum')
                                    ->one();

            if(!is_null($advancedPaymentModel->amount)){
                $this->advancePaymentNum = $advancedPaymentModel->amount;
            } 
        }
        else if($this->transType == "Stock Transfer"){
            $this->grandTotal = 0;
            $this->currency = "IDR";
            $this->rate = 1;
            $this->isImport = false;
            $this->taxRate = 0;

        }
                
        $this->joinGoodsReceiptDetail = [];
        $i = 0;
        
        $post =Yii::$app->request->get();
        if (array_key_exists('id', $post)){
            if(count($post) > 0){
                $connection = MdlDb::getDbConnection();

                $getID = $post['id'];

                if($this->transType == "Purchase Order"){
                    $sql = "SELECT a.goodsReceiptDetailID,a.productID,d.productName,a.uomID,e.uomName,a.hsCode,a.qty,a.pack,f.packingTypeName,a.packQty,a.goodsCondition,c.price,c.discount,c.subTotal
                            from tr_goodsreceiptdetail a join tr_goodsreceipthead b
                            on a.goodsReceiptNum=b.goodsReceiptNum
                            join tr_purchaseorderdetail c 
                            on b.refNum=c.purchaseOrderNum and a.productID=c.productID
                            join ms_product d on a.productID=d.productID
                            join ms_uom e on a.uomID=e.uomID
                            join ms_packingtype f on a.pack=f.packingTypeID
                            where a.goodsReceiptNum='".$getID."'";
                }
                else if($this->transType == "Sales Return"){
                    $sql = "SELECT a.goodsReceiptDetailID,a.productID,d.productName,a.uomID,e.uomName,a.hsCode,a.qty,a.pack,f.packingTypeName,a.packQty,a.goodsCondition,c.HPP as price,c.totalAmount,0.00 as discount
                            from tr_goodsreceiptdetail a join tr_goodsreceipthead b
                            on a.goodsReceiptNum=b.goodsReceiptNum
                            join tr_salesreturndetail c on b.refNum=c.salesReturnNum and a.productID=c.productID
                            join ms_product d on a.productID=d.productID
                            join ms_uom e on a.uomID=e.uomID
                            join ms_packingtype f on a.pack=f.packingTypeID
                            where a.goodsReceiptNum='".$getID."'";
                }
                else if($this->transType == "Stock Transfer"){
                    $sql = "SELECT a.goodsReceiptDetailID,a.productID,d.productName,a.uomID,e.uomName,a.hsCode,a.qty,a.pack,f.packingTypeName,a.packQty,a.goodsCondition,0.00 as price,0.00 as totalAmount,0.00 as discount
                            from tr_goodsreceiptdetail a join tr_goodsreceipthead b
                            on a.goodsReceiptNum=b.goodsReceiptNum
                            join ms_product d on a.productID=d.productID
                            join ms_uom e on a.uomID=e.uomID
                            join ms_packingtype f on a.pack=f.packingTypeID
                            where a.goodsReceiptNum='".$getID."'";
                } else {
                    $proceed = false;
                }
                $temp = $connection->createCommand($sql);
                $headResult = $temp->queryAll();

                $i = 0;
                if($proceed) {
                    foreach ($headResult as $detailMenu) {
                        $this->hsCode = $detailMenu['hsCode'];
                        if($this->getHsCode()->count() > 0){
                            $hsCodeModel = $this->getHsCode()->all();
                            $this->joinGoodsReceiptDetail[$i]["hsCodeTax"] = is_null($hsCodeModel[0]->taxPercentage)? "0.00" : $hsCodeModel[0]->taxPercentage;
                        }
                        else
                            $this->joinGoodsReceiptDetail[$i]["hsCodeTax"] = "0.00";

                        $this->joinGoodsReceiptDetail[$i]["detailID"] = $detailMenu['goodsReceiptDetailID'];
                        $this->joinGoodsReceiptDetail[$i]["productID"] = $detailMenu['productID'];
                        $this->joinGoodsReceiptDetail[$i]["productName"] = $detailMenu['productName'];
                        $this->joinGoodsReceiptDetail[$i]["uomID"] = $detailMenu['uomID'];
                        $this->joinGoodsReceiptDetail[$i]["uomName"] = $detailMenu['uomName'];
                        $this->joinGoodsReceiptDetail[$i]["qty"] = $detailMenu['qty'];
                        $this->joinGoodsReceiptDetail[$i]["packID"] = $detailMenu['pack'];
                        $this->joinGoodsReceiptDetail[$i]["packName"] = $detailMenu['packingTypeName'];
                        $this->joinGoodsReceiptDetail[$i]["packQty"] = number_format($detailMenu['packQty'], 4, ',', '.');
                        $this->joinGoodsReceiptDetail[$i]["condition"] = ($detailMenu['goodsCondition'] > 0 ? "checked" : "");
                        $this->joinGoodsReceiptDetail[$i]["price"] = $detailMenu['price'];
                        $this->joinGoodsReceiptDetail[$i]["discount"] = $detailMenu['discount'];
                        $this->joinGoodsReceiptDetail[$i]["taxValue"] = $this->taxRate;
                        $this->joinGoodsReceiptDetail[$i]["tax"] = ($this->taxRate > 0 ? "checked" : "");
                        $this->joinGoodsReceiptDetail[$i]["subTotal"] = $detailMenu['qty'] * $detailMenu['price'] * ((100-$detailMenu['discount']) / 100)
                                * ((100+$this->taxRate) / 100);

                        $i += 1;
                    }
                }
            }
        }
    }
}
