<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_taxindetail".
 *
 * @property string $taxInDetailID
 * @property string $taxInNum
 * @property string $receiptNum
 * @property string $taxInvoiceNum
 * @property string $taxInvoiceDate
 * @property string $taxPercentage
 * @property string $taxTotal
 * @property boolean $flagUsed
 * @property boolean $flagNotUsed
 */
class TrTaxindetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_taxindetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taxInDetailID', 'taxInNum', 'receiptNum', 'taxInvoiceNum', 'taxInvoiceDate', 'taxPercentage', 'taxTotal'], 'required'],
            [['taxInDetailID'], 'integer'],
            [['taxInvoiceDate'], 'safe'],
            [['taxPercentage', 'taxTotal'], 'number'],
            [['flagUsed', 'flagNotUsed'], 'boolean'],
            [['taxInNum', 'receiptNum'], 'string', 'max' => 50],
            [['taxInvoiceNum'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'taxInDetailID' => 'Tax In Detail ID',
            'taxInNum' => 'Tax In Number',
            'receiptNum' => 'Supplier Receipt Number',
            'taxInvoiceNum' => 'Tax Invoice',
            'taxInvoiceDate' => 'Supplier Invoice Date',
            'taxPercentage' => 'Tax Amount',
            'taxTotal' => 'Tax Total',
            'flagUsed' => 'Flag Used',
            'flagNotUsed' => 'Flag Not Used',
        ];
    }
}
