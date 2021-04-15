<?php

namespace app\models;

use app\components\AppHelper;
use Yii;
use yii\db\Exception;
use yii\helpers\Json;


class ReceivableDueForm extends TrCustomerreceivablehead {    
    public $contactPerson;
    public $invoice;
    public $id;
    
   
    public function rules()
    {
        return [
        [['contactPerson', 'invoice', 'id'], 'safe'],
        ];
    }
    
    

    public function attributeLabels() {
        $labels = parent::attributeLabels(); 
        return $labels;
    }     

    public function saveModel() {
       
    }
    
    
}