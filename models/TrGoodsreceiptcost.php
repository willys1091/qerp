<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tr_goodsreceiptcost".
 *
 * @property integer $ID
 * @property string $goodsReceiptNum
 * @property string $importDutyAmount
 * @property string $PPNImportAmount
 * @property string $PPHImportAmount
 * @property string $otherCostAmount
 * @property string $taxInvoiceAmount
 */
class TrGoodsreceiptcost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_goodsreceiptcost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsReceiptNum'], 'required'],
            [['importDutyAmount', 'PPNImportAmount', 'PPHImportAmount'], 'string'],
            [[ 'CIF', 'FOB', 'CNF','lsNo','lsDate' , 'otherCostAmount', 'taxInvoiceAmount'], 'safe'],
            [['goodsReceiptNum'], 'string', 'max' => 50],
            [['goodsReceiptNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrGoodsreceipthead::className(), 'targetAttribute' => ['goodsReceiptNum' => 'goodsReceiptNum']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'goodsReceiptNum' => 'Goods Receipt Num',
            'importDutyAmount' => 'Import Duty Amount',
            'PPNImportAmount' => 'Ppnimport Amount',
            'PPHImportAmount' => 'Pphimport Amount',
            'otherCostAmount' => 'Other Cost Amount',
            'taxInvoiceAmount' => 'Tax Invoice Amount',
            'lsNo' => 'LS No',
            'lsDate' => 'LS Date',
        ];
    }
    

}
