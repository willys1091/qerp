<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_suppliercontactdetail".
 *
 * @property integer $supplierContactID
 * @property integer $supplierID
 * @property string $contactPerson
 * @property string $position
 */
class MsSuppliercontactdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_suppliercontactdetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplierID'], 'integer'],
            [['nickname','position'], 'string', 'max' => 50],
            [['contactPerson'], 'string', 'max' => 200],
            [['supplierID'], 'exist', 'skipOnError' => true, 'targetClass' => MsSupplier::className(), 'targetAttribute' => ['supplierID' => 'supplierID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplierContactID' => 'Supplier Contact ID',
            'supplierID' => 'Supplier ID',
            'contactPerson' => 'Contact Person',
            'nickname' => 'Nickname',
            'position' => 'Position',
        ];
    }
    public function getSupplierContact()
    {
        return $this->hasMany(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
}
