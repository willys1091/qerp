<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_marketing".
 *
 * @property integer $marketingID
 * @property string $marketingName
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 * @property string $notes
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsMarketing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_marketing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marketingName','phone1'], 'required'],
            [['marketingID'], 'integer'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['marketingName', 'email', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['phone1', 'phone2'], 'string', 'max' => 20],
            [['notes'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'marketingID' => 'Marketing ID',
            'marketingName' => 'Marketing Name',
            'phone1' => 'Phone 1',
            'phone2' => 'Phone 2',
            'email' => 'Email',
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
                ->andFilterWhere(['like', 'marketingName', $this->marketingName])
                ->andFilterWhere(['like', 'phone1', $this->phone1])
                ->andFilterWhere(['like', 'phone2', $this->phone2])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'marketingName', $this->marketingName])
                ->andFilterWhere(['like', 'phone1', $this->phone1])
                ->andFilterWhere(['like', 'phone2', $this->phone2])
                ->andFilterWhere(['like', 'email', $this->email]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['marketingName' => SORT_ASC],
                'attributes' => ['marketingName']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
