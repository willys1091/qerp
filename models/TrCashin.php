<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;

/**
 * This is the model class for table "tr_cashin".
 *
 * @property string $cashInNum
 * @property string $cashInDate
 * @property string $cashAccount
 * @property string $incomeAccount
 * @property integer $paymentID
 * @property string $cashInAmount
 * @property integer $taxID
 * @property string $taxRate
 * @property string $totalAmount
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrCashin extends \yii\db\ActiveRecord
{
    public $refDate;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_cashin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cashInNum', 'cashInDate', 'currencyID', 'cashAccount', 'incomeAccount', 'cashInAmount'], 'required'],
            [['cashInDate', 'createdDate', 'editedDate'], 'safe'],
            [['cashInAmount','rate'], 'string'],
            ['rate', 'compare', 'compareValue' => '0,00', 'operator' => '>'],
            [['currencyID'], 'string', 'max' => 5],
            [['cashInNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['cashAccount', 'incomeAccount'], 'string', 'max' => 20],
            [['additionalInfo'], 'string', 'max' => 200],
            [['cashInNum','cashInDate', 'cashAccount', 'incomeAccount'], 'safe', 'on'=>'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cashInNum' => 'Transaction Number',
            'refNum' => 'Reference Number',
            'cashInDate' => 'Date',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'cashAccount' => 'Destination',
            'incomeAccount' => 'Payment For',
            'cashInAmount' => 'Cash In Amount',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function getCoaNo()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'incomeAccount']);
    }
    public function getCashAccounts()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'cashAccount']);
    }
    public function getCurrency()
    {
        return $this->hasOne(MsCurrency::className(), ['currencyID' => 'currencyID']);
    }
    public function search()
    {
        $query = self::find()
        ->joinWith('coaNo')
        ->andFilterWhere(['like', 'tr_cashin.cashInNum', $this->cashInNum])
        ->andFilterWhere(['=', "DATE_FORMAT(tr_cashin.cashInDate, '%d-%m-%Y')", $this->cashInDate])
        ->andFilterWhere(['=', 'tr_cashin.cashAccount', $this->cashAccount])
        ->andFilterWhere(['=', 'tr_cashin.incomeAccount', $this->incomeAccount]);
         
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['cashInDate' => SORT_DESC],
                'attributes' => [
                    'cashInNum',
                    'cashInDate',
                    'incomeAccount' => [
                        'asc' => ['ms_coa.description' => SORT_ASC],
                        'desc' => ['ms_coa.description' => SORT_DESC],
                    ],
                    'cashAccount' => [
                        'asc' => ['ms_coa.description' => SORT_ASC],
                        'desc' => ['ms_coa.description' => SORT_DESC],
                    ],
                    'cashInAmount',
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
