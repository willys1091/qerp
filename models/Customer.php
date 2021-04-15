<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ms_customer".
 *
 * @property int $customerID Customer ID
 * @property string $customerName Customer Name
 * @property int $dueDate Due Date
 * @property string $creditLimit Credit Limit
 * @property string $email Email
 * @property string $npwp NPWP
 * @property string $npwpAddress
 * @property string $npwpRegisteredDate
 * @property string $notes Notes
 * @property int $flagActive Flag Active
 * @property string $createdBy Created By
 * @property string $createdDate Created Date
 * @property string $editedBy Edited By
 * @property string $editedDate Edited Date
 * @property int $saranaID
 * 
 * @property CustomerDetail $details
 */
class Customer extends ActiveRecord {    
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ms_customer';
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
            [['customerName', 'dueDate'], 'required'],
            [['dueDate', 'flagActive', 'saranaID'], 'integer'],
            [['creditLimit'], 'number'],
            [['npwpRegisteredDate', 'createdDate', 'editedDate'], 'safe'],
            [['notes','npwpAddress'], 'string'],
            [['customerName', 'email'], 'string', 'max' => 200],
            [['email'],'email'],            
            [['customerName'], 'unique'],
            [['npwp', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['flagActive'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'customerID' => 'Customer ID',
            'customerName' => 'Customer Name',
            'dueDate' => 'Due Days',
            'creditLimit' => 'Credit Limit',
            'email' => 'E-Mail',
            'npwp' => 'NPWP Number',
            'npwpAddress' => 'NPWP Address',
            'npwpRegisteredDate' => 'NPWP Register Date',
            'notes' => 'Notes',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'saranaID' => 'Jenis Sarana',
        ];
    }
        
    public function getDetails() {
        return $this->hasMany(CustomerDetail::className(), ['customerID' => 'customerID'])->where(['ms_customerdetail.flagActive' => 1]);
    }

    public static function findActive() {
        return self::find()->where(['flagActive' => 1])->orderBy('customerName')->all();
    }
    
    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'customerName', $this->customerName])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'npwp', $this->npwp])
            ->andFilterWhere(['=', 'dueDate', $this->dueDate])
            ->andFilterWhere(['=', 'flagActive', $this->flagActive]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['customerName' => SORT_ASC],
                'attributes' => [
                    'customerName',
                    'email',
                    'npwp',
                    'dueDate',
                    'flagActive'
                ]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);
        
        return $dataProvider;
    }
}