<?php
namespace app\models;

use yii\base\Model;

class TriWulanReport extends Model
{
    public $year;
    public $periode;
    public $product;

    public function rules()
    {
        return [
            [['year','periode'], 'required'],
            [['year','periode'],'integer'],
            [['product'],'string', 'max' => 50]
        ];
    }
    
    public function attributeLabels() {
        return[
            'year' => 'Select Year',
            'periode' => 'Select Periode',
        ];
        
    }
}




