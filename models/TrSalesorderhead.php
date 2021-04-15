<?php

namespace app\models;

use app\components\AppHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tr_salesorderhead".
 *
 * @property string $salesOrderNum
 * @property string $refNum
 * @property string $salesOrderDate
 * @property string $dueDate
 * @property string $rate
 * @property integer $paymentID
 * @property integer $taxID
 * @property string $taxRate
 * @property string $grandTotal
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrSalesorderhead extends ActiveRecord
{
    public $joinSalesOrderDetail;
    public $marketingID;
    public $orderStatus;
    public $customerName;
    public $startDate,$endDate, $tax, $productName,$qtyPO, $city, $shipmentDate, $invoiceNum, $AWBNum, $notes, $origin, $qtySO;
    public $purchaseOrderNum;
	public $qtyAvailable;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_salesorderhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesOrderNum', 'salesOrderDate', 'customerID', 'grandTotal', 'contactPerson'], 'required'],
            [['salesOrderDate', 'materai', 'dueDate', 'origin', 'createdDate', 'editedDate','customerName','tax','productName','notes','qtyPO','city','shipmentDate','invoiceNum','AWBNum', 'qtySO', 'purchaseOrderNum', 'deliveryDestination', 'qtyAvailable'], 'safe'],
            [['taxRate', 'grandTotal'], 'string'],
            [['paymentID', 'taxID', 'customerID'], 'integer'],
            [['salesOrderNum', 'customerOrderNum', 'refNum', 'contactPerson', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['paymentID'], 'exist', 'skipOnError' => true, 'targetClass' => LkPaymentmethod::className(), 'targetAttribute' => ['paymentID' => 'paymentID']],
            [['startDate','endDate','joinSalesOrderDetail', 'marketingID', 'additionalInfo'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'salesOrderNum' => 'Sales Order Number',
            'customerOrderNum' => 'Customer Order Number',
            'refNum' => 'Sales Quotation Number',
            'salesOrderDate' => 'Date',
            'dueDate' => 'Delivery Due Date',
            'customerID' => 'Customer',
            'contactPerson' => 'Attendant',
            'marketingID' => 'Marketing Name',
            'paymentID' => 'Payment ID',
            'taxID' => 'Tax',
            'taxRate' => 'Tax Rate',
            'grandTotal' => 'Grand Total',
            'orderStatus' => 'Order Status',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Create By',
            'createdDate' => 'Create Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'productName' => 'Product',
            'qtyPO' => 'Stock Available',
            'city' => 'Delivery Destination',
            'shipmentDate' => 'Shipment Date',
            'AWBNum' => 'PO Customer',
            'purchaseOrderNum' => 'PO Shipment',
            'qtySO' => 'Qty'
        ];
    }
    public function getSalesQuotationHead()
    {
        return $this->hasOne(TrSalesquotationhead::className(), ['salesQuotationNum' => 'refNum']);
    }
    public function getParentCustomer(){
        return $this->hasOne(MsCustomer::className(), ['customerID' => 'customerID']);
    }
    public function getCustomer(){
        return $this->hasOne(MsCustomer::className(), ['customerID' => 'customerID']);
    }
    public function getParentMarketing(){
        return $this->hasOne(MsMarketing::className(), ['marketingID' => 'marketingID']);
    }
    public function getSalesOrderDetails()
    {
        return $this->hasMany(TrSalesorderdetail::className(), ['salesOrderNum' => 'salesOrderNum']);
    }
    public function getPurchaseOrder()
    {
        return $this->hasMany(TrPurchaseorderhead::className(), ['refNum' => 'salesOrderNum']);
    }
    public function getGoodsDelivery()
    {
        return $this->hasMany(TrGoodsdeliveryhead::className(), ['refNum' => 'salesOrderNum']);
    }
    public function getAdvancedPayment()
    {
        return $this->hasOne(TrCustomeradvancepayment::className(), ['refNum' => 'salesOrderNum']);
    }
	public function getCustomerDetailName()
    {
        return $this->hasOne(MsCustomerdetail::className(), ['contactPerson' => 'contactPerson']);
    }
    public function search()
    {
        $query = self::find()
            ->select('tr_goodsreceipthead.AWBNum,tr_goodsdeliveryhead.invoiceNum,tr_purchaseorderhead.shipmentDate,ms_customer.city,tr_purchaseorderdetail.qty as qtyPO,tr_salesorderhead.salesOrderNum, ms_product.productName,tr_salesorderhead.refNum, tr_salesorderhead.customerID, ms_customer.customerName, tr_salesorderhead.salesOrderDate, tr_salesorderhead.grandTotal')
            ->addSelect(new Expression('IFNULL(tr_goodsdeliveryhead.refNum,0) orderStatus'))
            ->joinWith('purchaseOrder.purchaseOrderDetails')
            ->joinWith('salesOrderDetails.product')
            ->joinWith('goodsDelivery')
            ->joinWith('purchaseOrder.goodsReceipt')
            ->joinWith('customer')
            ->andFilterWhere(['like', 'tr_salesorderhead.salesOrderNum', $this->salesOrderNum])
            ->andFilterWhere(['like', 'ms_product.productName', $this->productName])
            ->andFilterWhere(['like', 'tr_salesorderhead.refNum', $this->refNum])
            ->andFilterWhere(['like', 'ms_customer.city', $this->city])
            ->andFilterWhere(['like', 'ms_customer.customerName', $this->customerName])
            ->andFilterWhere(['like', 'tr_salesorderhead.grandTotal', $this->grandTotal]);

        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'tr_salesorderhead.salesOrderDate', $start]);
            $query->andFilterWhere(['<=', 'tr_salesorderhead.salesOrderDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['salesOrderDate' => SORT_DESC],
                'attributes' => [
                    'salesOrderDate',
                    'salesOrderNum',
                    'refNum',
                    'customerName',
                    'productName',
                    'qtySO',
                    'qtyPO',
                    'city',
                    'shipmentDate',
                    'invoiceNum',
                    'AWBNum',
                    'grandTotal']
            ],
        ]);

        return $dataProvider;
    }
    
	public function searchs()
    {
         
        $start = date('Y-m-d',strtotime($this->startDate)) ? date('Y-m-d',strtotime($this->startDate)) : null;
        $end = date('Y-m-d',strtotime($this->endDate. ' +1 day')) ?  date('Y-m-d',strtotime($this->endDate. ' +1 day')) : null;
        $query = self::find()
            ->select('tr_goodsreceipthead.AWBNum,tr_purchaseorderhead.purchaseOrderNum, '
                . 'tr_goodsdeliveryhead.invoiceNum,tr_purchaseorderhead.shipmentDate,'
                . 'tr_purchaseorderdetail.qty as qtyPO,tr_salesorderhead.salesOrderNum, ms_product.origin , '
                . 'ms_product.productName,tr_salesorderhead.refNum, tr_salesorderhead.customerID, ms_customer.customerName, '
                . 'tr_salesorderhead.salesOrderDate, tr_salesorderhead.grandTotal, tr_salesorderhead.customerOrderNum, tr_salesorderhead.dueDate, ms_customerdetail.city')
            ->addSelect(['orderStatus' => new Expression('IFNULL(tr_goodsdeliveryhead.refNum,0)'),
                'qtyAvailable' => new Expression('CASE
                                    WHEN tr_goodsreceiptdetail.qty > 0 THEN "Available"
                                    ELSE "On Going"
                                END') ])
            ->joinWith('purchaseOrder.purchaseOrderDetails')
            ->joinWith('purchaseOrder.goodsReceipt')
            ->joinWith('purchaseOrder.goodsReceipt.goodsReceiptDetails')
            ->joinWith('salesOrderDetails.product')
            ->joinWith('goodsDelivery')
            ->joinWith('goodsDelivery.goodsDeliveryDetails')
            ->joinWith('purchaseOrder.goodsReceipt')
            ->joinWith('customer')
            ->joinWith('customerDetailName')
            ->where('tr_salesorderhead.salesOrderNum IN
                (
                   SELECT  IFNULL(tr_goodsdeliveryhead.refNum,0) orderStatus
                    FROM `tr_salesorderhead` 
                    LEFT JOIN `tr_goodsdeliveryhead` ON `tr_salesorderhead`.`salesOrderNum` = `tr_goodsdeliveryhead`.`refNum` 

                ) = 0')
            ->andFilterWhere(['like', 'ms_product.origin', $this->origin])
            ->andFilterWhere(['like', 'tr_salesorderhead.salesOrderNum', $this->salesOrderNum])
            ->andFilterWhere(['like', 'ms_product.productName', $this->productName])
            ->andFilterWhere(['like', 'tr_salesorderhead.refNum', $this->refNum])
            ->andFilterWhere(['like', 'tr_salesorderhead.deliveryDestination', $this->deliveryDestination])
            ->andFilterWhere(['like', 'ms_customer.customerName', $this->customerName])
            ->andFilterWhere(['like', 'tr_salesorderhead.grandTotal', $this->grandTotal])
            ->andFilterWhere(['between', 'tr_salesorderhead.salesOrderDate', $start, $end]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['salesOrderDate' => SORT_DESC],
                'attributes' => [
                    'salesOrderDate',
                    'salesOrderNum',
                    'refNum',
                    'customerName',
                    'productName',
                    'qtyPO',
                    'deliveryDestination',
                    'dueDate',
                    'shipmentDate',
                    'purchaseOrderNum',
                    'customerOrderNum',
                    'grandTotal']
            ],
        ]);

        return $dataProvider;
    }
  
    public function afterFind(){
        parent::afterFind();
        $this->salesOrderDate = AppHelper::convertDateTimeFormat($this->salesOrderDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->dueDate = AppHelper::convertDateTimeFormat($this->dueDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->joinSalesOrderDetail = [];
            
        $i = 0;
        foreach ($this->salesOrderDetails as $joinSalesOrderDetail) {
            $this->joinSalesOrderDetail[$i]["productID"] = $joinSalesOrderDetail->productID;
            $this->joinSalesOrderDetail[$i]["productName"] = $joinSalesOrderDetail->product->productName;
            $this->joinSalesOrderDetail[$i]["uomID"] = $joinSalesOrderDetail->uomID;
            $this->joinSalesOrderDetail[$i]["uomName"] = $joinSalesOrderDetail->uom->uomName;
            $this->joinSalesOrderDetail[$i]["qty"] = $joinSalesOrderDetail->qty;
            $this->joinSalesOrderDetail[$i]["price"] = $joinSalesOrderDetail->price;
            $this->joinSalesOrderDetail[$i]["discount"] = $joinSalesOrderDetail->discount;
            $this->joinSalesOrderDetail[$i]["priceOffer"] = $joinSalesOrderDetail->subTotal;
            $i += 1;
        }
    }
}
