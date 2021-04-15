<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_jenissarana".
 *
 * @property integer $saranaID
 * @property string $saranaName
 */
class LkJenissarana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_jenissarana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['saranaName'], 'required'],
            [['saranaName'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'saranaID' => 'Sarana ID',
            'saranaName' => 'Sarana Name',
        ];
    }
}
