<?php

namespace app\models;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\TrCashinoutdetail;
use app\models\TrJournaldetail;
use app\models\TrJournalhead;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tr_cashinouthead".
 *
 * @property string $cashInOutNum
 * @property string $refNum
 * @property string $cashInOutDate
 * @property string $checkOrGiroNum
 * @property string $currencyID
 * @property string $rate
 * @property string $cashAccount
 * @property string $additionalInfo
 * @property boolean $flagCashInOut
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrCashinouthead extends \yii\db\ActiveRecord
{
    public $total;
    public $transactionDetails = [];
    
    public $startDate, $endDate;
    
    public $errorMessages = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_cashinouthead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cashInOutNum', 'voucherNum', 'cashInOutDate', 'currencyID', 'rate', 'cashAccount', 'createdBy', 'createdDate', 'flagCashInOut'], 'required'],
            [['cashInOutDate', 'createdDate', 'editedDate', 'checkOrGiroDate'], 'safe'],
            [['flagCashInOut'], 'string', 'max' => 50],
            [['cashInOutNum', 'voucherNum', 'refNum', 'checkOrGiroNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['currencyID'], 'string', 'max' => 5],
            [['cashAccount'], 'string', 'max' => 20],
            [['additionalInfo', 'penerima'], 'string', 'max' => 200],
            [['cashInOutDate','cashInOutNum', 'voucherNum', 'checkOrGiroNum', 'cashAccount', 'rate', 'startDate', 'endDate'], 'safe', 'on'=>'search'],
            [['transactionDetails', 'total'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cashInOutNum' => 'Transaction Number',
            'voucherNum' => 'Voucher Number',
            'refNum' => 'Reference Number',
            'cashInOutDate' => 'Date',
            'checkOrGiroNum' => 'Check or Giro Number',
            'currencyID' => 'Currency',
            'rate' => 'Rate',
            'cashAccount' => 'Cash Account',
            'additionalInfo' => 'Additional Info',
            'flagCashInOut' => 'Flow',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'penerima' => 'Penerima',
        ];
    }
    
    public function search()
    {
        $query = self::find()
        ->joinWith('coa')
        ->andFilterWhere(['like', 'cashInOutNum', $this->cashInOutNum])
        ->andFilterWhere(['like', 'voucherNum', $this->voucherNum])
        ->andFilterWhere(['=', 'cashAccount', $this->cashAccount])
        ->andFilterWhere(['=', 'checkOrGiroNum', $this->checkOrGiroNum])
        ->andFilterWhere(['like', 'additionalInfo', $this->additionalInfo]);
        
        if($this->startDate && $this->endDate)
        {
            $start = date('Y-m-d',strtotime($this->startDate));
            $end = date('Y-m-d',strtotime($this->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'cashInOutDate', $start]);
            $query->andFilterWhere(['<=', 'cashInOutDate', $end]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['cashInOutDate' => SORT_DESC],
                'attributes' => [
                    'cashInOutDate',
                    'cashInOutNum',
                    'voucherNum',
                    'checkOrGiroNum',
                    'cashAccount' => [
                        'asc' => ['coa.description' => SORT_ASC],
                        'desc' => ['coa.description' => SORT_DESC],
                    ]
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }
    public function getCoa()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'cashAccount']);
    }
    public function getCurrency()
    {
        return $this->hasOne(MsCurrency::className(), ['currencyID' => 'currencyID']);
    }
    
    public function afterFind() {
        parent::afterFind();
        
        $trDetail = TrCashinoutdetail::find()
            ->where(['cashInOutNum' => $this->cashInOutNum])
            ->asArray()
            ->all();
        
        foreach ($trDetail as $detail)
        {
            $detail['amount'] = AppHelper::formatNumberTwoDecimalConfig($detail['amount']);
            array_push($this->transactionDetails, $detail);
        }
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        
        $strTime = strtotime($this->cashInOutDate);
        $this->cashInOutDate = date('Y-m-d', $strTime);
        if($this->checkOrGiroDate != null){
            $this->checkOrGiroDate = AppHelper::convertDateTimeFormat($this->checkOrGiroDate, 'd-m-Y', 'Y-m-d H:i:s');
        }
        $this->rate = str_replace(',', '.', str_replace('.', '', $this->rate));
        
        
        
        
        if (!$insert) { return true; }
        
        $strDate = strtotime($this->cashInOutDate);
        
        $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $modelMonth = date("m",$strTime) - 1;
        
        $tempModel = self::find()
            ->where('SUBSTRING(cashInOutNum, 8, 2) LIKE :date', [':date' =>  date("y",$strDate)])
            ->orderBy([new Expression("CAST(SUBSTRING(cashInOutNum, '-3', '3') AS UNSIGNED) DESC")])
            ->one();
        $tempTransNum = "";
            
        if (empty($tempModel)){
            $tempTransNum = "QJA/{{flow}}/".date("y",$strTime)."/".$month[$modelMonth]."/001";
        }
        else{
            $temp = substr($tempModel->cashInOutNum,-3,3)+1;
            $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
            $tempTransNum = "QJA/{{flow}}/".date("y",$strTime)."/".$month[$modelMonth]."/".$temp;
        }

        $this->cashInOutNum = str_replace('{{flow}}', $this->flagCashInOut == 'in' ? 'CI' : 'CO', $tempTransNum);
        
        return true;
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        
        $trCashinoutdetails = [];
        
        TrCashinoutdetail::deleteAll(['cashInOutNum' => $this->cashInOutNum]);
        
        foreach ($this->transactionDetails as $detail)
        {
            $trDetail = new TrCashinoutdetail();
            $trDetail->cashInOutNum = $this->cashInOutNum;
            $trDetail->destinationAccount = $detail['destinationAccount'];
            $trDetail->amount = str_replace(',', '.', str_replace('.', '', $detail['amount']));
            $trDetail->notes = $detail['notes'];
            
            array_push($trCashinoutdetails, $trDetail);
            
            $trDetail->save(false);
        }
        
        //INSERT TO JOURNAL
        $connection = MdlDb::getDbConnection();
        $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
        
        $refNum = $this->cashInOutNum;
        $mode = 'cash in out'; //Mode 2 or 3 is or CashInOut, no mather you are in or out, you can use both mode. All In and Out specification is handled in the SP

        $command->bindParam(':refNum', $refNum);
        $command->bindParam(':mode', $mode);
        $command->execute();
    }
    
    public function afterDelete() {
        parent::afterDelete();
        
        TrCashinoutdetail::deleteAll(['cashInOutNum' => $this->cashInOutNum]);
        
        $journalHead = TrJournalhead::find()->where(['refNum' => $this->cashInOutNum])->one();
        if ($journalHead)
        {
            //Delete the journal detail first
            TrJournaldetail::deleteAll(['journalHeadID' => $journalHead->journalHeadID]);
            
            //Destroy ourself
            $journalHead->delete();
        }
    }
}
