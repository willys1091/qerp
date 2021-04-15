<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_customerdetail".
 *
 * @property integer $customerDetailID
 * @property integer $customerID
 * @property string $detailNameCustomer
 * @property string $contactPerson
 * @property string $address
 * @property string $phone
 * @property string $fax
 */
class MsCustomerdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_customerdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addressType', 'contactPerson'], 'required'],
            [['customerID'], 'integer'],
            [['nickname','addressType','country','city', 'fax', 'email'], 'string', 'max' => 50],
            [['postalCode'], 'string', 'max' => 10],
            [['contactPerson','phone','street'], 'string', 'max' => 200],
            [['customerID'], 'exist', 'skipOnError' => true, 'targetClass' => MsCustomer::className(), 'targetAttribute' => ['customerID' => 'customerID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
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
            'email' => 'Email'
        ];
    }
    
    public function getCustomer()
    {
        return $this->hasOne(MsCustomer::className(), ['customerID' => 'customerID']);
    }
}
