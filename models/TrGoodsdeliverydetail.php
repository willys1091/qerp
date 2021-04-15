<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_goodsdeliverydetail".
 *
 * @property string $goodsReceiptDetailID
 * @property string $goodsReceiptNum
 * @property integer $productID
 * @property integer $uomID
 * @property integer $warehouseID
 * @property string $batchNumber
 * @property string $hsCode
 * @property string $manufactureDate
 * @property string $expiredDate
 * @property string $qty
 * @property string $notes
 * @property string $goodsCondition
 * @property string $pack
 * @property string $packQty
 */
class TrGoodsdeliverydetail extends \yii\db\ActiveRecord
{
    public $unitID;
    public $uomName;
    public $productName;
    public $qtyStock;
    public $HPP, $goodsDeliveryDate;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_goodsdeliverydetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsDeliveryNum', 'productID', 'uomID', 'batchNumber', 'qty', 'pack', 'packQty'], 'required'],
            [['goodsDeliveryDetailID', 'productID', 'uomID', 'pack'], 'integer'],
            [['manufactureDate', 'expiredDate', 'retestDate'], 'safe'],
            [['qty', 'packQty'], 'string'],
            [['goodsDeliveryNum', 'batchNumber'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['uomID'], 'exist', 'skipOnError' => true, 'targetClass' => MsUom::className(), 'targetAttribute' => ['uomID' => 'uomID']],
            [['goodsDeliveryNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrGoodsdeliveryhead::className(), 'targetAttribute' => ['goodsDeliveryNum' => 'goodsDeliveryNum']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goodsDeliveryDetailID' => 'Goods Delivery Detail ID',
            'goodsDeliveryNum' => 'Goods Delivery Num',
            'productID' => 'Product ID',
            'uomID' => 'Uom ID',
            'batchNumber' => 'Batch Number',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'qty' => 'Qty',
            'notes' => 'Notes',
            'pack' => 'Pack',
            'packQty' => 'Pack Qty',
        ];
    }
    public function getUom()
    {
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID']);
    }
    public function getProduct()
    {
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
    public function getPackingType()
    {
        return $this->hasOne(MsPackingtype::className(), ['packingTypeID' => 'pack']);
    }
    
    public function getGoodsDeliveryHead()
    {
        return $this->hasOne(TrGoodsdeliveryhead::className(), ['goodsDeliveryNum' => 'goodsDeliveryNum']);
    }
    
    public function getCustomerDetail()
    {
        return $this->hasOne(MsCustomerdetail::className(), ['customerDetailID' => 'customerDetailID']);
    }
}
