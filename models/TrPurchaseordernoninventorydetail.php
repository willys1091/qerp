<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_purchaseordernoninventorydetail".
 *
 * @property integer $purchaseOrderNonInventoryID
 * @property string $refNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $price
 * @property string $discount
 * @property string $subtotal
 */
class TrPurchaseordernoninventorydetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_purchaseordernoninventorydetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchaseOrderNonInventoryNum', 'productID', 'uomID', 'qty', 'price', 'discount', 'subtotal'], 'required'],
            [['purchaseOrderNonInventoryID', 'productID', 'uomID'], 'integer'],
            [['qty', 'price', 'discount', 'subtotal'], 'number'],
            [['purchaseOrderNonInventoryNum'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchaseOrderNonInventoryID' => 'Purchase Order Non Inventory ID',
            'purchaseOrderNonInventoryNum' => 'Purchase Order Number',
            'productID' => 'Product ID',
            'uomID' => 'Uom ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'discount' => 'Discount',
            'subtotal' => 'Subtotal',
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
}
