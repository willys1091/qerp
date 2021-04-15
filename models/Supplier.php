<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ms_supplier".
 *
 * @property int $supplierID Supplier ID
 * @property string $supplierName Supplier Name
 * @property int $isForwarder
 * @property string $country Country
 * @property string $province
 * @property string $city
 * @property string $street Address
 * @property string $postalCode
 * @property string $officeNumber
 * @property string $factoryNumber
 * @property string $fax Fax
 * @property string $mobile Mobile
 * @property string $email Email
 * @property string $url URL WEBSITE
 * @property string $npwp NPWP
 * @property string $npwpAddress NPWP Address
 * @property string $npwpRegisteredDate NPWP Registered Date
 * @property string $notes Notes
 * @property int $flagActive Flag Active
 * @property string $createdBy Created By
 * @property string $createdDate Created Date
 * @property string $editedBy Edited By
 * @property string $editedDate Edited Date
 * 
 * @property SupplierDetail $details
 * @property SupplierContactDetail $contactDetails
 */
class Supplier extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_supplier';
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
    public function rules()
    {
        return [
            [['supplierName', 'isForwarder'], 'required'],
            [['supplierName'], 'unique'],
            [['isForwarder', 'flagActive'], 'integer'],
            [['street', 'npwpAddress', 'notes'], 'string'],
            [['npwpRegisteredDate', 'createdBy', 'createdDate', 'editedBy', 'editedDate'], 'safe'],
            [['supplierName', 'officeNumber', 'factoryNumber', 'mobile', 'email', 'url'], 'string', 'max' => 200],
            [['country', 'province', 'city', 'fax', 'npwp', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['postalCode'], 'string', 'max' => 10],
            [['flagActive'], 'default', 'value' => 1]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'supplierID' => 'Supplier ID',
            'supplierName' => 'Supplier Name',
            'isForwarder' => 'Supplier Type',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'street' => 'Address',
            'postalCode' => 'Postal Code',
            'officeNumber' => 'Phone Number (Office)',
            'factoryNumber' => 'Phone Number (Factory)',
            'fax' => 'Fax Number',
            'mobile' => 'Mobile Number',
            'email' => 'E-Mail',
            'url' => 'Website',
            'npwp' => 'NPWP',
            'npwpAddress' => 'NPWP Address',
            'npwpRegisteredDate' => 'NPWP Register Date',
            'notes' => 'Notes',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }    
    
    public function getDetails() {
        return $this->hasMany(SupplierDetail::className(), ['supplierID' => 'supplierID']);
    }
    
    public function getPicDetails() {
        return $this->hasMany(SupplierContactDetail::className(), ['supplierID' => 'supplierID']);
    }
    
    public static function findActive() {
        return self::find()->where(['flagActive' => 1])->orderBy('supplierName')->all();
    }
    
    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'supplierName', $this->supplierName])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'officeNumber', $this->officeNumber])
            ->andFilterWhere(['=', 'flagActive', $this->flagActive]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['supplierName' => SORT_ASC],
                'attributes' => [
                    'supplierName',
                    'officeNumber',
                    'email',
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
