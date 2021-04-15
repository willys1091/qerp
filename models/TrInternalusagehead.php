<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use app\components\AppHelper;

/**
 * This is the model class for table "tr_internalusagehead".
 *
 * @property string $internalUsageNum
 * @property string $internalUsageDate
 * @property integer $warehouseID
 * @property string $notes
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrInternalusagehead extends \yii\db\ActiveRecord
{
    public $joinStockDetail;
    public $joinPurposeDetail;
    public $internalUsageStatus;
    public $modelHPP;
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_internalusagehead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['internalUsageNum', 'internalUsageDate', 'warehouseID'], 'required'],
            [['internalUsageDate', 'createdDate', 'editedDate', 'startDate','endDate'], 'safe'],
            [['warehouseID'], 'integer'],
            [['internalUsageNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 200],
            [['joinStockDetail', 'joinPurposeDetail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'internalUsageNum' => 'Internal Usage Number',
            'internalUsageDate' => 'Date',
            'warehouseID' => 'Warehouse',
            'notes' => 'Notes',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'internalUsageStatus' => 'Status',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->select('tr_internalusagehead.internalUsageNum, tr_internalusagehead.internalUsageDate, tr_internalusagehead.warehouseID, tr_internalusagehead.notes')
            ->addSelect(new Expression('IFNULL(tr_journalhead.refNum,0) internalUsageStatus'))
            ->joinWith('journal')
            ->andFilterWhere(['like', 'internalUsageNum', $this->internalUsageNum])
            ->andFilterWhere(['=', 'warehouseID', $this->warehouseID]);

        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'internalUsageDate', $start]);
            $query->andFilterWhere(['<=', 'internalUsageDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['internalUsageDate' => SORT_DESC],
                'attributes' => [
                    'internalUsageDate',
                    'internalUsageNum',
                    'warehouseID',
                    'internalUsageStatus',
                ],
            ],
        ]);

        return $dataProvider;
    }
    
     public function searchApprove()
    {
        $query = self::find()
            ->select('tr_internalusagehead.internalUsageNum, tr_internalusagehead.internalUsageDate, tr_internalusagehead.warehouseID, tr_internalusagehead.notes')
            ->addSelect(new Expression('IFNULL(tr_journalhead.refNum,0) internalUsageStatus'))
            ->joinWith('journal')
            ->where(['tr_journalhead.refNum' => NULL])
            ->andFilterWhere(['like', 'internalUsageNum', $this->internalUsageNum])
            ->andFilterWhere(['=', 'warehouseID', $this->warehouseID]);

        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'internalUsageDate', $start]);
            $query->andFilterWhere(['<=', 'internalUsageDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['internalUsageDate' => SORT_DESC],
                'attributes' => [
                    'internalUsageDate',
                    'internalUsageNum',
                    'warehouseID',
                    'internalUsageStatus',
                ],
            ],
        ]);

        return $dataProvider;
    }
    
    public function searchApproval()
    {
        $sql = "SELECT internalUsageNum,internalUsageDate,warehouseID
                FROM tr_internalusagehead
                WHERE NOT EXISTS (select j.refNum from tr_journalhead j where j.refNum=internalUsageNum)";
        $query = self::findBySql($sql);

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['internalUsageDate' => SORT_DESC],
                'attributes' => [
                    'internalUsageDate',
                    'internalUsageNum',
                    'warehouseID',
                ],
            ],
        ]);

        return $dataProvider;
    }
    public function getWarehouse(){
        return $this->hasOne(MsWarehouse::className(), ['warehouseID' => 'warehouseID']);
    }
    public function getJournal()
    {
        return $this->hasMany(TrJournalhead::className(), ['refNum' => 'internalUsageNum']);
    }
    public function getInternalUsageDetails()
    {
        return $this->hasMany(TrInternalusagedetail::className(), ['internalUsageNum' => 'internalUsageNum']);
    }
    
    public function afterFind(){
        parent::afterFind();
        $post =Yii::$app->request->get();
        if(count($post) > 0){
            $this->joinStockDetail = [];
            $this->internalUsageDate = AppHelper::convertDateTimeFormat($this->internalUsageDate, 'Y-m-d H:i:s', 'd-m-Y');

            $i = 0;
            foreach ($this->getInternalUsageDetails()->all() as $joinStockDetail) {
                $modelPurpose = MsReason::find()
                                    ->where(['mapReasonID' => $joinStockDetail->purposeAccount])
                                    ->one();

                if(!empty($joinStockDetail->expiredDate)){
                    $modelHPP = StockHpp::find()
                            ->select(['qtyStock'])
                            ->where('warehouseID = :refNum',[':refNum' => $this->warehouseID])
                            ->andWhere('batchNumber = :batchNumber',[':batchNumber' => $joinStockDetail->batchNumber])
                            ->andWhere('manufactureDate = :manufactureDate',[':manufactureDate' => $joinStockDetail->manufactureDate])
                            ->andWhere('expiredDate = :expiredDate',[':expiredDate' => $joinStockDetail->expiredDate])
                            ->sum('qtyStock');
                }
                if(!empty($joinStockDetail->retestDate)){
                    $modelHPP = StockHpp::find()
                            ->select(['qtyStock'])
                            ->where('warehouseID = :refNum',[':refNum' => $this->warehouseID])
                            ->andWhere('batchNumber = :batchNumber',[':batchNumber' => $joinStockDetail->batchNumber])
                            ->andWhere('manufactureDate = :manufactureDate',[':manufactureDate' => $joinStockDetail->manufactureDate])
                            ->andWhere('retestDate = :retestDate',[':retestDate' => $joinStockDetail->retestDate])
                            ->sum('qtyStock');
                }
                
                $this->joinStockDetail[$i]["productID"] = $joinStockDetail->productID;
                $this->joinStockDetail[$i]["productName"] = $joinStockDetail->product->productName;
                $this->joinStockDetail[$i]["uomID"] = $joinStockDetail->uomID;
                $this->joinStockDetail[$i]["uomName"] = $joinStockDetail->uom->uomName;
                $this->joinStockDetail[$i]["qty"] = $joinStockDetail->qty;
                $this->joinStockDetail[$i]["batchNumber"] = $joinStockDetail->batchNumber;
                $this->joinStockDetail[$i]["purposeID"] = $joinStockDetail->purposeAccount;
                $this->joinStockDetail[$i]["purposeName"] = $modelPurpose->mapReasonName;
                $this->joinStockDetail[$i]["manufactureDate"] = AppHelper::convertDateTimeFormat($joinStockDetail->manufactureDate, 'Y-m-d H:i:s', 'd-m-Y');
                if(!empty($joinStockDetail->expiredDate)) $this->joinStockDetail[$i]["expiredDate"] = AppHelper::convertDateTimeFormat($joinStockDetail->expiredDate, 'Y-m-d H:i:s', 'd-m-Y');
                else $this->joinStockDetail[$i]["expiredDate"] = "";
                if(!empty($joinStockDetail->retestDate)) $this->joinStockDetail[$i]["retestDate"] = AppHelper::convertDateTimeFormat($joinStockDetail->retestDate, 'Y-m-d H:i:s', 'd-m-Y');
                else $this->joinStockDetail[$i]["retestDate"] = "";
                $this->joinStockDetail[$i]["qtyInStock"] = $modelHPP;
                $i += 1;
            }
        }
    }
}
