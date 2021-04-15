<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_packingtype".
 *
 * @property integer $packingTypeID
 * @property string $packingTypeName
 * @property string $notes
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsPackingtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_packingtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['packingTypeName'], 'required'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['packingTypeName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'packingTypeID' => 'Packing Type ID',
            'packingTypeName' => 'Packing Type Name',
            'notes' => 'Notes',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'packingTypeName', $this->packingTypeName]);

        if($this->flagActive != NULL){
            $query = self::find()
                ->andFilterWhere(['like', 'packingTypeName', $this->packingTypeName])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'packingTypeName', $this->packingTypeName]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['packingTypeName' => SORT_ASC],
                'attributes' => ['packingTypeName']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
