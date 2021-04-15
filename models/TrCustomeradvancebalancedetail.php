<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_customeradvancebalancedetail".
 *
 * @property integer $balanceDetailID
 * @property integer $balanceDetailHeadID
 * @property string $advancePaymentNum
 * @property string $amount
 */
class TrCustomeradvancebalancedetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_customeradvancebalancedetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['balanceHeadID', 'refNum', 'amount'], 'required'],
            [['balanceHeadID'], 'integer'],
            [['amount'], 'string'],
            [['refNum'], 'string', 'max' => 50],
            [['balanceHeadID'], 'exist', 'skipOnError' => true, 'targetClass' => TrCustomeradvancebalancehead::className(), 'targetAttribute' => ['balanceHeadID' => 'balanceHeadID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'balanceDetailID' => 'Balance Detail ID',
            'balanceHeadID' => 'Balance Head ID',
            'refNum' => 'Advance Payment Num',
            'amount' => 'Amount',
        ];
    }
}
