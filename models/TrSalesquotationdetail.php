<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_salesquotationdetail".
 *
 * @property string $salesQuotationDetailID
 * @property string $salesQuotationNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $priceOffer
 * @property string $tax
 * @property string $subTotal
 * @property string $notes
 */
class TrSalesquotationdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_salesquotationdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesQuotationNum', 'productID', 'uomID', 'qty', 'priceOffer', 'subTotal'], 'required'],
            [['productID', 'uomID'], 'integer'],
            [['qty', 'priceOffer', 'tax', 'subTotal', 'discount'], 'string'],
            [['salesQuotationNum'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
            [['salesQuotationNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrSalesquotationhead::className(), 'targetAttribute' => ['salesQuotationNum' => 'salesQuotationNum']],
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
            'salesQuotationDetailID' => 'Sales Quotation Detail ID',
            'salesQuotationNum' => 'Sales Quotation Number',
            'productID' => 'Product ID',
            'uomID' => 'Uom ID',
            'qty' => 'Quantity',
            'priceOffer' => 'Price',
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
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
}
