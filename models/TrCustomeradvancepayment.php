<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * This is the model class for table "tr_customeradvancepayment".
 *
 * @property string $custAdvancePaymentNum
 * @property string $refNum
 * @property string $custAdvancePaymentDate
 * @property integer $custID
 * @property string $paymentCOA
 * @property string $treasuryCOA
 * @property integer $currencyID
 * @property string $rate
 * @property string $amount
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrCustomeradvancepayment extends \yii\db\ActiveRecord
{
    public $customerName, $startDate, $endDate, $adminFeeCurrency,$orderStatus;
    
    
    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'editedBy',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'createdDate',
                'updatedAtAttribute' => 'editedDate',
                'value' => function() {
                    return date('Y-m-d H:i:s');
                }
            ],
        ];
    }
    
    public static function tableName()
    {
        return 'tr_customeradvancepayment';
    }

    public function rules()
    {
        return [
            [['custAdvancePaymentNum', 'refNum', 'custAdvancePaymentDate', 'custID',
                'adminFeeAmount'], 'required'],
            [['custAdvancePaymentDate', 'createdDate', 'editedDate','startDate','endDate','customerName','orderStatus','giroNum'], 'safe'],
            [['custID'], 'integer'],
            [['rate', 'amount'], 'string'],
            [['custAdvancePaymentNum', 'refNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['paymentCOA', 'treasuryCOA'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
            [['adminFeePaymentCoa'], 'string', 'max' => 20],
            [['adminFeeCurrency'], 'string', 'max' => 5],
            [['adminFeeRate', 'adminFeeAmount'], 'string'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'custAdvancePaymentNum' => 'Transaction Number',
            'refNum' => 'Reference Number',
            'custAdvancePaymentDate' => 'Date',
            'custID' => 'Customer',
            'customerName' => 'Customer',
            'paymentCOA' => 'Payment COA',
            'treasuryCOA' => 'Treasury COA',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'amount' => 'Amount',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'giroNum' => 'Giro Number',
            
            'adminFeePaymentCoa' => 'Select COA',
        ];
    }
    public function search()
    {
        $query = self::find()
             ->select('tr_customeradvancepayment.custAdvancePaymentDate, '
                 . 'tr_customeradvancepayment.refNum,'
                 . 'tr_customeradvancepayment.custAdvancePaymentNum, '
                 . 'tr_customeradvancepayment.custID, '
                 . 'tr_customeradvancepayment.amount')
            ->addSelect(new Expression('IFNULL(tr_goodsdeliveryhead.refNum,0) orderStatus'))
            ->joinWith('goodsDelivery')
            ->joinWith('parentCustomer')
            ->andFilterWhere(['like', 'custAdvancePaymentNum', $this->custAdvancePaymentNum])
            ->andFilterWhere(['like', 'refNum', $this->refNum])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'ms_customer.customerName', $this->customerName]);
            
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'custAdvancePaymentDate', $start]);
            $query->andFilterWhere(['<=', 'custAdvancePaymentDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['custAdvancePaymentDate' => SORT_DESC],
                'attributes' => [
                    'custAdvancePaymentDate',
                    'custAdvancePaymentNum',
                    'refNum',
                    'amount',
                    'customerName',
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
        
    public function getParentCustomer(){
        return $this->hasOne(MsCustomer::className(), ['customerID' => 'custID']);
    }
    
    public function getGoodsDelivery(){
        return $this->hasOne(TrGoodsdeliveryhead::className(), ['refNum' => 'refNum']);
    }
    
    public function getParentCoa(){
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'coaNo']);
    }
    
    public function getAdminFeeCoa(){
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'adminFeePaymentCoa']);
    }
}
