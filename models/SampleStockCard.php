<?php

namespace app\models;

use app\components\AppHelper;
use app\components\ReportEngine;
use app\models\MsProduct;
use app\models\TrSampledeliveryhead;
use app\models\TrSamplereceipthead;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "sample_stock_card".
 *
 * @property integer $ID
 * @property string $refNum
 * @property string $transactionDate
 * @property integer $productID
 * @property string $notes
 * @property string $inQty
 * @property string $outQty
 */
class SampleStockCard extends ActiveRecord
{
    public $productName,$uomID,$uomName;
    public $warehouseName;
    public $qtyStock;
    public $HPP;
    public $startDate, $endDate;
    public $balanceQty, $filterSupp, $filterCust, $customerName, $supplierName, $origin;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_stockcardsample';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refNum', 'transactionDate', 'productID', 'inQty', 'outQty'], 'required'],
            [['transactionDate','batchNumber','uomID','manufactureDate','expiredDate','retestDate', 'startDate', 'startDate','batchNumber', 'balanceQty','productName','uomName','filterSupp','filterCust','customerName', 'supplierName', 'origin'], 'safe'],
            [['productID', 'warehouseID'], 'integer'],
            [['inQty', 'outQty'], 'number'],
            [['refNum','batchNumber'], 'string', 'max' => 50],
            [['notes'], 'string', 'max' => 100],
            [['productID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProduct::className(), 'targetAttribute' => ['productID' => 'productID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'refNum' => 'Reference Number',
            'batchNumber' => 'Batch Number',
            'transactionDate' => 'Transaction Date',
            'manufactureDate' => 'Manufacture Date',
            'expiredDate' => 'Expired Date',
            'retestDate' => 'Retest Date',
            'productID' => 'Product',
            'warehouseID' => 'Warehouse',
            'notes' => 'Notes',
            'inQty' => 'In Qty',
            'outQty' => 'Out Qty',
            'uomID' => 'Unit',
            'filterCust' => 'Customer',
            'filterSupp' => 'Supplier',
            'balanceQty' => Yii::t('app', 'Balance Qty'),
        ];
    }
    public function getSamplereceipthead(){
        return $this->hasOne(TrSamplereceipthead::className(), ['sampleReceiptNum' => 'refNum']);
    }
    public function getSampledeliveryhead(){
        return $this->hasOne(TrSampledeliveryhead::className(), ['sampleDeliveryNum' => 'refNum']);
    }
    public function getParentProduct(){
        return $this->hasOne(MsProduct::className(), ['productID' => 'productID']);
    }
    public function getParentWarehouse(){
        return $this->hasOne(MsWarehouse::className(), ['warehouseID' => 'warehouseID']);
    }
    
    public function getParentProductDetail(){
        return $this->hasOne(MsProductdetail::className(), ['productID' => 'productID']);
    }
    
    public function getParentUom(){
        return $this->hasOne(MsUom::className(), ['uomID' => 'productID']);
    }
    
    public function search($filter,$isDownload = false)
    {       
        $convertedDateFrom = AppHelper::convertDateTimeFormat($filter->startDate, 'd-m-Y', 'Y-m-d');
        $convertedDateTo = AppHelper::convertDateTimeFormat($filter->endDate, 'd-m-Y', 'Y-m-d'); 
        
            
//         $query = self::find()
//            ->select([new Expression("'-- Previous Balance --' AS refNum"),
//                'transactionDate' =>  new Expression("'" . $convertedDateFrom  . "'"),
//                'ms_product.productID',
//                'ms_product.productName',
//                'ms_warehouse.warehouseID',
//                'inQty' => new Expression('0'),
//                'outQty'=> new Expression('0'),
//                'batchNumber'])
//            ->andFilterWhere(['=', 'ms_product.productID',''])
//            ->andFilterWhere(['=', 'ms_product.productName', ''])
//            ->andFilterWhere(['like', 'ms_warehouse.warehouseID', $filter->warehouseID])
//            ->andFilterWhere(['=', "DATE(transactionDate)", $convertedDateFrom])
//            ->joinWith('parentProduct')
//            ->joinWith('parentWarehouse')
//            ->groupBy(['DATE(transactionDate)']);
  
        $query1 = self::find()
            ->select(['ms_product.origin','ms_supplier.supplierName','ms_customer.customerName',new Expression("'-- Previous Balance --' AS refNum"),
                'transactionDate' =>  new Expression("'" . $filter->startDate  . "'"),
                'tr_stockcardsample.productID',
                'ms_warehouse.warehouseID',
                'ms_uom.uomName',
                'ms_product.productName',
                'inQty' => new Expression('IFNULL(SUM((inQty)),0)'),
                'outQty'=> new Expression('IFNULL(SUM((outQty)),0)'),
                'batchNumber'])
            ->where(['=', 'tr_stockcardsample.productID', $filter->productID])
            ->andFilterWhere(['LIKE', 'ms_product.productName', $filter->productName])
            ->andFilterWhere(['LIKE', 'ms_supplier.supplierName', $filter->filterSupp])
            ->andFilterWhere(['LIKE', 'ms_customer.customerName', $filter->filterCust])
            ->andFilterWhere(['=', 'tr_stockcardsample.warehouseID', $filter->warehouseID])
            ->andFilterWhere(['<', "DATE(transactionDate)", $convertedDateFrom])
            ->joinWith('parentProduct')
            ->joinWith('parentWarehouse')
            ->joinWith('samplereceipthead')
            ->joinWith('sampledeliveryhead')
            ->joinWith('samplereceipthead.supplier')
            ->joinWith('sampledeliveryhead.customer')
            ->joinWith('parentProductDetail.uom');
 

            //var_dump($query1->all());
        $query2 = self::find()
            ->select(['ms_product.origin','ms_supplier.supplierName','ms_customer.customerName','tr_stockcardsample.refNum',
                'DATE_FORMAT(transactionDate, "%d-%m-%Y")',
                'tr_stockcardsample.productID',
                'ms_warehouse.warehouseID',
                'ms_uom.uomName',
                'ms_product.productName',
                'inQty' => new Expression('IFNULL(SUM((inQty)),0)'),
                'outQty'=> new Expression('IFNULL(SUM((outQty)),0)'),
                'batchNumber'])
          
            ->where(['=', 'tr_stockcardsample.productID', $filter->productID])
            ->andFilterWhere(['LIKE', 'ms_product.productName', $filter->productName])
            ->andFilterWhere(['LIKE', 'ms_supplier.supplierName', $filter->filterSupp])
            ->andFilterWhere(['LIKE', 'ms_customer.customerName', $filter->filterCust])
            ->andFilterWhere(['=', 'tr_stockcardsample.warehouseID', $filter->warehouseID])
            ->andFilterWhere(['>=', "DATE(transactionDate)", $convertedDateFrom])
            ->andFilterWhere(['<=', "DATE(transactionDate)", $convertedDateTo])
            ->joinWith('parentProduct')
            ->joinWith('parentWarehouse')
            ->joinWith('samplereceipthead')
            ->joinWith('sampledeliveryhead')
            ->joinWith('samplereceipthead.supplier')
            ->joinWith('sampledeliveryhead.customer')
            ->joinWith('parentProductDetail.uom')
            ->groupBy(['tr_stockcardsample.transactionDate']);
        
     
        $unions = $query1->union($query2);
       //var_dump($query1->all());
        
        $headers = [

            "productName" => [
                "label" => $this->getAttributeLabel("ProductName"),
                "type" => "string",
            ],
            "customerName" => [
                "label" => $this->getAttributeLabel("customerName"),
                "type" => "string",
            ],
            "supplierName" => [
                "label" => $this->getAttributeLabel("supplierName"),
                "type" => "string",
            ],
            "batchNumber" => [
                "label" => $this->getAttributeLabel("batchNumber"),
                "type" => "string",
            ],
            "uomName" => [
                "label" => Yii::t("app", "Unit"),
                "type" => "string",
            ],
            "transactionDate" => [
                "label" => Yii::t("app", "transaction Date"),
                "type" => "string",
            ],
            "refNum" => [
                "label" => $this->getAttributeLabel("refNum"),
                "type" => "string",
            ],
            "inQty" => [
                "label" => $this->getAttributeLabel("inQty"),
                "type" => "string",
            ],
            "outQty" => [
                "label" => $this->getAttributeLabel("outQty"),
                "type" => "string",
            ],

        ];

     //$unionBalanceQuery = (new Query())->from(['unionQuery' => $query2->union($query, true)]);
       // var_dump($convertedDateFrom);
       

        if (!$isDownload) {
            $dataProvider = new ActiveDataProvider([
            'query' =>  $unions,//$filter->productName ? $unions : $query2,
            'sort' => [
                'defaultOrder' => ['transactionDate' => SORT_ASC],

                ],
                'pagination' => [
                    'pageSize' => 0
                ]
            ]);
           
        } else {
            $unions = (new Query)
           
            ->from(['dummy_name' => $query1->union($query2)]);
           // $unions = (new Query)
//            $unions = (new Query)
//            ->from(['dummy_name' => $query2]);
            ReportEngine::downloadReport($filter, $unions, $headers, "Stock Card Sample");
            return null;
        }
         return $dataProvider;
    }

//    public function search()
//    {
//        $query = self::find()
//            ->select(['refNum','transactionDate','productID','warehouseID','inQty','outQty','batchNumber']);
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort' => [
//                'defaultOrder' => ['productID' => SORT_ASC],
//                
//            ],
//            'pagination' => [
//                'pageSize' => 10
//            ]
//        ]);
//
//        return $dataProvider;
//    }
    
    
    public function afterFind() {
        parent::afterFind();
        
         
        $this->uomName = $this->uomName == '' ? '' :  $this->uomName;

    }
    
    public static function getOutstandingQty ($productID)
    {
        $stockCardSample = self::find()
            ->select([new Expression('SUM(inQty - outQty) as qtyStock')])
            ->where(['productID' => $productID])
            ->asArray()
            ->one();
        if ($stockCardSample == null)
        {
            return null;
        }
        
        return $stockCardSample['qtyStock'];
    }
}
