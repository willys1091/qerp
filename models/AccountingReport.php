<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AccountingReport extends Model
{
    public $typeReport;
    public $startDate;
    public $endDate;
    public $customerID;
    public $productID;
    public $supplierID;
    public $coaNo;

    public function rules()
    {
        return [
            [['typeReport'], 'required'],
            [['customerID','productID','supplierID'],'integer'],
            [['startDate', 'endDate'], 'string', 'max' => 10],
            [['coaNo'], 'string', 'max' => 20],
        ];
    }
    
    public function attributeLabels() {
        return[
            'typeReport' => 'Type Report',
            'startDate' => 'Date Start Periode',
            'endDate' => 'Date End Periode',
            'productID' => 'Product Name',
            'customerID' => 'Customer',
            'supplierID' => 'Supplier',
            'coaNo' => 'COA Number'
        ];
        
    }
}