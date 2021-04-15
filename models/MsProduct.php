<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "ms_product".
 *
 * @property integer $productID
 * @property integer $productCategoryID
 * @property string $productName
 * @property string $minQty
 * @property string $notes
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsProduct extends \yii\db\ActiveRecord
{
    public $joinProductDetail;
    public $productDetailID;
    public $uomID;
    public $uomName;
    public $packingTypeID;
    public $uomQty;
    public $buyPrice;
    public $sellPrice;
    public $qtyStock;
    public $HPP;
    public $supplierName, $country;
    
    public static function tableName(){
        return 'ms_product';
    }
    
    public function rules(){
        return [
            [['productName','uomID','packingTypeID','uomQty','hsCode'], 'required'],
            [['productID','productDetailID','productCategoryID','productSubcategoryID','uomID','packingTypeID'], 'integer'],
            [['flagOOT', 'flagActive'], 'boolean'],
            [['notes', 'createdDate', 'editedDate'], 'safe'],
            [['hsCode'], 'string', 'max' => 20],
            [['productName'], 'string', 'max' => 100],
            [['createdBy', 'editedBy', 'origin'], 'string', 'max' => 50],
            [['productCategoryID'], 'exist', 'skipOnError' => true, 'targetClass' => MsProductcategory::className(), 'targetAttribute' => ['productCategoryID' => 'productCategoryID']],
            [['joinProductDetail', 'supplierName'], 'safe'],
            [['buyPrice', 'sellPrice','uomQty', 'minQty'], 'string'],
        ];
    }

    public function attributeLabels(){
        return [
            'productID' => 'Product ID',
            'productDetailID' => 'Product Detail ID',
            'productCategoryID' => 'Category',
            'productSubcategoryID' => 'Sub Category',
            'productName' => 'Product Name',
            'minQty' => 'Min Quantity',
            'origin' => 'Origin',
            'notes' => 'Notes',
            'flagOOT' => 'OOT Product',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'joinProductDetail' => '',
            'uomID' => 'UOM',
            'uomName' => 'UOM',
            'packingTypeID' => 'Packing Type',
            'uomQty' => '@Packing/Unit',
            'buyPrice' => 'Buy Price (Rp)',
            'sellPrice' => 'Sell Price (Rp)',
            'hsCode' => 'HS Code'
        ];
    }
    public function getParentCategory(){
        return $this->hasOne(MsProductcategory::className(), ['productCategoryID' => 'productCategoryID']);
    }
    public function getParentSupplier(){
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }

    public function getSupplier(){
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }

    public function getUom(){
        return $this->hasOne(MsUom::className(), ['uomID' => 'uomID'])->viaTable('ms_productdetail', ['productID' => 'productID']);
    }

    public function getPackingType(){
        return $this->hasOne(MsPackingtype::className(), ['packingTypeID' => 'packingTypeID'])->viaTable('ms_productdetail', ['productID' => 'productID']);
    }

    public function searchSupp($filter){
        $query = self::find()
                 ->where('supplierID = :supplierID',[':supplierID' => $filter])
                 ->joinWith('productDetails')
                 ->andFilterWhere(['like', 'ms_productDetail.buyPrice', $this->buyPrice])
                 ->andFilterWhere(['like', 'ms_product.productName', $this->productName]);
        if($this->flagActive != NULL){
            $query->andFilterWhere(['=', 'ms_product.flagActive', $this->flagActive]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'buyPrice' => [
                        'asc' => ['ms_productDetail.buyPrice' => SORT_ASC],
                        'desc' => ['ms_productDetail.buyPrice' => SORT_DESC],
                    ],
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }
    public function search(){
        $query = self::find()
                ->joinWith('parentCategory')
                ->joinWith('uom')
                ->joinWith('supplier')
                ->andFilterWhere(['like', 'ms_product.productName', $this->productName])
                ->andFilterWhere(['like', 'ms_supplier.supplierName', $this->supplierName])
                ->andFilterWhere(['=', 'ms_product.productCategoryID', $this->productCategoryID])
                ->andFilterWhere(['=', 'ms_product.supplierID', $this->supplierID])
                ->andFilterWhere(['like', 'ms_product.origin', $this->origin])
                ->andFilterWhere(['like', 'ms_product.hsCode', $this->hsCode]);
        if($this->flagActive != NULL){
            $query->andFilterWhere(['=', 'ms_product.flagActive', $this->flagActive]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'productCategoryID' => [
                        'asc' => ['ms_productcategory.ProductCategoryName' => SORT_ASC],
                        'desc' => ['ms_productcategory.ProductCategoryName' => SORT_DESC],
                    ],
                    'supplierName' => [
                        'asc' => ['ms_supplier.supplierName' => SORT_ASC],
                        'desc' => ['ms_supplier.supplierName' => SORT_DESC]
                    ],
                    'supplierID',
                    'origin',
                    'minQty',
                    'hsCode'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }

    public function searchInv()
    {
        $query = self::find()
                ->joinWith('parentCategory')
                ->joinWith('uom')
                ->joinWith('supplier')
                ->andWhere(['<>','ms_product.productCategoryID', '4'])
                ->andWhere(['<>','ms_product.productCategoryID', '7'])
                ->andWhere(['<>','ms_product.productCategoryID', '9'])
                ->andFilterWhere(['like', 'ms_product.productName', $this->productName])
                ->andFilterWhere(['like', 'ms_supplier.supplierName', $this->supplierName])
                ->andFilterWhere(['=', 'ms_product.productCategoryID', $this->productCategoryID])
                ->andFilterWhere(['=', 'ms_product.supplierID', $this->supplierID])
                ->andFilterWhere(['like', 'ms_product.origin', $this->origin])
                ->andFilterWhere(['like', 'ms_product.hsCode', $this->hsCode]);
        if($this->flagActive != NULL){
            $query->andFilterWhere(['=', 'ms_product.flagActive', $this->flagActive]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'productCategoryID' => [
                        'asc' => ['ms_productcategory.ProductCategoryName' => SORT_ASC],
                        'desc' => ['ms_productcategory.ProductCategoryName' => SORT_DESC],
                    ],
                    'supplierName' => [
                        'asc' => ['ms_supplier.supplierName' => SORT_ASC],
                        'desc' => ['ms_supplier.supplierName' => SORT_DESC]
                    ],
                    'supplierID',
                    'origin',
                    'minQty',
                    'hsCode'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }

    public function searchNoninv()
    {
        $query = self::find()
                ->joinWith('parentCategory')
                ->joinWith('uom')
                ->joinWith('supplier')
                ->Where(['<>','ms_product.productCategoryID', '1'])
                ->andWhere(['<>','ms_product.productCategoryID', '2'])
                ->andWhere(['<>','ms_product.productCategoryID', '3'])
                ->andWhere(['<>','ms_product.productCategoryID', '5'])
                ->andWhere(['<>','ms_product.productCategoryID', '6'])
                ->andWhere(['<>','ms_product.productCategoryID', '8'])
                ->andFilterWhere(['like', 'ms_product.productName', $this->productName])
                ->andFilterWhere(['like', 'ms_supplier.supplierName', $this->supplierName])
                ->andFilterWhere(['=', 'ms_product.productCategoryID', $this->productCategoryID])
                ->andFilterWhere(['=', 'ms_product.supplierID', $this->supplierID])
                ->andFilterWhere(['like', 'ms_product.origin', $this->origin])
                ->andFilterWhere(['like', 'ms_product.hsCode', $this->hsCode]);
        if($this->flagActive != NULL){
            $query->andFilterWhere(['=', 'ms_product.flagActive', $this->flagActive]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'productCategoryID' => [
                        'asc' => ['ms_productcategory.ProductCategoryName' => SORT_ASC],
                        'desc' => ['ms_productcategory.ProductCategoryName' => SORT_DESC],
                    ],
                    'supplierName' => [
                        'asc' => ['ms_supplier.supplierName' => SORT_ASC],
                        'desc' => ['ms_supplier.supplierName' => SORT_DESC]
                    ],
                    'supplierID',
                    'origin',
                    'minQty',
                    'hsCode'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }

    public function searchRef()
    {
        $query = self::find()
            ->joinWith('parentCategory')
            ->joinWith('uom')
            ->where('ms_product.flagActive = 1')
            ->andFilterWhere(['like', 'ms_product.productName', $this->productName])
            ->andFilterWhere(['=', 'ms_product.productCategoryID', $this->productCategoryID]);

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'productCategoryID' => [
                        'asc' => ['ms_productcategory.ProductCategoryName' => SORT_ASC],
                        'desc' => ['ms_productcategory.ProductCategoryName' => SORT_DESC],
                    ],
                    'minQty'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }
    public function searchRefNonInventory()
    {
        $query = self::find()
            ->joinWith('parentCategory')
            ->joinWith('uom')
            ->where('ms_product.flagActive = 1')
            ->where('ms_productcategory.flagInventory = 0')
            ->andFilterWhere(['like', 'ms_product.productName', $this->productName])
            ->andFilterWhere(['=', 'ms_product.productCategoryID', $this->productCategoryID]);

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['productName' => SORT_ASC],
                'attributes' => [
                    'productName',
                    'productCategoryID' => [
                        'asc' => ['ms_productcategory.ProductCategoryName' => SORT_ASC],
                        'desc' => ['ms_productcategory.ProductCategoryName' => SORT_DESC],
                    ],
                    'minQty'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        return $dataProvider;
    }
    public function getProductDetails(){
        return $this->hasOne(MsProductdetail::className(), ['productID' => 'productID']);
    }
    
   
}
