<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_cashinoutdetail".
 *
 * @property integer $cashDetailID
 * @property string $cashInOutNum
 * @property string $destinationAccount
 * @property string $amount
 * @property string $notes
 */
class TrCashinoutdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_cashinoutdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cashInOutNum', 'destinationAccount', 'amount'], 'required'],
            [['amount'], 'number'],
            [['cashInOutNum'], 'string', 'max' => 50],
            [['destinationAccount'], 'string', 'max' => 20],
            [['notes'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cashDetailID' => 'Cash Detail ID',
            'cashInOutNum' => 'Cash In Out Num',
            'destinationAccount' => 'Destination Account',
            'amount' => 'Amount',
            'notes' => 'Notes',
        ];
    }
}

