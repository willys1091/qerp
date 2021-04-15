<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tr_supplieradvancepayment".
 *
 * @property string $supplierAdvancePaymentNum
 * @property string $refNum
 * @property string $supplierAdvancePaymentDate
 * @property integer $supplierID
 * @property string $paymentCOA
 * @property string $treasuryCOA
 * @property integer $currencyID
 * @property string $rate
 * @property string $amount
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrSupplieradvancepayment extends ActiveRecord
{
    public $supplierName, $amountDisplay, $adminFeeCurrency,$provisionFeeCurrency, $startDate, $endDate, $orderStatus;
    
    public static function tableName()
    {
        return 'tr_supplieradvancepayment';
    }

    public function rules()
    {
        return [
            [['supplierAdvancePaymentNum', 'refNum', 'supplierAdvancePaymentDate', 'supplierID', 'currencyID', 'rate', 'amount',
                'adminFeeAmount'], 'required'],
            [['supplierAdvancePaymentDate', 'createdDate', 'editedDate', 'amountDisplay', 'startDate', 'endDate','orderStatus', 'giroNum'], 'safe'],
            [['supplierID'], 'integer'],
            [['currencyID'], 'string', 'max' => 5],
            [['rate', 'amount'], 'string'],
            [['supplierAdvancePaymentNum', 'refNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['paymentCOA', 'treasuryCOA'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
            
            
            [['adminFeePaymentCoa'], 'string', 'max' => 20],
            [['adminFeeCurrency'], 'string', 'max' => 5],
            [['adminFeeRate', 'adminFeeAmount'], 'string'],

            [['provisionFeePaymentCoa'], 'string', 'max' => 20],
            [['provisionFeeCurrency'], 'string', 'max' => 5],
            [['provisionFeeRate', 'adminFeeAmount'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    //$model->currencyID,number_format($model->rate, 2, ',', '.')
    public function attributeLabels()
    {
        return [
            'supplierAdvancePaymentNum' => 'Transaction Number',
            'refNum' => 'Reference',
            'supplierAdvancePaymentDate' => 'Date',
            'supplierID' => 'Supplier',
            'paymentCOA' => 'Payment COA',
            'treasuryCOA' => 'Treasury COA',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'amount' => 'Amount',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'supplierName' => 'Supplier',
            'giroNum' => 'Giro Number',
            'adminFeePaymentCoa' => 'Select COA',
            'provisionFeePaymentCoa' => 'Select COA',
        ];
    }
     public function getPurchaseOrder()
    {
        return $this->hasMany(TrPurchaseorderhead::className(), ['purchaseOrderNum' => 'refNum']);
    }
    public function getGoodsReceipt()
    {
        return $this->hasMany(TrGoodsreceipthead::className(), ['refNum' => 'refNum']);
    }
    public function search()
    {
        $query = self::find()
            ->select('tr_supplieradvancepayment.supplierAdvancePaymentDate, tr_supplieradvancepayment.refNum, tr_supplieradvancepayment.supplierID, tr_supplieradvancepayment.amount, tr_supplieradvancepayment.supplierAdvancePaymentNum')
            ->addSelect(new Expression('IFNULL(tr_goodsreceipthead.refNum,0) orderStatus'))
            ->joinWith('goodsReceipt')
            ->andFilterWhere(['like', 'supplierAdvancePaymentNum', $this->supplierAdvancePaymentNum])
            ->andFilterWhere(['like', 'tr_supplieradvancepayment.refNum', $this->refNum])
            ->andFilterWhere(['like', 'amount', $this->amountDisplay])
            ->andFilterWhere(['=', 'supplierID', $this->supplierID]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'supplierAdvancePaymentDate', $start]);
            $query->andFilterWhere(['<=', 'supplierAdvancePaymentDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['supplierAdvancePaymentDate' => SORT_DESC],
                'attributes' => [
                    'supplierAdvancePaymentNum',
                    'supplierAdvancePaymentDate',
                    'refNum',
                    'supplierID',
                    'amountDisplay' => [
                        'asc' => ['amount' => SORT_ASC],
                        'desc' => ['amount' => SORT_DESC],
                    ],
                ],
            ]
        ]);

        return $dataProvider;
    }
    public function searchOutstanding()
    {
        $post = Yii::$app->request->get();
        $query = self::find()
            ->andFilterWhere(['like', 'supplierAdvancePaymentNum', $this->supplierAdvancePaymentNum])
            ->andFilterWhere(['like', 'refNum', $this->refNum])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['=', "DATE_FORMAT(supplierAdvancePaymentDate, '%d-%m-%Y')", $this->supplierAdvancePaymentDate]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['supplierAdvancePaymentDate' => SORT_DESC],
                'attributes' => ['supplierAdvancePaymentDate']
            ]
        ]);

        return $dataProvider;
    }
    public function getParentSupplier(){
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
    public function getParentCoa(){
        return $this->hasOne(MsCoa::className(), ['description' => 'paymentCOA']);
    }
    
    public function afterFind()
    {
        parent::afterFind();
        
        $supp =  MsSupplier::findOne($this->supplierID);
        $this->supplierName=$supp['supplierName'];
    }

}
