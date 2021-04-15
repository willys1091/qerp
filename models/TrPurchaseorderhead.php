<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\db\Expression;

/**
 * This is the model class for table "tr_purchaseorderhead".
 *
 * @property string $purchaseOrderNum
 * @property string $refNum
 * @property string $purchaseOrderDate
 * @property string $shipmentDate
 * @property integer $supplierID
 * @property string $currencyID
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
class TrPurchaseorderhead extends \yii\db\ActiveRecord
{
    public $joinPurchaseOrderDetail;
    public $grandtotalIDR;
    public $grandtotal;
    public $supplierName;
    public $orderStatus;
    public $subTotal;
    public $dateFrom;
    public $taxTotal;
    public $startDate,$endDate, $productID , $startDates,$endDates;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_purchaseorderhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchaseOrderNum', 'purchaseOrderDate', 'supplierID', 'currencyID', 'rate', 'contactPerson'], 'required'],
            [['purchaseOrderDate', 'shipmentDate', 'createdDate', 'editedDate', 'grandtotalIDR','grandtotal', 'productID','giroNumber','supplierpaymentDate','notes','revitionNotes'], 'safe'],
            [['isImport', 'hasVAT'], 'boolean'],
            [['paymentID', 'paymentDue'], 'integer'],
            [['rate', 'taxRate', 'grandTotal'], 'string'],
            [['purchaseOrderNum', 'refNum', 'contactPerson', 'deliveryType', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['currencyID'], 'string', 'max' => 5],
            [['shipmentType','packingType'], 'string', 'max' => 100],
            [['startDate','endDate','joinPurchaseOrderDetail', 'contactPersonCC', 'additionalInfo', 'giroNumber'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'giroNumber' => 'Giro Number',
            'supplierpaymentDate' => 'Supplier Payment Date',
            'purchaseOrderNum' => 'Purchase Order Number',
            'refNum' => 'Sales Order Number',
            'purchaseOrderDate' => 'Date',
            'shipmentType' => 'Shipment',
            'shipmentDate' => 'Shipment Date',
            'packingType' => 'Packing Type',
            'paymentDue' => 'Payment',
            'deliveryType' => 'Delivery',
            'supplierID' => 'Supplier',
            'supplierName' => 'Supplier',
            'isImport' => 'Is Import Products?',
            'hasVAT' => 'Has VAT?',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'paymentID' => 'Payment ID',
            'taxRate' => 'Tax Rate',
            'grandTotal' => 'Grand Total',
            'additionalInfo' => 'Additional Info',
			'revitionNotes' => 'Revision Notes',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'orderStatus' => 'Order Status',
            'contactPerson' => 'Attendant',
            'contactPersonCC' => 'CC Contact Person',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'productID' => 'Product',
            'productName' => 'Product',
        ];
    }
    
    public function init() {
        parent::init();
        
        $this->isImport = 0;
        $this->hasVAT = 0;
    }
    
    public function getCurrency()
    {
        return $this->hasOne(MsCurrency::className(), ['currencyID' => 'currencyID']);
    }
    
    public function getPaymentMethod()
    {
        return $this->hasOne(LkPaymentMethod::className(), ['paymentID' => 'paymentID']);
    }
    public function getTax()
    {
        return $this->hasOne(MsTax::className(), ['taxID' => 'taxID']);
    }
    public function getSupplier()
    {
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
  
    
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(TrPurchaseOrderdetail::className(), ['purchaseOrderNum' => 'purchaseOrderNum']);
    }
    
    public function getParentSupplier(){
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
    
    public function getGoodsReceipt()
    {
        return $this->hasMany(TrGoodsreceipthead::className(), ['refNum' => 'purchaseOrderNum']);
    }
    
    public function getSampleReceipt()
    {
        return $this->hasMany(TrSamplereceipthead::className(), ['refNum' => 'purchaseOrderNum']);
    }
    
    public function getSupplierAdvancePayment() {
        return $this->hasMany(TrSupplieradvancepayment::className(), ['refNum' => 'purchaseOrderNum']);
    }
    
    public function search()
    {
        $query = self::find()
                ->select('tr_purchaseorderhead.notes,tr_purchaseorderhead.giroNumber, tr_purchaseorderhead.supplierpaymentDate, tr_purchaseorderhead.purchaseOrderNum, tr_purchaseorderhead.purchaseOrderDate, tr_purchaseorderhead.shipmentDate, tr_purchaseorderhead.supplierID, tr_purchaseorderhead.currencyID, tr_purchaseorderhead.rate, tr_purchaseorderhead.grandTotal')
                ->addSelect(new Expression('IFNULL(tr_goodsreceipthead.refNum,IFNULL(tr_samplereceipthead.refNum,0)) orderStatus'))
                ->joinWith('goodsReceipt')
                ->joinWith('purchaseOrderDetails.product')
                ->joinWith('sampleReceipt')
                ->joinWith('supplier')
                ->joinWith('currency')
                ->andFilterWhere(['like', 'tr_purchaseorderhead.giroNumber', $this->giroNumber])
                ->andFilterWhere(['like', 'tr_purchaseorderhead.purchaseOrderNum', $this->purchaseOrderNum])
                ->andFilterWhere(['like', 'ms_product.productName', $this->productID])
                ->andFilterWhere(['=', 'tr_purchaseorderhead.grandTotal', $this->grandTotal])
                ->andFilterWhere(['=', 'ms_currency.currencyID', $this->currencyID])
                ->andFilterWhere(['like', 'ms_supplier.supplierName', $this->supplierID])
                ->andFilterWhere(['like', 'tr_purchaseorderhead.notes', $this->notes])
            ;
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'tr_purchaseorderhead.purchaseOrderDate', $start]);
            $query->andFilterWhere(['<=', 'tr_purchaseorderhead.purchaseOrderDate', $end]);
        }
        
//        if($this->startDates && $this->endDates)
//        {
//            $start = date('Y-m-d',strtotime($this->startDates));
//            $end = date('Y-m-d',strtotime($this->endDates. ' +1 day'));
//            
//            $query->andFilterWhere(['>=', 'tr_purchaseorderhead.supplierpaymentDate', $start]);
//            $query->andFilterWhere(['<=', 'tr_purchaseorderhead.supplierpaymentDate', $end]);
//        }
        
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                        'defaultOrder' => ['purchaseOrderNum' => SORT_DESC],
                        'attributes' => ['purchaseOrderNum']
                ],
        ]);
        
        $dataProvider->sort->attributes['purchaseOrderDate'] = [
                'asc' => [self::tableName() . '.purchaseOrderDate' => SORT_ASC],
                'desc' => [self::tableName() . '.purchaseOrderDate' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['supplierpaymentDate'] = [
                'asc' => [self::tableName() . '.supplierpaymentDate' => SORT_ASC],
                'desc' => [self::tableName() . '.supplierpaymentDate' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['giroNumber'] = [
                'asc' => [self::tableName() . '.giroNumber' => SORT_ASC],
                'desc' => [self::tableName() . '.giroNumber' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['productID'] = [
                'asc' => ['ms_product.productName' => SORT_ASC],
                'desc' => ['ms_product.productName' => SORT_DESC],
        ];
    
        $dataProvider->sort->attributes['grandTotal'] = [
                'asc' => [self::tableName() . '.grandTotal' => SORT_ASC],
                'desc' => [self::tableName() . '.grandTotal' => SORT_DESC],
        ];
    
        $dataProvider->sort->attributes['supplierID'] = [
                'asc' => ['supplierID' => SORT_ASC],
                'desc' => ['supplierID' => SORT_DESC],
        ];
    
        $dataProvider->sort->attributes['currencyID'] = [
                'asc' => ['ms_currency.currencyID' => SORT_ASC],
                'desc' => ['ms_currency.currencyID' => SORT_DESC],
        ];
    
        return $dataProvider;
        
        
    }
    public function searchBrowse()
    {
        $query = self::find()
                ->andFilterWhere(['like', 'purchaseOrderNum', $this->purchaseOrderNum])
                ->andFilterWhere(['=', "DATE_FORMAT(purchaseOrderDate, '%d-%m-%Y')", $this->purchaseOrderDate])
                ->andFilterWhere(['=', 'grandTotal', $this->grandTotal])
                ->andFilterWhere(['=', 'supplierID', $this->supplierID]);

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                        'defaultOrder' => ['purchaseOrderNum' => SORT_DESC],
                        'attributes' => ['purchaseOrderNum']
                ],
        ]);

        return $dataProvider;
    }

    public function afterFind(){
        parent::afterFind();
        if(Yii::$app->user->identity->userRole == 'ACCOUNTING-FETI'){
            
        } else {
            
        
        $this->purchaseOrderDate = AppHelper::convertDateTimeFormat($this->purchaseOrderDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->shipmentDate = AppHelper::convertDateTimeFormat($this->shipmentDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->supplierName = $this->parentSupplier->supplierName;
        
		Yii::trace($this->purchaseOrderNum, 'DEBUG POD');
		
        $this->joinPurchaseOrderDetail = [];
        $i = 0;
        foreach ($this->getPurchaseOrderDetails()->all() as $joinPurchaseOrderDetail) {
            $this->joinPurchaseOrderDetail[$i]["productID"] = $joinPurchaseOrderDetail->productID;
            $this->joinPurchaseOrderDetail[$i]["productName"] = $joinPurchaseOrderDetail->product->productName;
            $this->joinPurchaseOrderDetail[$i]["uomID"] = $joinPurchaseOrderDetail->uomID;
            $this->joinPurchaseOrderDetail[$i]["uomName"] = $joinPurchaseOrderDetail->uom->uomName;
            $this->joinPurchaseOrderDetail[$i]["qty"] = $joinPurchaseOrderDetail->qty;
            $this->joinPurchaseOrderDetail[$i]["price"] = $joinPurchaseOrderDetail->price;
            $this->joinPurchaseOrderDetail[$i]["discount"] = $joinPurchaseOrderDetail->discount;
            $this->joinPurchaseOrderDetail[$i]["subTotal"] = $joinPurchaseOrderDetail->subTotal;
            $i += 1;
        }
        }
    }
    
    public function fillDetail() {
        $this->joinPurchaseOrderDetail = [];
        $i = 0;
        foreach($this->getSalesQuotationDetails()->all() as $detail) {
            $this->joinPurchaseOrderDetail[$i]["productID"]= $detail->productID;
            $this->joinPurchaseOrderDetail[$i]["productName"]= $detail->product->productName;
            $this->joinPurchaseOrderDetail[$i]["uomID"]= $detail->uomID;
            $this->joinPurchaseOrderDetail[$i]["uomName"]= $detail->uom->uomName;
            $this->joinPurchaseOrderDetail[$i]["qty"]= $detail->qty;
            $this->joinPurchaseOrderDetail[$i]["price"]= $detail->price;
            $this->joinPurchaseOrderDetail[$i]["discount"]= $detail->discount;
            $this->joinPurchaseOrderDetail[$i]["subTotal"]= $detail->subTotal;
            $i++;
        }    
   
    }
}
