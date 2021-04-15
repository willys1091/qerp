<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ms_uom".
 *
 * @property int $uomID UOM ID
 * @property string $uomName UOM
 * @property string $notes Notes
 * @property int $flagActive Status
 * @property string $createdBy Created By
 * @property string $createdDate Created Date
 * @property string $editedBy Edited By
 * @property string $editedDate Edited Date
 */
class Uom extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_uom';
    }

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'editedBy',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdDate',
                'updatedAtAttribute' => 'editedDate',
                'value' => function() {
                    return date('Y-m-d H:i:s');
                }
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uomName'], 'required'],            
            [['uomName'], 'unique'],
            [['notes'], 'string'],
            [['notes', 'flagActive', 'createdBy', 'createdDate', 'editedBy', 'editedDate'], 'safe'],
            [['flagActive'], 'integer'],
            [['createdDate', 'editedDate'], 'safe'],
            [['uomName'], 'string', 'max' => 200],
            [['createdBy', 'editedBy'], 'string', 'max' => 50],
            [['flagActive'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uomID' => 'Uom ID',
            'uomName' => 'UOM',
            'notes' => 'Notes',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
        
    public static function findActive() {
        return self::find()->where(['flagActive' => 1])->orderBy('uomName')->all();
    }
    
    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'uomName', $this->uomName])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['=', 'flagActive', $this->flagActive]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['uomName' => SORT_ASC],
                'attributes' => [
                    'uomName',
                    'notes',
                    'flagActive'
                ]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $dataProvider;
    }
}
