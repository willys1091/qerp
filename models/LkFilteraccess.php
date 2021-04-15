<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_filteraccess".
 *
 * @property string $accessID
 * @property boolean $insertAcc
 * @property boolean $updateAcc
 * @property boolean $deleteAcc
 * @property boolean $viewAcc
 */
class LkFilteraccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_filteraccess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accessID'], 'required'],
            [['insertAcc', 'updateAcc', 'deleteAcc', 'viewAcc'], 'boolean'],
            [['accessID'], 'string', 'max' => 10],
            [['accessID'], 'exist', 'skipOnError' => true, 'targetClass' => LkAccesscontrol::className(), 'targetAttribute' => ['accessID' => 'accessID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'accessID' => 'Access ID',
            'insertAcc' => 'Insert Access',
            'updateAcc' => 'Update Access',
            'deleteAcc' => 'Delete Access',
            'viewAcc' => 'View Access',
        ];
    }
}
