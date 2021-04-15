<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_paymentmethod".
 *
 * @property integer $paymentID
 * @property string $paymentName
 */
class LkPaymentmethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_paymentmethod';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paymentName'], 'required'],
            [['paymentID'], 'integer'],
            [['paymentName'], 'string', 'max' => 20],
            [['paymentID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paymentID' => 'Payment ID',
            'paymentName' => 'Payment Name',
        ];
    }
}
