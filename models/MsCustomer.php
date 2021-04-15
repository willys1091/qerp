<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_customer".
 *
 * @property integer $customerID
 * @property string $customerName
 * @property integer $dueDate
 * @property string $creditLimit
 * @property string $email
 * @property string $npwp
 * @property string $npwpAddress
 * @property string $npwpRegisteredDate
 * @property string $notes
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsCustomer extends \yii\db\ActiveRecord
{
    public $joinMsCustomerDetail, $contactPerson;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerName'], 'required'],
            [['dueDate'], 'integer'],
            [['creditLimit'], 'string'],
            [['npwpRegisteredDate', 'createdDate', 'editedDate', 'joinMsCustomerDetail','contactPerson'], 'safe'],
            [['flagActive','tax'], 'boolean'],
            [['npwp', 'createdBy', 'editedBy','city'], 'string',  'max' => 50],
            [['customerName', 'email', 'npwpAddress'], 'string', 'max' => 200],
            [['notes'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customerID' => 'Customer ID',
            'customerName' => 'Customer Name',
            'dueDate' => 'Due Date (Days)',
            'creditLimit' => 'Credit Limit',
            'email' => 'Email',
            'npwp' => 'NPWP',
            'npwpAddress' => 'NPWP Address',
            'npwpRegisteredDate' => 'NPWP Registered Date',
            'notes' => 'Notes',
            'tax' => 'Tax',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'saranaID' => 'Jenis Sarana',
            'city' => 'City',
            'joinMsCustomerDetail' => ''
        ];
    }
    public function search()
    {
        if($this->flagActive != NULL){
            $query = self::find()
                ->andFilterWhere(['like', 'customerName', $this->customerName])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'npwp', $this->npwp])
                ->andFilterWhere(['like', 'creditLimit', $this->creditLimit])
                ->andFilterWhere(['=', 'dueDate', $this->dueDate])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'customerName', $this->customerName])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'npwp', $this->npwp])
                ->andFilterWhere(['=', 'dueDate', $this->dueDate])
                ->andFilterWhere(['like', 'creditLimit', $this->creditLimit]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['customerName' => SORT_ASC],
                'attributes' => [
                    'customerName',
                    'creditLimit',
                    'dueDate'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $dataProvider->sort->attributes['creditLimit'] = [
            'asc' => ['creditLimit' => SORT_ASC],
            'desc' => ['creditLimit' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['dueDate'] = [
            'asc' => ['dueDate' => SORT_ASC],
            'desc' => ['dueDate' => SORT_DESC],
        ];

        return $dataProvider;
    }
    public function getCustomerDetail()
    {
        return $this->hasOne(MsCustomerdetail::className(), ['customerID' => 'customerID']);
    }
    public function getCustomerDetails()
    {
        return $this->hasMany(MsCustomerdetail::className(), ['customerID' => 'customerID']);
    }
    public function afterFind(){
        parent::afterFind();
        $this->joinMsCustomerDetail = [];
        $i = 0;
        foreach ($this->getCustomerDetail()->all() as $joinMsCustomerDetail) {
            $this->joinMsCustomerDetail[$i]["customerDetailID"] = $joinMsCustomerDetail->customerDetailID;
            $this->joinMsCustomerDetail[$i]["contactPerson"] = $joinMsCustomerDetail->contactPerson;
            $this->joinMsCustomerDetail[$i]["nickname"] = $joinMsCustomerDetail->nickname;
            $this->joinMsCustomerDetail[$i]["addressType"] = $joinMsCustomerDetail->addressType;
            $this->joinMsCustomerDetail[$i]["country"] = $joinMsCustomerDetail->country;
            $this->joinMsCustomerDetail[$i]["city"] = $joinMsCustomerDetail->city;
            $this->joinMsCustomerDetail[$i]["street"] = $joinMsCustomerDetail->street;
            $this->joinMsCustomerDetail[$i]["postalCode"] = $joinMsCustomerDetail->postalCode;
            $this->joinMsCustomerDetail[$i]["phone"] = $joinMsCustomerDetail->phone;
            $this->joinMsCustomerDetail[$i]["fax"] = $joinMsCustomerDetail->fax;
            $this->joinMsCustomerDetail[$i]["email"] = $joinMsCustomerDetail->email;
            $this->joinMsCustomerDetail[$i]["used"] = TrGoodsdeliveryhead::find()->where(['customerDetailID' => $joinMsCustomerDetail->customerDetailID])->count() ? true : false;
            $i += 1;
        }
    }
}
