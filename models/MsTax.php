<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_tax".
 *
 * @property integer $taxID
 * @property string $taxName
 * @property string $taxRate
 * @property string $coaNo
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsTax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_tax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taxName', 'taxRate', 'coaNo'], 'required'],
            [['taxID'], 'integer'],
            [['taxRate'], 'string'],
			['taxRate', 'compare', 'compareValue' => '0,00', 'operator' => '>'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['taxName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['coaNo'], 'string', 'max' => 20],
            [['coaNo'], 'exist', 'skipOnError' => true, 'targetClass' => MsCoa::className(), 'targetAttribute' => ['coaNo' => 'coaNo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'taxID' => 'Tax ID',
            'taxName' => 'Tax Name',
            'taxRate' => 'Rate',
            'coaNo' => 'COA Number',
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
                ->andFilterWhere(['like', 'taxName', $this->taxName])
                ->andFilterWhere(['like', 'taxRate', $this->taxRate])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'taxName', $this->taxName])
                ->andFilterWhere(['like', 'taxRate', $this->taxRate]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['taxName' => SORT_ASC],
                'attributes' => ['taxName']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $dataProvider->sort->attributes['taxRate'] = [
            'asc' => ['taxRate' => SORT_ASC],
            'desc' => ['taxRate' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
