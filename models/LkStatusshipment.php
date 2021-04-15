<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_statusshipment".
 *
 * @property integer $statusShipmentID
 * @property string $statusShipmentName
 */
class LkStatusshipment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_statusshipment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statusShipmentID', 'statusShipmentName'], 'required'],
            [['statusShipmentID'], 'integer'],
            [['statusShipmentName'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'statusShipmentID' => 'Status Shipment ID',
            'statusShipmentName' => 'Status Shipment Name',
        ];
    }
}
