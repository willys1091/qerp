<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_goodsreceiptdetail".
 *
 * @property string $goodsReceiptDetailID
 * @property string $goodsReceiptNum
 * @property string $goodsReceiptRefID
 * @property integer $productID
 * @property integer $uomID
 * @property string $batchNumber
 * @property string $hsCode
 * @property string $manufactureDate
 * @property string $expiredDate
 * @property string $qty
 * @property string $notes
 * @property boolean $goodsCondition
 * @property string $pack
 * @property string $packQty
 */
class TrGoodsreceiptdetail extends \yii\db\ActiveRecord
{
    public $productName;
    public $uomName;
    public $HPP;
    public $qtyStock;
    public $unitID;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_goodsreceiptdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsReceiptNum', 'productID', 'uomID', 'qty'], 'required'],
            [['productID', 'uomID', 'pack'], 'integer'],
            [['manufactureDate', 'expiredDate', 'retestDate','productName'], 'safe'],
            [['qty', 'packQty', 'temperature'], 'string'],
            [['goodsCondition'], 'boolean'],
            [['goodsReceiptNum', 'hsCodeTax'], 'string', 'max' => 50],
            [['hsCode'], 'string', 'max' => 100],
            [['hsCode'], 'string', 'max' => 20],
            [['notes'], 'string', 'max' => 200],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProductdetail::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['uomID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProductdetail::className(), 'targetAttribute' => ['uomID' => 'uomID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goodsReceiptDetailID' => 'Goods Receipt Detail ID',
            'goodsReceiptNum' => 'Goods Receipt Number',
            'productID' => 'Product ID',
            'uomID' => 'UOM',
            'temperature' => 'Temperature',
            'batchNumber' => 'Batch Number',
            'hsCode' => 'Hs Code',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'qty' => 'Qty',
            'qtyStock' => 'Qty',
            'notes' => 'Notes',
            'goodsCondition' => 'Goods Condition',
            'pack' => 'Pack',
            'packQty' => 'Pack Quantity',
        ];
    }
    public function getUom()
    {
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID']);
    }
    
    public function getGoodsReceiptHead()
    {
        return $this->hasOne(TrGoodsreceipthead::className(), ['goodsReceiptNum' => 'goodsReceiptNum']);
    }
    
    public function getProduct()
    {
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
    public function getPackingType()
    {
        return $this->hasOne(MsPackingtype::className(), ['packingTypeID' => 'pack']);
    }
}
