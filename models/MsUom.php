<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_uom".
 *
 * @property integer $uomID
 * @property string $uomName
 * @property string $notes
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsUom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_uom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uomName'], 'required'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['uomName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uomID' => 'UOM ID',
            'uomName' => 'UOM',
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
        if($this->flagActive != NULL){
            $query = self::find()
            ->andFilterWhere(['like', 'uomName', $this->uomName])
            ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
             $query = self::find()
            ->andFilterWhere(['like', 'uomName', $this->uomName]);
        }
      
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['uomName' => SORT_ASC],
                'attributes' => ['uomName']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
