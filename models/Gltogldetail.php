<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gltogldetail".
 *
 * @property integer $gltoglDetailID
 * @property string $gltoglNum
 * @property string $coaNo
 * @property string $currencyID
 * @property string $rate
 * @property string $debitAmount
 * @property string $creditAmount
 */
class Gltogldetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_gltogldetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gltoglNum', 'coaNo', 'currencyID', 'rate'], 'required'],
            [['rate', 'debitAmount', 'creditAmount'], 'string'],
            [['gltoglNum'], 'string', 'max' => 50],
            [['coaNo'], 'string', 'max' => 20],
            [['currencyID'], 'string', 'max' => 5],
            [['gltoglNum'], 'exist', 'skipOnError' => true, 'targetClass' => Gltogl::className(), 'targetAttribute' => ['gltoglNum' => 'gltoglNum']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gltoglDetailID' => 'Gltogl Detail ID',
            'gltoglNum' => 'Gltogl Num',
            'coaNo' => 'Coa No',
            'currencyID' => 'Currency ID',
            'rate' => 'Rate',
            'debitAmount' => 'Debit Amount',
            'creditAmount' => 'Credit Amount',
        ];
    }
    public function getCoaDescription()
    {
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'coaNo']);
    }
}
