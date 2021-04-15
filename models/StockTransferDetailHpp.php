<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_stocktransferdetailhpp".
 *
 * @property int $ID
 * @property int $transferDetailID
 * @property string $stockDate
 * @property string $refNum
 * @property string $HPP
 * @property string $qty
 */
class StockTransferDetailHpp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tr_stocktransferdetailhpp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['ID', 'transferDetailID'], 'integer'],
            [['stockDate'], 'safe'],
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
            'transferDetailID' => 'Transfer Detail ID',
            'stockDate' => 'Stock Date',
            'refNum' => 'Ref Num',
            'HPP' => 'Hpp',
            'qty' => 'Qty',
        ];
    }
}
