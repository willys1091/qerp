<?php

namespace app\models;

/**
 * This is the model class for table "tr_customeradvancebalancehead".
 *
 * @property integer $balanceHeadID
 * @property integer $customerID
 */
class TrCustomeradvancebalancehead extends \yii\db\ActiveRecord
{
    public $amount;
    
    public static function tableName()
    {
        return 'tr_customeradvancebalancehead';
    }
    
    public function rules()
    {
        return [
            [['customerID','balanceDate'], 'required'],
            [['customerID'], 'integer'],
            [['amount'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'balanceHeadID' => 'Balance Head ID',
            'balanceDate' => 'Balance Date',
            'customerID' => 'Customer ID',
        ];
    }
    
    public function getBalanceDetail()
    {
        return $this->hasMany(TrCustomeradvancebalancedetail::className(), ['balanceHeadID' => 'balanceHeadID']);
    }
    
    public static function newData($refNum, $customerID, $date, $amount) {
        $prevAdvance = self::find()
                        ->joinWith('balanceDetail')
                        ->where(['refNum' => $refNum])
                        ->andWhere(['tr_customeradvancebalancehead.customerID' => $customerID])->one();
                
        if ($prevAdvance != NULL) {
            $prevAdvance->delete();
            foreach ($prevAdvance->balanceDetail as $detail)
                $detail->delete();
        } 
        
        $balanceHead = new TrCustomeradvancebalancehead();
        $balanceHead->balanceDate = $date;
        $balanceHead->customerID = $customerID;
        if (!$balanceHead->save(false)) {
            return false;
        }
        
        $balanceDetail = new TrCustomeradvancebalancedetail();
        $balanceDetail->balanceHeadID = $balanceHead->balanceHeadID;
        $balanceDetail->refNum = $refNum;
        $balanceDetail->amount =  $amount;
        if (!$balanceDetail->save(false)) {
            return false;
        }
        
        return true;
    }
}
