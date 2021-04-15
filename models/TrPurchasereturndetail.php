<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_purchasereturndetail".
 *
 * @property string $purchaseReturnDetailID
 * @property string $purchaseReturnNum
 * @property string $refNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $HPP
 * @property string $VAT
 * @property string $totalAmount
 * @property string $notes
 */
class TrPurchasereturndetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_purchasereturndetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchaseReturnNum', 'productID', 'uomID', 'qty', 'HPP', 'VAT', 'totalAmount'], 'required'],
            [['productID', 'uomID'], 'integer'],
            [['qty', 'HPP', 'VAT', 'totalAmount'], 'string'],
            [['purchaseReturnNum', 'refNum'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['purchaseReturnNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrPurchasereturnhead::className(), 'targetAttribute' => ['purchaseReturnNum' => 'purchaseReturnNum']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchaseReturnDetailID' => 'Purchase Return Detail ID',
            'purchaseReturnNum' => 'Purchase Return Num',
            'refNum' => 'Ref Num',
            'productID' => 'Product ID',
            'uomID' => 'Uom ID',
            'qty' => 'Qty',
            'HPP' => 'Hpp',
            'VAT' => 'Vat',
            'totalAmount' => 'Total Amount',
            'notes' => 'Notes',
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
