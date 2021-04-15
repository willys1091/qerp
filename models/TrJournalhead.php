<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tr_journalhead".
 *
 * @property string $journalHeadID
 * @property string $journalDate
 * @property string $transactionType
 * @property string $refNum
 * @property string $notes
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrJournalhead extends \yii\db\ActiveRecord
{
    public $searchRef;
    public $startDate,$endDate;
    
    public static $totalDebit = 0;
    public static $totalCredit = 0;
    
    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => null,
                'updatedByAttribute' => 'editedBy',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => null,
                'updatedAtAttribute' => 'editedDate',
                'value' => function() {
                    return date('Y-m-d H:i:s');
                }
            ],
        ];
    }
    
    public static function tableName()
    {
        return 'tr_journalhead';
    }

    public function rules()
    {
        return [
            [['journalDate', 'transactionType', 'refNum', 'notes', 'createdBy', 'createdDate', 'editedBy', 'editedDate'], 'required'],
            [['journalDate', 'createdDate', 'editedDate', 'startDate', 'endDate', 'searchRef'], 'safe'],
            [['journalHeadID'], 'integer'],
            [['transactionType', 'notes'], 'string', 'max' => 100],
            [['refNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'journalHeadID' => 'Journal Head ID',
            'journalDate' => 'Date',
            'transactionType' => 'Transaction Type',
            'refNum' => 'Reference Number',
            'notes' => 'Notes',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public function getTrJournalDetails()
    {
        return $this->hasMany(TrJournaldetail::className(), ['journalHeadID' => 'journalHeadID']);
    }
    
    public function getTotalDebit ()
    {
        $total = 0;
        foreach($this->trJournalDetails AS $detail)
        {
            $total += $detail->drAmount;
        }
        return $total;
    }
    
    public function getTotalCredit ()
    {
        $total = 0;
        foreach($this->trJournalDetails AS $detail)
        {
            $total += $detail->crAmount;
        }
        return $total;
    }
    
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'tr_journalhead.transactionType', $this->transactionType])
            ->andFilterWhere(['like', 'tr_journalhead.refNum', $this->searchRef]);

        if(!empty($this->journalDate) && strpos($this->journalDate, 'to') !== false) { 
            //list($this->startDate, $this->endDate) = explode(' to ', $this->journalDate); 

            $query->andFilterWhere(['>=', 'tr_journalhead.journalDate', date('Y-m-d',strtotime($this->startDate))]);
            $query->andFilterWhere(['<=', 'tr_journalhead.journalDate', date('Y-m-d',strtotime($this->endDate. ' +1 day'))]);

        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['journalDate' => SORT_DESC],
                'attributes' => [
                    'journalHeadID',
                    'journalDate' => [
                        'asc' => ['tr_journalhead.journalDate' => SORT_ASC],
                        'desc' => ['tr_journalhead.journalDate' => SORT_DESC]
                    ],
                    'transactionType' => [
                        'asc' => ['tr_journalhead.transactionType' => SORT_ASC],
                        'desc' => ['tr_journalhead.transactionType' => SORT_DESC],
                    ],
                    'refNum' => [
                        'asc' => ['tr_journalhead.refNum' => SORT_ASC],
                        'desc' => ['tr_journalhead.refNum' => SORT_DESC],
                    ],
                    'notes' => [
                        'asc' => ['tr_journalhead.notes' => SORT_ASC],
                        'desc' => ['tr_journalhead.notes' => SORT_DESC],
                    ]
                    
                ]
            ],
            'pagination' => false
        ]);
        return $dataProvider;
    }
    
    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }
        
        
        foreach($this->trJournalDetails AS $detail)
        {
            $detail->delete();
        }
        
        return true;
    }
    
    public static function newData(&$headId, $date, $transactionType, $refNum, $notes) {
        $prevJournalHead = self::findOne(['refNum' => $refNum, 'transactionType' => $transactionType]);
        $journalHead = new self();
        if ($prevJournalHead != NULL) {
            $journalHead->createdBy = $prevJournalHead->createdBy;
            $journalHead->createdDate = $prevJournalHead->createdDate;
            
            $prevJournalHead->delete();
        } else {
            $journalHead->createdBy = Yii::$app->user->id;
            $journalHead->createdDate = new \yii\db\Expression('NOW()');
        }      
        
        $journalHead->journalDate = $date;
        $journalHead->transactionType = $transactionType;
        $journalHead->refNum = $refNum;
        $journalHead->notes = $notes;
        if (!$journalHead->save(false)) {
            return false;
        }
        
        $headId = $journalHead->journalHeadID;
        return true;
    }
}
