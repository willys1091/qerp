<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_productdetail".
 *
 * @property string $barcodeNumber
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $buyPrice
 * @property string $sellPrice
 */
class MsProductdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_productdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productID', 'uomID'], 'required'],
            [['productID', 'uomID', 'packingTypeID'], 'integer'],
            [['buyPrice', 'sellPrice'], 'string'],
            [['uomQty'], 'number'],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['uomID'], 'exist', 'skipOnError' => true, 'targetClass' => MsUom::className(), 'targetAttribute' => ['uomID' => 'uomID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productDetailID' => 'Product Detail ID',
            'productID' => 'Product ID',
            'uomID' => 'UOM ID',
            'packingTypeID' => 'Packing Type ID',
            'uomQty' => '@Packing/Unit',
            'buyPrice' => 'Buy Price',
            'sellPrice' => 'Sell Price',
        ];
    }
    public function getUom()
    {
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID']);
    }
    public function getPackingType()
    {
        return $this->hasOne(MsPackingtype::className(), ['packingTypeID' => 'packingTypeID']);
    }
}
