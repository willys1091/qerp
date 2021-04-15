<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\db\Expression;
use app\models\TrSampledeliverydetail;

/**
 * This is the model class for table "tr_sampledeliveryhead".
 *
 * @property string $sampleDeliveryNum
 * @property string $sampleDeliveryDate
 * @property string $refNum
 * @property integer $customerID
 * @property string $notes
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrSampledeliveryhead extends \yii\db\ActiveRecord
{
    public $customerName;
    public $joinSampleDeliveryDetail;
    public $joinStatusDetail;

    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_sampledeliveryhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sampleDeliveryNum', 'sampleDeliveryDate', 'warehouseID', 'customerID', 'customerDetailID'], 'required'],
            [['sampleDeliveryDate', 'createdDate', 'editedDate', 'startDate','endDate'], 'safe'],
            [['customerID','warehouseID', 'customerDetailID'], 'integer'],
            [['sampleDeliveryNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 200],
            [['customerID'], 'exist', 'skipOnError' => true, 'targetClass' => MsCustomer::className(), 'targetAttribute' => ['customerID' => 'customerID']],
            [['joinSampleDeliveryDetail', 'joinStatusDetail'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sampleDeliveryNum' => 'Transaction Number',
            'sampleDeliveryDate' => 'Date',
            'customerID' => 'Customer',
            'customerName' => 'Customer',
            'warehouseID' => 'Warehouse',
            'notes' => 'Notes',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'customerDetailID' => 'Attendant'
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'sampleDeliveryNum', $this->sampleDeliveryNum])
            ->andfilterWhere(['=', 'customerID', $this->customerID]);

        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'sampleDeliveryDate', $start]);
            $query->andFilterWhere(['<=', 'sampleDeliveryDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sampleDeliveryDate' => SORT_DESC],
                'attributes' => [
                    'sampleDeliveryDate',
                    'sampleDeliveryNum',
                    'customerID',
                ],
            ]
        ]);

        return $dataProvider;
    }
    public function getCustomer(){
        return $this->hasOne(MsCustomer::className(), ['customerID' => 'customerID']);
    }
    
    public function getSampleDeliveryDetails()
    {
        return $this->hasMany(TrSampledeliverydetail::className(), ['sampleDeliveryNum' => 'sampleDeliveryNum']);
    }

    public function afterFind(){
        parent::afterFind();
        $this->sampleDeliveryDate = AppHelper::convertDateTimeFormat($this->sampleDeliveryDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->joinSampleDeliveryDetail = [];
            
        $i = 0;
        foreach ($this->getSampleDeliveryDetails()->all() as $joinSampleDeliveryDetail) {
            $this->joinSampleDeliveryDetail[$i]["productID"] = $joinSampleDeliveryDetail->productID;
            $this->joinSampleDeliveryDetail[$i]["productName"] = $joinSampleDeliveryDetail->product->productName;
            $this->joinSampleDeliveryDetail[$i]["uomID"] = $joinSampleDeliveryDetail->uomID;
            $this->joinSampleDeliveryDetail[$i]["uomName"] = $joinSampleDeliveryDetail->uom->uomName;
            $this->joinSampleDeliveryDetail[$i]["qty"] = $joinSampleDeliveryDetail->qty;
            $this->joinSampleDeliveryDetail[$i]["batchNo"] = $joinSampleDeliveryDetail->batchNumber;
            $this->joinSampleDeliveryDetail[$i]["manufactureDate"] = AppHelper::convertDateTimeFormat($joinSampleDeliveryDetail->manufactureDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinSampleDeliveryDetail[$i]["expiredDate"] = AppHelper::convertDateTimeFormat($joinSampleDeliveryDetail->expiredDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinSampleDeliveryDetail[$i]["retestDate"] = $joinSampleDeliveryDetail->retestDate == null? '' : AppHelper::convertDateTimeFormat($joinSampleDeliveryDetail->retestDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinSampleDeliveryDetail[$i]["notes"] = $joinSampleDeliveryDetail->notes;
            $this->joinSampleDeliveryDetail[$i]["outstandingQty"] = SampleStockCard::getOutstandingQty($joinSampleDeliveryDetail->productID);
            $i += 1;
        }
    }
    
    public function afterDelete() {
        parent::afterDelete();
        
        TrSampledeliverydetail::deleteAll('sampleDeliveryNum = :sampleDeliveryNum', [":sampleDeliveryNum" => $this->sampleDeliveryNum]);
        SampleStockCard::deleteAll('refNum = :refNum', [':refNum' => $this->sampleDeliveryNum]);
    }
}
