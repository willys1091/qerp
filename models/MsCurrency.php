<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_currency".
 *
 * @property string $currencyID
 * @property string $currencyName
 * @property string $currencySign
 * @property string $rate
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsCurrency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currencyID', 'currencyName', 'currencySign'], 'required'],
            [['rate'], 'string'],
			['rate', 'compare', 'compareValue' => '0,00', 'operator' => '>'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['currencyID'], 'string', 'max' => 5],
            [['currencyName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['currencySign'], 'string', 'max' => 3],
            [['currencyID'], 'unique', 'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'currencyID' => 'Currency',
            'currencyName' => 'Currency Name',
            'currencySign' => 'Currency Sign',
            'rate' => 'Rate',
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
                ->andFilterWhere(['like', 'currencyID', $this->currencyID])
                ->andFilterWhere(['like', 'currencyName', $this->currencyName])
                ->andFilterWhere(['like', 'currencySign', $this->currencySign])
                ->andFilterWhere(['like', 'rate', $this->rate])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'currencyID', $this->currencyID])
                ->andFilterWhere(['like', 'currencyName', $this->currencyName])
                ->andFilterWhere(['like', 'currencySign', $this->currencySign])
                ->andFilterWhere(['like', 'rate', $this->rate]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['currencyID' => SORT_ASC],
                'attributes' => [
                    'currencyID',
                    'currencyName'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
