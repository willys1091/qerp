<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\db\Expression;
use app\models\TrSamplereceiptdetail;

/**
 * This is the model class for table "tr_samplereceipthead".
 *
 * @property string $sampleReceiptNum
 * @property string $refNum
 * @property string $deliveryNum
 * @property integer $supplierID
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrSamplereceipthead extends \yii\db\ActiveRecord
{
    public $supplierName;
    public $joinSampleReceiptDetail;
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_samplereceipthead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sampleReceiptNum', 'sampleReceiptDate'], 'required'],
            [['supplierID', 'warehouseID'], 'integer'],
            [['createdDate', 'editedDate', 'startDate','endDate'], 'safe'],
            [['sampleReceiptNum', 'refNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 200],
            [['joinSampleReceiptDetail'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sampleReceiptNum' => 'Transaction Number',
            'sampleReceiptDate' => 'Date',
            'refNum' => 'Reference Number',
            'supplierID' => 'Supplier',
            'warehouseID' => 'Warehouse',
            'supplierName' => 'Supplier',
            'notes' => 'Notes',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'sampleReceiptNum', $this->sampleReceiptNum])
            ->andFilterWhere(['like', 'refNum', $this->refNum]) 
            ->andFilterwhere(['=', 'supplierID', $this->supplierID]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'sampleReceiptDate', $start]);
            $query->andFilterWhere(['<=', 'sampleReceiptDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sampleReceiptDate' => SORT_DESC],
                'attributes' => [
                    'sampleReceiptDate',
                    'sampleReceiptNum',
                    'refNum',
                    'supplierID' => [
                        'asc' => ['ms_supplier.supplierName' => SORT_ASC],
                        'desc' => ['ms_supplier.supplierName' => SORT_DESC],
                    ],
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
    public function getSupplier(){
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
    public function getSampleReceiptDetails()
    {
        return $this->hasMany(TrSamplereceiptdetail::className(), ['sampleReceiptNum' => 'sampleReceiptNum']);
    }

    public function afterFind(){
        parent::afterFind();
        $this->sampleReceiptDate = AppHelper::convertDateTimeFormat($this->sampleReceiptDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->joinSampleReceiptDetail = [];
            
        $i = 0;
        foreach ($this->getSampleReceiptDetails()->all() as $joinSampleReceiptDetail) {
            $this->joinSampleReceiptDetail[$i]["productID"] = $joinSampleReceiptDetail->productID;
            $this->joinSampleReceiptDetail[$i]["productName"] = $joinSampleReceiptDetail->product->productName;
            $this->joinSampleReceiptDetail[$i]["uomID"] = $joinSampleReceiptDetail->uomID;
            $this->joinSampleReceiptDetail[$i]["uomName"] = $joinSampleReceiptDetail->uom->uomName;
            $this->joinSampleReceiptDetail[$i]["qty"] = $joinSampleReceiptDetail->qty;
            $this->joinSampleReceiptDetail[$i]["batchNo"] = $joinSampleReceiptDetail->batchNumber;
            $this->joinSampleReceiptDetail[$i]["manufactureDate"] = AppHelper::convertDateTimeFormat($joinSampleReceiptDetail->manufactureDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinSampleReceiptDetail[$i]["expiredDate"] = AppHelper::convertDateTimeFormat($joinSampleReceiptDetail->expiredDate, 'Y-m-d H:i:s', 'd-m-Y');
            $this->joinSampleReceiptDetail[$i]["retestDate"] = AppHelper::convertDateTimeFormat($joinSampleReceiptDetail->retestDate, 'Y-m-d H:i:s', 'd-m-Y');
            $i += 1;
        }
    }
    
    public function afterDelete() {
        parent::afterDelete();
        
        TrSamplereceiptdetail::deleteAll('sampleReceiptNum = :sampleReceiptNum', [":sampleReceiptNum" => $this->sampleReceiptNum]);
        SampleStockCard::deleteAll('refNum = :refNum', [':refNum' => $this->sampleReceiptNum]);
    }
}
