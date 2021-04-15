<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\db\Expression;

/**
 * This is the model class for table "tr_salesreturnhead".
 *
 * @property string $salesReturnNum
 * @property string $salesReturnDate
 * @property integer $customerID
 * @property string $coaNo
 * @property string $grandTotal
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrSalesreturnhead extends \yii\db\ActiveRecord
{
    public $joinSalesReturnDetail;
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_salesreturnhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesReturnNum', 'salesReturnDate', 'customerID', 'grandTotal'], 'required'],
            [['salesReturnDate', 'createdDate', 'editedDate', 'startDate','endDate', 'fakturNum'], 'safe'],
            [['customerID'], 'integer'],
            [['grandTotal'], 'string'],
            [['salesReturnNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['coaNo'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 45],
            [['joinSalesReturnDetail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'salesReturnNum' => 'Transaction Number',
            'salesReturnDate' => 'Date',
            'customerID' => 'Customer',
            'coaNo' => 'COA Number',
            'grandTotal' => 'Grand Total',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'fakturNum' => 'Faktur Number',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->joinWith('coa')
            ->andFilterWhere(['like', 'salesReturnNum', $this->salesReturnNum])
            ->andFilterWhere(['=', 'customerID', $this->customerID])
            ->andFilterWhere(['=', 'ms_coa.coaNo', $this->coaNo])
            ->andFilterWhere(['like', 'grandTotal', $this->grandTotal]);

        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'salesReturnDate', $start]);
            $query->andFilterWhere(['<=', 'salesReturnDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['salesReturnDate' => SORT_DESC],
                'attributes' => [
                    'salesReturnDate',
                    'salesReturnNum',
                    'customerID',
                    'grandTotal',
                    'coaNo'
                ],
            ],
        ]);

        return $dataProvider;
    }
    public function getCustomer(){
        return $this->hasOne(MsCustomer::className(), ['customerID' => 'customerID']);
    }
    
    public function getSalesReturnDetails() {
        return $this->hasMany(TrSalesreturndetail::className(), ['salesReturnNum' => 'salesReturnNum']);        
    }
    
    public function getCoa() {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'coaNo']);        
    }
    
    public function afterFind(){
        parent::afterFind();
        $this->salesReturnDate = AppHelper::convertDateTimeFormat($this->salesReturnDate, 'Y-m-d H:i:s', 'd-m-Y');
                
        $this->joinSalesReturnDetail = [];
        $i = 0;
        foreach ($this->getSalesReturnDetails()->all() as $joinSalesReturnDetail) {
            
           
            
            $data =  TrGoodsdeliverydetail::find()
                ->select([new Expression('SUM(qty) as qtyStock')])
                ->where('goodsDeliveryNum = :refNum', [':refNum' => $joinSalesReturnDetail->refNum])->all();
            foreach ($data as $row) {
                
                $myFloat =  $row->qtyStock;
                $myStr = "$myFloat" * 1;
                $decimal = strlen(explode('.', $myStr)[1]);
                $qtyStock = number_format($myStr, $decimal, '.', ',');
                $this->joinSalesReturnDetail[$i]["sentQty"] = $qtyStock;
            }
            $this->joinSalesReturnDetail[$i]["refNum"] = $joinSalesReturnDetail->refNum;
            $this->joinSalesReturnDetail[$i]["productID"] = $joinSalesReturnDetail->productID;
            $this->joinSalesReturnDetail[$i]["productName"] = $joinSalesReturnDetail->product->productName;
            $this->joinSalesReturnDetail[$i]["uomID"] = $joinSalesReturnDetail->uomID;
            $this->joinSalesReturnDetail[$i]["uomName"] = $joinSalesReturnDetail->uom->uomName;
            
            $myFloat =  $joinSalesReturnDetail->qty;
            $myStr = "$myFloat" * 1;
            $decimal = strlen(explode('.', $myStr)[1]);
            $qty= number_format($myStr, $decimal, '.', ',');
            
            $this->joinSalesReturnDetail[$i]["qty"] =  $qty;
            
               
            $this->joinSalesReturnDetail[$i]["HPP"] = $joinSalesReturnDetail->HPP;
            $this->joinSalesReturnDetail[$i]["VAT"] = $joinSalesReturnDetail->VAT;
            $this->joinSalesReturnDetail[$i]["tax"] = ($joinSalesReturnDetail->VAT > 0 ? "checked" : "");
            $this->joinSalesReturnDetail[$i]["totalAmount"] = $joinSalesReturnDetail->totalAmount;
            $this->joinSalesReturnDetail[$i]["notes"] = $joinSalesReturnDetail->notes;
            $i += 1;
        }
    }
}
