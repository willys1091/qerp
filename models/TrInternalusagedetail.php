<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_internalusagedetail".
 *
 * @property string $internalUsageDetailID
 * @property string $internalUsageNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $HPP
 * @property string $purposeAccount
 */
class TrInternalusagedetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $internalUsageDate, $productName, $origin, $notes, $uomName;
    public static function tableName()
    {
        return 'tr_internalusagedetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['internalUsageNum', 'productID', 'uomID', 'qty', 'batchNumber'], 'required'],
            [['productID', 'uomID'], 'integer'],
            [['qty'], 'string'],
            [['internalUsageNum', 'batchNumber'], 'string', 'max' => 50],
            [['purposeAccount'], 'string', 'max' => 20],
            [['manufactureDate', 'expiredDate', 'retestDate' ,'HPP'], 'safe'],
            [['internalUsageNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrInternalusagehead::className(), 'targetAttribute' => ['internalUsageNum' => 'internalUsageNum']],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'internalUsageDetailID' => 'Internal Usage Detail ID',
            'internalUsageNum' => 'Internal Usage Num',
            'productID' => 'Product ID',
            'uomID' => 'Uom ID',
            'qty' => 'Qty',
            'batchNumber' => 'Batch Number',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'purposeAccount' => 'Purpose Account',
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
    
    public function getUsageDetail()
    {
        return $this->hasOne(TrInternalusagehead::className(), ['internalUsageNum' => 'internalUsageNum']);
    }
}
