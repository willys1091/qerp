<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tr_goodsreceipthead".
 *
 * @property string $goodsReceiptNum
 * @property string $refNum
 * @property string $transType
 * @property string $goodsReceiptDate
 * @property integer $warehouseID
 * @property string $deliveryNum
 * @property string $pibNumber
 * @property string $pibDate
 * @property string $pibRate
 * @property string $additionalInfo
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrGoodsreceipthead2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_goodsreceipthead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsReceiptNum', 'refNum', 'warehouseID', 'goodsReceiptDate'], 'required'],
            [['goodsReceiptTime', 'invoiceDate', 'AWBDate', 'pibDate', 'createdDate', 'editedDate'], 'safe'],
            [['pibRate', 'pibAmount', 'whtPercentage'], 'string'],
            [['goodsReceiptNum', 'refNum', 'transType', 'invoiceNum', 'PPJK', 'noIzin', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['deliveryNum', 'AWBNum', 'pibSubmitCode', 'pibNumber'], 'string', 'max' => 20],
            [['CNFCIF'], 'string', 'max' => 100],
            [['additionalInfo'], 'string', 'max' => 200],
            [['whtID'], 'integer'],
            [['joinGoodsReceiptDetail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goodsReceiptNum' => 'Goods Receipt Number',
            'refNum' => 'Reference Number',
            'transType' => 'Transaction Type',
            'goodsReceiptDate' => 'Purchase Order Date',
            'deliveryNum' => 'Delivery Number',
            'AWBNum' => 'AWB Number',
            'AWBDate' => 'AWB Date',
            'warehouseID' => 'Warehouse',
            'warehouseName' => 'Warehouse',
            'PPJK' => 'PPJK',
            'CNFCIF' => 'CNF/CIF',
            'pibNumber' => 'PIB Number',
            'pibDate' => 'PIB Date',
            'pibRate' => 'PIB Rate',
            'pibSubmitCode' => 'No Aju PIB',
            'pibAmount' => 'PIB Amount',
            'invoiceNum' => 'Invoice Number',
            'invoiceDate' => 'Invoice Date',
            'noIzin' => 'Izin POM/SKI',
            'whtID' => 'WHT Article',
            'whtPercentage' => 'WHT Percentage (%)',
            'additionalInfo' => 'Additional Information',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'supplierID' => 'Supplier',
            'taxTotal' => 'Tax Total',
            'grandTotal' => 'Grand Total',
            'advancePaymentNum' => 'Total Advance Payment',
            'outstanding' => 'Outstanding',
        ];
    }
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'goodsReceiptNum', $this->goodsReceiptNum])
            ->andFilterWhere(['like', 'refNum', $this->refNum]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['goodsReceiptDate' => SORT_DESC],
                'attributes' => ['goodsReceiptDate']
            ]
        ]);

        return $dataProvider;
    }
    public function getPurchaseOrder()
    {
        return $this->hasOne(TrPurchaseorderhead::className(), ['purchaseOrderNum' => 'refNum']);
    }
}
