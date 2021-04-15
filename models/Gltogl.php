<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\db\Expression;

/**
 * This is the model class for table "gltogl".
 *
 * @property string $gltoglNum
 * @property string $gltoglDate
 * @property string $debitCoa
 * @property string $creditCoa
 * @property string $currencyID
 * @property string $rate
 * @property string $amount
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class Gltogl extends \yii\db\ActiveRecord
{
    public $joinDebitDetail;
    public $joinCreditDetail;
    
    public $startDate, $endDate;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_gltoglhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gltoglDate'], 'required'],
            [['gltoglDate', 'createdDate', 'editedDate', 'startDate','endDate','voucherNum','notes'], 'safe'],
            [['gltoglNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['joinDebitDetail', 'joinCreditDetail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gltoglNum' => 'GL Code',
            'gltoglDate' => 'Date',
            'voucherNum' => 'Voucher Number',
            'notes' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function search()
    {
     
        $query = self::find()
            ->andFilterWhere(['like', 'gltoglNum', $this->gltoglNum])
            ->andFilterWhere(['like', 'voucherNum', $this->voucherNum]);

        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'gltoglDate', $start]);
            $query->andFilterWhere(['<=', 'gltoglDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['gltoglDate' => SORT_DESC],
                'attributes' => [
                    'gltoglNum',
                    'gltoglDate',
                    'voucherNum',
                    ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }
    public function getGLDetails()
    {
        return $this->hasMany(Gltogldetail::className(), ['gltoglNum' => 'gltoglNum']);
    }
    
    public function afterFind(){
        parent::afterFind();
        $this->gltoglDate = AppHelper::convertDateTimeFormat($this->gltoglDate, 'Y-m-d H:i:s', 'd-m-Y');
                
        $this->joinDebitDetail = [];
        $this->joinCreditDetail = [];
        $i = 0;
        foreach ($this->getGLDetails()->where('debitAmount is not null')->all() as $joinDebitDetail) {
            $this->joinDebitDetail[$i]["debitID"] = $joinDebitDetail->coaNo;
            $this->joinDebitDetail[$i]["debitName"] = $joinDebitDetail->coaDescription->description;
            $this->joinDebitDetail[$i]["debitCurrency"] = $joinDebitDetail->currencyID;
            $this->joinDebitDetail[$i]["debitRate"] = $joinDebitDetail->rate;
            $this->joinDebitDetail[$i]["debitAmount"] = $joinDebitDetail->debitAmount;
            $i += 1;
        }

        $j = 0;
        foreach ($this->getGLDetails()->where('creditAmount is not null')->all() as $joinCreditDetail) {
            $this->joinCreditDetail[$j]["creditID"] = $joinCreditDetail->coaNo;
            $this->joinCreditDetail[$j]["creditName"] = $joinCreditDetail->coaDescription->description;
            $this->joinCreditDetail[$j]["creditCurrency"] = $joinCreditDetail->currencyID;
            $this->joinCreditDetail[$j]["creditRate"] = $joinCreditDetail->rate;
            $this->joinCreditDetail[$j]["creditAmount"] = $joinCreditDetail->creditAmount;
            $j += 1;
        }
    }
}
