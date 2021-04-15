<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tr_taxinhead".
 *
 * @property string $taxInNum
 * @property string $taxInDate
 * @property string $taxTotal
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrTaxinhead extends \yii\db\ActiveRecord
{
    public $taxInvoiceNum,$taxGrandTotal,$taxRate,$taxTotal,$taxSource;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_taxinhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taxInNum', 'taxPeriode', 'taxInTotal', 'taxOutTotal', 'taxPayable'], 'required'],
            [['taxInDate', 'createdDate', 'editedDate', 'additionalInfo'], 'safe'],
            [['taxInMonth', 'taxInYear'], 'number'],
            [['taxInTotal', 'taxOutTotal'], 'number'],
            [['taxInNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'taxInNum' => 'Tax In Number',
            'taxPeriode' => 'Tax Periode',
            'taxInTotal' => 'Tax In Total',
            'taxOutTotal' => 'Tax Out Total',
            'taxPayable' => 'Tax Payable',
            'additionalInfo' => 'Additional Info',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'taxInvoiceNum' => 'Invoice Number',
            'taxGrandTotal' => 'Grand Total',
            'taxRate' => 'VAT',
            'taxTotal' => 'Tax Total',
            'taxSource' => 'Source',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'taxInNum', $this->taxInNum])
            ->andFilterWhere(['=', "DATE_FORMAT(taxPeriode, '%m-%Y')", $this->taxPeriode])
            ->andfilterWhere(['like', 'taxInTotal', $this->taxInTotal])
            ->andfilterWhere(['like', 'taxOutTotal', $this->taxOutTotal])
            ->andfilterWhere(['like', 'taxPayable', $this->taxPayable]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['taxPeriode' => SORT_DESC],
                'attributes' => [
                    'taxPeriode',
                    'taxInNum',
                    'taxInTotal',
                    'taxOutTotal',
                    'taxPayable'
                ],
            ]
        ]);

        return $dataProvider;
    }
}
