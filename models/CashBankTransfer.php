<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "cash_bank_transfer".
 *
 * @property integer $transferID
 * @property string $transferDate
 * @property string $sourceCurrency
 * @property string $destinationCurrency
 * @property string $sourceRate
 * @property string $destinationRate
 * @property string $sourceAmount
 * @property string $destinationAmount
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class CashBankTransfer extends \yii\db\ActiveRecord
{
    public $destinationAmount;
    
    public $errorMessages = [];
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_cashbanktransfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sourceCurrency', 'destinationCurrency', 'sourceRate', 'destinationRate', 'sourceAmount'], 'required'],
            [['transferID'], 'string'],
            [['transferDate', 'createdDate', 'editedDate', 'startDate','endDate'], 'safe'],
            [['sourceRate', 'destinationRate', 'sourceAmount'], 'string'],
            [['sourceCurrency', 'destinationCurrency'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
            [['createdBy', 'editedBy', 'voucherNum'], 'string', 'max' => 50],
            [['destinationCurrency'], 'exist', 'skipOnError' => true, 'targetClass' => MsCoa::className(), 'targetAttribute' => ['destinationCurrency' => 'coaNo']],
            [['sourceCurrency'], 'exist', 'skipOnError' => true, 'targetClass' => MsCoa::className(), 'targetAttribute' => ['sourceCurrency' => 'coaNo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transferID' => 'Transfer Number',
            'transferDate' => 'Transfer Date',
            'sourceCurrency' => 'Source Currency',
            'destinationCurrency' => 'Destination Currency',
            'sourceRate' => 'Source Rate',
            'destinationRate' => 'Destination Rate',
            'sourceAmount' => 'Amount',
            'destinationAmount' => 'Destination Amount',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'voucherNum' => 'Voucher Number'
        ];
    }
    public function getSourcecurrency()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'sourceCurrency']);
    }
    public function getDestinationcurrency()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'destinationCurrency']);
    }
    public function search()
    {
        $query = self::find()
        ->andFilterWhere(['like', 'transferID', $this->transferID])
        ->andFilterWhere(['=', 'sourceCurrency', $this->sourceCurrency])
        ->andFilterWhere(['=', 'destinationCurrency', $this->destinationCurrency])
        ->andFilterWhere(['like', 'voucherNum', $this->voucherNum]);
         
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'transferDate', $start]);
            $query->andFilterWhere(['<=', 'transferDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['transferDate' => SORT_DESC],
                'attributes' => [
                    'transferID',
                    'voucherNum',
                    'transferDate',
                    'sourceCurrency',
                    'destinationCurrency',
                    'destinationRate',
                    'sourceAmount'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }
}
