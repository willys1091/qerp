<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_stocktransferdetail".
 *
 * @property string $stockTransferDetailID
 * @property string $stockTransferNum
 * @property integer $productID
 * @property string $qtyTransfer
 * @property string $batchNumber
 */
class TrStocktransferdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $productName;
    
    public static function tableName()
    {
        return 'tr_stocktransferdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stockTransferNum', 'productID', 'qtyInStock', 'qtyTransfer','batchNumber'], 'required'],
            [['productID'], 'integer'],
            [['productName','manufactureDate', 'expiredDate','uomID'], 'safe'],
            [['qtyInStock','qtyTransfer'], 'string'],
            [['stockTransferNum'], 'string', 'max' => 50],
            [['stockTransferNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrStocktransferhead::className(), 'targetAttribute' => ['stockTransferNum' => 'stockTransferNum']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stockTransferDetailID' => 'Stock Transfer Detail ID',
            'stockTransferNum' => 'Stock Transfer Num',
            'productID' => 'Product ID',
            'qtyInStock' => 'Qty In Stock',
            'qtyTransfer' => 'Qty Transfer',
        ];
    }
    public function getProduct(){
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
    public function getUom()
    {
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID'])->viaTable('ms_productdetail', ['productID' => 'productID']);
    }
    public function getHpps()
    {
        return $this->hasMany(StockTransferDetailHpp::className(), ['transferDetailID' => 'stockTransferDetailID']);
    }
}
