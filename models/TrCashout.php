<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;

/**
 * This is the model class for table "tr_cashout".
 *
 * @property string $cashOutNum
 * @property string $cashOutDate
 * @property string $cashAccount
 * @property string $expenseAccount
 * @property integer $paymentID
 * @property string $cashOutAmount
 * @property integer $taxID
 * @property string $taxRate
 * @property string $totalAmount
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrCashout extends \yii\db\ActiveRecord
{
    public $refDate;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_cashout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cashOutNum', 'cashOutDate', 'currencyID', 'cashAccount', 'expenseAccount', 'cashOutAmount'], 'required'],
            [['cashOutDate', 'createdDate', 'editedDate'], 'safe'],
            [['cashOutAmount', 'rate'], 'string'],
            ['rate', 'compare', 'compareValue' => '0,00', 'operator' => '>'],
            [['currencyID'], 'string', 'max' => 5],
            [['cashOutNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['cashAccount', 'expenseAccount'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cashOutNum' => 'Transaction Number',
            'refNum' => 'Reference Number',
            'cashOutDate' => 'Date',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'cashAccount' => 'Source',
            'expenseAccount' => 'Purpose',
            'cashOutAmount' => 'Cash Out Amount',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function getCoaNo()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'expenseAccount']);
    }
    public function getCashAccounts()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'cashAccount'])
         ->from(['coa' => MsCoa::tableName()]);
    }
    public function getCurrency()
    {
        return $this->hasOne(MsCurrency::className(), ['currencyID' => 'currencyID']);
    }
    public function search()
    {
        $query = self::find()
        ->joinWith('coaNo')
        ->andFilterWhere(['like', 'tr_cashout.cashOutNum', $this->cashOutNum])
        ->andFilterWhere(['=', "DATE_FORMAT(tr_cashout.cashOutDate, '%d-%m-%Y')", $this->cashOutDate])
        ->andFilterWhere(['=', 'tr_cashout.cashAccount', $this->cashAccount])
        ->andFilterWhere(['=', 'tr_cashout.expenseAccount', $this->expenseAccount]);
         
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['cashOutDate' => SORT_DESC],
                'attributes' => [
                    'cashOutDate',
                    'cashOutNum',
                    'cashOutAmount',
                    'expenseAccount' => [
                        'asc' => ['ms_coa.description' => SORT_ASC],
                        'desc' => ['ms_coa.description' => SORT_DESC],
                    ],
                    'cashAccount' => [
                        'asc' => ['ms_coa.description' => SORT_ASC],
                        'desc' => ['ms_coa.description' => SORT_DESC],
                    ]
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }
    public function searchRef(){
        $sql = "SELECT purchaseOrderNum as refNum, purchaseOrderDate as refDate from tr_purchaseorderhead
                UNION SELECT salesOrderNum as refNum, salesOrderDate as refDate from tr_salesorderhead";
        $query = $this::findBySql($sql);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $dataProvider;
    }
}
