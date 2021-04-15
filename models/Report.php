<?php

namespace app\models;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use app\components\AppHelper;
/**
 * This is the model class for "report".
 * 
 * @property string $dateFrom
 * @property string $dateTo
 */
class Report extends Model {

    public $initial;
    public $dateFrom;
    public $dateTo;
    public $yearReport;
    public $location;
    public $locationID;
    public $locationMandatory;
    public $supplierID;
    public $branchID;
    public $categoryID;
    public $menuCategory;
    public $menuCategoryDetail;
    public $categoryMandatory;
    public $paymentMethod;
    public $dateDaily;
    public $purchaseNum;
    public $productName;
    public $productCode;
    public $uomID;
    public $currencyID;
    public $expectedDateFrom;
    public $expectedDateTo;
    public $expectedDate;
    public $purchaseDate;
    public $reportDate;
    public $dateReport;
    public $username;
    public $search;
    public $salesNum;
    public $memberID;
    public $paymentMethodTypeID;
    public $menuName;
    public $createdBranch;
    public $usedBranch;
    public $voucherID;
    public $notes;
    public $status;
    public $subCategoryID;
    public $tableID;
    public $paymentMethodID;
    public $cancelNotes;
    public $parentNum;
    public $childNum;
    public $coaNo;
    public $monthPeriod;
    public $fullName;
    public $purchasePaymentNum;
    public $purchaseInvoiceNum;
    public $itemJournalNum;
    public $purposeID;
    public $stockOpnameNum;
    public $reportTitle;
    public $visitPurposeID;  
    public $assetCode;
    public $assetCategoryID;
    public $showMenuPackage;
    public $purchaseTypeID;
    public $type;
    public $limit;
    public $bomTypeID;
    public $productionOrderNum;
    public $formulaName;
    public $goodsReceiptNum;
    public $refNum;
    public $transType;

    public function rules() {
        return [
            [['dateFrom', 'dateTo', 'dateDaily'], 'date', 'format' => 'php:d-m-Y'],
            [['dateFrom', 'dateTo', 'dateDaily', 'locationMandatory', 'categoryMandatory'], 'required'],
            [['yearReport'], 'string', 'max' => 4],
            [['yearReport'], 'required'],
            [['location', 'locationMandatory', 'supplierID',
            'branchID', 'categoryID', 'menuCategory', 'menuCategoryDetail', 'categoryMandatory',
            'paymentMethod', 'dateDaily', 'purchaseNum', 'productName',
            'productCode', 'uomID', 'currencyID', 'expectedDateFrom',
            'expectedDateTo', 'expectedDate', 'purchaseDate', 'reportDate',
            'username', 'search', 'salesNum', 'memberID',
            'paymentMethodTypeID', 'menuName', 'createdBranch', 'usedBranch',
            'voucherID', 'notes', 'status', 'subCategoryID',
            'tableID', 'paymentMethodID', 'cancelNotes', 'parentNum',
            'childNum', 'coaNo', 'monthPeriod', 'fullName',
            'purchasePaymentNum', 'purchaseInvoiceNum', 'itemJournalNum', 'purposeID',
            'stockOpnameNum', 'visitPurposeID', 'assetCode', 'assetCategoryID', 'showMenuPackage', 
            'purchaseTypeID', 'type', 'limit', 'bomTypeID', 'productionOrderNum', 'formulaName', 
            'goodsReceiptNum', 'dateReport', 'refNum', 'transType'], 'safe']
        ];
    }

    public function attributeLabels() {
        return [
            'dateFrom' => Yii::t('app', 'From'),
            'dateTo' => Yii::t('app', 'To'),
            'yearReport' => Yii::t('app', 'Year'),
            'dateDaily' => Yii::t('app', 'Date'),
            'locationID' => Yii::t('app', 'Location'),
            'locationMandatory' => Yii::t('app', 'Location'),
            'categoryMandatory' => Yii::t('app', 'Category'),
            'branchID' => Yii::t('app', 'Branch'),
            'supplierID' => Yii::t('app', 'Supplier'),
            'currencyID' => Yii::t('app', 'Currency'),
            'uomID' => Yii::t('app', 'Unit'),
            'purchaseNum' => Yii::t('app', 'Purchase Number'),
            'productName' => Yii::t('app', 'Product Name'),
            'productCode' => Yii::t('app', 'Product Code'),
            'excpectedDate' => Yii::t('app', 'Expected Receipt Date'),
            'assetCategoryID' => Yii::t('app', 'Asset Category'),
            'categoryID' => Yii::t('app', 'Category'),
            'reportDate' => Yii::t('app', 'Period'),
            'salesNum' => Yii::t('app', 'Sales Number'),
            'dateReport' => Yii::t('app', 'Period'),
            'memberID' => Yii::t('app', 'Member'),
            'paymentMethodTypeID' => Yii::t('app', 'Payment Method Type'),
            'voucherID' => Yii::t('app', 'Voucher ID'),
            'subCategoryID' => Yii::t('app', 'Sub Category'),
            'createdBranch' => Yii::t('app', 'Created Branch'),
            'usedBranch' => Yii::t('app', 'Used Branch'),
            'status' => Yii::t('app', 'Status'),
            'notes' => Yii::t('app', 'Notes'),
            'tableID' => Yii::t('app', 'Table'),
            'paymentMethodID' => Yii::t('app', 'Payment Method'),
            'cancelNotes' => Yii::t('app', 'Cancel Notes'),
            'parentNum' => Yii::t('app', 'Parent Sales Number'),
            'childNum' => Yii::t('app', 'Child Sales Number'),
            'coaNo' => Yii::t('app', 'Account'),
            'purposeID' => Yii::t('app', 'Purpose'),
            'stockOpnameNum' => Yii::t('app', 'Stock Opname Number'),
            'visitPurposeID' => Yii::t('app', 'Visit Purpose'),
            'purchaseTypeID' => Yii::t('app', 'Purchase Type'),
            'purchaseInvoiceNum' => Yii::t('app', 'Purchase Invoice Number'),
            'bomTypeID' => Yii::t('app', 'Bom Type'),
            'productionOrderNum' => Yii::t('app', 'Production Number'),
            'formulaName' => Yii::t('app', 'Formula Name'),
            'purchasePaymentNum' => Yii::t('app', 'Purchase Payment Number'),
            'refNum' => Yii::t('app', 'Reference Number'),
            'transType' => Yii::t('app', 'Transaction Type'),
        ];
    }

 
}
