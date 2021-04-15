<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_supplieradvancebalancedetail".
 *
 * @property integer $balanceDetailID
 * @property integer $balanceHeadID
 * @property string $refNum
 * @property string $amount
 */
class TrSupplieradvancebalancedetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_supplieradvancebalancedetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['balanceHeadID', 'refNum', 'amount'], 'required'],
            [['balanceHeadID'], 'integer'],
            [['amount'], 'number'],
            [['refNum'], 'string', 'max' => 50],
            [['balanceHeadID'], 'exist', 'skipOnError' => true, 'targetClass' => TrSupplieradvancebalancehead::className(), 'targetAttribute' => ['balanceHeadID' => 'balanceHeadID']],
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
            'refNum' => 'Ref Num',
            'amount' => 'Amount',
        ];
    }
}
