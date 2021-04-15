<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ms_customerdetail".
 *
 * @property int $customerDetailID Customer Detail ID
 * @property int $customerID Customer ID
 * @property string $addressType Customer Detail Name
 * @property string $contactPerson Contact Person
 * @property string $nickname
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $postalCode
 * @property string $phone Phone
 * @property string $fax Fax
 * @property string $email
 */
class CustomerDetail extends ActiveRecord {
    public $active;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ms_customerdetail';
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
            [['customerID', 'addressType'], 'required'],
            [['customerID'], 'integer'],
            [['addressType', 'nickname', 'country', 'city', 'fax', 'email'], 'string', 'max' => 50],
            [['contactPerson', 'street', 'phone'], 'string', 'max' => 200],
            [['postalCode'], 'string', 'max' => 10],
            [['active', 'customerDetailID', 'createdDate', 'createdBy', 'editedDate', 'editedBy'], 'safe'],
            [['flagActive'], 'default', 'value' => 1]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'customerDetailID' => 'Customer Detail ID',
            'customerID' => 'Customer ID',
            'addressType' => 'Address Type',
            'contactPerson' => 'Contact Person',
            'nickname' => 'Nickname',
            'country' => 'Country',
            'city' => 'City',
            'street' => 'Street',
            'postalCode' => 'Postal Code',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
        ];
    }
        
    public static function getListData($customerID = null) {
        $result = self::find()
            ->indexBy("customerDetailID")
            ->select("contactPerson")
            ->orderBy("contactPerson")
            ->andFilterWhere(["customerID" => $customerID])
            ->column();
        return $result;
    }
}