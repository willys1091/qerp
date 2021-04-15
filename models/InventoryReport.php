<?php
namespace app\models;

use yii\base\Model;

class InventoryReport extends Model
{
    public $typeReport; 
    public $periode;
    public $purchaseNum;
    public $goodsReceiptNum;
    public $productID;
    public $productName;
    public $purchaseNumID;
    public $dateS;
    public $dateE;
    public $monthYear;
    public $month;
    public $monthPicker;
    public $productOOT;
    public $productIDStock, $batchNumber;

    public function rules()
    {
        return [
            [['typeReport'], 'required'],
            [['typeReport','dateS','dateE','goodsReceiptNum', 'purchaseNum','purchaseNumID', 'monthYear', 'month', 'monthPicker'],'string', 'max' => 50],
            [['productID','periode', 'productOOT'], 'integer'],
            [['productName','productIDStock'], 'safe'],
        ];
    }
    
    public function attributeLabels() {
        return[
            'typeReport' => 'Type Report',
            'dateS' => 'Date From',
            'dateE' => 'Date To',
            'productID' => 'Product',
            'purchaseNum' => 'Purchase Order Number',
            'goodsReceiptNum' => 'Goods Receipt Number',
            'periode' => 'Periode',
            'monthPicker' => 'Month',
            'productOOT' => 'Product',
            'productName' => 'Product',
            'productIDStock' => 'Product'
        ];
        
    }
}



