<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tr_sampledeliverydetail".
 *
 * @property int $sampleDeliveryDetailID
 * @property string $sampleDeliveryNum
 * @property int $productID
 * @property string $qty
 * @property string $batchNumber
 * @property string $manufactureDate
 * @property string $expiredDate
 * @property string $retestDate
 * @property string $statusID
 * 
 * @property Product $product
 * @property SampleDeliveryHead $head
 */
class SampleDeliveryDetail extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tr_sampledeliverydetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sampleDeliveryNum', 'productID', 'qty', 'batchNumber', 'manufactureDate'], 'required'],
            [['productID'], 'integer'],
            [['qty'], 'number'],
            [['manufactureDate', 'expiredDate', 'retestDate'], 'safe'],
            [['sampleDeliveryNum'], 'string', 'max' => 50],
            [['batchNumber'], 'string', 'max' => 100],
            [['statusID'],'default', 'value' => 1]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'sampleDeliveryDetailID' => 'Sample Receipt Detail ID',
            'sampleDeliveryNum' => 'Transaction Number',
            'productID' => 'Product ID',
            'qty' => 'Qty',
            'batchNumber' => 'Batch Number',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
        ];
    }
     
    public function getProduct() {
        return $this->hasOne(Product::className(), ['productID' => 'productID']);
    }
       public function getUom()
    {
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID']);
    }
    public function getHead() {
        return $this->hasOne(SampleDeliveryHead::className(), ['sampleDeliveryNum' => 'sampleDeliveryNum']);
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        
        if($insert) {
            $stockCard = new StockCardSample();
            $stockCard->refNum = $this->sampleDeliveryNum;
            $stockCard->batchNumber = $this->batchNumber;
            $stockCard->productID = $this->productID;
        } else {
            $stockCard = StockCardSample::find()
                    ->where(['refNum' => $this->sampleDeliveryNum, 
                        'productID' => $this->productID, 
                        'batchNumber' => $this->batchNumber])
                    ->one();
        }
        
        $stockCard->transactionDate = $this->head->sampleDeliveryDate;
        $stockCard->warehouseID = $this->head->warehouseID;
        $stockCard->manufactureDate = $this->manufactureDate;
        $stockCard->expiredDate = $this->expiredDate;
        $stockCard->retestDate = $this->retestDate;
        $stockCard->inQty = 0;
        $stockCard->outQty = $this->qty;
        if(!$stockCard->save()) {
            return false;
        }
        return true;
    }
    
    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }
        
        $stockCard = StockCardSample::find()
                    ->where(['refNum' => $this->sampleDeliveryNum, 
                        'productID' => $this->productID, 
                        'batchNumber' => $this->batchNumber])
                    ->one();
        
        if($stockCard && !$stockCard->delete()) {
            return false;
        }        
        
        return true;
    }
    
    public function afterFind() {
        parent::afterFind();
        
                        
    }
}