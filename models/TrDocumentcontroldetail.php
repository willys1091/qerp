<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_documentcontroldetail".
 *
 * @property integer $docControlDetailID
 * @property integer $docControlHeadID
 * @property integer $documentTypeID
 * @property string $document
 */
class TrDocumentcontroldetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_documentcontroldetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['docControlHeadID', 'documentTypeID', 'document'], 'required'],
            [['docControlHeadID', 'documentTypeID'], 'integer'],
            [['document'], 'string', 'max' => 100],
            [['docControlHeadID'], 'exist', 'skipOnError' => true, 'targetClass' => TrDocumentcontrolhead::className(), 'targetAttribute' => ['docControlHeadID' => 'docControlHeadID']],
            [['documentTypeID'], 'exist', 'skipOnError' => true, 'targetClass' => MsDocumenttype::className(), 'targetAttribute' => ['documentTypeID' => 'documentTypeID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'docControlDetailID' => 'Document Control Detail ID',
            'docControlHeadID' => 'Document Control Head ID',
            'documentTypeID' => 'Document Type ID',
            'document' => 'Document',
        ];
    }
}
