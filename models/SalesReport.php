<?php

namespace app\models;

use app\components\AppHelper;
use app\components\MdlDb;
use Yii;
use yii\base\Model;
use function Symfony\Component\Debug\header;

class SalesReport extends Model
{
    public $typeReport;
    public $dateStart;
    public $dateEnd;
    public $customerID;
    public $productID;
    public $supplierID, $yearsS , $yearsE;

    public function rules()
    {
        return [
            [['typeReport','dateStart','dateEnd', 'yearsS', 'yearsE'], 'required'],
            [['customerID','productID','supplierID'],'integer'],
        ];
    }
    
    public function attributeLabels() {
        return[
            'typeReport' => 'Type Report',
            'dateStart' => 'Date Start Periode',
            'dateEnd' => 'Date End Periode',
            'yearsS' => 'Year Start Periode',
            'yearsE' => 'Year End Periode',
            'productID' => 'Product Name',
            'customerID' => 'Customer',
            'supplierID' => 'Supplier',
        ];
        
    }
    
    
    public function printSales($dateS, $dateE, $type, $customerID, $productID, $supplierID)
    { 
        $connection = MdlDb::getDbConnection();
        
        
        $dateS = AppHelper::convertDateTimeFormat($dateS, 'd-m-Y', 'Y-m-d');
        $dateE = AppHelper::convertDateTimeFormat($dateE, 'd-m-Y', 'Y-m-d');
        if($productID != ''){
            $filterProduct = 'AND gdDetail.productID = "'.$productID.'"';
        }
        if($customerID != ''){
            $filterCustomer = 'AND soHead.customerID = "'.$customerID.'"';
        }
        if($supplierID != ''){
            $filterSupplier = 'AND supplier.supplierID = "'.$supplierID.'"';
        }
        
    
        
        if($type == 'Product'){

            $sql = 'SELECT uom.uomName, product.productID, product.origin , product.productName, soDetail.price, soDetail.subTotal, gdHead.goodsDeliveryDate, gdDetail.qty, cs.customerName FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE DATE(gdHead.goodsDeliveryDate)  BETWEEN "'.$dateS.'" and "'.$dateE.'" '.'
                    AND gdHead.transType = "Sales Order" 
                    '.$filterProduct.'ORDER BY product.productName ASC';
        
        } else if($type == 'Customer') {
            
            $sql = 'SELECT uom.uomName, product.productID,product.origin, product.productName,soDetail.price, soDetail.subTotal, gdHead.goodsDeliveryDate, gdDetail.qty, cs.customerName FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE DATE(gdHead.goodsDeliveryDate)  BETWEEN "'.$dateS.'" and "'.$dateE.'" '.'
                    AND gdHead.transType = "Sales Order" 
                    '.$filterCustomer.'ORDER BY cs.customerName ASC';;
                   
        } else if($type == 'Supplier') {
            
            $sql = 'SELECT uom.uomName, product.productID, product.origin, soDetail.price, supplier.supplierName, product.productName, soDetail.subTotal, gdHead.goodsDeliveryDate, gdDetail.qty, cs.customerName FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN ms_supplier supplier on supplier.supplierID = product.supplierID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE DATE(gdHead.goodsDeliveryDate)  BETWEEN "'.$dateS.'" and "'.$dateE.'" '.'
                    AND gdHead.transType = "Sales Order" 
                    '.$filterSupplier.'ORDER BY product.productName ASC';
                   
        }
      
        $command = $connection->createCommand($sql);
        $model = $command->queryAll();
        return $model;
    }
    
    
    public function printSalesRecap($years, $type, $customerID, $productID, $supplierID)
    { 
        $connection = MdlDb::getDbConnection();
        
        if($type == 'Product'){
            $filterProduct = 'AND gdDetail.productID = "'.$productID.'"';
        }
        if($type == 'Customer'){
            $filterCustomer = 'AND soHead.customerID = "'.$customerID.'"';
        }
        if($type == 'Supplier'){
            $filterSupplier = 'AND supplier.supplierID = "'.$supplierID.'"';
        }
        
    
        
        if($type == 'Product'){

            $sql = 'SELECT soDetail.subTotal AS total, product.productName , product.productID FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE YEAR(gdHead.goodsDeliveryDate)  = "'.$years.'"'.'
                    AND gdHead.transType = "Sales Order" 
                    '.$filterProduct.'
                    GROUP BY product.productID
                    ORDER BY product.productName ASC';
        
        } else if($type == 'Customer') {
            
            $sql = 'SELECT SUM(soDetail.subTotal) AS total, cs.customerName FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE YEAR(gdHead.goodsDeliveryDate)  = "'.$years.'"
                    AND gdHead.transType = "Sales Order" 
                    '.$filterCustomer.'
                    GROUP BY cs.customerID
                    ORDER BY cs.customerName ASC';
                   
        } else if($type == 'Supplier') {
            
            $sql = 'SELECT SUM(soDetail.subTotal) AS total, supplier.supplierName FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN ms_supplier supplier on supplier.supplierID = product.supplierID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE YEAR(gdHead.goodsDeliveryDate)  = "'.$years.'"'.'
                    AND gdHead.transType = "Sales Order" 
                    '.$filterSupplier.'
                    GROUP BY supplier.supplierID
                    ORDER BY product.productName ASC';
                   
        }
      
        $command = $connection->createCommand($sql);
        $model = $command->queryAll();
        return $model;
    }
    
    
     public function dataSalesRecap($yearsS, $yearsE, $type, $customerID, $productID, $supplierID)
    { 
        $connection = MdlDb::getDbConnection();
        
        if($productID != ''){
            $filterProduct = 'AND gdDetail.productID = "'.$productID.'"';
        }
        if($customerID != ''){
            $filterCustomer = 'AND soHead.customerID = "'.$customerID.'"';
        }
        if($supplierID != ''){
            $filterSupplier = 'AND supplier.supplierID = "'.$supplierID.'"';
        }
        
    
        
        if($type == 'Product'){

            $sql = 'SELECT SUM(soDetail.subTotal) AS total, product.productID, product.productName AS name FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE YEAR(gdHead.goodsDeliveryDate) between "'.$yearsS.'"'.' AND  "'.$yearsE.'"'.'
                    AND gdHead.transType = "Sales Order" 
                    GROUP BY product.productID
                    ORDER BY product.productName ASC';
        
        } else if($type == 'Customer') {
            
            $sql = 'SELECT SUM(soDetail.subTotal) AS total,cs.customerID, cs.customerName AS name FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE YEAR(gdHead.goodsDeliveryDate) between "'.$yearsS.'"'.' AND  "'.$yearsE.'"'.'
                    AND gdHead.transType = "Sales Order" 
                    GROUP BY cs.customerID
                    ORDER BY cs.customerName ASC';
                   
        } else if($type == 'Supplier') {
            
            $sql = 'SELECT SUM(soDetail.subTotal) AS total,supplier.supplierID, supplier.supplierName AS name FROM tr_goodsdeliverydetail gdDetail
                    LEFT JOIN tr_goodsdeliveryhead  as gdHead on gdHead.goodsDeliveryNum = gdDetail.goodsDeliveryNum
                    LEFT JOIN ms_product product on product.productID = gdDetail.productID
                    LEFT JOIN ms_supplier supplier on supplier.supplierID = product.supplierID
                    LEFT JOIN tr_salesorderhead soHead on soHead.salesOrderNum = gdHead.refNum
                    LEFT JOIN tr_salesorderdetail soDetail on soDetail.salesOrderNum = soHead.salesOrderNum
                    LEFT JOIN ms_customer cs on cs.customerID = soHead.customerID
                    LEFT JOIN ms_uom uom on uom.uomID = soDetail.uomID
                    WHERE YEAR(gdHead.goodsDeliveryDate) between "'.$yearsS.'"'.' AND  "'.$yearsE.'"'.'
                    AND gdHead.transType = "Sales Order" 
                    GROUP BY supplier.supplierID
                    ORDER BY supplier.supplierName ASC';
                   
        }
      
        $command = $connection->createCommand($sql);
        $model = $command->queryAll();
        return $model;
    }
}


