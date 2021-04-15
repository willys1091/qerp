<?php

namespace app\models;

use app\components\AppHelper;
use Yii;
use yii\db\Exception;
use yii\helpers\Json;

class SampleReceiptForm extends SampleReceiptHead {    
    public $formDetails;
    public $_formDetails = [];
    
    public function rules() {
        $rules = parent::rules();
        $rules[] = [['formDetails'], 'safe'];
        
        return $rules;
    }
    
    public function attributeLabels() {
        $labels = parent::attributeLabels(); 
        return $labels;
    }     

    public function saveModel() {
        $transaction = Yii::$app->db->beginTransaction();
        
        if($this->isNewRecord) {
            $newTransNum = '';
            $checkNumber = 'QJA/SSR/'
                .date("y",strtotime($this->sampleReceiptDate)).'/'
                .AppHelper::$monthRomans[intval(date("m",strtotime($this->sampleReceiptDate)))].'/%';
            
            $existing = SampleReceiptHead::find()
                ->where(['like','sampleReceiptNum', $checkNumber, false])
                ->orderBy('sampleReceiptNum DESC')
                ->one();
            
            if (empty($existing)){
                $newTransNum = "QJA/SSR/".date("y",strtotime($this->sampleReceiptDate))."/".
                    AppHelper::$monthRomans[intval(date("m",strtotime($this->sampleReceiptDate)))]."/".
                    '001';
            }
            else{
                $newNumber = substr($existing->sampleReceiptNum,-3,3)+1;
                $newTransNum = "QJA/SSR/".date("y",strtotime($this->sampleReceiptDate))."/".
                    AppHelper::$monthRomans[intval(date("m",strtotime($this->sampleReceiptDate)))]."/".
                    str_pad($newNumber,3,"0",STR_PAD_LEFT);
            }
            
            $this->sampleReceiptNum = $newTransNum;
        }
        $this->sampleReceiptDate = AppHelper::convertDateTimeFormat($this->sampleReceiptDate,'Y-m-d','Y-m-d H:i');
        if ($this->save()) {
            foreach($this->formDetails as $detail) {
                if ($detail['active'] == '0') {
                    $model = SampleReceiptDetail::findOne($detail['sampleReceiptDetailID']);
                    if(!$model->delete()) {
                        $transaction->rollBack();
                        return false;
                    }
                } else {
                    $model = new SampleReceiptDetail();
                    if($detail['sampleReceiptDetailID'] == '') {
                        $model->sampleReceiptNum = $this->sampleReceiptNum;                                               
                    } else {
                        $model = SampleReceiptDetail::findOne($detail['sampleReceiptDetailID']);
                    }
                    $model->productID = $detail['productID'];
                    $model->qty = str_replace(",",".",str_replace(".","",$detail['qty']));
                    $model->uomID = $detail['uomID'];
                    $model->batchNumber = $detail['batchNumber'];
                    $model->manufactureDate = AppHelper::convertDateTimeFormat($detail['manufactureDate'],'d-m-Y','Y-m-d');
                    $model->expiredDate = AppHelper::convertDateTimeFormat($detail['expiredDate'],'d-m-Y','Y-m-d');
                    $model->retestDate = AppHelper::convertDateTimeFormat($detail['retestDate'],'d-m-Y','Y-m-d');
                    
                    if (!$model->save()) {
                        $transaction->rollBack();
                         $arrayInfo = json::encode($model->getErrors());
                         throw new Exception("Gagal Menyimpan dengan error: $arrayInfo");
                        return false;
                    }
                }                              
            }
            
            $transaction->commit();
            return true;
        } else {
            $transaction->rollBack();
            return false;
        }
    }
    
    public function afterFind() {
        parent::afterFind();
        
        $this->sampleReceiptDate = AppHelper::convertDateTimeFormat($this->sampleReceiptDate, 'Y-m-d H:i:s','Y-m-d');
        
        $data = [];
        $details = $this->details;        
        foreach($details as $detail) {
            $data[] = [
                'sampleReceiptDetailID' => $detail->sampleReceiptDetailID,
                'productID' => $detail->productID, 
                'productName' => $detail->product->productName,
                'qty' => $detail->qty, 
                'uomID' => $detail->uomID, 
                'uomName' => $detail->uom->uomName, 
                'batchNumber' => $detail->batchNumber, 
                'manufactureDate' => AppHelper::convertDateTimeFormat($detail->manufactureDate, 'Y-m-d H:i:s','d-m-Y'),
                'expiredDate' => AppHelper::convertDateTimeFormat($detail->expiredDate, 'Y-m-d H:i:s','d-m-Y'),
                'retestDate' => AppHelper::convertDateTimeFormat($detail->retestDate, 'Y-m-d H:i:s','d-m-Y'),
                'active' => 1,
            ];
        }    
        $this->_formDetails = $data;
    }
}