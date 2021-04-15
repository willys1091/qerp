<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_accesscontrol".
 *
 * @property string $accessID
 * @property string $description
 * @property string $controller
 * @property string $icon
 */
class LkAccesscontrol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_accesscontrol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accessID', 'description', 'controller', 'icon'], 'required'],
            [['accessID'], 'string', 'max' => 10],
            [['description', 'controller', 'icon'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'accessID' => 'Access ID',
            'description' => 'Description',
            'controller' => 'Controller',
            'icon' => 'Icon',
        ];
    }
}
