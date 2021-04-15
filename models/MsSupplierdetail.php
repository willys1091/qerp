<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_supplierdetail".
 *
 * @property integer $supplierDetailID
 * @property integer $supplierID
 * @property string $bankName
 * @property string $swiftCode
 * @property string $accountNo
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $postalCode
 */
class MsSupplierdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_supplierdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['supplierID', 'bankName'], 'required'],
            [['supplierID'], 'integer'],
            [['bankName', 'swiftCode', 'accountNo', 'country', 'city'], 'string', 'max' => 50],
            [['street'], 'string', 'max' => 200],
            [['postalCode'], 'string', 'max' => 10],
            [['supplierID'], 'exist', 'skipOnError' => true, 'targetClass' => MsSupplier::className(), 'targetAttribute' => ['supplierID' => 'supplierID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplierDetailID' => 'Supplier Detail ID',
            'supplierID' => 'Supplier ID',
            'bankName' => 'Bank Name',
            'swiftCode' => 'Swift Code',
            'accountNo' => 'Account Number',
            'country' => 'Country',
            'city' => 'City',
            'street' => 'Street',
            'postalCode' => 'Postal Code',
        ];
    }
}
