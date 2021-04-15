<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ms_warehouse".
 *
 * @property int $warehouseID Warehouse ID
 * @property string $warehouseName Warehouse Name
 * @property string $address Address
 * @property string $phone Phone
 * @property int $flagActive Flag Active
 * @property string $createdBy Created By
 * @property string $createdDate Created Date
 * @property string $editedBy Edited By
 * @property string $editedDate Edited Date
 */
class Warehouse extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_warehouse';
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
            [['warehouseName'], 'required'],
            [['flagActive'], 'integer'],
            [['flagActive', 'createdBy', 'createdDate', 'editedBy', 'editedDate'], 'safe'],
            [['warehouseName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['flagActive'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'warehouseID' => 'Warehouse ID',
            'warehouseName' => 'Warehouse Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    
    public static function findActive() {
        return self::find()->where(['flagActive' => 1])->orderBy('warehouseName')->all();
    }
    
    public function search() {
        $query = self::find()
            ->andFilterWhere(['like', 'warehouseName', $this->warehouseName])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])            
            ->andFilterWhere(['=', 'flagActive', $this->flagActive]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['warehouseName' => SORT_ASC],
                'attributes' => [
                    'warehouseName',
                    'address',
                    'phone',
                    'flagActive',
                ]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $dataProvider;
    }
}
