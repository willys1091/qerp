<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SamplingReport extends Model
{
    public $typeReport;
    public $dateStart;
    public $dateEnd;
    public $customerID;
    public $productID;
    public $supplierID;

    public function rules()
    {
        return [
            [['typeReport','dateStart','dateEnd'], 'required'],
            [['customerID','productID','supplierID'],'integer'],
        ];
    }
    
    public function attributeLabels() {
        return[
            'typeReport' => 'Type Report',
            'dateStart' => 'Date Start Periode',
            'dateEnd' => 'Date End Periode',
            'productID' => 'Product Name',
            'customerID' => 'Customer',
            'supplierID' => 'Supplier',
        ];
        
    }
}


