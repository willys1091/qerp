<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_reportdestination".
 *
 * @property integer $reportDestinationID
 * @property string $reportDestinationName
 */
class MsReportdestination extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_reportdestination';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reportDestinationName'], 'string', 'max' => 100],
            [['createdDate', 'editedDate'], 'safe'],
            [['createdBy', 'editedBy'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reportDestinationID' => 'Report Destination ID',
            'reportDestinationName' => 'Report Destination',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'reportDestinationName', $this->reportDestinationName]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['reportDestinationName' => SORT_ASC],
                'attributes' => ['reportDestinationName']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
