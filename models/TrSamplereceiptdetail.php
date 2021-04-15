<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tr_samplereceiptdetail".
 *
 * @property integer $sampleReceiptDetailID
 * @property string $sampleReceiptNum
 * @property integer $productID
 * @property string $qty
 * @property string $hsCode
 * @property string $manufactureDate
 * @property string $expiredDate
 * @property string $notes
 */
class TrSamplereceiptdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_samplereceiptdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sampleReceiptNum', 'productID', 'uomID', 'qty'], 'required'],
            [['productID', 'uomID'], 'integer'],
            [['qty'], 'string'],
            [['manufactureDate', 'expiredDate', 'retestDate'], 'safe'],
            [['sampleReceiptNum'], 'string', 'max' => 50],
            [['batchNumber'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sampleReceiptDetailID' => 'Sample Receipt Detail ID',
            'sampleReceiptNum' => 'Sample Receipt Num',
            'productID' => 'Product',
            'uomID' => 'Unit',
            'qty' => 'Qty',
            'batchNumber' => 'Batch Number',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
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
