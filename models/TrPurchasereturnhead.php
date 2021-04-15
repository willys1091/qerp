<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\db\Expression;

/**
 * This is the model class for table "tr_purchasereturnhead".
 *
 * @property string $purchaseReturnNum
 * @property string $purchaseReturnDate
 * @property integer $supplierID
 * @property string $currencyID
 * @property string $rate
 * @property integer $paymentID
 * @property string $coaNo
 * @property string $grandTotal
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrPurchasereturnhead extends \yii\db\ActiveRecord
{
    public $joinPurchaseReturnDetail;
    public $supplierName;
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_purchasereturnhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchaseReturnDate', 'supplierID', 'currencyID', 'rate', 'grandTotal'], 'required'],
            [['purchaseReturnDate', 'createdDate', 'editedDate', 'startDate','endDate'], 'safe'],
            [['supplierID','uomID'], 'integer'],
            [['rate', 'grandTotal'], 'string'],    
            [['purchaseReturnNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['currencyID'], 'string', 'max' => 5],
            [['coaNo'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
            [['joinPurchaseReturnDetail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchaseReturnNum' => 'Transaction Number',
            'purchaseReturnDate' => 'Date',
            'supplierID' => 'Supplier',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'taxInvoiceNum' => 'Tax Invoice Number',
            'coaNo' => 'COA Number',
            'grandTotal' => 'Grand Total',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }

    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'purchaseReturnNum', $this->purchaseReturnNum])
            ->andFilterWhere(['=', 'supplierID', $this->supplierID])
            ->andFilterWhere(['like', 'grandTotal', $this->grandTotal])
            ->andFilterWhere(['=', 'currencyID', $this->currencyID]);

        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'purchaseReturnDate', $start]);
            $query->andFilterWhere(['<=', 'purchaseReturnDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['purchaseReturnDate' => SORT_DESC],
                'attributes' => [
                    'purchaseReturnDate',
                    'purchaseReturnNum',
                    'supplierID',
                    'currencyID',
                    'grandTotal',
                ],
            ],
        ]);

        return $dataProvider;
    }
    public function getSupplier(){
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
    public function getPurchaseReturnDetails()
    {
        return $this->hasMany(TrPurchasereturndetail::className(), ['purchaseReturnNum' => 'purchaseReturnNum']);
    }
    
    public function getCoaNo()
    {
        return $this->hasMany(MsCoa::className(), ['coaNo' => 'coaNo']);
    }
    
    public function afterFind(){
        parent::afterFind();
        $this->purchaseReturnDate = AppHelper::convertDateTimeFormat($this->purchaseReturnDate, 'Y-m-d H:i:s', 'd-m-Y');
                
        $this->joinPurchaseReturnDetail = [];
        $i = 0;
        foreach ($this->getPurchaseReturnDetails()->all() as $joinPurchaseReturnDetail) {
            $this->joinPurchaseReturnDetail[$i]["productID"] = $joinPurchaseReturnDetail->productID;
            $this->joinPurchaseReturnDetail[$i]["productName"] = $joinPurchaseReturnDetail->product->productName;
            $this->joinPurchaseReturnDetail[$i]["uomID"] = $joinPurchaseReturnDetail->uomID;
            $this->joinPurchaseReturnDetail[$i]["uomName"] = $joinPurchaseReturnDetail->uom->uomName;
            $this->joinPurchaseReturnDetail[$i]["qty"] = $joinPurchaseReturnDetail->qty;
            $this->joinPurchaseReturnDetail[$i]["Price"] = $joinPurchaseReturnDetail->HPP;
            $this->joinPurchaseReturnDetail[$i]["taxValue"] = $joinPurchaseReturnDetail->VAT;
            $this->joinPurchaseReturnDetail[$i]["tax"] = ($joinPurchaseReturnDetail->VAT > 0 ? "checked" : "");
            $this->joinPurchaseReturnDetail[$i]["totalAmount"] = $joinPurchaseReturnDetail->totalAmount;
            $this->joinPurchaseReturnDetail[$i]["notes"] = $joinPurchaseReturnDetail->notes;
            $i += 1;
        }
    }
}
