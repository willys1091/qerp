<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_purchaseorderdetail".
 *
 * @property string $purchaseOrderDetailID
 * @property string $purchaseOrderNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $price
 * @property string $discount
 * @property string $tax
 * @property string $subTotal
 * @property string $notes
 * @property integer $statusShipment
 */
class TrPurchaseorderdetail extends \yii\db\ActiveRecord
{
    //public $APODetail = [];
    public static function tableName()
    {
        return 'tr_purchaseorderdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchaseOrderNum', 'productID', 'uomID', 'qty', 'price', 'subTotal'], 'required'],
            [['productID', 'uomID', 'statusShipment'], 'integer'],
            [['qty', 'price', 'discount', 'subTotal'], 'string'],
            [['qty', 'price', 'discount', 'subTotal', 'productID', 'uomID', 'statusShipment'], 'safe'],
            [['purchaseOrderNum'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProductdetail::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['purchaseOrderNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrPurchaseorderhead::className(), 'targetAttribute' => ['purchaseOrderNum' => 'purchaseOrderNum']],
            [['statusShipment'], 'exist', 'skipOnError' => true, 'targetClass' => LkStatusshipment::className(), 'targetAttribute' => ['statusShipment' => 'statusShipmentID']],
            [['uomID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProductdetail::className(), 'targetAttribute' => ['uomID' => 'uomID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchaseOrderDetailID' => 'Purchase Order Detail ID',
            'purchaseOrderNum' => 'Purchase Order Num',
            'productID' => 'Product ID',
            'uomID' => 'UOM ID',
            'qty' => 'Quantity',
            'price' => 'Price',
            'discount' => 'Discount',
            'subTotal' => 'Sub Total',
            'notes' => 'Notes',
            'statusShipment' => 'Status Shipment',
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
