<?php

namespace app\models;

/**
 * This is the model class for table "ms_coasetting".
 *
 * @property string $key
 * @property string $description
 * @property string $coaNo
 */

class MsCoasetting extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ms_coasetting';
    }
    
    public function rules()
    {
        return [
            [['key', 'description', 'coaNo'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'key' => 'Key',
            'description' => 'Keterangan',
            'coaNo' => 'Nomor COA',
        ];
    }
    
    public static function findCOA($value) {
        $coaSetting = self::find()->where(['key' => $value])->one();
        
        return $coaSetting->coaNo;
    }
}
