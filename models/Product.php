<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ms_product".
 *
 * @property int $productID Product ID
 * @property int $productCategoryID Product Category
 * @property int $productSubCategoryID Sub Category
 * @property string $productName Name
 * @property int $supplierID Supplier
 * @property string $origin Origin
 * @property bool $flagOOT OOT
 * @property int $hsCodeID HS Code
 * @property string $minQty Reorder Qty
 * @property int $uomID UOM
 * @property int $packingTypeID Packing Type
 * @property string $uomPackingTypeQty @Packing/Unit
 * @property string $notes Notes
 * @property int $flagActive Status
 * @property string $createdBy Created By
 * @property string $createdDate Created Date
 * @property string $editedBy Edited By
 * @property string $editedDate Edited Date
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ms_product';
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
    public function rules()
    {
        return [
            [['productCategoryID', 'productSubCategoryID', 'supplierID', 'productName', 
                'supplierID', 'uomID', 'packingTypeID','flagOOT', 'origin'], 'required'],
            [['flagActive','hsCodeID'], 'integer'],
            [['flagOOT'], 'boolean'],
            [['minQty', 'uomPackingTypeQty','notes'], 'string'],
            [['createdBy', 'editedBy', 'createdDate', 'editedDate'], 'safe'],
            [['productName'], 'string', 'max' => 100],
            [['origin', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['flagActive'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'productID' => 'Product ID',
            'productCategoryID' => 'Product Category',
            'productSubCategoryID' => 'Sub Category',
            'productName' => 'Name',
            'supplierID' => 'Supplier',
            'origin' => 'Origin',
            'flagOOT' => 'Is OOT?',
            'hsCodeID' => 'HS Code',
            'minQty' => 'Reorder Qty',
            'uomID' => 'UOM',
            'packingTypeID' => 'Packing Type',
            'uomPackingTypeQty' => '@Packing/Unit',
            'notes' => 'Notes',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
        
    public function getCategory() {
        return $this->hasOne(ProductCategory::className(), ['productCategoryID' => 'productCategoryID']);
    }
    
    public function getSubCategory() {
        return $this->hasOne(ProductSubCategory::className(), ['productSubCategoryID' => 'productSubCategoryID']);
    }
    
    public function getSupplier() {
        return $this->hasOne(Supplier::className(), ['supplierID' => 'supplierID']);
    }
    
    public function getUom() {
        return $this->hasOne(Uom::className(), ['uomID' => 'uomID']);
    }
    
    public function getHsCode() {
        return $this->hasOne(HsCode::className(), ['hsCodeID' => 'hsCodeID']);
    }
        
    public function search() {
        $query = self::find()
            ->joinWith('category')
            ->joinWith('subCategory')
            ->joinWith('supplier')
            ->joinWith('hsCode')
            ->andFilterWhere(['like', 'productName', $this->productName])
            ->andFilterWhere(['like', 'ms_productcategory.productCategoryName', $this->productCategoryID])
            ->andFilterWhere(['like', 'ms_productsubcategory.productSubCategoryName', $this->productSubCategoryID])
            ->andFilterWhere(['like', 'origin', $this->origin])
            ->andFilterWhere(['like', 'ms_supplier.supplierName', $this->supplierID])
            ->andFilterWhere(['like', 'ms_hscode.hsCode', $this->hsCodeID])
            ->andFilterWhere(['=', 'ms_product.flagActive', $this->flagActive]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'productCategoryID' => [
                        'asc' => ['ms_productcategory.productCategoryName' => SORT_ASC],
                        'desc' => ['ms_productcategory.productCategoryName' => SORT_DESC],
                    ],
                    'productSubCategoryID' => [
                        'asc' => ['ms_productsubcategory.productSubCategoryName' => SORT_ASC],
                        'desc' => ['ms_productsubcategory.productSubCategoryName' => SORT_DESC],
                    ],
                    'origin',
                    'supplierID' => [
                        'asc' => ['ms_supplier.supplierName' => SORT_ASC],
                        'desc' => ['ms_supplier.supplierName' => SORT_DESC],
                    ],
                    'hsCodeID' => [
                        'asc' => ['ms_hscode.hsCode' => SORT_ASC],
                        'desc' => ['ms_hscode.hsCode' => SORT_DESC],
                    ],
                    'notes',
                    'flagActive'
                ]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $dataProvider;
    }
        
    public function searchBrowse($supplierID = null) {
        $query = self::find()
            ->joinWith('supplier')
            ->joinWith('uom')
            ->andFilterWhere(['like', 'productName', $this->productName])
            ->andFilterWhere(['like', 'origin', $this->origin])
            ->andFilterWhere(['like', 'ms_uom.uomName', $this->uomID])
            ->andFilterWhere(['like', 'ms_supplier.supplierName', $this->supplierID]);

        if($supplierID) {
            $query->andWhere(['ms_product.supplierID' => $supplierID]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'origin',
                    'supplierID' => [
                        'asc' => ['ms_supplier.supplierName' => SORT_ASC],
                        'desc' => ['ms_supplier.supplierName' => SORT_DESC],
                    ],
                    'uomID' => [
                        'asc' => ['ms_uom.uomName' => SORT_ASC],
                        'desc' => ['ms_uom.uomName' => SORT_DESC],
                    ],
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
