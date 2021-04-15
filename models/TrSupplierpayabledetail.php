<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tr_supplierpayabledetail".
 *
 * @property string $payableDetailID
 * @property string $payableDetailNum
 * @property string $currency
 * @property string $rate
 * @property string $amount
 */
class TrSupplierpayabledetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tr_supplierpayabledetail';
    }

    public function rules()
    {
        return [
            [['payableDetailID', 'payableNum', 'refNum', 'amount'], 'required'],
            [['payableDetailID'], 'integer'],
            [['rate', 'amount'], 'string'],
            [['payableNum', 'refNum'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 5],
        ];
    }

    public function attributeLabels()
    {
        return [
            'payableDetailID' => 'Payable Detail ID',
            'payableNum' => 'Payable Num',
            'currency' => 'Currency',
            'rate' => 'Rate',
            'amount' => 'Amount',
        ];
    }
        
    public function getTrSupplierpayablehead()
    {
        return $this->hasOne(TrSupplierpayablehead::className(), ['payableNum' => 'payableNum']);
    }
    
//     public function afterDelete() {
//        if (!parent::afterDelete()) {
//            return false;
//        }
//        
//        Yii::trace('test');
//        TrSupplierpayableHead::deleteAll('payableNum = :payableNum', [":payableNum" => $this->payableNum]);
//       
//        return true;
//    }
}
