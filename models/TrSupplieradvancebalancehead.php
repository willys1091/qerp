<?php

namespace app\models;

/**
 * This is the model class for table "tr_supplieradvancebalancehead".
 *
 * @property integer $balanceHeadID
 * @property string $balanceDate
 * @property integer $supplierID
 */
class TrSupplieradvancebalancehead extends \yii\db\ActiveRecord
{
    public $amount;
    public static function tableName()
    {
        return 'tr_supplieradvancebalancehead';
    }

    public function rules()
    {
        return [
            [['balanceDate', 'supplierID'], 'required'],
            [['balanceDate'], 'safe'],
            [['supplierID'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'balanceHeadID' => 'Balance Head ID',
            'balanceDate' => 'Balance Date',
            'supplierID' => 'Supplier ID',
        ];
    }
    public function getBalanceDetail()
    {
        return $this->hasMany(TrSupplieradvancebalancedetail::className(), ['balanceHeadID' => 'balanceHeadID']);
    }
    
    public static function newData($refNum, $supplierID, $date, $amount) {
        $prevAdvance = self::find()
                        ->joinWith('balanceDetail')
                        ->where(['refNum' => $refNum])
                        ->andWhere(['tr_supplieradvancebalancehead.supplierID' => $supplierID])->one();
                
        if ($prevAdvance != NULL) {
            $prevAdvance->delete();
            foreach ($prevAdvance->balanceDetail as $detail)
                $detail->delete();
        } 
        
        $balanceHead = new self();
        $balanceHead->balanceDate = $date;
        $balanceHead->supplierID = $supplierID;
        if (!$balanceHead->save(false)) {
            return false;
        }
        
        $balanceDetail = new TrSupplieradvancebalancedetail();
        $balanceDetail->balanceHeadID = $balanceHead->balanceHeadID;
        $balanceDetail->refNum = $refNum;
        $balanceDetail->amount =  $amount;
        if (!$balanceDetail->save(false)) {
            return false;
        }
        
        return true;
    }
}
