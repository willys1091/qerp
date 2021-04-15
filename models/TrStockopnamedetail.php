<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_stockopnamedetail".
 *
 * @property integer $stockOpnameDetailID
 * @property string $stockOpnameNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $manufactureDate
 * @property string $expiredDate
 * @property string $qtyInStock
 * @property string $qtyReal
 * @property string $HPP
 */
class TrStockopnamedetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_stockopnamedetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stockOpnameNum', 'productID', 'uomID', 'qtyInStock', 'qtyReal', 'HPP'], 'required'],
            [['stockOpnameDetailID', 'productID', 'uomID'], 'integer'],
            [['manufactureDate', 'expiredDate','retestDate'], 'safe'],
            [['qtyInStock', 'qtyReal', 'HPP'], 'string'],
            [['stockOpnameNum','batchNumber'], 'string', 'max' => 50],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['stockOpnameNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrStockopnamehead::className(), 'targetAttribute' => ['stockOpnameNum' => 'stockOpnameNum']],
            [['uomID'], 'exist', 'skipOnError' => true, 'targetClass' => MsUom::className(), 'targetAttribute' => ['uomID' => 'uomID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stockOpnameDetailID' => 'Stock Opname Detail ID',
            'stockOpnameNum' => 'Stock Opname Num',
            'productID' => 'Product ID',
            'uomID' => 'Uom ID',
            'batchNumber' => 'Batch Number',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'qtyInStock' => 'Qty In Stock',
            'qtyReal' => 'Qty Real',
            'HPP' => 'Hpp',
        ];
    }
    public function getProduct(){
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
    public function getUom(){
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID']);
    }
    public function getHpps()
    {
        return $this->hasMany(StockOpnameDetailHpp::className(), ['stockOpnameDetailID' => 'stockOpnameDetailID']);
    }
    
//    public function afterFind()
//    {
//        $this->qtyInStock = StockCard::find()
//            ->where(['batchNumber' => $this->batchNumber,'productID' => $this->productID])
//            ->sum('inQty - outQty');
//    }
}
