<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_status".
 *
 * @property integer $statusID
 * @property string $statusName
 */
class LkStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statusName'], 'required'],
            [['statusID'], 'integer'],
            [['statusName'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'statusID' => 'Status ID',
            'statusName' => 'Status Name',
        ];
    }
}
