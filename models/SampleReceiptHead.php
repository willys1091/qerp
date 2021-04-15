<?php

namespace app\models;

use app\components\AppHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tr_samplereceipthead".
 *
 * @property string $sampleReceiptNum
 * @property string $sampleReceiptDate
 * @property string $refNum
 * @property int $supplierID
 * @property int $warehouseID
 * @property string $notes
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 * @property string $dateSearchStart
 * @property string $dateSearchEnd
 * 
 * @property Supplier $supplier
 * @property SampleReceiptDetail $details
 */
class SampleReceiptHead extends ActiveRecord {
    public $dateSearchStart, $dateSearchEnd;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tr_samplereceipthead';
    }

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'createdBy',
                'updatedByAttribute' => 'editedBy',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdDate',
                'updatedAtAttribute' => 'editedDate',
                'value' => function() {
                    return date('Y-m-d H:i:s');
                }
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sampleReceiptDate', 'supplierID', 'warehouseID'], 'required'],
            [['createdBy', 'createdDate', 'editedBy', 'editedDate', 'dateSearchStart', 'dateSearchEnd'], 'safe'],
            [['supplierID', 'warehouseID','notes'], 'string'],
            [['sampleReceiptNum', 'refNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['sampleReceiptNum'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'sampleReceiptNum' => 'Transaction Number',
            'sampleReceiptDate' => 'Date',
            'refNum' => 'Reference',
            'supplierID' => 'Supplier',
            'warehouseID' => 'Warehouse',
            'notes' => 'Notes',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
    
    public function getSupplier() {
        return $this->hasOne(Supplier::className(), ['supplierID' => 'supplierID']);
    }
    
    public function getDetails() {
        return $this->hasMany(SampleReceiptDetail::className(), ['sampleReceiptNum' => 'sampleReceiptNum']);
    }

    public function search() {
        $query = self::find()
            ->joinWith('supplier')
            ->andFilterWhere(['between', 'sampleReceiptDate', AppHelper::convertDateTimeFormat($this->dateSearchStart, 'd-m-Y', 'Y-m-d'), AppHelper::convertDateTimeFormat($this->dateSearchEnd, 'd-m-Y', 'Y-m-d')])
            ->andFilterWhere(['like', 'sampleReceiptNum', $this->sampleReceiptNum])
            ->andFilterWhere(['like', 'refNum', $this->refNum])
            ->andFilterWhere(['like', 'ms_supplier.supplierName', $this->supplierID]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sampleReceiptDate' => SORT_DESC, 'sampleReceiptNum' => SORT_ASC],
                'attributes' => [
                    'sampleReceiptDate',
                    'sampleReceiptNum',
                    'refNum',
                    'supplierID' =>[
                        'asc' => ['ms_supplier.supplierName' => SORT_ASC],
                        'desc' => ['ms_supplier.supplierName' => SORT_DESC],
                    ],
                   
                ]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $dataProvider;
    }
    
    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }
        
        foreach($this->details as $detail) {
            if(!$detail->delete()) {
                return false;
            }
        }        
        
        return true;
    }
}