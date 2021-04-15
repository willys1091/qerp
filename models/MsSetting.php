<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_setting".
 *
 * @property string $key1
 * @property string $key2
 * @property string $value1
 * @property string $value2
 */
class MsSetting extends \yii\db\ActiveRecord
{
    public $joinSettingsDetail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key1'], 'required'],
            [['key1', 'key2', 'value1', 'value2'], 'string', 'max' => 100],
            [['joinSettingsDetail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key1' => 'Key 1',
            'key2' => 'Key 2',
            'value1' => 'Value 1',
            'value2' => 'Value 2',
        ];
    }
    
    public static function getSetting($key1, $key2 = null) {
        $setting = self::find()->where(['key1'=>$key1]);
        if ($key2) { $setting->andWhere(['key2'=>$key2]); }
        $setting = $setting->one();
        
        if($setting){
            return $setting->value1;
        }
        else {
            return '';
        }
    }
}
