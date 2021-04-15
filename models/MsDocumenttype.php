<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\MsDocumenttype;

/**
 * This is the model class for table "ms_documenttype".
 *
 * @property integer $documentTypeID
 * @property string $documentTypeName
 * @property boolean $flagMandatory
 * @property integer $ordinal
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsDocumenttype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_documenttype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['documentTypeName', 'lkDocumentTypeID', 'ordinal'], 'required'],
            [['documentTypeID', 'lkDocumentTypeID', 'ordinal'], 'integer'],
            [['flagMandatory', 'flagActive'], 'boolean'],
            [['createdDate', 'editedDate', 'reportDestination'], 'safe'],
            [['documentTypeName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'documentTypeID' => 'Document Type ID',
            'lkDocumentTypeID' => 'Transaction Type',
            'documentTypeName' => 'Document Type Name',
            'reportDestination' => 'Report To',
            'flagMandatory' => 'Mandatory',
            'ordinal' => 'Priority',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function search()
    {
        if($this->flagActive != NULL){
            $query = self::find()
                ->andFilterWhere(['like', 'documentTypeName', $this->documentTypeName])
                ->andFilterWhere(['=', 'lkDocumentTypeID', $this->lkDocumentTypeID])
                ->andFilterWhere(['=', 'ordinal', $this->ordinal])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'documentTypeName', $this->documentTypeName])
                ->andFilterWhere(['=', 'lkDocumentTypeID', $this->lkDocumentTypeID])
                ->andFilterWhere(['=', 'ordinal', $this->ordinal]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['lkDocumentTypeID' => SORT_ASC],
                'attributes' => [
                    'lkDocumentTypeID',
                    'documentTypeName',
                    'ordinal',
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }
    public function getParentDocumentType(){
        return $this->hasOne(LkDocumenttype::className(), ['lkDocumentTypeID' => 'lkDocumentTypeID']);
    }
}
