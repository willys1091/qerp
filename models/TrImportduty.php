<?php

namespace app\models;

use Yii;
use yii\base\Model;

class TrImportduty extends Model
{
    public $goodsReceiptNum, $goodsReceiptDate, $refNum, $transType;
    public $importDutyAmount;
    public $PPNImportAmount;
    public $PPHImportAmount;
    public $supplierID;
    public $pibNumber, $pibDate, $pibRate, $pibSubmitCode, $pibAmount, $startDate, $endDate;
    public $joinGoodsReceiptDetail;
    public $importDutyStatus;

    public static function tableName()
    {
        return 'tr_goodsreceiptcost';
    }
    
    public function rules()
    {
        return [
            [['goodsReceiptNum'], 'required'],
            [['importDutyAmount', 'PPNImportAmount', 'PPHImportAmount', 'CIF', 'FOB', 'CNF'], 'string'],
            [['pibRate', 'pibAmount'], 'string'],
            [['goodsReceiptNum'], 'string', 'max' => 50],
            [['refNum','goodsReceiptDate','supplierID','joinGoodsReceiptDetail','startDate','endDate','importDutyStatus'], 'safe']
        ];
    }
    
    public function attributeLabels() {
        return[
            'goodsReceiptNum' => 'Goods Receipt Number',
            'goodsReceiptDate' => 'Receipt Date',
            'refNum' => 'PO Number',
            'transType' => 'Transaction Type',
            'importDutyAmount' => 'Import Duty Amount',
            'PPNImportAmount' => 'Ppnimport Amount',
            'PPHImportAmount' => 'Pphimport Amount',
            'taxInvoiceAmount' => 'Tax Invoice Amount',
            'pibNumber' => 'PIB Number',
            'pibDate' => 'PIB Date',
            'pibRate' => 'PIB Rate',
            'pibSubmitCode' => 'No Aju PIB',
            'pibAmount' => 'PIB Amount',
        ];
        
    }
}