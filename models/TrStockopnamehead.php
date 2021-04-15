<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\db\Expression;

/**
 * This is the model class for table "tr_stockopnamehead".
 *
 * @property string $stockOpnameNum
 * @property string $stockOpnameDate
 * @property integer $warehouseID
 * @property string $notes
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrStockopnamehead extends \yii\db\ActiveRecord
{
    public $joinStockDetail;
    public $startDate, $endDate, $status;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_stockopnamehead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stockOpnameNum', 'stockOpnameDate', 'warehouseID'], 'required'],
            [['stockOpnameDate', 'createdDate', 'editedDate', 'startDate','endDate', 'status'], 'safe'],
            [['warehouseID'], 'integer'],
            [['stockOpnameNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 200],
            [['warehouseID'], 'exist', 'skipOnError' => true, 'targetClass' => MsWarehouse::className(), 'targetAttribute' => ['warehouseID' => 'warehouseID']],
            [['joinStockDetail'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stockOpnameNum' => 'Stock Number',
            'stockOpnameDate' => 'Date',
            'warehouseID' => 'Warehouse',
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
            ->where(['type' => 'lose'])
            ->andFilterWhere(['like', 'stockOpnameNum', $this->stockOpnameNum])
            ->andFilterWhere(['=', 'warehouseID', $this->warehouseID]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'stockOpnameDate', $start]);
            $query->andFilterWhere(['<=', 'stockOpnameDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['stockOpnameDate' => SORT_DESC],
                'attributes' => [
                    'stockOpnameDate',
                    'stockOpnameNum',
                    'warehouseID',
                ],
            ],
        ]);

        return $dataProvider;
    }
    
    public function searchFound()
    {
        $query = self::find()
            ->where(['type' => 'found'])
            ->andFilterWhere(['like', 'stockOpnameNum', $this->stockOpnameNum])
            ->andFilterWhere(['=', 'warehouseID', $this->warehouseID]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'stockOpnameDate', $start]);
            $query->andFilterWhere(['<=', 'stockOpnameDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['stockOpnameDate' => SORT_DESC],
                'attributes' => [
                    'stockOpnameDate',
                    'stockOpnameNum',
                    'warehouseID',
                ],
            ],
        ]);

        return $dataProvider;
    }
    
    public function getStockOpnameDetails()
    {
        return $this->hasMany(TrStockopnamedetail::className(), ['stockOpnameNum' => 'stockOpnameNum']);
    }
    public function getParentWarehouse(){
        return $this->hasOne(MsWarehouse::className(), ['warehouseID' => 'warehouseID']);
    }

    public function afterFind(){
        parent::afterFind();
        $this->stockOpnameDate = AppHelper::convertDateTimeFormat($this->stockOpnameDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->joinStockDetail = [];
//             addRow(entry.productID.toString(),
//                 entry.productName.toString(), 
//                 entry.uomID.toString(), 
//                 entry.uomName.toString(), 
//                 entry.batchNumber.toString(), 
//                 entry.manufactureDate.toString(), 
//                 entry.expiredDate.toString(), 
//                 entry.retestDate.toString(), 
//                 entry.qty.toString(), 
//                 entry.realQty.toString(), 
//                 entry.stockHPP.toString(), 
//                 entry.HPP.toString());
         $sql = "SELECT IF(COUNT(*) = 1 AND x.equal = 1, 0, 1) AS used FROM (
            SELECT
            detail.qtyReal = (
                SELECT SUM(qtyStock) FROM tr_stockhpp AS stockhpp WHERE stockhpp.productID = detail.productID AND stockhpp.batchNumber = detail.batchNumber
            ) AS equal
            FROM tr_stockopnamedetail AS detail
            WHERE stockOpnameNum = '$this->stockOpnameNum'
            GROUP BY equal
        ) x;";
        $this->status = Yii::$app->db->createcommand($sql)->queryScalar();
        $i = 0;
        foreach ($this->getStockOpnameDetails()->all() as $joinStockDetail) {
            $this->joinStockDetail[$i]["productID"] = $joinStockDetail->productID;
            $this->joinStockDetail[$i]["productName"] = $joinStockDetail->product->productName;
            $this->joinStockDetail[$i]["uomID"] = $joinStockDetail->uomID;
            $this->joinStockDetail[$i]["uomName"] = $joinStockDetail->uom->uomName;
            $this->joinStockDetail[$i]["batchNumber"] = $joinStockDetail->batchNumber;
            $this->joinStockDetail[$i]["manufactureDate"] = AppHelper::convertDateTimeFormat($joinStockDetail->manufactureDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinStockDetail[$i]["expiredDate"] = AppHelper::convertDateTimeFormat($joinStockDetail->expiredDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinStockDetail[$i]["retestDate"] = AppHelper::convertDateTimeFormat($joinStockDetail->retestDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinStockDetail[$i]["qty"] = $joinStockDetail->qtyInStock;
            $this->joinStockDetail[$i]["realQty"] = $joinStockDetail->qtyReal;
            $this->joinStockDetail[$i]["stockHPP"] = $joinStockDetail->HPP;
            $this->joinStockDetail[$i]["HPP"] = $joinStockDetail->HPP;
            $this->joinStockDetail[$i]["stockOpnameDetailID"] = $joinStockDetail->stockOpnameDetailID;
            $i += 1;
        }
    }
}
