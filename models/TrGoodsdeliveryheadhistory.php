<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use app\components\MdlDb;
use yii\db\Expression;

/**
 * This is the model class for table "tr_goodsdeliveryhead".
 *
 * @property string $goodsDeliveryNum
 * @property string $refNum
 * @property string $transType
 * @property string $goodsDeliveryDate
 * @property string $deliveryNum
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrGoodsdeliveryheadhistory extends \yii\db\ActiveRecord
{
    public $customerID;
    public $sendTo;
    public $advancePaymentNum;
    public $goodsDeliveryTime;
    public $joinGoodsDeliveryDetail;
    public $joinStockDetail;
    public $status;
    
    public $startDate, $endDate;
    
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
            [['goodsDeliveryNum', 'refNum', 'goodsDeliveryDate'], 'required'],
            [['goodsDeliveryDate', 'goodsDeliveryTime', 'createdDate', 'editedDate'], 'safe'],
            [['goodsDeliveryNum', 'refNum', 'invoiceNum', 'transType', 'shipmentBy', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['deliveryNum'], 'string', 'max' => 200],
            [['additionalInfo'], 'string', 'max' => 45],
            [['status'], 'string'],
            [['customerDetailID','deliveryStatus'], 'integer'],
            [['joinGoodsDeliveryDetail', 'joinStockDetail', 'startDate', 'endDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goodsDeliveryNum' => 'Goods Delivery Number',
            'invoiceNum' => 'PO Number',
            'refNum' => 'Reference Number',
            'transType' => 'Transaction Type',
            'goodsDeliveryDate' => 'Goods Delivery Date',
            'goodsDeliveryTime' => 'Goods Delivery Time',
            'customerDetailID' => 'Delivery Address',
            'deliveryNum' => 'Delivery Number',
            'shipmentBy' => 'Shipment By',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'sendTo' => 'Delivery to'
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'goodsDeliveryNum', $this->goodsDeliveryNum])
            ->andFilterWhere(['like', 'invoiceNum', $this->invoiceNum])
            ->andFilterWhere(['like', 'refNum', $this->refNum])
            ->andFilterWhere(['like', 'transType', $this->transType])
            ->andFilterWhere(['=', "deliveryStatus", $this->deliveryStatus]);
        if ($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['between', 'goodsDeliveryDate', $start, $end]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['goodsDeliveryDate' => SORT_DESC],
                'attributes' => ['goodsDeliveryDate']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $dataProvider->sort->attributes['goodsDeliveryNum'] = [
            'asc' => ['goodsDeliveryNum' => SORT_ASC],
            'desc' => ['goodsDeliveryNum' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['invoiceNum'] = [
            'asc' => ['invoiceNum' => SORT_ASC],
            'desc' => ['invoiceNum' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['transType'] = [
            'asc' => ['transType' => SORT_ASC],
            'desc' => ['transType' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['refNum'] = [
            'asc' => ['refNum' => SORT_ASC],
            'desc' => ['refNum' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['deliveryStatus'] = [
            'asc' => ['deliveryStatus' => SORT_ASC],
            'desc' => ['deliveryStatus' => SORT_DESC],
        ];

        return $dataProvider;
    }
    public function getGoodsDeliveryDetails()
    {
        return $this->hasMany(TrGoodsdeliverydetail::className(), ['goodsDeliveryNum' => 'goodsDeliveryNum']);
    }
    public function getJournal()
    {
        return $this->hasMany(TrJournalhead::className(), ['refNum' => 'goodsDeliveryNum']);
    }
    
    public function getStockOut ()
    {
        return $this->hasMany(StockCard::className(), ['refNum' => 'goodsDeliveryNum']);
    }
    
    public function getLkStatus()
    {
        return $this->hasOne(LkStatus::className(), ['statusID' => 'deliveryStatus']);
    }
    public function afterFind(){
        parent::afterFind();
        $this->goodsDeliveryTime = date("H",strtotime($this->goodsDeliveryDate)).":".date("i",strtotime($this->goodsDeliveryDate));
        $this->goodsDeliveryDate = AppHelper::convertDateTimeFormat($this->goodsDeliveryDate, 'Y-m-d H:i:s', 'd-m-Y');
        
        if($this->transType == "Sales Order"){
            $modelSendTo = TrSalesorderhead::find()
                            ->select('tr_salesorderhead.customerID, ms_customer.customerName')
                            ->joinWith('customer')
                            ->where(['salesOrderNum' => $this->refNum])
                            ->one();
            $this->customerID = $modelSendTo->customerID;
            $this->sendTo = $modelSendTo->customerName;
        }
        else if($this->transType == "Purchase Return"){
            $modelSendTo = TrPurchasereturnhead::find()
                                    ->select('ms_supplier.supplierName')
                                    ->joinWith('supplier')
                                    ->where(['purchaseReturnNum' => $this->refNum])
                                    ->one();
            $this->customerID = 0;
            $this->sendTo = $modelSendTo->supplierName;
        }
        else if($this->transType == "Stock Transfer"){
            $modelSendTo = TrStocktransferhead::find()
                                    ->select('ms_warehouse.warehouseName,tr_stocktransferhead.sourceWarehouseID')
                                    ->joinWith('destinationWarehouse')
                                    ->where(['stockTransferNum' => $this->refNum])
                                    ->one();
            $this->customerID = 0;
            $this->sendTo = $modelSendTo->warehouseName;
        }
        
        $this->joinGoodsDeliveryDetail = [];
        $i = 0;
        
        $sql = "SELECT a.notes, a.productID,p.productName,a.uomID,e.uomName,a.batchNumber,a.manufactureDate,a.expiredDate,a.retestDate,a.qty,a.pack,f.packingTypeName,a.packQty
            from tr_goodsdeliverydetail a join tr_goodsdeliveryhead b
            on a.goodsDeliveryNum=b.goodsDeliveryNum
            join ms_product p on a.productID=p.productID
            left join ms_uom e on a.uomID=e.uomID
            left join ms_packingtype f on a.pack=f.packingTypeID
            where a.goodsDeliveryNum='".$this->goodsDeliveryNum."'";
        
        $connection = MdlDb::getDbConnection();
        $temp = $connection->createCommand($sql);
        $headResult = $temp->queryAll();

        $i = 0;
        foreach ($headResult as $detailMenu) {
            $this->joinGoodsDeliveryDetail[$i]["productID"] = $detailMenu['productID'];
            $this->joinGoodsDeliveryDetail[$i]["productName"] = $detailMenu['productName'];
            $this->joinGoodsDeliveryDetail[$i]["uomID"] = $detailMenu['uomID'];
            $this->joinGoodsDeliveryDetail[$i]["uomName"] = $detailMenu['uomName'];
            $this->joinGoodsDeliveryDetail[$i]["qtyOutstanding"] = "0,00";
            $this->joinGoodsDeliveryDetail[$i]["qty"] = $detailMenu['qty'];
            $this->joinGoodsDeliveryDetail[$i]["packID"] = $detailMenu['pack'];
            $this->joinGoodsDeliveryDetail[$i]["packName"] = $detailMenu['packingTypeName'];
            $this->joinGoodsDeliveryDetail[$i]["packQty"] = $detailMenu['packQty'];
            $this->joinGoodsDeliveryDetail[$i]["batchNumberID"] = $detailMenu['batchNumber'];
            $this->joinGoodsDeliveryDetail[$i]["batchNumber"] = $detailMenu['batchNumber'];
            $this->joinGoodsDeliveryDetail[$i]["notes"] = $detailMenu['notes'] ? $detailMenu['notes'] : '';
            $this->joinGoodsDeliveryDetail[$i]["manufactureDate"] = AppHelper::convertDateTimeFormat($detailMenu['manufactureDate'], 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinGoodsDeliveryDetail[$i]["expiredDate"] = AppHelper::convertDateTimeFormat($detailMenu['expiredDate'], 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinGoodsDeliveryDetail[$i]["retestDate"] = '';
            
            if(!empty($detailMenu['expiredDate'])) $this->joinGoodsDeliveryDetail[$i]["expiredDate"] = AppHelper::convertDateTimeFormat($detailMenu['expiredDate'], 'Y-m-d H:i:s', 'd-m-Y');
            if(!empty($detailMenu['retestDate'])) $this->joinGoodsDeliveryDetail[$i]["retestDate"] = AppHelper::convertDateTimeFormat($detailMenu['retestDate'], 'Y-m-d H:i:s', 'd-m-Y');
            $i += 1;
        }

    } 
    
    public function beforeDelete() {
        
        if (!parent::beforeDelete()) {
            return false;
        }
        
        foreach($this->journal AS $journal)
        {
            $journal->delete();
        }
        
        foreach ($this->stockOut AS $stockOut)
        {
            $stockOut->delete();
        }
        
        return true;
    }
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
       
        $i = 0;
        foreach ($this->joinGoodsDeliveryDetail as $detailMenu) {
            $deliveryDetail = TrGoodsdeliverydetail::findOne(['goodsDeliveryNum' => $this->goodsDeliveryNum, 'productID' => $detailMenu['productID']]);
            $deliveryDetail->notes = $detailMenu['notes'];
            $deliveryDetail->save();
            $i += 1;
        }
              
        return true;
    }
}
