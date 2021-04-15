<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\db\Expression;

/**
 * This is the model class for table "tr_purchaseordernoninventoryhead".
 *
 * @property string $purchaseOrderNonInventoryDate
 * @property string $refNum
 * @property boolean $hasVAT
 * @property string $taxInvoice
 * @property integer $supplierID
 * @property string $additionalInfo
 * @property string $subtotal
 * @property string $discountTotal
 * @property string $total
 * @property string $VAT
 * @property string $grandTotal
 */
class TrPurchaseordernoninventoryhead extends \yii\db\ActiveRecord
{
    public $supplierName;
    public $joinPurchaseOrderDetail;
    public $amount;
    public $subtotal, $total, $discountTotal;
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_purchaseordernoninventoryhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchaseOrderNonInventoryDate','currencyID','rate','supplierID', 'supplierName'], 'required'],
            [['purchaseOrderNonInventoryDate', 'refNum', 'supplierID','joinPurchaseOrderDetail', 'startDate','endDate','supplierName','subtotal','discountTotal'], 'safe'],
            [['hasVAT'], 'boolean'],
            [['supplierID', 'whtID'], 'integer'],
            [['taxInvoice', 'grandTotal', 'whtRate', 'rate', 'amount', 'purchaseOrderNonInventoryNum'], 'string'],
            [['currencyID'], 'string', 'max' => 5],
            [['refNum'], 'string', 'max' => 50],
            [['additionalInfo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchaseOrderNonInventoryDate' => 'Date',
            'refNum' => 'Reference Number',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'hasVAT' => 'Has Vat?',
            'taxInvoice' => 'Tax Invoice',
            'supplierID' => 'Supplier',
            'additionalInfo' => 'Additional Info',
            'subtotal' => 'SubTotal',
            'discountTotal' => 'Discount Total',
            'grandTotal' => 'Grand Total',
            'supplierName' => 'Supplier',
            'whtID' => 'WHT'
        ];
    }
    
    public function getSupplier()
    {
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
    
    public function getPurchaseOrderNonInventoryDetails()
    {
        return $this->hasMany(TrPurchaseordernoninventorydetail::className(), ['purchaseOrderNonInventoryNum' => 'purchaseOrderNonInventoryNum']);
    }
    
    public function search()
    {
        $query = self::find()
        ->select('purchaseOrderNonInventoryNum, refNum, purchaseOrderNonInventoryDate, supplierID, taxInvoice, grandTotal')
        ->andFilterWhere(['like', 'purchaseOrderNonInventoryNum', $this->purchaseOrderNonInventoryNum])        
        ->andFilterWhere(['like', 'refNum', $this->refNum])
        ->andFilterWhere(['=', 'grandTotal', $this->grandTotal])
        ->andFilterWhere(['=', 'supplierID', $this->supplierID]);
         
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'purchaseOrderNonInventoryDate', $start]);
            $query->andFilterWhere(['<=', 'purchaseOrderNonInventoryDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                        'defaultOrder' => ['purchaseOrderNonInventoryDate' => SORT_DESC],
                        'attributes' => [
                            'purchaseOrderNonInventoryNum',
                            'purchaseOrderNonInventoryDate',
                            'grandTotal',
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
    
    public function afterFind(){
        parent::afterFind();
        $this->purchaseOrderNonInventoryDate = AppHelper::convertDateTimeFormat($this->purchaseOrderNonInventoryDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->supplierName = $this->supplier->supplierName;                
        $this->joinPurchaseOrderDetail = [];
        
        $i = 0;
        foreach ($this->getPurchaseOrderNonInventoryDetails()->all() as $joinPurchaseOrderDetail) {
            $this->joinPurchaseOrderDetail[$i]["productID"] = $joinPurchaseOrderDetail->productID;
            $this->joinPurchaseOrderDetail[$i]["productName"] = $joinPurchaseOrderDetail->product->productName;
            $this->joinPurchaseOrderDetail[$i]["uomID"] = $joinPurchaseOrderDetail->uomID;
            $this->joinPurchaseOrderDetail[$i]["uomName"] = $joinPurchaseOrderDetail->uom->uomName;
            $this->joinPurchaseOrderDetail[$i]["qty"] = $joinPurchaseOrderDetail->qty;
            $this->joinPurchaseOrderDetail[$i]["price"] = $joinPurchaseOrderDetail->price;
            $this->joinPurchaseOrderDetail[$i]["discount"] = $joinPurchaseOrderDetail->discount;
            $this->joinPurchaseOrderDetail[$i]["subtotal"] = $joinPurchaseOrderDetail->subtotal;
            $i += 1;
        }
    }
}
