<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_warehouse".
 *
 * @property integer $warehouseID
 * @property string $warehouseName
 * @property string $address
 * @property string $phone
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsWarehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['warehouseName'], 'required'],
            [['warehouseID'], 'integer'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['warehouseName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
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

    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'warehouseName', $this->warehouseName])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['=', 'flagActive', $this->flagActive]);;

        if ($this->flagActive > 0)
            $query = $query->andFilterWhere(['=', 'flagActive', $this->flagActive]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['warehouseName' => SORT_ASC],
                'attributes' => [
                    'warehouseName',
                    'address'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
