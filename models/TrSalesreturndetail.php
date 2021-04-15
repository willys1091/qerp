<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_salesreturndetail".
 *
 * @property string $salesReturnDetailID
 * @property string $salesReturnNum
 * @property string $refNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $HPP
 * @property string $VAT
 * @property string $totalAmount
 * @property string $notes
 */
class TrSalesreturndetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_salesreturndetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesReturnNum', 'refNum', 'productID', 'uomID', 'qty', 'HPP', 'VAT', 'totalAmount'], 'required'],
            [['productID', 'uomID'], 'integer'],
            [['qty', 'HPP', 'VAT', 'totalAmount'], 'number'],
            [['salesReturnNum', 'refNum'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['salesReturnNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrSalesreturnhead::className(), 'targetAttribute' => ['salesReturnNum' => 'salesReturnNum']],
            [['uomID'], 'exist', 'skipOnError' => true, 'targetClass' => MsUom::className(), 'targetAttribute' => ['uomID' => 'uomID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'salesReturnDetailID' => 'Sales Return Detail ID',
            'salesReturnNum' => 'Sales Return Num',
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
