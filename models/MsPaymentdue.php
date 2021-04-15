<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_paymentdue".
 *
 * @property integer $ID
 * @property string $paymentDue
 */
class MsPaymentdue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_paymentdue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paymentDue'], 'required'],
            [['paymentDue'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'paymentDue' => 'Payment Due',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'paymentDue', $this->paymentDue]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['paymentDue' => SORT_ASC],
                'attributes' => [
                    'paymentDue',
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
