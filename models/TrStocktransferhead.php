<?php

namespace app\models;

use app\components\AppHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * This is the model class for table "tr_stocktransferhead".
 *
 * @property string $stockTransferNum
 * @property string $stockTransferDate
 * @property integer $sourceWarehouseID
 * @property integer $destinationWarehouseID
 * @property string $notes
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrStocktransferhead extends \yii\db\ActiveRecord
{
    public $deliveryStatus;
    public $joinStockDetail;
    public $warehouseName, $status;
    
    public $startDate, $endDate;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_stocktransferhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stockTransferDate', 'sourceWarehouseID', 'destinationWarehouseID'], 'required'],
            [['stockTransferDate', 'createdDate', 'editedDate', 'startDate','endDate','notes', 'status'], 'safe'],
            [['sourceWarehouseID', 'destinationWarehouseID'], 'integer'],
            [['sourceWarehouseID'], 'compare', 'compareAttribute' => 'destinationWarehouseID', 'operator' => '!=', 'skipOnEmpty'=>true],
            [['destinationWarehouseID'], 'compare', 'compareAttribute' => 'sourceWarehouseID', 'operator' => '!=', 'skipOnEmpty'=>true],
            [['stockTransferNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 200],
            [['joinStockDetail'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stockTransferNum' => 'Stock Transfer Number',
            'stockTransferDate' => 'Date',
            'sourceWarehouseID' => 'Source Warehouse',
            'destinationWarehouseID' => 'Destination Warehouse',
            'notes' => 'Notes',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->select('stockTransferNum, stockTransferDate, sourceWarehouseID, destinationWarehouseID, notes')
            ->addSelect(new Expression('IFNULL(tr_goodsdeliveryhead.refNum,0) deliveryStatus'))
            ->joinWith('goodsDelivery')
            ->andFilterWhere(['like', 'stockTransferNum', $this->stockTransferNum])
            ->andFilterWhere(['=', 'sourceWarehouseID', $this->sourceWarehouseID])
            ->andFilterWhere(['=', 'destinationWarehouseID', $this->destinationWarehouseID]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate));
            
            $query->andFilterWhere(['>=', 'stockTransferDate', $start]);
            $query->andFilterWhere(['<=', 'stockTransferDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['stockTransferDate' => SORT_DESC],
                'attributes' => [
                    'stockTransferDate',
                    'stockTransferNum',
                    'sourceWarehouseID',
                    'destinationWarehouseID',
                ],
            ],
        ]);

        return $dataProvider;
    }
    public function getSourceWarehouse(){
        return $this->hasOne(MsWarehouse::className(), ['warehouseID' => 'sourceWarehouseID']);
    }
    public function getDestinationWarehouse(){
        return $this->hasOne(MsWarehouse::className(), ['warehouseID' => 'destinationWarehouseID']);
    }
    public function getGoodsDelivery()
    {
        return $this->hasMany(TrGoodsdeliveryhead::className(), ['refNum' => 'stockTransferNum']);
    }
    public function getStockTransferDetails()
    {
        return $this->hasMany(TrStocktransferdetail::className(), ['stockTransferNum' => 'stockTransferNum']);
    }
    public function afterFind(){
//        addRow(entry.productID.toString(), 
//            entry.productName.toString(), 
//            entry.uomID.toString(), 
//            entry.uomName.toString(), 
//            entry.manufactureDate.toString(), 
//            entry.expiredDate.toString(), 
//            entry.qty.toString(), 
//            entry.transferedQty.toString());
        parent::afterFind();
        $this->stockTransferDate = AppHelper::convertDateTimeFormat($this->stockTransferDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->joinStockDetail = [];
        
        $sql = "SELECT IF(COUNT(*) = 1 AND x.equal = 1, 0, 1) AS used FROM (
                SELECT detail.qtyTransfer = stockhpp.qtyStock AS equal FROM tr_stocktransferdetail AS detail
                LEFT JOIN tr_stockhpp AS stockhpp ON stockhpp.refNum = detail.stockTransferNum
                AND stockhpp.productID = detail.productID AND stockhpp.batchNumber = detail.batchNumber
                WHERE stockTransferNum = '$this->stockTransferNum'
                GROUP BY detail.qtyTransfer = stockhpp.qtyStock
            ) x;";
        $this->status = Yii::$app->db->createcommand($sql)->queryScalar();
        $i = 0;
        foreach ($this->getStockTransferDetails()->all() as $joinStockDetail) {
            $this->joinStockDetail[$i]["productID"] = $joinStockDetail->productID;
            $this->joinStockDetail[$i]["productName"] = $joinStockDetail->product->productName;
            $this->joinStockDetail[$i]["uomID"] = $joinStockDetail->uomID;
            $this->joinStockDetail[$i]["uomName"] = $joinStockDetail->uom->uomName;
            $this->joinStockDetail[$i]["batchNumber"] = $joinStockDetail->batchNumber;
            $this->joinStockDetail[$i]["manufactureDate"] =  AppHelper::convertDateTimeFormat($joinStockDetail->manufactureDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinStockDetail[$i]["expiredDate"] =  AppHelper::convertDateTimeFormat($joinStockDetail->expiredDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinStockDetail[$i]["qty"] = $joinStockDetail->qtyInStock;
            $this->joinStockDetail[$i]["transferedQty"] = $joinStockDetail->qtyTransfer;
            $this->joinStockDetail[$i]["stockTransferDetailID"] = $joinStockDetail->stockTransferDetailID;
            
            $i += 1;
        }
    }
}
