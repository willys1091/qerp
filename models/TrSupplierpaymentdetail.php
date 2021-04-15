<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_supplierpaymentdetail".
 *
 * @property integer $supplierPaymentDetailID
 * @property string $supplierPaymentNum
 * @property string $refNum
 * @property string $currencyID
 * @property string $rate
 * @property integer $whtID
 * @property string $whtPercentage
 * @property string $transactionAmountBeforeTax
 * @property string $tax
 */
class TrSupplierpaymentdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_supplierpaymentdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplierPaymentNum'], 'required'],
            [['supplierPaymentDetailID'], 'integer'],
            [['whtAmount', 'transactionAmountBeforeTax', 'tax', 'paymentAmount'], 'string'],
            [['supplierPaymentNum', 'refNum'], 'string', 'max' => 50],
            [['supplierPaymentNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrSupplierpaymenthead::className(), 'targetAttribute' => ['supplierPaymentNum' => 'supplierPaymentNum']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplierPaymentDetailID' => 'Supplier Payment Detail ID',
            'supplierPaymentNum' => 'Supplier Payment Num',
            'refNum' => 'Ref Num',
            'whtAmount' => 'Wht Amount',
            'transactionAmountBeforeTax' => 'Transaction Amount Before Tax',
            'tax' => 'Tax',
            'paymentAmount' => 'Payment Amount',
        ];
    }
    public function getPaymentHead()
    {
        return $this->hasMany(TrSupplierpaymenthead::className(), ['supplierPaymentNum' => 'supplierPaymentNum']);
    }
    
}
