<?php

namespace app\models;

use app\components\AppHelper;
use app\components\MdlDb;
use Yii;
use yii\db\Exception;
use yii\helpers\Json;

class SampleDeliveryForm extends SampleDeliveryHead {    
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
            $checkNumber = 'QJA/CSD/'
                .date("y",strtotime($this->sampleDeliveryDate)).'/'
                .AppHelper::$monthRomans[intval(date("m",strtotime($this->sampleDeliveryDate)))].'/%';
            
            $existing = SampleDeliveryHead::find()
                ->where(['like','sampleDeliveryNum', $checkNumber, false])
                ->orderBy('sampleDeliveryNum DESC')
                ->one();
            
            if (empty($existing)){
                $newTransNum = "QJA/CSD/".date("y",strtotime($this->sampleDeliveryDate))."/".
                    AppHelper::$monthRomans[intval(date("m",strtotime($this->sampleDeliveryDate)))]."/".
                    '001';
            }
            else{
                $newNumber = substr($existing->sampleDeliveryNum,-3,3)+1;
                $newTransNum = "QJA/CSD/".date("y",strtotime($this->sampleDeliveryDate))."/".
                    AppHelper::$monthRomans[intval(date("m",strtotime($this->sampleDeliveryDate)))]."/".
                    str_pad($newNumber,3,"0",STR_PAD_LEFT);
            }
            
            $this->sampleDeliveryNum = $newTransNum;
        }
        $this->sampleDeliveryDate = AppHelper::convertDateTimeFormat($this->sampleDeliveryDate,'Y-m-d','Y-m-d H:i');
        if ($this->save()) {
            foreach($this->formDetails as $detail) {
                if ($detail['active'] == '0') {
                    $model = SampleDeliveryDetail::findOne($detail['sampleDeliveryDetailID']);
                    if(!$model->delete()) {
                        $transaction->rollBack();
                        return false;
                    }
                } else {
                    $model = new SampleDeliveryDetail();
                    if($detail['sampleDeliveryDetailID'] == '') {
                        $model->sampleDeliveryNum = $this->sampleDeliveryNum;                                               
                    } else {
                        $model = SampleDeliveryDetail::findOne($detail['sampleDeliveryDetailID']);
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
                throw new Exception("Gagal Menyimpan engan error: $arrayInfo");
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
        
        $this->sampleDeliveryDate = AppHelper::convertDateTimeFormat($this->sampleDeliveryDate, 'Y-m-d H:i:s','Y-m-d');
        
        $data = [];
        $details = $this->details;        
        foreach($details as $detail) {
            
            $connection = MdlDb::getDbConnection();
            $sql = 'SELECT SUM(qty) AS qty, (
                        SELECT SUM(qty) FROM tr_sampledeliverydetail
                        WHERE tr_sampledeliverydetail.batchNumber = tr_samplereceiptdetail.batchNumber
                        AND tr_sampledeliverydetail.sampleDeliveryNum != "'.$detail->sampleDeliveryNum.'"
                    ) AS stock
                    FROM tr_samplereceiptdetail 
                    WHERE batchNumber = "'.$detail->batchNumber.'"';
            $command = $connection->createCommand($sql);        
            $models = $command->queryOne();
            
          
            
                $data[] = [
                    'sampleDeliveryDetailID' => $detail->sampleDeliveryDetailID,
                    'productID' => $detail->productID, 
                    'productName' => $detail->product->productName,
                    'uomID' => $detail->uomID, 
                    'uomName' => $detail->uom->uomName, 
                    'qty' => number_format($detail->qty, 4, ',', '.'), //6 
                    'batchNumber' => $detail->batchNumber, 
                    'manufactureDate' => AppHelper::convertDateTimeFormat($detail->manufactureDate, 'Y-m-d H:i:s','d-m-Y'),
                    'expiredDate' => AppHelper::convertDateTimeFormat($detail->expiredDate, 'Y-m-d H:i:s','d-m-Y'),
                    'retestDate' => AppHelper::convertDateTimeFormat($detail->retestDate, 'Y-m-d H:i:s','d-m-Y'),
                    'stock' => $models['qty'] - $models['stock'],
                    'active' => 1,
                ];

           
        }    
        $this->_formDetails = $data;
    }
}