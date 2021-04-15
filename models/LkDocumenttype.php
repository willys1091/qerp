<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_documenttype".
 *
 * @property integer $lkDocumentTypeID
 * @property string $lkDocumentTypeName
 * @property integer $ordinal
 */
class LkDocumenttype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lk_documenttype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lkDocumentTypeName', 'ordinal'], 'required'],
            [['ordinal'], 'integer'],
            [['lkDocumentTypeName'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lkDocumentTypeID' => 'Lk Document Type ID',
            'lkDocumentTypeName' => 'Lk Document Type Name',
            'ordinal' => 'Ordinal',
        ];
    }
    public function search()
    {
     
        $query = self::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $dataProvider;
    }
}
