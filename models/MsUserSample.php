<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_user".
 *
 * @property string $username
 * @property string $fullName
 * @property string $password
 * @property string $salt
 * @property string $userRole
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsUserSample extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'fullName', 'salt', 'userRole', 'createdDate'], 'required'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['username', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['fullName'], 'string', 'max' => 200],
            [['password'], 'string', 'max' => 255],
            [['salt'], 'string', 'max' => 45],
            [['userRole'], 'string', 'max' => 100],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'fullName' => 'Fullname',
            'password' => 'Password',
            'salt' => 'Salt Password',
            'userRole' => 'User Role ID',
            'flagActive' => 'Flag Active',
            'createdBy' => 'Create By',
            'createdDate' => 'Create Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
}
