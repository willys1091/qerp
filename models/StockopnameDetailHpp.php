<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_stockopnamedetailhpp".
 *
 * @property int $ID
 * @property int $stockOpnameDetailID
 * @property string $stockDate
 * @property string $refNum
 * @property string $HPP
 * @property string $qty
 * @property string $retestDate
 * @property string $manufactureDate
 * @property string $expiredDate
 */
class StockopnameDetailHpp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_stockopnamedetailhpp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['ID', 'stockOpnameDetailID'], 'integer'],
            [['stockDate', 'retestDate', 'manufactureDate', 'expiredDate'], 'safe'],
            [['HPP', 'qty'], 'number'],
            [['refNum'], 'string', 'max' => 45],
            [['ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'stockOpnameDetailID' => 'Stock Opname Detail ID',
            'stockDate' => 'Stock Date',
            'refNum' => 'Ref Num',
            'HPP' => 'Hpp',
            'qty' => 'Qty',
            'retestDate' => 'Retest Date',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
        ];
    }
}
