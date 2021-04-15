<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_reason".
 *
 * @property integer $mapReasonID
 * @property string $mapReasonName
 * @property string $coaNo
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsReason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_reason';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mapReasonName', 'coaNo'], 'required'],
            [['mapReasonID'], 'integer'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['mapReasonName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
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
            'mapReasonID' => 'Map Reason ID',
            'mapReasonName' => 'Reason Name',
            'coaNo' => 'COA Number',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function getCoaNos(){
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'coaNo']);
    }
    public function search()
    {
        if($this->flagActive != NULL){
            $query = self::find()
                ->andFilterWhere(['like', 'mapReasonName', $this->mapReasonName])
                ->andFilterWhere(['=', 'coaNo', $this->coaNo])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'mapReasonName', $this->mapReasonName])
                ->andFilterWhere(['like', 'coaNo', $this->coaNo]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['mapReasonName' => SORT_ASC],
                'attributes' => ['mapReasonName']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
