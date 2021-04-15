<?php

namespace app\models;

use app\components\AppHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tr_salesquotationhead".
 *
 * @property string $salesQuotationNum
 * @property string $salesQuotationDate
 * @property integer $marketingID
 * @property integer $customerID
 * @property string $grandTotal
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrSalesquotationhead extends ActiveRecord
{
    public $joinSalesQuotationDetail;
    public $orderStatus;
	public $unitPrice;
    public $customerName;
    public $dateFrom;
    public $startDate,$endDate, $productID;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_salesquotationhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salesQuotationNum', 'salesQuotationDate', 'marketingID', 'customerID', 'contactPerson'], 'required'],
            [['salesQuotationDate', 'additionalInfo', 'createdDate', 'editedDate', 'cc', 'attachment','currencyID', 'productID', 'unitPrice'], 'safe'],
            [['marketingID', 'customerID'], 'integer'],
            [['grandTotal'], 'string'],
            [['salesQuotationNum', 'contactPerson', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['delivery', 'payment', 'attachment'], 'string', 'max' => 50],
            [['customerID'], 'exist', 'skipOnError' => true, 'targetClass' => MsCustomer::className(), 'targetAttribute' => ['customerID' => 'customerID']],
            [['marketingID'], 'exist', 'skipOnError' => true, 'targetClass' => MsMarketing::className(), 'targetAttribute' => ['marketingID' => 'marketingID']],
            [['startDate','endDate','joinSalesQuotationDetail'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'salesQuotationNum' => 'Sales Quotation Number',
            'salesQuotationDate' => 'Date',
            'marketingID' => 'Marketing Name',
            'customerID' => 'Customer Name',
            'contactPerson' => 'Attendant',
            'grandTotal' => 'Grand Total',
            'orderStatus' => 'Order Status',
            'delivery' => 'Delivery',
            'payment' => 'Payment',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'cc' => 'Cc',
            'attachment' => 'Attachment',
            'currencyID' => 'Currency',
            'productID' => 'Product',
        ];
    }
    public function getParentCustomer(){
        return $this->hasOne(MsCustomer::className(), ['customerID' => 'customerID']);
    }
    public function getParentMarketing(){
        return $this->hasOne(MsMarketing::className(), ['marketingID' => 'marketingID']);
    }
    public function getSalesQuotationDetails()
    {
        return $this->hasMany(TrSalesquotationdetail::className(), ['salesQuotationNum' => 'salesQuotationNum']);
    }
    public function getSalesOrder()
    {
        return $this->hasMany(TrSalesorderhead::className(), ['refNum' => 'salesQuotationNum']);
    }
    public function search()
    {
        $query = self::find()
            ->select('tr_salesquotationhead.currencyID, tr_salesquotationhead.salesQuotationNum, tr_salesquotationhead.salesQuotationDate, tr_salesquotationhead.customerID, ms_customer.customerName, tr_salesquotationhead.marketingID, tr_salesquotationhead.grandTotal')
            ->addSelect(new Expression('IFNULL(tr_salesorderhead.refNum,0) orderStatus'))
            ->joinWith('salesOrder')
            ->joinWith('parentCustomer')
            ->joinWith('salesQuotationDetails.product')
            ->andFilterWhere(['like', 'tr_salesquotationhead.salesQuotationNum', $this->salesQuotationNum])
            ->andFilterWhere(['=', 'marketingID', $this->marketingID])
            ->andFilterWhere(['=', 'currencyID', $this->currencyID])
            ->andFilterWhere(['like', 'ms_product.productName', $this->productID])
            ->andFilterWhere(['=', 'tr_salesquotationdetail.priceoffer', $this->unitPrice])
            ->andFilterWhere(['like', 'ms_customer.customerName', $this->customerID])
            ->andFilterWhere(['like', 'tr_salesquotationhead.grandTotal', $this->grandTotal]);
    
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'salesQuotationDate', $start]);
            $query->andFilterWhere(['<=', 'salesQuotationDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['salesQuotationDate' => SORT_DESC],
                'attributes' => [
                    'salesQuotationNum',
                    'salesQuotationDate',
                    'customerID' => [
                        'asc' => ['ms_customer.customerName' => SORT_ASC],
                        'desc' => ['ms_customer.customerName' => SORT_DESC],
                    ],
                    'productID' => [
                        'asc' => ['ms_product.productName' => SORT_ASC],
                        'desc' => ['ms_product.productName' => SORT_DESC],
                    ],
                    'unitPrice' => [
                        'asc' => ['tr_salesquotationdetail.priceoffer' => SORT_ASC],
                        'desc' => ['tr_salesquotationdetail.priceoffer' => SORT_DESC],
                    ],
                    'currencyID',
                    'grandTotal'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }

    public function searchBrowse()
    {   
//        $query = self::find()
//            ->select('ms_marketing.marketingName, ms_customer.customerName, tr_salesquotationhead.currencyID,tr_salesquotationhead.currencyID,tr_salesquotationhead.currencyID, '
//                . 'tr_salesquotationhead.salesQuotationNum, tr_salesquotationhead.salesQuotationDate, tr_salesquotationhead.customerID, tr_salesquotationhead.marketingID,'
//                . ' tr_salesquotationhead.grandTotal, tr_salesquotationhead.contactPerson')
//            ->addSelect(new Expression('IFNULL(tr_salesorderhead.refNum,0) orderStatus'))
//            ->joinWith('salesOrder')
//            ->joinWith('parentMarketing')
//            ->joinWith('parentCustomer')
//            ->joinWith('salesQuotationDetails.product')
//            ->where('tr_salesorderhead.salesOrderNum IN
//                (
//                    SELECT  IFNULL(SUM(b.qty),0) qtyDetail
//                    FROM tr_salesorderhead a
//                    LEFT JOIN tr_salesorderdetail ON b.salesOrderNum = a.salesOrderNum
//                    groupby(salesOrderNum)
//
//                ) < ')
//            ->andFilterWhere(['like', 'tr_salesquotationhead.salesQuotationNum', $this->salesQuotationNum])
//            ->andFilterWhere(['like', 'ms_marketing.marketingName', $this->marketingID])
//            ->andFilterWhere(['=', 'currencyID', $this->currencyID])
//            ->andFilterWhere(['like', 'ms_product.productName', $this->productID])
//            ->andFilterWhere(['like', 'ms_customer.customerName', $this->customerID])
//            ->andFilterWhere(['=', "DATE_FORMAT(salesQuotationDate, '%d-%m-%Y')", $this->salesQuotationDate])
//            ->andFilterWhere(['like', 'tr_salesquotationhead.grandTotal', $this->grandTotal]);
//        
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort' => [
//                'defaultOrder' => ['salesQuotationDate' => SORT_DESC],
//                'attributes' => [
//                    'salesQuotationDate',
//                    'salesQuotationNum',
//                    'marketingID' => [
//                        'asc' => ['ms_marketing.marketingName' => SORT_ASC],
//                        'desc' => ['ms_marketing.marketingName' => SORT_DESC],
//                    ],
//                    'customerID' => [
//                        'asc' => ['ms_customer.customerName' => SORT_ASC],
//                        'desc' => ['ms_customer.customerName' => SORT_DESC],
//                    ],
//                    'productID' => [
//                        'asc' => ['ms_product.productName' => SORT_ASC],
//                        'desc' => ['ms_product.productName' => SORT_DESC],
//                    ],
//                    'currencyID' => [
//                        'asc' => ['tr_salesquotationhead.currencyID' => SORT_ASC],
//                        'desc' => ['tr_salesquotationhead.currencyID' => SORT_DESC],
//                    ],
//                    'grandTotal' => [
//                        'asc' => ['tr_salesquotationhead.grandTotal' => SORT_ASC],
//                        'desc' => ['tr_salesquotationhead.grandTotal' => SORT_DESC],
//                    ]
//                ]
//            ],
//        ]);
//        return $dataProvider;   
        $filterSalesQuotationNum = '';
        if($this->salesQuotationNum != NULL) $filterSalesQuotationNum = " and a.salesQuotationNum LIKE ('%". $this->salesQuotationNum ."%')";
        
        $filterMarketingName = '';
        if($this->marketingID != NULL) $filterMarketingName = " and c.marketingName LIKE ('%". $this->marketingID ."%')";
        
        $filterProductName = '';
        if($this->productID != NULL) $filterProductName = " and d.productName LIKE ('%". $this->productID ."%')";
        
        $filterCurrencyID = '';
        if($this->currencyID != NULL) $filterCurrencyID = " and a.currencyID = $this->currencyID ";
        
        $filterSalesQuotationDate = '';
        if($this->salesQuotationDate != NULL) $filterSalesQuotationDate = " and DATE_FORMAT(a.salesQuotationDate, '%d-%m-%Y') = '$this->salesQuotationDate' ";
        $query1 = "select a.salesQuotationNum, b.qty , c.marketingName, e.customerName, 
                    a.currencyID, a.salesQuotationDate, a.customerID,
                    a.marketingID, a.grandTotal, a.contactPerson, d.productName, b.priceOffer
                   from tr_salesquotationhead a
                   left join tr_salesquotationdetail b on b.salesQuotationNum = a.salesQuotationNum
                   left join ms_marketing c on c.marketingID = a.marketingID
                   left join ms_product d on d.productID = b.productID
                   left join ms_customer e on e.customerID = a.customerID
                   where 1=1
                   $filterSalesQuotationNum
                   $filterMarketingName 
                   $filterProductName
                   $filterCurrencyID
                   $filterSalesQuotationDate
                   group by a.salesQuotationNum
                   HAVING sum(b.qty) > IFNULL(
                   (SELECT sum(soDetail.qty) 
                       FROM tr_salesorderhead soHead
                       JOIN tr_salesorderdetail soDetail ON soDetail.salesOrderNum = soHead.salesOrderNum 
                       WHERE a.salesQuotationNum = soHead.refNum 
                       GROUP BY a.salesQuotationNum),
                   0)";    
        
        $query2 = "SELECT count(*)
                    from tr_salesquotationhead a
                    left join tr_salesquotationdetail b on b.salesQuotationNum = a.salesQuotationNum
                    left join ms_marketing c on c.marketingID = a.marketingID
                    left join ms_product d on d.productID = b.productID
                    left join ms_customer e on e.customerID = a.customerID
                    where 1= 1
                    $filterSalesQuotationNum
                    $filterMarketingName
                    $filterProductName
                    $filterCurrencyID
                    $filterSalesQuotationDate
                    group by a.salesQuotationNum
                    HAVING sum(b.qty) > IFNULL(
                    (SELECT sum(soDetail.qty) 
                        FROM tr_salesorderhead soHead
                        JOIN tr_salesorderdetail soDetail ON soDetail.salesOrderNum = soHead.salesOrderNum 
                        WHERE a.salesQuotationNum = soHead.refNum 
                        GROUP BY a.salesQuotationNum),
                    0)";
        $count = Yii::$app->db->createCommand($query1)->queryAll();
        $dataProvider = new SqlDataProvider([
            'sql' => $query1,
            //'totalCount' => $count,
            'key' => 'salesQuotationNum',
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => ['salesQuotationDate' => SORT_DESC],
                'attributes' => [
                    'salesQuotationDate',
                    'salesQuotationNum',
                    'marketingID' => [
                        'asc' => ['c.marketingName' => SORT_ASC],
                        'desc' => ['c.marketingName' => SORT_DESC],
                    ],
                    'customerID' => [
                        'asc' => ['e.customerName' => SORT_ASC],
                        'desc' => ['e.customerName' => SORT_DESC],
                    ],
                    'productID' => [
                        'asc' => ['d.productName' => SORT_ASC],
                        'desc' => ['d.productName' => SORT_DESC],
                    ],
                    'currencyID' => [
                        'asc' => ['a.currencyID' => SORT_ASC],
                        'desc' => ['a.currencyID' => SORT_DESC],
                    ],
                    'grandTotal' => [
                        'asc' => ['a.grandTotal' => SORT_ASC],
                        'desc' => ['a.grandTotal' => SORT_DESC],
                    ]
                ]
            ]
        ]);

        return $dataProvider;
    }

    public function afterFind(){
        parent::afterFind();
        $this->salesQuotationDate = AppHelper::convertDateTimeFormat($this->salesQuotationDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->joinSalesQuotationDetail = [];
            
        $i = 0;
        foreach ($this->getSalesQuotationDetails()->all() as $joinSalesQuotationDetail) {
            $this->joinSalesQuotationDetail[$i]["productID"] = $joinSalesQuotationDetail->productID;
            $this->joinSalesQuotationDetail[$i]["productName"] = $joinSalesQuotationDetail->product->productName;
            $this->joinSalesQuotationDetail[$i]["uomID"] = $joinSalesQuotationDetail->uomID;
            $this->joinSalesQuotationDetail[$i]["uomName"] = $joinSalesQuotationDetail->uom->uomName;
            $this->joinSalesQuotationDetail[$i]["qty"] = $joinSalesQuotationDetail->qty;
            $this->joinSalesQuotationDetail[$i]["price"] = $joinSalesQuotationDetail->priceOffer;
            $this->joinSalesQuotationDetail[$i]["discount"] = $joinSalesQuotationDetail->discount;
            $this->joinSalesQuotationDetail[$i]["priceOffer"] = $joinSalesQuotationDetail->subTotal;
            $i += 1;
        }
    }
    

}
