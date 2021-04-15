<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tr_journaldetail".
 *
 * @property string $journalDetailID
 * @property string $journalHeadID
 * @property string $coaNo
 * @property string $currency
 * @property string $rate
 * @property string $originalDrAmount
 * @property string $originalCrAmount
 * @property string $drAmount
 * @property string $crAmount
 */
class TrJournaldetail extends \yii\db\ActiveRecord
{
    public $transactionType;
    public $refNum;
    public $journalDate,$startDate,$endDate;
    
    public static function tableName()
    {
        return 'tr_journaldetail';
    }

    public function rules()
    {
        return [
            [['journalHeadID', 'coaNo', 'currency', 'rate', 'originalDrAmount', 'originalCrAmount', 'drAmount', 'crAmount'], 'required'],
            [['journalHeadID'], 'integer'],
            [['rate', 'originalDrAmount', 'originalCrAmount', 'drAmount', 'crAmount'], 'number'],
            [['coaNo'], 'string', 'max' => 20],
            [['currency'], 'string', 'max' => 5],
            [['coaNo'], 'exist', 'skipOnError' => true, 'targetClass' => MsCoa::className(), 'targetAttribute' => ['coaNo' => 'coaNo']],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => MsCurrency::className(), 'targetAttribute' => ['currency' => 'currencyID']],
            [['journalHeadID'], 'exist', 'skipOnError' => true, 'targetClass' => TrJournalhead::className(), 'targetAttribute' => ['journalHeadID' => 'journalHeadID']],
            [['journalDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'journalDetailID' => 'Journal Detail ID',
            'journalHeadID' => 'Journal Head ID',
            'journalDate' => 'Date',
            'coaNo' => 'COA',
            'currency' => 'Currency',
            'rate' => 'Rate',
            'originalDrAmount' => 'Original Debit Amount',
            'originalCrAmount' => 'Original Credit Amount',
            'drAmount' => 'Debit Amount',
            'crAmount' => 'Credit Amount',
        ];
    }
    
    public function getJournalHeads()
    {
        return $this->hasOne(TrJournalhead::className(), ['journalHeadID' => 'journalHeadID']);
    }
    
    public function getJournalHead()
    {
        return $this->hasOne(TrJournalhead::className(), ['journalHeadID' => 'journalHeadID']);
    }
    
    public function getCoaNos()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'coaNo']);
    }
    
    public function getCoa()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'coaNo']);
    }
    
    public function search()
    {
        $query = self::find()
            ->joinWith('journalHeads')
            ->joinWith('coaNos')
            ->andFilterWhere(['like', 'tr_journalhead.transactionType', $this->transactionType])
            ->andFilterWhere(['like', 'tr_journalhead.refNum', $this->refNum])
            ->andFilterWhere(['=', 'tr_journaldetail.coaNo', $this->coaNo])
            ->andFilterWhere(['=', 'tr_journaldetail.journalHeadID', $this->journalHeadID]);

        if(!empty($this->journalDate) && strpos($this->journalDate, 'to') !== false) { 
            list($this->startDate, $this->endDate) = explode(' to ', $this->journalDate); 

            $query->andFilterWhere(['>=', 'tr_journalhead.journalDate', date('Y-m-d',strtotime($this->startDate))]);
            $query->andFilterWhere(['<=', 'tr_journalhead.journalDate', date('Y-m-d',strtotime($this->endDate. ' +1 day'))]);

        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['journalHeadID' => SORT_DESC],
                'attributes' => ['journalHeadID']
            ],
            'pagination' => [
                'pageSize' => 10,
                ],
        ]);
        
        $dataProvider->sort->attributes['transactionType'] = [
            'asc' => ['tr_journalhead.transactionType' => SORT_ASC],
            'desc' => ['tr_journalhead.transactionType' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['journalDate'] = [
            'asc' => ['tr_journalhead.journalDate' => SORT_ASC],
            'desc' => ['tr_journalhead.journalDate' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['refNum'] = [
            'asc' => ['tr_journalhead.refNum' => SORT_ASC],
            'desc' => ['tr_journalhead.refNum' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['coaNo'] = [
            'asc' => ['ms_coa.description' => SORT_ASC],
            'desc' => ['ms_coa.description' => SORT_DESC],
        ];
        
        return $dataProvider;
    }
    
    public static function newData($headId, $COANo, $currencyID, $rate, $oriDr, $oriCr) {
        $journalDetail = new self();
        $journalDetail->journalHeadID = $headId;
        $journalDetail->coaNo = $COANo;
        $journalDetail->currency = $currencyID;
        $journalDetail->rate = $rate;
        $journalDetail->originalDrAmount = $oriDr;
        $journalDetail->originalCrAmount = $oriCr;
        $journalDetail->drAmount = $oriDr * $rate;
        $journalDetail->crAmount = $oriCr * $rate;
        if (!$journalDetail->save(false)) {
            return false;
        }
        
        return true;
    }
    
//      public function afterDelete() {
//        if (!parent::afterDelete()) {
//            return false;
//        }
//        
//        
//         TrJournalhead::deleteAll('refNum = :refNum', ["refNum" => $this->refNum]);
//        
//        return true;
//    }
      
}
