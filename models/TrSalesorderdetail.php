<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_salesorderdetail".
 *
 * @property string $salesOrderDetailID
 * @property string $salesOrderNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $price
 * @property string $discount
 * @property string $tax
 * @property string $subTotal
 * @property string $notes
 */
class TrSalesorderdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_salesorderdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesOrderNum', 'productID', 'uomID', 'qty', 'price', 'subTotal'], 'required'],
            [['productID', 'uomID'], 'integer'],
            [['qty', 'price', 'discount', 'tax', 'subTotal'], 'string'],
            [['salesOrderNum'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
            [['salesOrderNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrSalesorderhead::className(), 'targetAttribute' => ['salesOrderNum' => 'salesOrderNum']],
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
            'salesOrderDetailID' => 'Sales Order Detail ID',
            'salesOrderNum' => 'Sales Order Number',
            'productID' => 'Product ID',
            'uomID' => 'UOM ID',
            'qty' => 'Quantity',
            'price' => 'Price',
            'discount' => 'Discount',
            'tax' => 'Tax',
            'subTotal' => 'Sub Total',
            'notes' => 'Notes',
        ];
    }
    public function getUom()
    {
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID']);
    }
    
    public function getProduct()
    {
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID' ]);
    }
}
