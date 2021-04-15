<?php

namespace app\models;

use app\components\AppHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tr_supplierpaymenthead".
 *
 * @property string $supplierPaymentNum
 * @property string $paymentTransactionDate
 * @property integer $supplierID
 * @property string $currencyID
 * @property string $rate
 * @property string $paymentTotal
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrSupplierpaymenthead extends ActiveRecord
{
    public $supplierName;
    public $whtName;
    public $whtAmount;
    public $transactionAmount;
    public $outstandingAmount;
    public $paymentAmount;
    public $joinPaymentDetail;
    public $startDate, $endDate;
    
    public $adminFeeCurrency;
    
    public $errorMessages = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_supplierpaymenthead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplierPaymentNum', 'supplierPaymentDate', 'supplierID', 'currencyID', 'rate',
                'adminFeeAmount', 'voucherNum'], 'required'],
            [['supplierPaymentDate', 'createdDate', 'editedDate', 'startDate','endDate','giroNum','provisiCost'], 'safe'],
            [['supplierID'], 'integer'],
            [['rate'], 'string'],
            [['currencyID'], 'string', 'max' => 5],
            [['coaNo'], 'string', 'max' => 20],
            [['supplierPaymentNum', 'createdBy', 'editedBy', 'voucherNum'], 'string', 'max' => 50],
            [['additionalInfo'], 'string', 'max' => 500],
            [['joinPaymentDetail','paymentAmount', 'additionalInfo', 'supplierName','whtAmount','transactionAmount','outstandingAmount'], 'safe'],
            
            [['adminFeePaymentCoa'], 'string', 'max' => 20],
            [['adminFeeCurrency'], 'string', 'max' => 5],
            [['adminFeeRate', 'adminFeeAmount'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplierPaymentNum' => 'Payment Number',
            'voucherNum' => 'Voucher Number',
            'supplierPaymentDate' => 'Payment Date',
            'supplierID' => 'Supplier',
            'supplierName' => 'Supplier',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'additionalInfo' => 'Additional Info',
            'coaNo' => 'COA No',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'transactionAmount' => 'Transaction Amount',
            'whtAmount' => 'WHT Amount',
            'outstandingAmount' => 'Outstanding Amount',
            'paymentAmount' => 'Payment Amount',
            'additionalInfo' => 'Additional Info',
            'giroNum' => 'Giro Number',
            'provisiCost' => 'Provisi Cost',
            'adminFeePaymentCoa' => 'Select COA',
        ];
    }
    public function getSupplier()
    {
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
    public function getPaymentDetail()
    {
        return $this->hasMany(TrSupplierpaymentdetail::className(), ['supplierPaymentNum' => 'supplierPaymentNum']);
    }
    
    public function search()
    {
        $query = self::find()
            ->joinWith('paymentDetail')
            ->joinWith('supplier')
            ->select([new Expression('SUM(tr_supplierpaymentdetail.paymentAmount) as paymentAmount'), 'supplierPaymentDate', 'tr_supplierpaymenthead.supplierPaymentNum', 'ms_supplier.supplierID', 'additionalInfo', 'voucherNum'])
            ->andFilterWhere(['like', 'tr_supplierpaymenthead.supplierPaymentNum', $this->supplierPaymentNum])
            ->andFilterWhere(['like', '(SELECT supplierName FROM ms_supplier WHERE ms_supplier.supplierID = tr_supplierpaymenthead.supplierID)', $this->supplierName])
            ->andFilterWhere(['like', 'tr_supplierpaymenthead.voucherNum', $this->voucherNum])
            ->andWhere(['ms_supplier.isForwarder' => 0])
            ->groupBy('tr_supplierpaymenthead.supplierPaymentNum');
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'supplierPaymentDate', $start]);
            $query->andFilterWhere(['<=', 'supplierPaymentDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['supplierPaymentDate' => SORT_DESC],
                'attributes' => [
                    'supplierPaymentDate',
                    'supplierPaymentNum',
                    'voucherNum',
                    'supplierName',
                    'paymentAmount',
                    'additionalInfo'
                ],
            ]
        ]);

        return $dataProvider;
    }
    
    public function searchForwarder ()
    {
        $query = self::find()
            ->joinWith('paymentDetail')
            ->joinWith('supplier')
            ->select([new Expression('SUM(tr_supplierpaymentdetail.paymentAmount) as paymentAmount'), 'supplierPaymentDate', 'tr_supplierpaymenthead.supplierPaymentNum', 'ms_supplier.supplierID', 'additionalInfo', 'voucherNum'])
            ->andFilterWhere(['like', 'tr_supplierpaymenthead.supplierPaymentNum', $this->supplierPaymentNum])
            ->andFilterWhere(['like', '(SELECT supplierName FROM ms_supplier WHERE ms_supplier.supplierID = tr_supplierpaymenthead.supplierID)', $this->supplierName])
            ->andFilterWhere(['like', 'tr_supplierpaymenthead.voucherNum', $this->voucherNum])
            ->andWhere(['ms_supplier.isForwarder' => 1])
            ->groupBy('tr_supplierpaymenthead.supplierPaymentNum');
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'supplierPaymentDate', $start]);
            $query->andFilterWhere(['<=', 'supplierPaymentDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['supplierPaymentDate' => SORT_DESC],
                'attributes' => [
                    'supplierPaymentDate',
                    'supplierPaymentNum',
                    'voucherNum',
                    'supplierName',
                    'paymentAmount',
                    'additionalInfo'
                ],
            ]
        ]);

        return $dataProvider;
    }
    
      public function afterFind(){
        parent::afterFind();
        $this->supplierPaymentDate = AppHelper::convertDateTimeFormat($this->supplierPaymentDate, 'Y-m-d H:i:s', 'd-m-Y');
        $this->joinPaymentDetail = [];
//        $suppNum = TrSupplierpaymenthead::find()
//            ->where('supplierPaymentNum = :supplierPaymentNum', [':supplierPaymentNum' => $this->supplierPaymentNum])
//            ->AndWhere(['like', 'tr_supplierpaymenthead.supplierPaymentNum', 'QJA/FP' ])
//            ->one();   
        $i = 0;
        foreach ($this->getPaymentDetail()->all() as $joinPaymentDetail) {
            $grRefNum = $joinPaymentDetail->refNum;
            $supplierID = $this->supplierID;
            $supplierPayment = $this->supplierPaymentNum;
             
            
             $modelAdvancedPayment = TrSupplieradvancebalancehead::find()
                ->select([new Expression('SUM(tr_supplieradvancebalancedetail.amount) as amount')])
                ->joinWith('balanceDetail')
                ->andFilterWhere(['refNum' => $grRefNum])
                ->andWhere(['supplierID' => $supplierID])
                ->one();
             
            if (substr($supplierPayment, 4, 2) == "SP") {
                $modelPreviousPayment = TrSupplierpaymentdetail::find()
                    ->select([new Expression('SUM(tr_supplierpaymentdetail.paymentAmount) as paymentAmount')])
                    ->joinWith('paymentHead')
                    ->where('tr_supplierpaymentdetail.refNum = :refNum', [':refNum' => $grRefNum])
                    ->andWhere(['like', 'tr_supplierpaymentdetail.supplierPaymentNum', 'QJA/SP'])
                    ->andWhere(['<>', 'tr_supplierpaymentdetail.supplierPaymentNum', $supplierPayment])
                    ->one();
            } else {
                $modelPreviousPayment = TrSupplierpaymentdetail::find()
                    ->select([new Expression('SUM(tr_supplierpaymentdetail.paymentAmount) as paymentAmount')])
                    ->joinWith('paymentHead')
                    ->where('tr_supplierpaymentdetail.refNum = :refNum', [':refNum' => $grRefNum])
                    ->andWhere(['like', 'tr_supplierpaymentdetail.supplierPaymentNum', 'QJA/FP'])
                    ->andWhere(['<>', 'tr_supplierpaymentdetail.supplierPaymentNum', $supplierPayment])
                    ->one();
            }



            if (is_null($modelPreviousPayment->paymentAmount)) {
                $previousPayment = "0.00";
            } else {
               $previousPayment = $modelPreviousPayment->paymentAmount;
                //$previousPayment = "0.00";
            }
            
            if (is_null($modelAdvancedPayment->amount)) {
                $advancePayment = "0.00";
            } else {
                $advancePayment = $modelAdvancedPayment->amount;
               // $advancePayment = "0.00";
            }
            
//            if (is_null($modelAdvancedPayment->amount)) {
//                $previousPayment = "0.00";
//            } else {
//               $previousPayment = $modelAdvancedPayment->amount;
//                //$previousPayment = "0.00";
//            }
            $subtotal = $joinPaymentDetail->transactionAmountBeforeTax *(100+$joinPaymentDetail->tax)/100;
            $outstanding = $subtotal - $previousPayment - $advancePayment;

            
            $this->joinPaymentDetail[$i]["refNum"] = $joinPaymentDetail->refNum;
            $this->joinPaymentDetail[$i]["priceBeforeTax"] = $joinPaymentDetail->transactionAmountBeforeTax;
            $this->joinPaymentDetail[$i]["taxRate"] = $joinPaymentDetail->tax;
            $this->joinPaymentDetail[$i]["WHTAmount"] = $joinPaymentDetail->whtAmount;
            $this->joinPaymentDetail[$i]["subTotal"] =  "$subtotal";
            $this->joinPaymentDetail[$i]["paid"] =  $previousPayment;
            $this->joinPaymentDetail[$i]["outstanding"] = "$outstanding";
            $this->joinPaymentDetail[$i]["advancedPayment"] = $advancePayment;
            $this->joinPaymentDetail[$i]["payment"] = $joinPaymentDetail->paymentAmount;
  
//             var_dump($subtotal);
//            die();
         
            $i += 1;
        }
    }
}