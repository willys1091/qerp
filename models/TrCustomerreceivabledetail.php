<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tr_customerreceivabledetail".
 *
 * @property string $receivableDetailID
 * @property string $receivableNum
 * @property string $currency
 * @property string $rate
 * @property string $amount
 */
class TrCustomerreceivabledetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_customerreceivabledetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receivableDetailID', 'receivableNum', 'refNum', 'amount'], 'required'],
            [['receivableDetailID'], 'integer'],
            [['rate', 'amount'], 'string'],
            [['receivableNum', 'refNum'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 5],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => MsCurrency::className(), 'targetAttribute' => ['currency' => 'currencyID']],
            [['receivableNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrCustomerreceivablehead::className(), 'targetAttribute' => ['receivableNum' => 'receivableNum']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'receivableDetailID' => 'Receivable Detail ID',
            'receivableNum' => 'Receivable Num',
            'currency' => 'Currency',
            'rate' => 'Rate',
            'amount' => 'Amount',
        ];
    }
}
