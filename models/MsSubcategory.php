<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_subcategory".
 *
 * @property integer $subcategoryID
 * @property string $subcategoryName
 */
class MsSubcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_subcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subcategoryName'], 'string', 'max' => 50],
            [['createdDate', 'editedDate'], 'safe'],
            [['flagActive'], 'boolean'],
            [['createdBy', 'editedBy'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subcategoryID' => 'Subcategory ID',
            'subcategoryName' => 'Sub Category',
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
                ->andFilterWhere(['like', 'subcategoryName', $this->subcategoryName])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'subcategoryName', $this->subcategoryName]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['subcategoryName' => SORT_ASC],
                'attributes' => ['subcategoryName']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
