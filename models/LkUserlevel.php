<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_userlevel".
 *
 * @property integer $id
 * @property string $description
 * @property integer $flag_active
 *
 * @property MsUser[] $msUsers
 */
class LkUserlevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_userlevel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flag_active'], 'integer'],
            [['description'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'flag_active' => 'Flag Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsUsers()
    {
        return $this->hasMany(MsUser::className(), ['user_level_id' => 'id']);
    }
}
