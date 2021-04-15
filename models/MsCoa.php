<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_coa".
 *
 * @property string $coaNo
 * @property integer $coaLevel
 * @property string $description
 * @property string $currencyID
 * @property integer $ordinal
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsCoa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_coa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coaNo', 'coaLevel', 'description','currencyID'], 'required'],
            [['coaLevel', 'ordinal'], 'integer'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['coaNo'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 100],
            [['currencyID'], 'string', 'max' => 5],
            [['createdBy', 'editedBy'], 'string', 'max' => 50],
            [['currencyID'], 'exist', 'skipOnError' => true, 'targetClass' => MsCurrency::className(), 'targetAttribute' => ['currencyID' => 'currencyID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'coaNo' => 'COA No',
            'coaLevel' => 'COA Level',
            'description' => 'Description',
            'currencyID' => 'Currency',
            'ordinal' => 'Ordinal',
            'flagActive' => 'Flag Active',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    public static function findActive()
    {
        return self::find()->andWhere(self::tableName() . '.flagActive = 1');
    }
    public function getCurrency(){
        return $this->hasOne(MsCurrency::className(), ['currencyID' => 'currencyID']);
    }
    public function search()
    {
        $query = self::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $dataProvider;
    }
    public function searchLevelFour()
    {
        $query = self::find()
                ->where('coaLevel = 4')
                ->andFilterWhere(['like', 'coaNo', $this->coaNo])
                ->andFilterWhere(['like', 'description', $this->description]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['coaNo' => SORT_ASC],
                'attributes' => ['coaNo']
            ]
        ]);
        
        return $dataProvider;
    }
    
    /**
     * Query build for cash Bank
     * @return ActiveQuery
     */
    public static function cashBankCoa ()
    {
        return self::find()
            ->where('coaLevel = 4 AND (coaNo LIKE "1110.%" OR coaNo LIKE "1111.%")')
            ->orderBy('description');
    }
    
    /**
     * 
     * @return ActiveQuery
     */
	 
	

	 public static function cashInCoa ()
    {
        return Self::find()->select(['coaNo', 'description', 'currencyID'])
            ->where(['coaLevel' => 4]);
    }
    
    /**
     * 
     * @return ActiveQuery
     */
    public static function cashOutCoa ()
    {
        return Self::find()->select(['coaNo', 'description', 'currencyID'])
            ->where(['coaLevel' => 4]);
    }
	 
    /* public static function cashInCoa ()
    {
        return self::find()->select(['coaNo', 'description', 'currencyID'])
            ->where([
                'or', 
                ['like', 'coaNo', '7%', false], 
                ['like', 'coaNo', '1122%', false],
                ['like', 'coaNo', '1120%', false],
                ['like', 'coaNo', '1121%', false],
                ['like', 'coaNo', '2118%', false],
                ['like', 'coaNo', '2117%', false],
                ['like', 'coaNo', '9110%', false]])
            ->andWhere(['coaLevel' => 4]);
    } */
    
    /**
     * 
     * @return ActiveQuery
     */
   /* public static function cashOutCoa ()
    {
        return Self::find()->select(['coaNo', 'description', 'currencyID'])
            ->where([
                'or', 
                ['like', 'coaNo', '1122%', false],
                ['like', 'coaNo', '1120%', false],
                ['like', 'coaNo', '1121%', false],
                ['like', 'coaNo', '2118%', false],
                ['like', 'coaNo', '2117%', false],
                ['like', 'coaNo', '2115%', false],
                ['like', 'coaNo', '1710%', false],
                ['like', 'coaNo', '1410%', false],
                ['like', 'coaNo', '5110%', false],
                ['like', 'coaNo', '6110%', false],
                ['like', 'coaNo', '6111%', false],
                ['like', 'coaNo', '6112%', false],
                ['like', 'coaNo', '6113%', false],
                ['like', 'coaNo', '8110%', false],
                
                ['like', 'coaNo', '9110%', false]])
            ->andWhere(['coaLevel' => 4]);
    } */
}
