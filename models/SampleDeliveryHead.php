<?php

namespace app\models;

use app\components\AppHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tr_sampledeliveryhead".
 *
 * @property string $sampleDeliveryNum
 * @property string $sampleDeliveryDate
 * @property int $customerID
 * @property int $customerDetailID
 * @property int $warehouseID
 * @property string $notes
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 * @property string $dateSearchStart
 * @property string $dateSearchEnd
 * 
 * @property Customer $customer
 * @property SampleDeliveryDetail $details
 */
class SampleDeliveryHead extends ActiveRecord {
    public $dateSearchStart, $dateSearchEnd;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tr_sampledeliveryhead';
    }

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'editedBy',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdDate',
                'updatedAtAttribute' => 'editedDate',
                'value' => function() {
                    return date('Y-m-d H:i:s');
                }
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sampleDeliveryDate', 'customerID', 'warehouseID'], 'required'],
            [['createdBy', 'createdDate', 'editedBy', 'editedDate', 'dateSearchStart', 'dateSearchEnd'], 'safe'],
            [['customerID', 'customerDetailID', 'warehouseID','notes'], 'string'],
            [['sampleDeliveryNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['sampleDeliveryNum'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'sampleDeliveryNum' => 'Transaction Number',
            'sampleDeliveryDate' => 'Date',
            'customerID' => 'Customer',
            'warehouseID' => 'Warehouse',
            'customerDetailID' => 'PIC',
            'notes' => 'Notes',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',            
        ];
    }
    
    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['customerID' => 'customerID']);
    }
    
    public function getDetails() {
        return $this->hasMany(SampleDeliveryDetail::className(), ['sampleDeliveryNum' => 'sampleDeliveryNum']);
    }

    public function search() {
        $query = self::find()
            ->joinWith('customer')
            ->andFilterWhere(['between', 'sampleDeliveryDate', AppHelper::convertDateTimeFormat($this->dateSearchStart, 'd-m-Y', 'Y-m-d'), AppHelper::convertDateTimeFormat($this->dateSearchEnd, 'd-m-Y', 'Y-m-d')])
            ->andFilterWhere(['like', 'sampleDeliveryNum', $this->sampleDeliveryNum])
            ->andFilterWhere(['like', 'refNum', $this->refNum])
            ->andFilterWhere(['like', 'ms_customer.customerName', $this->customerID]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sampleDeliveryDate' => SORT_DESC, 'sampleDeliveryNum' => SORT_ASC],
                'attributes' => [
                    'sampleDeliveryDate',
                    'sampleDeliveryNum',
                    'refNum',
                    'customerID' => [
                        'asc' => ['ms_customer.customerName' => SORT_ASC],
                        'desc' => ['ms_customer.customerName' => SORT_DESC],
                    ],
                   
                ]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $dataProvider;
    }
    
    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }
        
        foreach($this->details as $detail) {
            if(!$detail->delete()) {
                return false;
            }
        }        
        
        return true;
    }
}