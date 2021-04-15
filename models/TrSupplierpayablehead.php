<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\data\SqlDataProvider;

/**
 * This is the model class for table "tr_supplierpayablehead".
 *
 * @property string $payableNum
 * @property string $payableDate
 * @property integer $supplierID
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrSupplierpayablehead extends \yii\db\ActiveRecord
{
    public $supplierName, $contactPerson, $street, $officeNumber;
    public $refNum,$currency,$rate;
    public $amount;
    
    public $startDate, $endDate;
    
    public static $payableTotal = 0;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_supplierpayablehead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payableNum', 'payableDate', 'supplierID'], 'required'],
            [['payableDate', 'startDate', 'endDate'], 'safe'],
            [['supplierID'], 'integer'],
            [['payableNum'], 'string', 'max' => 50],
            [['supplierID'], 'exist', 'skipOnError' => true, 'targetClass' => MsSupplier::className(), 'targetAttribute' => ['supplierID' => 'supplierID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'payableNum' => 'Payable Number',
            'payableDate' => 'Date',
            'supplierID' => 'Supplier'
        ];
    }
    
    public function search()
    {
        $query = self::find()
            ->select([
                'tr_supplierpayablehead.payableNum',
                'tr_supplierpayablehead.payableDate',
                'tr_supplierpayablehead.supplierID',
                'ms_supplier.supplierName',
                'ms_supplier.street',
                'ms_supplier.officeNumber',
                new Expression('(SELECT SUM(detail.amount) FROM tr_supplierpayabledetail AS detail WHERE detail.payableNum = tr_supplierpayablehead.payableNum) AS amount')])
            ->joinWith('supplier')
            ->groupBy('tr_supplierpayablehead.supplierID')
            ->andFilterWhere(['=', 'tr_supplierpayablehead.supplierID', $this->supplierID]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'payableDate', $start]);
            $query->andFilterWhere(['<=', 'payableDate', $end]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['payableDate' => SORT_DESC],
                'attributes' => [
                    'payableDate',
                    'supplierID'
                ]
            ]
        ]);

        return $dataProvider;
    }
    
    public function searchUnpaidPPJK ()
    {
         $queryGR = TrGoodsreceipthead::find()
                ->select(['(tr_goodsreceiptcost.importDutyAmount + tr_goodsreceiptcost.PPNImportAmount + tr_goodsreceiptcost.PPHImportAmount
                 + IF(tr_goodsreceiptcost.otherCostAmount IS NULL, 0, tr_goodsreceiptcost.otherCostAmount)
                 + IF(tr_goodsreceiptcost.taxInvoiceAmount IS NULL, 0, tr_goodsreceiptcost.taxInvoiceAmount)) AS total','ms_supplier.supplierName', 'ms_supplier.country','ms_supplier.street', 'ms_supplier.officeNumber'])
                ->joinWith('goodsReceiptCost')
                ->joinWith('supplier')
                ->where('tr_goodsreceiptcost.goodsReceiptNum is not null')
                ->andWhere('tr_goodsreceipthead.PPJK = :PPJK',[':PPJK' => ms_supplier.supplierID])
                ->andWhere("(importDutyAmount + PPNImportAmount + PPHImportAmount + IF(otherCostAmount IS NULL, 0, otherCostAmount) + IF(taxInvoiceAmount IS NULL, 0, taxInvoiceAmount))"
                        . " - (SELECT SUM(paymentAmount) FROM tr_supplierpaymentdetail WHERE refNum = tr_goodsreceipthead.goodsReceiptNum) > 0 "
                        . " OR (SELECT SUM(paymentAmount) FROM tr_supplierpaymentdetail WHERE refNum = tr_goodsreceipthead.goodsReceiptNum) IS NULL")
                ->groupBy(['tr_goodsreceipthead.PPJK'])
                ->having('total > 0');

        $dataProvider = new ActiveDataProvider([
                'query' => $queryGR,
                'pagination' => [
                    'pageSize' => 10
                ]
            ]);
        
        return $dataProvider;

    }
    
    
    public function searchUnpaid ()
    {
        
        $filterSupplier = '';
        if($this->supplierID != NULL) $filterSupplier = " and x.supplierID =  $this->supplierID";
        
        $sql = "SELECT sum(x.grandTotal), x.supplierID, supplier.supplierName, supplier.isForwarder, supplier.country, 
                CONCAT(LEFT(supplier.street, 60), IF(LENGTH(supplier.street) > 60, '...','')) AS street,
                supplier.officeNumber, SUM(x.outstandingAmount) AS payableTotal, currency
                FROM (
                    SELECT refNum AS transactionRefNum, head.payableDate AS transactionDate, detail.currency,
                    ref.num AS originalRefNum, ref.supplierID, ref.hasVat, 
                    CAST(IF(ref.hasVat=1, detail.amount/110*100, detail.amount) AS DECIMAL(18,2)) AS subTotal,
                    CAST(IF(ref.hasVat=1, detail.amount/110*10, 0) AS DECIMAL(18,2)) AS tax,
                    @grandTotal := detail.amount AS grandTotal,
                    @advancedPaymentAmount := (
                        SELECT CAST(IFNULL(SUM(advPaymentDetail.amount), 0) AS DECIMAL(18, 2))
                        FROM tr_supplieradvancebalancedetail AS advPaymentDetail
                        LEFT JOIN tr_supplieradvancebalancehead AS advPaymentHead ON advPaymentHead.balanceHeadID = advPaymentDetail.balanceHeadID
                        WHERE advPaymentDetail.refNum = detail.refNum AND advPaymentHead.supplierID = head.supplierID
                    ) AS advancedPaymentAmount,
                    @previousPayment := (
                        SELECT CAST(IFNULL(SUM(paymentDetail.paymentAmount), 0) AS DECIMAL(18, 2))
                        FROM tr_supplierpaymenthead AS paymentHead
                        LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
                        WHERE paymentDetail.refNum = detail.refNum AND paymentHead.supplierID = head.supplierID
                    ) AS previousPayment,
                    CAST(@grandTotal - @advancedPaymentAmount - @previousPayment AS DECIMAL(18, 2)) AS outstandingAmount
                    FROM tr_supplierpayabledetail AS detail
                    LEFT JOIN tr_supplierpayablehead AS head ON detail.payableNum = head.payableNum
                    INNER JOIN (
                        SELECT d.payableDetailID,
                        CASE 
                            WHEN poHead.supplierID IS NOT NULL THEN poHead.supplierID
                            WHEN poni.supplierID IS NOT NULL THEN poni.supplierID
                            ELSE '-'
                        END AS supplierID,
                        CASE 
                            WHEN poHead.purchaseOrderNum IS NOT NULL THEN poHead.purchaseOrderNum
                            WHEN poni.purchaseOrderNonInventoryNum IS NOT NULL THEN poni.purchaseOrderNonInventoryNum
                            ELSE '-'
                            END AS num,
                        CASE
                            WHEN poHead.hasVat IS NOT NULL THEN poHead.hasVat
                            WHEN poni.hasVat IS NOT NULL THEN poni.hasVat
                            ELSE 0
                        END AS hasVat,
                        CASE 
                            WHEN poHead.grandTotal IS NOT NULL THEN poHead.grandTotal
                            WHEN poni.grandTotal IS NOT NULL THEN poni.grandTotal
                            ELSE 0
                        END AS grandTotal
                        FROM tr_supplierpayabledetail AS d
                        LEFT JOIN tr_goodsreceipthead AS receiptHead ON receiptHead.goodsReceiptNum = d.refNum
                        LEFT JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = receiptHead.refNum
                        LEFT JOIN tr_purchaseordernoninventoryhead AS poni ON poni.purchaseOrderNonInventoryNum = d.refNum
                    ) AS ref ON ref.payableDetailID = detail.payableDetailID
                ) x
                LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = x.supplierID
                WHERE supplierName IS NOT NULL AND x.outstandingAmount > 0 
                $filterSupplier
                GROUP BY x.supplierID";
        
        $counter = "SELECT COUNT(*) FROM ($sql) y";
        $count = Yii::$app->db->createCommand($counter)->queryScalar();
        
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'key' => 'supplierID',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => ['supplierID' => SORT_ASC],
                'attributes' => [
                    'supplierID' => [
                        'asc' => ['supplierName' => SORT_ASC],
                        'desc' => ['supplierName' => SORT_DESC],
                    ],
                    'supplierName',
                    'country',
                    'street',
                    'officeNumber',
                    'payableTotal'
                ]
            ]
        ]);
        
        return $dataProvider;
    }
    
    public function getPayableDetail()
    {
        return $this->hasMany(TrSupplierpayabledetail::className(), ['payableNum' => 'payableNum']);
    }
    
    public function getSupplier()
    {
        return $this->hasMany(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
    
    public static function newData($refNum, $supplierID, $date, $currencyID, $rate, $amount) {
        $prevPayable = self::find()
                        ->joinWith('payableDetail')
                        ->where(['refNum' => $refNum])
                        ->andWhere(['tr_supplierpayablehead.supplierID' => $supplierID])->one();
                
        if ($prevPayable != NULL) {
            $prevPayable->delete();
            foreach ($prevPayable->payableDetail as $detail)
                $detail->delete();
        }
        
        $payableHead = new TrSupplierpayablehead();
        $payableHead->payableDate = $date;
        $payableHead->supplierID = $supplierID;
        if (!$payableHead->save(false)) {
            return false;
        }
        
        $payableDetail = new TrSupplierpayabledetail();
        $payableDetail->payableNum = $payableHead->payableNum;
        $payableDetail->refNum = $refNum;
        $payableDetail->currency =  $currencyID;
        $payableDetail->rate = $rate;
        $payableDetail->amount =  $amount;
        if (!$payableDetail->save(false)) {
            return false;
        }
        
        return true;
    }
    
//       public function afterDelete() {
//        if (!parent::afterDelete()) {
//            return false;
//        }
//        
//        
//        TrSupplierpayabledetail::deleteAll('refNum = :refNum', [":refNum" => $this->refNum]);
//       
//        return true;
//    }
}
