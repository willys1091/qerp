<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tr_samplereceiptdetail".
 *
 * @property int $sampleReceiptDetailID
 * @property string $sampleReceiptNum
 * @property int $productID
 * @property string $qty
 * @property string $batchNumber
 * @property string $manufactureDate
 * @property string $expiredDate
 * @property string $retestDate
 * 
 * @property Product $product
 * @property SampleReceiptHead $head
 */
class SampleReceiptDetail extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tr_samplereceiptdetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sampleReceiptNum', 'productID', 'qty', 'batchNumber', 'manufactureDate'], 'required'],
            [['productID'], 'integer'],
            [['qty'], 'string'],
            [['manufactureDate', 'expiredDate', 'retestDate'], 'safe'],
            [['sampleReceiptNum'], 'string', 'max' => 50],
            [['batchNumber'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'sampleReceiptDetailID' => 'Sample Receipt Detail ID',
            'sampleReceiptNum' => 'Sample Receipt Num',
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
        return $this->hasOne(SampleReceiptHead::className(), ['sampleReceiptNum' => 'sampleReceiptNum']);
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        
        if($insert) {
            $stockCard = new StockCardSample();
            $stockCard->refNum = $this->sampleReceiptNum;
            $stockCard->batchNumber = $this->batchNumber;
            $stockCard->productID = $this->productID;
        } else {
            $stockCard = StockCardSample::find()
                    ->where(['refNum' => $this->sampleReceiptNum, 
                        'productID' => $this->productID, 
                        'batchNumber' => $this->batchNumber])
                    ->one();
        }
        
        $stockCard->transactionDate = $this->head->sampleReceiptDate;
        $stockCard->warehouseID = $this->head->warehouseID;
        $stockCard->manufactureDate = $this->manufactureDate;
        $stockCard->expiredDate = $this->expiredDate;
        $stockCard->retestDate = $this->retestDate;
        $stockCard->inQty = $this->qty;
        $stockCard->outQty = 0;
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
                    ->where(['refNum' => $this->sampleReceiptNum, 
                        'productID' => $this->productID, 
                        'batchNumber' => $this->batchNumber])
                    ->one();
        
        if($stockCard && !$stockCard->delete()) {
            return false;
        }        
        
        return true;
    }
}