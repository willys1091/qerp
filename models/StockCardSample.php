<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tr_stockcardsample".
 *
 * @property int $StockCardSampleID
 * @property string $refNum
 * @property string $transactionDate
 * @property int $productID
 * @property int $warehouseID
 * @property string $batchNumber
 * @property string $manufactureDate
 * @property string $expiredDate
 * @property string $retestDate
 * @property string $inQty
 * @property string $outQty
 */
class StockCardSample extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tr_stockcardsample';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['refNum', 'transactionDate', 'productID', 'warehouseID', 'inQty', 'outQty'], 'required'],
            [['transactionDate', 'manufactureDate', 'expiredDate', 'retestDate'], 'safe'],
            [['productID', 'warehouseID'], 'integer'],
            [['inQty', 'outQty'], 'number'],
            [['refNum'], 'string', 'max' => 50],
            [['batchNumber'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'StockCardSampleID' => 'Stock Card Sample ID',
            'refNum' => 'Ref Num',
            'transactionDate' => 'Transaction Date',
            'productID' => 'Product ID',
            'warehouseID' => 'Warehouse ID',
            'batchNumber' => 'Batch Number',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'inQty' => 'In Qty',
            'outQty' => 'Out Qty',
        ];
    }

}