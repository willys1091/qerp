<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "map_productsupplier".
 *
 * @property integer $productID
 * @property integer $supplierID
 */
class MapProductsupplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_productsupplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productID', 'supplierID'], 'required'],
            [['productID', 'supplierID'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productID' => 'Product ID',
            'supplierID' => 'Supplier ID',
        ];
    }

    public function getParentSupplier(){
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }

    public function getParentProduct()
    {
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }

    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'productID', $this->productID]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);



        return $dataProvider;
    }
}
