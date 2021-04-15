<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\SampleStockCard;

/**
 * This is the model class for table "tr_sampledeliverydetail".
 *
 * @property integer $sampleDeliveryDetailID
 * @property string $sampleDeliveryNum
 * @property integer $productID
 * @property integer $uomID
 * @property string $qty
 * @property string $deliveryNum
 */
class TrSampledeliverydetail extends \yii\db\ActiveRecord
{
    public $transactionDate;
    public $customerID;
    public $outstandingQty;
    
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_sampledeliverydetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sampleDeliveryNum', 'productID'], 'required'],
            [['sampleDeliveryDetailID', 'productID', 'uomID', 'statusID'], 'integer'],
            [['qty'], 'string'],
            [['manufactureDate', 'expiredDate','retestDate','transactionDate', 'startDate', 'endDate'], 'safe'],
            [['sampleDeliveryNum'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 50],
            [['batchNumber'], 'string', 'max' => 100],
            [['sampleDeliveryNum'], 'exist', 'skipOnError' => true, 'targetClass' => TrSampledeliveryhead::className(), 'targetAttribute' => ['sampleDeliveryNum' => 'sampleDeliveryNum']],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
            [['uomID'], 'exist', 'skipOnError' => true, 'targetClass' => MsUom::className(), 'targetAttribute' => ['uomID' => 'uomID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sampleDeliveryDetailID' => 'Sample Delivery Detail ID',
            'sampleDeliveryNum' => 'Sample Delivery Num',
            'productID' => 'Product',
            'uomID' => 'Uom ID',
            'qty' => 'Qty',
            'batchNumber' => 'Batch Num',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'statusID' => 'Status',
            'notes' => 'Notes',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'tr_sampledeliverydetail.productID', $this->productID])
            ->andFilterWhere(['like', 'tr_sampledeliverydetail.sampleDeliveryNum', $this->sampleDeliveryNum]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->joinWith('sampleHead');
            $query->andFilterWhere(['>=', 'sampleDeliveryDate', $start]);
            $query->andFilterWhere(['<=', 'sampleDeliveryDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sampleDeliveryNum' => SORT_DESC],
                'attributes' => [
                    'sampleDeliveryNum',
                    'productID',
                ],
            ]
        ]);

        return $dataProvider;
    }
    public function getUom()
    {
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID']);
    }
    public function getProduct()
    {
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
    public function getSampleHead()
    {
        return $this->hasOne(TrSampledeliveryhead::className(), ['sampleDeliveryNum' => 'sampleDeliveryNum']);
    }
    public function getStatus()
    {
        return $this->hasOne(LkStatus::className(), ['statusID' => 'statusID']);
    }
    
    public function afterFind()
    {
        parent::afterFind();
        
        $this->outstandingQty = SampleStockCard::getOutstandingQty($this->productID);
    }
}
