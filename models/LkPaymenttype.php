<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_paymenttype".
 *
 * @property integer $paymentTypeID
 * @property string $paymentTypeName
 */
class LkPaymenttype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_paymenttype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paymentTypeID', 'paymentTypeName'], 'required'],
            [['paymentTypeID'], 'integer'],
            [['paymentTypeName'], 'string', 'max' => 20],
            [['paymentTypeID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paymentTypeID' => 'Payment Type ID',
            'paymentTypeName' => 'Payment Type Name',
        ];
    }
}
