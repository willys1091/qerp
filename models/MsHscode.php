<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_hscode".
 *
 * @property integer $hsCodeID
 * @property string $hsCode
 */
class MsHscode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_hscode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hsCode'], 'string', 'max' => 20],
            [['hsCode'], 'unique'],
            [['createdDate', 'editedDate'], 'safe'],
            [['taxPercentage'], 'string'],
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
            'hsCodeID' => 'HS Code ID',
            'hsCode' => 'HS Code',
            'taxPercentage' => 'Tax (%)',
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
                ->andFilterWhere(['like', 'hsCode', $this->hsCode])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'hsCode', $this->hsCode]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['hsCode' => SORT_ASC],
                'attributes' => [
                    'hsCode',
                    'taxPercentage']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
