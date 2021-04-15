<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * This is the model class for table "tr_customerpayment".
 *
 * @property string $customerPaymentNum
 * @property string $paymentTransactionDate
 * @property string $refNum
 * @property integer $customerID
 * @property string $transactionAmount
 * @property integer $paymentID
 * @property string $paymentAmount
 * @property string $giroNum
 * @property string $giroDueDate
 * @property string $coaNo
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 * @property string $adminFeeRate
 * @property string $adminFeeAmount
 */
class TrCustomerpayment extends \yii\db\ActiveRecord
{
    public $customerName;
    public $advancedPayment, $outstandingAmount;
    public $startDate, $endDate;
    
    public $adminFeeCurrency;
    
    public $errorMessages = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_customerpayment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerPaymentNum', 'paymentTransactionDate', 'refNum', 'voucherNum', 'customerID', 'paymentAmount', 'coaNo',
                'adminFeeAmount'], 'required'],
            [['paymentTransactionDate', 'createdDate', 'editedDate', 'startDate','endDate','giroNum'], 'safe'],
            [['customerID'], 'integer'],
            [['transactionAmount', 'paymentAmount', 'adjustment', 'downpayment'], 'string'],
            [['customerPaymentNum', 'refNum', 'voucherNum','createdBy', 'editedBy'], 'string', 'max' => 50],
            [['coaNo'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
            [['coaNo'], 'exist', 'skipOnError' => true, 'targetClass' => MsCoa::className(), 'targetAttribute' => ['coaNo' => 'coaNo']],
            [['customerID'], 'exist', 'skipOnError' => true, 'targetClass' => MsCustomer::className(), 'targetAttribute' => ['customerID' => 'customerID']],
            
            [['adminFeePaymentCoa'], 'string', 'max' => 20],
            [['adminFeeCurrency'], 'string', 'max' => 5],
            [['adminFeeRate', 'adminFeeAmount'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customerPaymentNum' => 'Payment Number',
            'paymentTransactionDate' => 'Payment Date',
            'refNum' => 'Reference Number',
            'voucherNum' => 'Voucher Number',
            'customerID' => 'Customer',
            'customerName' => 'Customer',
            'transactionAmount' => 'Transaction Amount',
            'advancedPayment' => 'Advanced Payment Balance',
            'paymentAmount' => 'Payment Amount',
            'adjustment' => 'Adjustment',
            'downpayment' => 'Downpayment',
            'coaNo' => 'Payment COA',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'giroNum' => 'Giro Number',
            
            'adminFeePaymentCoa' => 'Admin COA',
        ];
    }
    public function getCustomer()
    {
        return $this->hasOne(MsCustomer::className(), ['customerID' => 'customerID']);
    }
    public function search()
    {
        $query = self::find()
            ->joinWith(customer)
            ->andFilterWhere(['like', 'customerPaymentNum', $this->customerPaymentNum])
            ->andFilterWhere(['like', 'ms_customer.customerName', $this->customerID])
            ->andFilterWhere(['like', 'paymentAmount', $this->paymentAmount])
            ->andFilterwhere(['like', 'additionalInfo', $this->additionalInfo])
            ->andFilterWhere(['like', 'voucherNum', $this->voucherNum]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'paymentTransactionDate', $start]);
            $query->andFilterWhere(['<=', 'paymentTransactionDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['paymentTransactionDate' => SORT_DESC],
                'attributes' => [
                    'paymentTransactionDate',
                    'customerPaymentNum',
                    'voucherNum',
                    'customerID',
                    'paymentAmount'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
