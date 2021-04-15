<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\data\SqlDataProvider;

/**
 * This is the model class for table "tr_customerreceivablehead".
 *
 * @property string $receivableNum
 * @property string $receivableDate
 * @property integer $customerID
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrCustomerreceivablehead extends \yii\db\ActiveRecord
{
    public $customerName, $contactPerson, $street, $phone;
    public $refNum,$currency,$rate;
    public static $receivableTotal = 0;
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_customerreceivablehead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receivableNum', 'receivableDate', 'customerID', 'createdBy', 'createdDate'], 'required'],
            [['receivableDate', 'createdDate', 'editedDate'], 'safe'],
            [['customerID'], 'integer'],
            [['receivableNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['customerID'], 'exist', 'skipOnError' => true, 'targetClass' => MsCustomer::className(), 'targetAttribute' => ['customerID' => 'customerID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'receivableNum' => 'Receivable Number',
            'receivableDate' => 'Date',
            'customerID' => 'Customer',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'refNum' => 'Reference Number',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->select([
                'tr_customerreceivablehead.customerID',
                'ms_customer.customerName',
                new Expression('(SELECT SUM(detail.amount) FROM tr_customerreceivabledetail AS detail WHERE detail.receivableNum = tr_customerreceivablehead.receivableNum) AS amount')])
            ->joinWith('customer')
            ->joinWith('receivableDetail')
            ->andFilterWhere(['=', 'tr_customerreceivablehead.customerID', $this->customerID])
            ->groupBy('customerID');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['customerID' => SORT_ASC],
                'attributes' => [
                    'customerID',
                    'amount'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
    public function searchUnpaid()
    {
        
        $filterCusomer = '';
        if($this->customerID != NULL) $filterCusomer = " and x.customerID =  $this->customerID";
        $sql = "SELECT x.*, pic.contactPerson, 
            CONCAT(LEFT(pic.street, 60), IF(LENGTH(pic.street) > 60, '...','')) AS street,
            pic.phone, customer.customerName,SUM(x.outstandingAmount) AS receivableTotal
        FROM (
        SELECT detail.receivableNum, refNum AS transactionRefNum, head.receivableDate AS transactionDate, detail.currency,
        ref.num AS originRefNum, ref.customerID, ref.hasVat,
            CAST(IF(ref.hasVat=1, detail.amount/110*100, detail.amount) AS DECIMAL(18,2)) AS subTotal,
        CAST(IF(ref.hasVat=1, detail.amount/110*10, 0) AS DECIMAL(18,2)) AS tax,
            @grandTotal := detail.amount AS grandTotal,
            @advancedPaymentAmount := (
                SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
                FROM tr_customeradvancebalancedetail AS advPaymentDetail
                LEFT JOIN tr_customeradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
                WHERE advPaymentDetail.refNum = detail.refNum
        ) AS advancedPaymentAmount,
        @previousPayment := (
            SELECT CAST(IFNULL(SUM(payment.paymentAmount), 0) AS DECIMAL(18, 2))
            FROM tr_customerpayment AS payment
            WHERE payment.refNum = detail.refNum
        ) AS previousPayment,
            CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
        FROM tr_customerreceivabledetail AS detail
        LEFT JOIN tr_customerreceivablehead AS head ON detail.receivableNum = head.receivableNum
        INNER JOIN (
            SELECT d.receivableNum,
            sohead.customerID,
            sohead.salesorderNum AS num,
            IF(sohead.taxRate > 0, 1, 0) AS hasVat,
            sohead.grandTotal
            FROM tr_customerreceivabledetail AS d
            LEFT JOIN tr_goodsdeliveryhead AS deliveryHead ON deliveryHead.goodsDeliveryNum = d.refNum
            LEFT JOIN tr_salesorderhead AS sohead ON sohead.salesOrderNum = deliveryHead.refNum
        ) AS ref ON ref.receivableNum = detail.receivableNum
            ) AS x
            LEFT JOIN ms_customer AS customer ON customer.customerID = x.customerID
            LEFT JOIN (
                SELECT cust.customerID,
                IFNULL(office.contactPerson, custDetail.contactPerson) AS contactPerson, 
                IFNULL(office.street, custDetail.street) AS street,
                IFNULL(office.phone, custDetail.phone) AS phone
                FROM ms_customer AS cust
                LEFT JOIN ms_customerdetail AS office ON office.customerID = cust.customerID AND office.addressType = 'Office'
                LEFT JOIN ms_customerdetail AS custDetail ON custDetail.customerID = cust.customerID
                GROUP BY cust.customerID
            ) AS pic ON pic.customerID = customer.customerID
            WHERE  x.customerId IS NOT NULL AND x.outstandingAmount > 0
            $filterCusomer
            GROUP BY x.customerID";
                
        $counter = "SELECT COUNT(*) FROM ($sql) y";
        $count = Yii::$app->db->createCommand($counter)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'key' => 'customerID',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => ['customerID' => SORT_ASC],
                'attributes' => [
                    'customerID' => [
                        'asc' => ['customerName' => SORT_ASC],
                        'desc' => ['customerName' => SORT_DESC],
                    ],
                    'customerName',
                    'street',
                    'contactPerson',
                    'phone',
                    'receivableTotal'
                ]
            ]
        ]);
        
        return $dataProvider;
    }
     public function searchDue()
     {
         
        $filterCusomer = '';
        if($this->customerID != NULL) $filterCusomer = " and x.customerID =  $this->customerID";
        $sql = "SELECT x.*, pic.contactPerson, 
            CONCAT(LEFT(pic.street, 60), IF(LENGTH(pic.street) > 60, '...','')) AS street, 
            pic.phone, customer.customerName,SUM(x.outstandingAmount) AS receivableTotal
        FROM (
	SELECT detail.receivableNum, refNum AS transactionRefNum, head.receivableDate AS transactionDate, detail.currency,
	ref.num AS originRefNum, ref.customerID, ref.hasVat,ref.dueDate,
        CAST(IF(ref.hasVat=1, detail.amount/110*100, detail.amount) AS DECIMAL(18,2)) AS subTotal,
        CAST(IF(ref.hasVat=1, detail.amount/110*10, 0) AS DECIMAL(18,2)) AS tax,
        @grandTotal := FLOOR(detail.amount) AS grandTotal,
        @advancedPaymentAmount := (
            SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
            FROM tr_customeradvancebalancedetail AS advPaymentDetail
            LEFT JOIN tr_customeradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
            WHERE advPaymentDetail.refNum = detail.refNum
            ) AS advancedPaymentAmount,
            @previousPayment := (
		SELECT CAST(IFNULL(SUM(payment.paymentAmount), 0) AS DECIMAL(18, 2))
		FROM tr_customerpayment AS payment
		WHERE payment.refNum = detail.refNum
                ) AS previousPayment,
                CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
                FROM tr_customerreceivabledetail AS detail
                LEFT JOIN tr_customerreceivablehead AS head ON detail.receivableNum = head.receivableNum
                INNER JOIN (
                    SELECT d.receivableNum,
                    sohead.customerID,
                    sohead.salesorderNum AS num,
                    DATE_ADD(deliveryHead.goodsDeliveryDate, INTERVAL cs.dueDate DAY) AS dueDate,
                    IF(sohead.taxRate > 0, 1, 0) AS hasVat,
                    sohead.grandTotal
		FROM tr_customerreceivabledetail AS d
		LEFT JOIN tr_goodsdeliveryhead AS deliveryHead ON deliveryHead.goodsDeliveryNum = d.refNum
		LEFT JOIN tr_salesorderhead AS sohead ON sohead.salesOrderNum = deliveryHead.refNum
        LEFT JOIN ms_customer AS cs ON cs.customerID = sohead.customerID
	) AS ref ON ref.receivableNum = detail.receivableNum
	WHERE NOW() > ref.dueDate
        ) AS x
        LEFT JOIN ms_customer AS customer ON customer.customerID = x.customerID
        LEFT JOIN (
	SELECT cust.customerID,
        IFNULL(office.contactPerson, custDetail.contactPerson) AS contactPerson, 
        IFNULL(office.street, custDetail.street) AS street,
        IFNULL(office.phone, custDetail.phone) AS phone
        FROM ms_customer AS cust
        LEFT JOIN ms_customerdetail AS office ON office.customerID = cust.customerID AND office.addressType = 'Office'
            LEFT JOIN ms_customerdetail AS custDetail ON custDetail.customerID = cust.customerID
        GROUP BY cust.customerID
        ) AS pic ON pic.customerID = x.customerID
        WHERE x.outstandingAmount > 0 AND NOW() > x.dueDate
        $filterCusomer
        
        GROUP BY x.customerID"; 
        
         $counter = "SELECT COUNT(*) FROM ($sql) y";
         $count = Yii::$app->db->createCommand($counter)->queryScalar();
            
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'key' => 'customerID',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => ['customerID' => SORT_ASC],
                'attributes' => [
                    'customerID' => [
                        'asc' => ['customerName' => SORT_ASC],
                        'desc' => ['customerName' => SORT_DESC],
                    ],
                    'customerName',
                    'street',
                    'contactPerson',
                    'phone',
                    'receivableTotal'
                ]
            ]
        ]);
        
        return $dataProvider;
     }
    public function getReceivableDetail()
    {
        return $this->hasMany(TrCustomerreceivabledetail::className(), ['receivableNum' => 'receivableNum']);
    }
    public function getCustomer()
    {
        return $this->hasMany(MsCustomer::className(), ['customerID' => 'customerID']);
    }
    public function getCustomerDetail()
    {
        return $this->hasMany(MsCustomerdetail::className(), ['customerID' => 'customerID']);
    }
}
