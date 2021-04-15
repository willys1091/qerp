<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * This is the model class for table "stock_hpp".
 *
 * @property string $ID
 * @property string $stockDate
 * @property string $refNum
 * @property string $expiredDate
 * @property integer $warehouseID
 * @property integer $productID
 * @property string $HPP
 * @property string $qtyStock
 */
class StockHpp extends \yii\db\ActiveRecord
{
    public $productName;
    public $uomID;
    public $uomName;
    public $expiredOrRetestDate;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_stockhpp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stockDate', 'refNum', 'manufactureDate', 'warehouseID', 'productID', 'HPP', 'qtyStock'], 'required','on' => 'create'],
            [['stockDate', 'refNum', 'manufactureDate', 'warehouseID', 'productID', 'HPP', 'qtyStock'], 'safe','on' => 'update'],
            [['HPP', 'qtyStock'], 'number'],
            [['productName',  'expiredDate'], 'safe'],
            [['warehouseID', 'productID'], 'integer'],
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
            'stockDate' => 'Date',
            'refNum' => 'Reference Number',
            'batchNumber' => 'Batch Number',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'expiredOrRetestDate' => 'Expired/Retest Date',
            'warehouseID' => 'Warehouse',
            'productID' => 'Product',
            'HPP' => 'HPP',
            'qtyStock' => 'Stock Qty',
            'uomName' => 'Unit',
        ];
    }
    
    public static function addStock($warehouseID, $batchNumber, $refNum, $hpp, $qty, $manufactureDate, $retestDate, $expiredDate, $stockDate = null)
    {
        $transaction = Yii::$app->db->beginTransaction();
        if (!$stockDate) $stockDate = date('Y-m-d H:i:s');
        
        $oldStock = self::find()->where(['warehouseID' => $warehouseID, 'batchNumber' => $batchNumber, 'HPP' => $hpp, 'refNum' => $refNum])->one();
        
        if ($oldStock)
        {
            $oldStock->qtyStock += $qty;
            if (!$oldStock->save())
            {
                $transaction->rollBack();
                return false;
            }
        } else 
        {
            $newStock = new StockHpp([
                'warehouseID' => $warehouseID,
                'batchNumber' => $batchNumber,
                'refNum' => $refNum,
                'HPP' => $hpp,
                'qtyStock' => $qty,
                'manufactureDate' => $manufactureDate,
                'retestDate' => $retestDate,
                'expiredDate' => $expiredDate,
                'stockDate' => $stockDate
            ]);
            
            if (!$newStock->save())
            {
                $transaction->rollBack();
                return false;
            }
        }
        
        $transaction->commit();
        return true;
    }
    
    /**
     * 
     * @param type $warehouseID
     * @param type $batchNumber
     * @param type $qty
     * @return array
     */
    public static function cutStock($warehouseID, $batchNumber, $qty)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $stocks = self::find()->where(['warehouseID' => $warehouseID, 'batchNumber' => $batchNumber])->all();
        
        $hpps = [];
        
        $qtyNeed = abs($qty);
        foreach($stocks as $stock)
        {
            $availableQty = $stock->qtyStock;
            
            if ($availableQty > 0)
            {
                $stock->qtyStock = max(0, $availableQty - $qtyNeed);
                $qtyNeed = max(0, $qtyNeed - $availableQty);
                
                if (array_key_exists("$stock->HPP", $hpps))
                {
                     $hpps["$stock->HPP"]['qty'] = $hpps["$stock->HPP"]['qty'] + ($availableQty - $stock->qtyStock);
                } else 
                {
                    $hpps["$stock->HPP"] = [
                        'refNum' => $stock->refNum,
                        'stockDate' => $stock->stockDate,
                        'qty' => $availableQty - $stock->qtyStock,
                        'HPP' => $stock->HPP,
                        'retestDate' => $stock->retestDate,
                        'manufactureDate' => $stock->manufactureDate,
                        'expiredDate' => $stock->expiredDate
                    ];
                }
                
                if (!$stock->save())
                {
                    Yii::trace($stock->getErrors(), 'WKWK');
                    $transaction->rollback();
                    return [];
                }
            }
            
            if ($qtyNeed == 0) break;
        }
        
        $transaction->commit();
        return array_values($hpps);
    }
    
    public static function cutStockFound($warehouseID, $batchNumber)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $stocks = self::find()->where(['warehouseID' => $warehouseID, 'batchNumber' => $batchNumber])->all();
        
        $hpps = [];
        
        $qtyNeed = abs($qty);
        foreach($stocks as $stock)
        {
           
                    $hpps["$stock->HPP"] = [
                        'refNum' => $stock->refNum,
                        'stockDate' => $stock->stockDate,
                        'HPP' => $stock->HPP,
                        
                    ];
              
                
           
        }
        
        $transaction->commit();
        return array_values($hpps);
    }
    
    public static function cutStockOpname($warehouseID, $batchNumber, $qty)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $stocks = self::find()->where(['warehouseID' => $warehouseID, 'batchNumber' => $batchNumber])->all();
        
        $hpps = [];
        
        $qtyNeed = abs($qty);
        $qtyNeeds = abs($qty);
        foreach($stocks as $stock)
        {
            $availableQty = $stock->qtyStock;
            
            if ($availableQty > 0)
            {
                $stock->qtyStock = max(0, $qty);
               
                
                if (array_key_exists("$stock->HPP", $hpps))
                {
                     $hpps["$stock->HPP"]['qty'] = $stock->qtyStock;
                } else 
                {
                    $hpps["$stock->HPP"] = [
                        'refNum' => $stock->refNum,
                        'stockDate' => $stock->stockDate,
                        'qty' => $stock->qtyStock,
                        'HPP' => $stock->HPP
                    ];
                }
                
                if (!$stock->save())
                {
                    Yii::trace($stock->getErrors(), 'WKWK');
                    $transaction->rollback();
                    return [];
                }
            }
            
            if ($qtyNeed == 0) break;
        }
        
        $transaction->commit();
        return array_values($hpps);
    }
    
    public function search()
    {
        $query = self::find()
            ->select(['productID','warehouseID','expiredDate',new Expression('SUM(qtyStock) as qtyStock')])
            ->andFilterWhere(['=', 'warehouseID', $this->warehouseID])
            ->andFilterWhere(['=', 'productID', $this->productID])
            ->andfilterWhere(['=', "DATE_FORMAT(expiredDate, '%d-%m-%Y')", $this->expiredDate])
            ->groupBy(['productID', 'warehouseID']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['warehouseID' => SORT_ASC],
                'attributes' => [
                    'warehouseID',
                    'productID',
                    'expiredDate',
                ],
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
    
    public function searchs()
    {
        $query = new ActiveDataProvider([
                            'query' => StockHpp::find()
                                        ->select(['tr_stockhpp.productID','ms_productdetail.uomID','ms_uom.uomName','tr_stockhpp.batchNumber','tr_stockhpp.manufactureDate','tr_stockhpp.expiredDate','tr_stockhpp.retestDate','ms_product.productName','tr_stockhpp.HPP',new Expression('SUM(tr_stockhpp.qtyStock) as qtyStock')])
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_stockhpp.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = tr_stockhpp.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('tr_stockhpp.warehouseID = :refNum',[':refNum' => $filter])
                                        ->groupBy('tr_stockhpp.productID')
                                        ->groupBy('tr_stockhpp.batchNumber')
//                                        ->orderBy(['ms_product.productName'=>SORT_ASC])
                        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'uomName',
                    'qtyStock',
                    'HPP',
                ],
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
    public function getParentProduct(){
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
    public function getParentWarehouse(){
        return $this->hasOne(MsWarehouse::className(), ['warehouseID' => 'warehouseID']);
    }
}
