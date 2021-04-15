<?php

namespace app\models;

use Yii;

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
            [['productID', 'supplierID'], 'integer'],
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
}
