<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\ExcelFormatter;
use app\components\MdlDb;
use app\components\ReportEngine;
use app\models\AccountingReport;
use app\models\MsCoa;
use kartik\mpdf\Pdf;
use mPDF;
use PHPExcel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


function nl2space($string)
{
    return preg_replace("/[\r\n]{2,}/", " ", $string);
}

class AccountingReportController extends MainController
{
    public function actionIndex()
    {
    	$model = new AccountingReport();
    	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             return ActiveForm::validate($model);
        }
        
        if (Yii::$app->request->post('btnPrint'))
        {
            $model->load(Yii::$app->request->post());
            $typeReport = $model->typeReport;
            
            if ($typeReport == 'Balance Sheet')
            {
                $url = Url::to(['accounting-report/balancesheet'.(Yii::$app->request->post('showDetail', false) ? '-detail' : ''),
                    'typeReport' => $typeReport,
                    'startDate' => $model->startDate,
                    'endDate' =>  $model->endDate,
                ]);
                echo "<script>window.open('$url', 'Balance Sheet', 'width=900,height=630')</script>";
            } else if ($typeReport == 'GL Report')
            {
                $url = Url::to(['accounting-report/glreport',
                    'typeReport' => $typeReport,
                    'coaNo' => $model->coaNo,
                    'startDate' => $model->startDate,
                    'endDate' =>  $model->endDate,
                ]);
                echo "<script>window.open('$url', 'GL Report', 'width=900,height=630')</script>";
            } else if ($typeReport == 'Trial Balance')
            {
                $url = Url::to(['accounting-report/trial-balance',
                   'typeReport' => $typeReport,
                   'startDate' => $model->startDate,
                   'endDate' =>  $model->endDate,
                ]);
                echo "<script>window.open('$url', '_blank')</script>";
            } else if ($typeReport == 'Tax Recapitulation')
            {
                $url = Url::to(['accounting-report/taxrecap',
                    'typeReport' => $typeReport,
                    'monthYear' => Yii::$app->request->post('monthYear'),
                ]);
                echo "<script>window.open('$url', 'GL Report', 'width=900,height=630')</script>";
            } else if ($typeReport == 'Profit Loss')
            {
                $url = Url::to(['accounting-report/profit-loss'.(Yii::$app->request->post('showDetail', false) ? '-detail' : ''),
                    'typeReport' => $typeReport,
                    'startDate' => $model->startDate,
                    'endDate' =>  $model->endDate,
                ]);
                echo "<script>window.open('$url', 'Profit Loss', 'width=900,height=630')</script>";
            }
        }
        
        $model->typeReport = NULL;
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    public function actionPrint($typeReport)
    {
    	$this->layout = 'reportLayout';

        if($typeReport == "Profit Loss"){
            $modelLevelZero = MsCoa::find()
                                ->rightJoin('tr_journaldetail', 'SUBSTR(tr_journaldetail.coaNo,1,1) = ms_coa.coaNo')
                                ->where(['in','ms_coa.coaNo',[4,5,6,7,8,9]])
                                ->orderBy('ms_coa.coaNo')
                                ->all();
            $view = 'report_profitloss';     
        }
        if($typeReport == "Balance Sheet"){
            $modelLevelZero = MsCoa::find()
                                ->where(['in','coaNo',[1,2,3]])
                                ->orderBy('coaNo')
                                ->all();
            $view = 'report_balancesheet';     
        }
        $content = $this->renderPartial($view, [
            'modelLevelZero' => $modelLevelZero,
        ]);  
        $mpdf = new mPDF;
    
        //$mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($content);

        //$mpdf->debug = true;
        $mpdf ->Output('report.pdf','I');
        exit;
    }
    
    public function actionBalancesheet($startDate, $endDate )
    {
        $startDate =  date('Y-m-d', strtotime($startDate));
        $endDate =  date('Y-m-d', strtotime($endDate));
       
        $monthYearStart = explode('-', $startDate);
        $monthStart = $monthYearStart[0];
        $yearStart = $monthYearStart[1];
        
        $monthYearEnd = explode('-', $endDate);
        $monthEnd = $monthYearEnd[0];
        $yearEnd = $monthYearEnd[1];
        
        
        $startYear = date('Y', strtotime($endDate));
        $tillDateStart = "$startYear"."-01-01";
      
        
        $connection = AppHelper::getDbConnection();
        $aktivasQuery = "SELECT IFNULL(parentCoa.coaNo, '-') AS parentCoa, IFNULL(parentCoa.description, '-') AS parentDescription, 
        account.coaNo, account.description,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(account.coaNo, '%') 
            AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
        ) AS amount,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(account.coaNo, '%')  AND (th.journalDate BETWEEN '$tillDateStart' AND '$endDate')
        ) AS lastAmount
        FROM tr_journaldetail AS detail
        LEFT JOIN ms_coa AS account ON SUBSTRING(detail.coaNo, 1, 4) = account.coaNo
        LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(detail.coaNo, 1, 3) = parentCoa.coaNo
        WHERE account.coaNo LIKE '1%'
        GROUP BY account.coaNo
        ORDER BY parentDescription ASC, coaNo ASC";
        $aktivas = $connection->createCommand($aktivasQuery)->queryAll();
        
        $pasivasQuery = "SELECT IFNULL(parentCoa.coaNo, '-') AS parentCoa, IFNULL(parentCoa.description, '-') AS parentDescription, 
        account.coaNo, account.description,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(account.coaNo, '%') 
            AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
        ) AS amount,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(account.coaNo, '%') AND th.journalDate < '$startDate'
        ) AS lastAmount
        FROM tr_journaldetail AS detail
        LEFT JOIN ms_coa AS account ON SUBSTRING(detail.coaNo, 1, 4) = account.coaNo
        LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(detail.coaNo, 1, 3) = parentCoa.coaNo
        WHERE (account.coaNo LIKE '2%' OR account.coaNo LIKE '3%')
        GROUP BY account.coaNo
        ORDER BY parentDescription ASC, coaNo ASC";
        $pasivas = $connection->createCommand($pasivasQuery)->queryAll();
        
        $content = $this->renderPartial('report_balancesheet', [
            'aktivas' => $aktivas,
            'pasivas' => $pasivas,
            'monthStart' => $monthStart,
            'yearStart' => $yearStart,
            'monthEnd' => $monthEnd,
            'yearEnd' => $yearEnd,
        ]);  
        
        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        
        $mpdf->Output("Balance_Sheet-Report_$month-$year.pdf", 'I');
    }
    
    public function actionBalancesheetDetail($startDate, $endDate )
    {
        $startDate =  date('Y-m-d', strtotime($startDate));
        $endDate =  date('Y-m-d', strtotime($endDate));
       
        $monthYearStart = explode('-', $startDate);
        $monthStart = $monthYearStart[0];
        $yearStart = $monthYearStart[1];
        
        $monthYearEnd = explode('-', $endDate);
        $monthEnd = $monthYearEnd[0];
        $yearEnd = $monthYearEnd[1];
        
        $connection = AppHelper::getDbConnection();
        $mainQuery = "SELECT IFNULL(rootCoa.coaNo, '-') AS rootCoaNo, IFNULL(rootCoa.description, '-') AS rootCoaDescription, 
        parentCoa.coaNo AS parentCoaNo, parentCoa.description AS parentCoaDescription,
        coa.coaNo, coa.description,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') 
            AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
        ) AS amount,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') AND (th.journalDate BETWEEN '$tillDateStart' AND '$endDate')
        ) AS lastAmount
        FROM tr_journaldetail AS detail
        LEFT JOIN tr_journalhead AS head ON head.journalHeadID = detail.journalheadID
        LEFT JOIN ms_coa AS coa ON detail.coaNo = coa.coaNo
        LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(detail.coaNo, 1, 4) = parentCoa.coaNo
        LEFT JOIN ms_coa AS rootCoa ON SUBSTRING(detail.coaNo, 1, 3) = rootCoa.coaNo
        WHERE (head.journalDate < LAST_DAY('$startDate'))
        -- //WHERE parentCoa.coaNo LIKE '1%'
        GROUP BY coa.coaNo
        HAVING amount != 0 OR lastAmount != 0
        ORDER BY coa.coaNo ASC, coaNo ASC";
        
        $datas = $connection->createCommand($mainQuery)->queryAll();
        
        $loopPersediaan = false;
        $tree = [];
        foreach ($datas AS $data)
        {
            if (true)//Will always be called, we don't want to include to much detail
            {
                $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $data;
            }
            else if ($data['coaNo'] == '1114.0001')
            {
                //PIUTANG DAGANG CUSTOMER GD -> SO
                $piutangQuery = "SELECT IFNULL(rootCoa.coaNo, '-') AS rootCoaNo, IFNULL(rootCoa.description, '-') AS rootCoaDescription, 
                parentCoa.coaNo AS parentCoaNo, parentCoa.description AS parentCoaDescription,
                coa.coaNo, CONCAT('Piutang Dagang ', IFNULL(customer.customerName, '-')) AS description,
                (
                        SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
                        LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsdeliveryhead AS gd ON gd.goodsDeliveryNum = th.refNum
                        LEFT JOIN tr_salesorderhead AS so ON so.salesOrderNum = gd.refNum
                        LEFT JOIN ms_customer AS cust ON cust.customerID = so.customerID
                        WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') 
                        AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
                    AND cust.customerID = customer.customerID
                ) AS amount,
                (
                        SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
                        LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsdeliveryhead AS gd ON gd.goodsDeliveryNum = th.refNum
                        LEFT JOIN tr_salesorderhead AS so ON so.salesOrderNum = gd.refNum
                        LEFT JOIN ms_customer AS cust ON cust.customerID = so.customerID
                        WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') AND th.journalDate < '$startDate'
                        AND cust.customerID = customer.customerID
                ) AS lastAmount
                FROM tr_journaldetail AS detail
                LEFT JOIN tr_journalhead AS head ON head.journalHeadID = detail.journalheadID
                LEFT JOIN ms_coa AS coa ON detail.coaNo = coa.coaNo
                LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(detail.coaNo, 1, 4) = parentCoa.coaNo
                LEFT JOIN ms_coa AS rootCoa ON SUBSTRING(detail.coaNo, 1, 3) = rootCoa.coaNo
                LEFT JOIN tr_goodsdeliveryhead AS delivery ON delivery.goodsDeliveryNum = head.refNum
                LEFT JOIN tr_salesorderhead AS sales ON sales.salesOrderNum = delivery.refNum
                LEFT JOIN ms_customer AS customer ON customer.customerID = sales.customerID
                WHERE detail.coaNo LIKE '1114.0001'
                GROUP BY customer.customerID
                HAVING amount != 0 OR lastAmount != 0
                ORDER BY coa.coaNo ASC, coaNo ASC";

                $details = $connection->createCommand($piutangQuery)->queryAll();
                foreach ($details as $detail)
                {
                    $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $detail;
                }
            } 
            else if (explode('.', $data['coaNo'])[0] == '1119')
            {
                //PERSEDIAAN 1119% GR -> DETAIL -> PRODUCT || GD -> DETAIL PRODUCT
                $persediaanQuery = "SELECT IFNULL(rootCoa.coaNo, '-') AS rootCoaNo, IFNULL(rootCoa.description, '-') AS rootCoaDescription, 
                parentCoa.coaNo AS parentCoaNo, parentCoa.description AS parentCoaDescription,
                coa.coaNo, CONCAT('Persediaan ', IFNULL(product.productName, '-')) AS description,
                (
                    SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
                    LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsdeliverydetail AS del on del.goodsDeliveryNum = th.refNum
                    LEFT JOIN tr_goodsreceiptdetail AS rec ON rec.goodsReceiptNum = th.refNum
                    LEFT JOIN ms_product AS prod ON prod.productID = IFNULL(del.productID, rec.productID)
                    WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') 
                    AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
                    AND prod.productID = product.productID
                ) AS amount,
                (
                    SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
                    LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsdeliverydetail AS del on del.goodsDeliveryNum = th.refNum
                    LEFT JOIN tr_goodsreceiptdetail AS rec ON rec.goodsReceiptNum = th.refNum
                    LEFT JOIN ms_product AS prod ON prod.productID = IFNULL(del.productID, rec.productID)
                    WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') AND th.journalDate < '$startDate'
                    AND prod.productID = product.productID
                ) AS lastAmount
                FROM tr_journaldetail AS detail
                LEFT JOIN tr_journalhead AS head ON head.journalHeadID = detail.journalheadID
                LEFT JOIN ms_coa AS coa ON detail.coaNo = coa.coaNo
                LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(detail.coaNo, 1, 4) = parentCoa.coaNo
                LEFT JOIN ms_coa AS rootCoa ON SUBSTRING(detail.coaNo, 1, 3) = rootCoa.coaNo
                LEFT JOIN tr_goodsdeliverydetail AS delivery on delivery.goodsDeliveryNum = head.refNum
                LEFT JOIN tr_goodsreceiptdetail AS receipt ON receipt.goodsReceiptNum = head.refNum
                LEFT JOIN ms_product AS product ON product.productID = IFNULL(delivery.productID, receipt.productID)
                WHERE detail.coaNo LIKE '1119%'
                GROUP BY product.productID
                HAVING amount != 0 OR lastAmount != 0
                ORDER BY product.productName ASC";
                
                if (!$loopPersediaan)
                {
                    $details = $connection->createCommand($persediaanQuery)->queryAll();
                    foreach ($details as $detail)
                    {
                        $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $detail;
                    }
                }
                $loopPersediaan = true;
            }
            else if ($data['coaNo'] == '1120.0002')
            {
                //UANG MUKA SUPPLIER 
                $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $data;
            }
            else if ($data['coaNo'] == '1120.0003')
            {
                //UANG MUKA CUSTOMER
                $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $data;
            }
            else if ($data['coaNo'] == '2111.0001')
            {
                //HUTANG DAGANG SUPPLER GR -> PO
                $hutang = "SELECT IFNULL(rootCoa.coaNo, '-') AS rootCoaNo, IFNULL(rootCoa.description, '-') AS rootCoaDescription, 
                parentCoa.coaNo AS parentCoaNo, parentCoa.description AS parentCoaDescription,
                coa.coaNo, CONCAT('Hutang Dagang ', supplier.supplierName) AS description,
                (
                    SELECT CEIL(ABS(IFNULL(SUM(td.drAmount - td.crAmount), 0))) FROM tr_journaldetail AS td
                    LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsreceipthead AS gd ON gd.goodsReceiptNum = th.refNum
                    LEFT JOIN tr_purchaseorderhead AS po ON po.purchaseOrderNum = gd.refNum
                    LEFT JOIN ms_supplier AS supp ON supp.supplierID = po.supplierID
                    WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') 
                    AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
                    AND supp.supplierID = supplier.supplierID
                ) AS amount,
                (
                    SELECT CEIL(ABS(IFNULL(SUM(td.drAmount - td.crAmount), 0))) FROM tr_journaldetail AS td
                    LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsreceipthead AS gd ON gd.goodsReceiptNum = th.refNum
                    LEFT JOIN tr_purchaseorderhead AS po ON po.purchaseOrderNum = gd.refNum
                    LEFT JOIN ms_supplier AS supp ON supp.supplierID = po.supplierID
                    WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') AND th.journalDate < '$startDate'
                    AND supp.supplierID = supplier.supplierID
                ) AS lastAmount
                FROM tr_journaldetail AS detail
                LEFT JOIN tr_journalhead AS head ON head.journalHeadID = detail.journalheadID
                LEFT JOIN ms_coa AS coa ON detail.coaNo = coa.coaNo
                LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(detail.coaNo, 1, 4) = parentCoa.coaNo
                LEFT JOIN ms_coa AS rootCoa ON SUBSTRING(detail.coaNo, 1, 3) = rootCoa.coaNo
                LEFT JOIN tr_goodsreceipthead AS receipt ON receipt.goodsReceiptNum = head.refNum
                LEFT JOIN tr_purchaseorderhead AS purchase ON purchase.purchaseOrderNum = receipt.refNum
                LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = purchase.supplierID
                WHERE detail.coaNo LIKE '2111.0001' AND head.transactionType = 'Goods Receipt' AND receipt.transType = 'Purchase Order'
                GROUP BY supplier.supplierID
                HAVING amount != 0 OR lastAmount != 0
                ORDER BY coa.coaNo ASC, coaNo ASC";
                
                $details = $connection->createCommand($hutang)->queryAll();
                foreach ($details as $detail)
                {
                    $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $detail;
                }
            }
            else if ($data['coaNo'] == '4110.0002')
            {
                //PENJUALAN LOKAL GD -> DETAIL -> PRODUCT
                $penjualan = "SELECT IFNULL(rootCoa.coaNo, '-') AS rootCoaNo, IFNULL(rootCoa.description, '-') AS rootCoaDescription, 
                parentCoa.coaNo AS parentCoaNo, parentCoa.description AS parentCoaDescription,
                coa.coaNo, CONCAT('Penjualan ', product.productName) AS description, 
                (
                    SELECT CEIL(ABS(IFNULL(SUM(td.drAmount - td.crAmount), 0))) FROM tr_journaldetail AS td
                    LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsdeliverydetail AS del ON del.goodsDeliveryNum = th.refNum
                    LEFT JOIN ms_product AS prod ON prod.productID = del.productID
                    WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') 
                    AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
                    AND prod.productID = product.productID
                ) AS amount,
                (
                    SELECT CEIL(ABS(IFNULL(SUM(td.drAmount - td.crAmount), 0))) FROM tr_journaldetail AS td
                    LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsdeliverydetail AS del ON del.goodsDeliveryNum = th.refNum
                    LEFT JOIN ms_product AS prod ON prod.productID = del.productID
                    WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') AND th.journalDate < '$startDate'
                    AND prod.productID = product.productID
                ) AS lastAmount
                FROM tr_journaldetail AS detail
                LEFT JOIN tr_journalhead AS head ON head.journalHeadID = detail.journalheadID
                LEFT JOIN ms_coa AS coa ON detail.coaNo = coa.coaNo
                LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(detail.coaNo, 1, 4) = parentCoa.coaNo
                LEFT JOIN ms_coa AS rootCoa ON SUBSTRING(detail.coaNo, 1, 3) = rootCoa.coaNo
                LEFT JOIN tr_goodsdeliverydetail AS deliveryDetail ON deliveryDetail.goodsDeliveryNum = head.refNum
                LEFT JOIN ms_product AS product ON product.productID = deliveryDetail.productID
                WHERE detail.coaNo LIKE '4110.0002%'
                GROUP BY deliveryDetail.productID
                HAVING amount != 0 OR lastAmount != 0
                ORDER BY coa.coaNo ASC, coaNo ASC";
                
                
                $details = $connection->createCommand($penjualan)->queryAll();
                foreach ($details as $detail)
                {
                    $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $detail;
                }
            }
            else
            {
                $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $data;
            }
        }
        
        $content = $this->renderPartial('report_balancesheet_detail', [
            'datas' => $datas,
            'tree' => $tree,
            'monthStart' => $monthStart,
            'yearStart' => $yearStart,
            'monthEnd' => $monthEnd,
            'yearEnd' => $yearEnd,
        ]);  
        
        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        
        $mpdf->Output("Balance_Sheet-Detail-Report_$month-$year.pdf", 'I');
    }
    
    public function actionProfitLoss ($startDate, $endDate)
    {
        $startDate =  date('Y-m-d', strtotime($startDate));
        $endDate =  date('Y-m-d', strtotime($endDate));
       
        $monthYearStart = explode('-', $startDate);
        $monthStart = $monthYearStart[0];
        $yearStart = $monthYearStart[1];
        
        $monthYearEnd = explode('-', $endDate);
        $monthEnd = $monthYearEnd[0];
        $yearEnd = $monthYearEnd[1];
        
        $startYear = date('Y', strtotime($endDate));
        $tillDateStart = "$startYear"."-01-01";
        //AppHelper::showVarDump($tillDateStart);

       
        $connection = AppHelper::getDbConnection();
        $query = "SELECT rootCoa.description AS rootCoaDescription, rootCoa.coaNo AS rootCoaNo, 
        parentCoa.description AS parentCoaDescription, parentCoa.coaNo AS parentCoaNo, 
        coa.description, 
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(parentCoa.coaNo, '%') 
            AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
        ) AS thisMonth,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(parentCoa.coaNo, '%')
            AND (th.journalDate BETWEEN '$tillDateStart' AND '$endDate')
        ) AS tillThisMonth
        FROM tr_journaldetail AS detail
        LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
        LEFT JOIN ms_coa AS coa ON detail.coaNo = coa.coaNo
        LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(coa.coaNo, 1, 4) = parentCoa.coaNo
        LEFT JOIN ms_coa AS rootCoa ON SUBSTRING(coa.coaNo, 1, 3) = rootCoa.coaNo
        WHERE (coa.coaNo LIKE '411%' || coa.coaNo LIKE '511%' || coa.coaNo LIKE '611%' || coa.coaNo LIKE '711%')
        AND (head.journalDate BETWEEN '$tillDateStart' AND '$endDate')
        GROUP BY parentCoa.coaNo
        HAVING thisMonth != 0 OR tillThisMonth != 0
        ORDER BY rootCoaNo, parentCoaDescription";
        $datas = $connection->createCommand($query)->queryAll();
        
        $content = $this->renderPartial('report_profitloss', [
            'datas' => $datas,
            'monthStart' => $monthStart,
            'yearStart' => $yearStart,
            'monthEnd' => $monthEnd,
            'yearEnd' => $yearEnd,
        ]);  
        
        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        
        $mpdf->Output("Profit_Loss_Report-$month-$year.pdf",'I');
    }
    
    public function actionProfitLossDetail ($startDate, $endDate)
    {
        $startDate =  date('Y-m-d', strtotime($startDate));
        $endDate =  date('Y-m-d', strtotime($endDate));
       
        $monthYearStart = explode('-', $startDate);
        $monthStart = $monthYearStart[0];
        $yearStart = $monthYearStart[1];
        
        $monthYearEnd = explode('-', $endDate);
        $monthEnd = $monthYearEnd[0];
        $yearEnd = $monthYearEnd[1];
        
        $startYear = date('Y', strtotime($endDate));
        $tillDateStart = "$startYear"."-01-01";
        
        $connection = AppHelper::getDbConnection();
        $query = "SELECT rootCoa.description AS rootCoaDescription, rootCoa.coaNo AS rootCoaNo, 
        parentCoa.description AS parentCoaDescription, parentCoa.coaNo AS parentCoaNo, 
        coa.description, coa.coaNo,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') 
            AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
        ) AS thisMonth,
        (
            SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
            LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
            WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%')
            AND (th.journalDate BETWEEN '$tillDateStart' AND '$endDate')
        ) AS tillThisMonth
        FROM tr_journaldetail AS detail
        LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
        LEFT JOIN ms_coa AS coa ON detail.coaNo = coa.coaNo
        LEFT JOIN ms_coa AS parentCoa ON SUBSTRING(coa.coaNo, 1, 4) = parentCoa.coaNo
        LEFT JOIN ms_coa AS rootCoa ON SUBSTRING(coa.coaNo, 1, 3) = rootCoa.coaNo
        WHERE (coa.coaNo LIKE '411%' || coa.coaNo LIKE '511%' || coa.coaNo LIKE '611%' || coa.coaNo LIKE '711%')
        AND (head.journalDate BETWEEN '$startDate' AND '$endDate')
        GROUP BY coa.coaNo
        HAVING thisMonth != 0 OR tillThisMonth != 0
        ORDER BY rootCoaNo, parentCoaDescription";
        $datas = $connection->createCommand($query)->queryAll();
        
        $tree = [];
        foreach ($datas AS $data)
        {
            if ($data['coaNo'] == '4110.0002')
            {
                $salesQuery = "SELECT rootCoa.description AS rootCoaDescription, rootCoa.coaNo AS rootCoaNo, 
                parentCoa.description AS parentCoaDescription, parentCoa.coaNo AS parentCoaNo, 
                CONCAT('Penjualan ', product.productName) AS description, coa.coaNo,
                (
                    SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
                    LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsdeliverydetail AS sd ON th.refNUm = sd.goodsDeliveryNum
                    WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') AND sd.productID = sales.productID
                    AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
                ) AS thisMonth,
                (
                    SELECT CEIL(IFNULL(SUM(td.drAmount - td.crAmount), 0)) FROM tr_journaldetail AS td
                    LEFT JOIN tr_journalhead AS th ON td.journalHeadID = th.journalHeadID
                    LEFT JOIN tr_goodsdeliverydetail AS sd ON th.refNUm = sd.goodsDeliveryNum
                    WHERE td.coaNo LIKE CONCAT(coa.coaNo, '%') AND sd.productID = sales.productID
                    AND (th.journalDate BETWEEN '$startDate' AND '$endDate')
                ) AS tillThisMonth,
                head.transactionType, sales.goodsDeliveryNum
                FROM tr_journaldetail AS detail
                LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
                LEFT JOIN ms_coa AS coa ON detail.coaNo = coa.coaNo
                LEFT JOIN ms_coa AS parentCoa ON parentCoa.coaNo = SUBSTRING(coa.coaNo, 1, 4)
                LEFT JOIN ms_coa AS rootCoa ON rootCoa.coaNo = SUBSTRING(coa.coaNo, 1, 3)
                LEFT JOIN tr_goodsdeliverydetail AS sales ON head.refNUm = sales.goodsDeliveryNum
                LEFT JOIN ms_product AS product ON product.productID = sales.productID
                WHERE (coa.coaNo LIKE '4110.0002%')
                AND (head.journalDate BETWEEN '$startDate' AND '$endDate')
                GROUP BY sales.productID
                HAVING thisMonth != 0 OR tillThisMonth != 0
                ORDER BY rootCoaNo, parentCoaDescription, product.productName";
                
                $saleses = $connection->createCommand($salesQuery)->queryAll();
                foreach ($saleses as $sales)
                {
                    $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $sales;
                }
            } else
            {
                $tree[$data['rootCoaDescription']][$data['parentCoaDescription']][] = $data;
            }
        }
        
        $content = $this->renderPartial('report_profitloss_detail', [
            'datas' => $datas,
            'tree' => $tree,
            'monthStart' => $monthStart,
            'yearStart' => $yearStart,
            'monthEnd' => $monthEnd,
            'yearEnd' => $yearEnd,
        ]);
        
        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        
        $mpdf->Output("Profit_Loss_Report_Detail-$month-$year.pdf",'I');
    }
    public function actionPutra()
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();

        $sql=   "SELECT product.productName, product.origin, supplier.supplierName, detail.qty,
                po.purchaseOrderNum, customer.customerName, po.purchaseOrderDate, po.purchaseOrderNum,
                so.customerOrderNum, IFNULL(receiptHead.pibRate,0) AS importRate, IFNULL(importDuty.importDutyAmount,0)AS customs,
                IFNULL(importDutyAmount,0) + IFNULL(PPNImportAmount,0) + IFNULL(PPHImportAmount,0) + IFNULL(otherCostAmount, 0) + IFNULL(taxInvoiceAmount,0) AS landedCost
                FROM tr_goodsdeliverydetail AS detail
                LEFT JOIN tr_goodsdeliveryhead AS head ON detail.goodsDeliveryNum = head.goodsDeliveryNum
                LEFT JOIN tr_salesorderhead AS so ON so.salesOrderNum = head.refnum
                LEFT JOIN ms_customer AS customer ON customer.customerID = so.customerID
                LEFT JOIN ms_product AS product ON product.productID = detail.productID
                LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = product.supplierID
                LEFT JOIN tr_stockhpp AS stock ON stock.batchNumber = detail.batchNumber
                LEFT JOIN tr_goodsreceipthead AS receiptHead ON receipthead.goodsReceiptNum = stock.refNum
                LEFT JOIN tr_goodsreceiptcost AS importDuty ON importDuty.goodsReceiptNum = receiptHead.goodsReceiptNum
                LEFT JOIN tr_purchaseorderhead AS po ON po.purchaseOrderNum = receiptHead.refNum;";
        $command = $connection->createCommand($sql);
        $model = $command->queryAll();  
        
        $objPHPExcel = new PHPExcel();
        $sheet=0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(27);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(23);
        
        $objPHPExcel->getActiveSheet()->getStyle("A1:W4")->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setTitle('xxx')
            ->setCellValue('A1', 'Local Sales Performance in IDR')
            ->setCellValue('A3', 'Purchase Order')
            ->setCellValue('A4', 'Date')
            ->setCellValue('B4', 'No')
            ->setCellValue('C3', 'Principal')
            ->setCellValue('D3', 'Origin')
            ->setCellValue('E3', 'Product')
            ->setCellValue('F3', 'Import Purchase')
            ->setCellValue('F4', 'Qty')  
            ->setCellValue('G4', 'CNF/CIF')
            ->setCellValue('H4', 'Customs')
            ->setCellValue('I4', 'Rate')
            ->setCellValue('J4', 'Landed')
            ->setCellValue('K4', 'Landed in IDR')  
            ->setCellValue('L3', 'Customer')
            ->setCellValue('L4', 'Name')
            ->setCellValue('M4', 'Po Cust No')
            ->setCellValue('N4', 'Qtty')
            ->setCellValue('O4', 'Unit Price')
            ->setCellValue('P3', 'Commision')
            ->setCellValue('P4', '-')  
            ->setCellValue('Q4', 'Out Of C/P')
            ->setCellValue('R3', 'Nett Profit')
            ->setCellValue('R4', 'IDR')
            ->setCellValue('S4', '%')
            ->setCellValue('T3', 'Invoice Pricipal')
            ->setCellValue('U3', 'Remarks')
            ->setCellValue('V3', 'Total Sales Local By Customer')
            ->setCellValue('V4', 'IDR')
            ->setCellValue('W3', 'Total Import By Pricipal')
            ->setCellValue('W4', 'IDR');
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:W1');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
        $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
        $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:K3');
        $objPHPExcel->getActiveSheet()->mergeCells('L3:O3');
        $objPHPExcel->getActiveSheet()->mergeCells('P3:Q3');
        $objPHPExcel->getActiveSheet()->mergeCells('R3:S3');
        $objPHPExcel->getActiveSheet()->mergeCells('T3:T4');
        $objPHPExcel->getActiveSheet()->mergeCells('U3:U4');
        
        $style = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );
            
        $styleRight = array(
                        'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        )
                );

        $styleLeft = array(
                        'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        )
                );

        $allBorder = array (
                'borders' => [
                    'allborders' => [
                        'style'  => 'thin',
                        'color'  => [
                        'rgb'    => '000000'

                        ]
                    ]
                ]
            );

         $allBorderoutline = array (
                'borders' => [
                    'allborders' => [
                        'style'  => 'medium',
                        'color'  => [
                        'rgb'    => '000000'

                        ]
                    ]
                ]
            );
         
         $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('M4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('N4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('P3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('P4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('Q4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('R3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('R4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('S4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('T3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('U3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('V3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('V4')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('W3')->applyFromArray($style);
         $objPHPExcel->getActiveSheet()->getStyle('W4')->applyFromArray($style);

         $row=5;
            foreach ($model as $foo) {      
                
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['purchaseOrderDate']);
         $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['purchaseOrderNum']);
         $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['supplierName']);
         $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['origin']);
         $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['productName']);
         $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['qty']);
         //$objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['-']);
         $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['customs'], 0, ',', '.');
         $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo['importRate']);
         $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$foo['landedCost']);
         //$objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$foo['-']);
         $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$foo['customerName']);
         $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$foo['customerOrderNum']);
         $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$foo['qty']);
         
         $objPHPExcel->getActiveSheet()->getStyle('A3:W'.$row)->applyFromArray($allBorder);
         $objPHPExcel->getActiveSheet()->getStyle('M4'.$row)->applyFromArray($styleLeft);
  
            $row++ ;
            }
            
            header('Content-Type: application/vnd.ms-excel');
            $filename = "Sales_Performance_".date("d-m-Y-His").".xls";
            header('Content-Disposition: attachment;filename='.$filename .' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
   
    public function actionTrialBalance($startDate, $endDate)
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        
        $startDate =  date('Y-m-d', strtotime($startDate));
        $endDate =  date('Y-m-d', strtotime($endDate));
       
        $monthYearStart = explode('-', $startDate);
        $yearStart = $monthYearStart[0];
        $monthStart = $monthYearStart[1];
        $dateStart = $monthYearStart[2];
        
        $monthYearEnd = explode('-', $endDate);
        $yearEnd = $monthYearEnd[0];
        $monthEnd = $monthYearEnd[1];
        $dateEnd = $monthYearEnd[2];
        
      
        
        $filterCoa = '';
        if($monthStart == 01 && $monthEnd == 01 )
            $filterCoa = "AND  SUBSTRING(account.coaNo,1, 1)  IN('1','2','3')";
        
        
        $sql = "SELECT account.coaNo,description,
            (
                SELECT IFNULL(SUM(detail.drAmount - detail.crAmount),0) FROM tr_journaldetail AS detail 
                LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
                WHERE detail.coaNo = account.coaNo AND head.journalDate < '$startDate'
                $filterCoa
            ) AS saldoAwal,
            (
                SELECT SUM(detail.drAmount) FROM tr_journaldetail AS detail 
                LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
                WHERE detail.coaNo = account.coaNo AND head.journalDate BETWEEN '$startDate' AND '$endDate'
            ) AS mutasiDebit,
            (
                SELECT IFNULL(SUM(detail.crAmount),0) FROM tr_journaldetail AS detail 
                LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
                WHERE detail.coaNo = account.coaNo AND head.journalDate BETWEEN '$startDate' AND '$endDate'
            ) AS mutasiCredit
            FROM tr_journaldetail AS account 
            JOIN ms_coa AS msCoa ON account.coaNo = msCoa.coaNo
            GROUP BY account.coaNo;";
        
            $command = $connection->createCommand($sql);
            $model = $command->queryAll();
       
            $objPHPExcel = new PHPExcel();
            $sheet=0;
            $objPHPExcel->setActiveSheetIndex($sheet);
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            
            $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("B5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("C5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("C6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("D6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("E5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("F6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("G5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("G6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("H6")->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->setTitle('xxx')
                ->setCellValue('A1', 'PT.QWINJAYA ADITAMA')
                ->setCellValue('A2', 'TRIAL BALANCE')  
                ->setCellValue('A3', "Bulan: $monthStart / $yearStart - $monthEnd / $yearEnd")
                ->setCellValue('A5', 'NO.ACC')
                ->setCellValue('B5', 'KETERANGAN ACC')
                ->setCellValue('C5', 'SALDO AWAL')
                ->setCellValue('C6', 'DEBIT')
                ->setCellValue('D6', 'CREDIT')    
                ->setCellValue('E5', 'MUTASI')
                ->setCellValue('E6', 'DEBIT')
                ->setCellValue('F6', 'CREDIT')
                ->setCellValue('G5', 'SALDO AKHIR')
                ->setCellValue('G6', 'DEBIT')
                ->setCellValue('H6', 'CREDIT'); 
            
            $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
            $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:F5');
            $objPHPExcel->getActiveSheet()->mergeCells('G5:H5');
            
            $style = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );
            

            $styleRight = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );

            $styleLeft = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );
            
            $allBorder = array (
                    'borders' => [
                        'allborders' => [
                            'style'  => 'thin',
                            'color'  => [
                            'rgb'    => '000000'
                                
                            ]
                        ]
                    ]
                );
            
             $allBorderoutline = array (
                    'borders' => [
                        'allborders' => [
                            'style'  => 'medium',
                            'color'  => [
                            'rgb'    => '000000'
                                
                            ]
                        ]
                    ]
                );
           
                        
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('F5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($style);
            
            $row=7;
            foreach ($model as $foo) {
                $saldoAwal = number_format(abs(ceil(floatval($foo['saldoAwal']))), 0, ',', '.');
                $mutasiDebit = number_format(ceil(floatval($foo['mutasiDebit'])), 0, ',', '.');
                $mutasiCredit = number_format(ceil(floatval($foo['mutasiCredit'])), 0, ',', '.');
                $saldoAkhir = floatval($foo['mutasiDebit']) - floatval($foo['mutasiCredit']) + floatval($foo['saldoAwal']);
                $saldoAkhirFormat = number_format(abs(ceil($saldoAkhir)));
                
                if(($foo['saldoAwal']) > 0)
                    $totalSaldoAwalDebit += $foo['saldoAwal'];
                else
                    $totalSaldoAwalCredit += abs($foo['saldoAwal']);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['coaNo']); 
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['description']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,0);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,0);
                $objPHPExcel->getActiveSheet()->setCellValue((floatval($foo['saldoAwal']) > 0 ? 'C' : 'D').$row, $saldoAwal);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, ' '.$mutasiDebit);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, ' '.$mutasiCredit);
               
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleLeft);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleRight);   
                $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('A5:H'.$row)->applyFromArray($allBorder);
                
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,0);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,0);
                $objPHPExcel->getActiveSheet()->setCellValue(($saldoAkhir > 0 ? 'G' : 'H').$row, $saldoAkhirFormat);
                
                $row++ ;
            }
            
            //$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,0);
            //$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,0);
            //$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, number_format($totalSaldoAwalDebit), 0, ',', '.');
            //$objPHPExcel->getActiveSheet()->setCellValue('D'.$row,  number_format($totalSaldoAwalCredit), 0, ',', '.');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
            //header('Content-Type: application/vnd.ms-excel');
            $filename = "Trial_Balance_".date("d-m-Y-His").".xlsx";
            header('Content-Disposition: attachment;filename='.$filename .' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $objWriter->save('php://output');
            die();
    }
   
    public function actionTrialBalance1($monthYear)
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        
        $monthYearArr = explode('-', $monthYear);
        $month = $monthYearArr[0];
        $year = $monthYearArr[1];
        
        
        $sql = "SELECT account.coaNo,description,
            (
                SELECT IFNULL(SUM(detail.drAmount - detail.crAmount),0) FROM tr_journaldetail AS detail 
                LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
                WHERE detail.coaNo = account.coaNo AND head.journalDate < DATE('$year-$month-01')
            ) AS saldoAwal,
            (
                SELECT SUM(detail.drAmount) FROM tr_journaldetail AS detail 
                LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
                WHERE detail.coaNo = account.coaNo AND head.journalDate BETWEEN '$year-$month-01' AND LAST_DAY('$year-$month-01')
            ) AS mutasiDebit,
            (
                SELECT IFNULL(SUM(detail.crAmount),0) FROM tr_journaldetail AS detail 
                LEFT JOIN tr_journalhead AS head ON detail.journalHeadID = head.journalHeadID
                WHERE detail.coaNo = account.coaNo AND head.journalDate BETWEEN '$year-$month-01' AND LAST_DAY('$year-$month-01')
            ) AS mutasiCredit
            FROM tr_journaldetail AS account 
            JOIN ms_coa AS msCoa ON account.coaNo = msCoa.coaNo
            GROUP BY account.coaNo;";
         $command = $connection->createCommand($sql);
            $model = $command->queryAll();

            $objPHPExcel = new PHPExcel();
            $sheet=0;
            $objPHPExcel->setActiveSheetIndex($sheet);
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            
            $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("B5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("C5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("C6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("D6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("E5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("E6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("F6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("G5")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("G6")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("H6")->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->setTitle('xxx')
                ->setCellValue('A1', 'PT.QWINJAYA ADITAMA')
                ->setCellValue('A2', 'TRIAL BALANCE')  
                ->setCellValue('A3', "Bulan: $month / $year")
                ->setCellValue('A5', 'NO.ACC')
                ->setCellValue('B5', 'KETERANGAN ACC')
                ->setCellValue('C5', 'SALDO AWAL')
                ->setCellValue('C6', 'DEBIT')
                ->setCellValue('D6', 'CREDIT')    
                ->setCellValue('E5', 'MUTASI')
                ->setCellValue('E6', 'DEBIT')
                ->setCellValue('F6', 'CREDIT')
                ->setCellValue('G5', 'SALDO AKHIR')
                ->setCellValue('G6', 'DEBIT')
                ->setCellValue('H6', 'CREDIT'); 
            
            $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
            $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:F5');
            $objPHPExcel->getActiveSheet()->mergeCells('G5:H5');

            
            $style = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );
            

            $styleRight = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );

            $styleLeft = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );
            
            $allBorder = array (
                    'borders' => [
                        'allborders' => [
                            'style'  => 'thin',
                            'color'  => [
                            'rgb'    => '000000'
                                
                            ]
                        ]
                    ]
                );
            
             $allBorderoutline = array (
                    'borders' => [
                        'allborders' => [
                            'style'  => 'medium',
                            'color'  => [
                            'rgb'    => '000000'
                                
                            ]
                        ]
                    ]
                );
                
            //$styleArray = array(
                            //'borders' => array(
                            //'allborders' => array(
                            //'style' => PHPExcel_Style_Border::BORDER_THIN
                           // )
                          //)
                        //);
                        //$objPHPExcel->getActiveSheet()->getStyle('A1:B2')->applyFromArray($styleArray);
                        //unset($styleArray);
                        
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('F5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($style);
            
            $row=7;
            foreach ($model as $foo) {
                $saldoAwal = number_format(abs(ceil(floatval($foo['saldoAwal']))), 0, ',', '.');
                $mutasiDebit = number_format(ceil(floatval($foo['mutasiDebit'])), 0, ',', '.');
                $mutasiCredit = number_format(ceil(floatval($foo['mutasiCredit'])), 0, ',', '.');
                $saldoAkhir = floatval($foo['mutasiDebit']) - floatval($foo['mutasiCredit']) + floatval($foo['saldoAwal']);
                $saldoAkhirFormat = number_format(abs(ceil($saldoAkhir)));
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['coaNo']); 
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['description']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,0);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,0);
                $objPHPExcel->getActiveSheet()->setCellValue((floatval($foo['saldoAwal']) > 0 ? 'C' : 'D').$row, $saldoAwal);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, ' '.$mutasiDebit);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, ' '.$mutasiCredit);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleLeft);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleRight);   
                $objPHPExcel->getActiveSheet()->getStyle('G'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('A5:H'.$row)->applyFromArray($allBorder);
                
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,0);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,0);
                $objPHPExcel->getActiveSheet()->setCellValue(($saldoAkhir > 0 ? 'G' : 'H').$row, $saldoAkhirFormat);
                
                $row++ ;
            }
            
            //header('Content-Type: application/vnd.ms-excel');
            $filename = "Trial_Balance_".date("d-m-Y-His").".xlsx";
            header('Content-Disposition: attachment;filename='.$filename .' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $objWriter->save('php://output');
            die();
    }
    
    public function actionGlreport($coaNo, $startDate, $endDate)
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        $startDate =  date('Y-m-d', strtotime($startDate));
        $endDate =  date('Y-m-d', strtotime($endDate));
       
        $monthYearStart = explode('-', $startDate);
        $monthStart = $monthYearStart[0];
        $yearStart = $monthYearStart[1];
        
        $monthYearEnd = explode('-', $endDate);
        $monthEnd = $monthYearEnd[0];
        $yearEnd = $monthYearEnd[1];
        
        
        $coaModel = MsCoa::findOne(['coaNo' => $coaNo]);

        $sql = "SELECT 
                COALESCE(ctf.voucherNum,  cash.voucherNum ,gl.voucherNum , csp.voucherNum, spp.voucherNum) AS voucherNum,
                head.refNum,head.journalDate,head.transactionType,head.notes,detail.coaNo,detail.drAmount,detail.crAmount,
                (
                    SELECT SUM(drAmount) FROM tr_journalhead head 
                    JOIN tr_journaldetail detail ON head.journalHeadID=detail.journalHeadID
                    WHERE detail.coaNo = '".$coaNo."' and head.journalDate BETWEEN '$startDate' AND '$endDate'
                ) AS grandTotalDebit, 
                (
                    SELECT SUM(crAmount) FROM tr_journalhead head
                    JOIN tr_journaldetail detail ON head.journalHeadID=detail.journalHeadID
                    WHERE detail.coaNo = '".$coaNo."' and head.journalDate BETWEEN '$startDate' AND '$endDate'
                ) AS grandTotalCredit
                FROM tr_journalhead head 
                JOIN tr_journaldetail detail ON head.journalHeadID=detail.journalHeadID
                LEFT JOIN tr_gltoglhead gl ON gl.gltoglNum = head.refNum
                LEFT JOIN tr_cashinouthead cash ON cash.cashInOutNum = head.refNum
                LEFT JOIN tr_cashbanktransfer ctf ON ctf.transferID = head.refNum
                LEFT JOIN tr_customerpayment csp ON csp.customerPaymentNum = head.refNum
                LEFT JOIN tr_supplierpaymenthead spp ON spp.supplierPaymentNum = head.refNum
                WHERE detail.coaNo = '".$coaNo."' and head.journalDate BETWEEN '$startDate' AND '$endDate' "
                . "ORDER BY head.journalDate ASC"
                 ;
                
        $command = $connection->createCommand($sql);
        $model = $command->queryAll();

        $objPHPExcel = new PHPExcel();
        $sheet=0;
        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);   
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->setTitle('xxx')
            ->setCellValue('A1', 'PT. QWINJAYA ADITAMA')
            ->setCellValue('A2', 'GL Transactions Listing')
            ->setCellValue('A3', 'Periode:'.$monthStart.'/'.$yearStart.'-'.$monthEnd.'/'.$yearEnd)                
            ->setCellValue('A6', 'Date')
            ->setCellValue('B6', 'Keterangan')
            ->setCellValue('C6', 'Ref Num')
            ->setCellValue('D6', 'Voucher')
            ->setCellValue('E6', 'Debit')
            ->setCellValue('F6', 'Credit')
            ->setCellValue('A7', 'No.Account :');


        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:E4');
        $objPHPExcel->getActiveSheet()->mergeCells('B7:F7');

        $objPHPExcel->getActiveSheet()->getStyle("A1:E7")->getFont()->setBold( true );

        $style = array(
                        'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        )
                );


        $styleRight = array(
                        'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        )
                );

        $styleLeft = array(
                        'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        )
                );
        $allBorder = array (
                'borders' => [
                    'allborders' => [
                        'style'  => 'thin',
                        'color'  => [
                        'rgb'    => '000000'

                        ]
                    ]
                ]
            );

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleLeft);
        $objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($style);

        $row = 7;
        $totalBalance = 0;
        foreach ($model as $item) { 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$item['coaNo']." - ".'('.nl2space($coaModel->description).')');
        }

        $row = 8;
        $totalBalance = 0;
        $countRow = 0;

        $subTotal = 0;
        $subTotal1 = 0;
        foreach ($model as $item) {  
            $countRow += $countRow ;
            $drAmount = number_format(abs(ceil(floatval($item['drAmount']))), 0, ',', '.');
            $crAmount = number_format(abs(ceil(floatval($item['crAmount']))), 0, ',', '.');
            $subTotal += $item['drAmount'];
            $subTotal1 += $item['crAmount'];
            $totalBalance = $subTotal1 - $subTotal ;
            $grandTotalDebit= number_format(abs(ceil(floatval($item['grandTotalDebit']))), 0, ',', '.');
            $grandTotalCredit= number_format(abs(ceil(floatval($item['grandTotalCredit']))), 0, ',', '.');
            $grandTotalBalance= floatval($item['grandTotalCredit']) - floatval($item['grandTotalDebit']) ;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,AppHelper::convertDateTimeFormat($item['journalDate'], 'Y-m-d H:i:s', 'd-M-Y')); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$item['transactionType']." - ".nl2space($item['notes'])." ");
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$item['refNum']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$item['voucherNum']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,' '.$drAmount);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,' '.$crAmount);
                        
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleLeft);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleRight);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleRight);    
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleRight);  
            $objPHPExcel->getActiveSheet()->getStyle('A6:F'.$row)->applyFromArray($allBorder);

            $row++ ;
        }
            $totalDebit = number_format($subTotal,0,",",".");
            $totalCredit = number_format($subTotal1,0,",",".");
            $totalRow = $countRow + $row ;
            $balance = number_format($totalBalance,0,",",".");
            $totalRowbalance = $countRow + $row +1 ;
            $totalRowgt = $countRow + $row +2;
            $gtBalance = number_format($grandTotalBalance,0,",",".");
            $totalRowgtbalance = $countRow + $row +3;
            
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$totalRow,'Subtotal        :');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$totalRowbalance,'Balance         :');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$totalRowgt,'Grand Total :');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$totalRowgtbalance,'Balance         :');

            $objPHPExcel->getActiveSheet()->setCellValue('E'.$totalRow,' '.$totalDebit);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$totalRow,' '.$totalCredit);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$totalRowbalance,' '.$balance);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$totalRowgt,' '.$grandTotalDebit);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$totalRowgt,' '.$grandTotalCredit);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$totalRowgtbalance,' '.$gtBalance);
            

            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleRight);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleRight);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$totalRowbalance)->applyFromArray($styleRight);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$totalRowgt)->applyFromArray($styleRight);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$totalRowgt)->applyFromArray($styleRight);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$totalRowgtbalance)->applyFromArray($styleRight);
            
            $objPHPExcel->getActiveSheet()->getStyle('A6:F'.$row)->applyFromArray($allBorder); 
            $objPHPExcel->getActiveSheet()->getStyle('A6:F'.$totalRowbalance)->applyFromArray($allBorder);
            $objPHPExcel->getActiveSheet()->getStyle('A6:F'.$totalRowgt)->applyFromArray($allBorder);
            $objPHPExcel->getActiveSheet()->getStyle('A6:F'.$totalRowgtbalance)->applyFromArray($allBorder);

            $objPHPExcel->getActiveSheet()->getStyle('F'.$totalRowbalance)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('C'.$totalRowbalance)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('C'.$totalRowgt)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('D'.$totalRowgt)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('F'.$totalRowgt)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('C'.$totalRowgtbalance)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('F'.$totalRowgtbalance)->getFont()->setBold( true );
            $row++;

        header('Content-Type: application/vnd.ms-excel');
        $filename = "GLReport_".$coaNo.".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output'); 
        die();
    }
    
    public function actionExcel($typeReport, $dateStart, $dateEnd, $coaNo)
    {
        
        if ($typeReport == 'Trial Balance'){
        
            $sql = "select  a.coaNo, a.description, ifnull(c.sumAmountAwal, 0) as sumAmountAwal, ifnull(d.sumAmount, 0) as sumAmount, ifnull(d.sumAmount, 0) - ifnull(c.sumAmountAwal,0) as movement
                    from ms_coa a
                    left join tr_journaldetail b on a.coano = b.coano
                    left join (
                        select  a.coaNo, a.description, ifnull(b.drAmount, 0), c.journalDate, ifnull(b.crAmount, 0), ifnull(sum(case when left(b.coaNo,1) in ('1') then drAmount - crAmount 
                        else case when left(b.coaNo,1) in ('2') then crAmount - drAmount 
                        else case when left(b.coaNo,1) in ('3') then crAmount - drAmount 
                        else case when left(b.coaNo,1) in ('5') then drAmount - crAmount 
                        else case when left(b.coaNo,1) in ('7') then crAmount - drAmount 
                        else case when left(b.coaNo,1) in ('8') then drAmount - crAmount 
                        end
                        end
                        end
                        end
                        end
                        end), 0) as sumAmountAwal
                        from ms_coa a
                        left join tr_journaldetail b on a.coaNo = b.coaNo
                        left join tr_journalhead c on b.journalHeadID = c.journalHeadID
                        where date_format(c.journalDate,'%d-%m-%Y') < '".$dateStart."'
                        group by a.coaNo
                        ) c on a.coaNo = c.coaNo
                    left join(
                        select  a.coaNo, a.description, ifnull(b.drAmount, 0), c.journalDate, ifnull(b.crAmount, 0), ifnull(sum(case when left(b.coaNo,1) in ('1') then drAmount - crAmount 
                        else case when left(b.coaNo,1) in ('2') then crAmount - drAmount 
                        else case when left(b.coaNo,1) in ('3') then crAmount - drAmount 
                        else case when left(b.coaNo,1) in ('5') then drAmount - crAmount 
                        else case when left(b.coaNo,1) in ('7') then crAmount - drAmount 
                        else case when left(b.coaNo,1) in ('8') then drAmount - crAmount 
                        end
                        end
                        end
                        end
                        end
                        end), 0) as sumAmount
                        from ms_coa a
                        left join tr_journaldetail b on a.coaNo = b.coaNo
                        left join tr_journalhead c on b.journalHeadID = c.journalHeadID
                        where date_format(c.journalDate,'%d-%m-%Y') < '".$dateEnd."'
                        group by a.coaNo
                        ) d on a.coaNo = d.coaNo
                    group by a.coaNo; ";
            $command = $connection->createCommand($sql);
            $model = $command->queryAll();

            $objPHPExcel = new PHPExcel();
            $sheet=0;
            $objPHPExcel->setActiveSheetIndex($sheet);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);            

            $objPHPExcel->getActiveSheet()->setTitle('xxx')
                ->setCellValue('A1', 'PT QWINJAYA ADITAMA')
                ->setCellValue('A2', 'TRIAL BALANCE')
                ->setCellValue('A3', $year)                
                ->setCellValue('A5', 'ACC NO.')
                ->setCellValue('B5', 'DESCRIPTION')
                ->setCellValue('C5', 'BALANCE '.$start)
                ->setCellValue('D5', $end)
                ->setCellValue('D6', 'MOVEMENT')
                ->setCellValue('E6', 'END. BALANCE 2017');

            $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
            $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:C6');
            $objPHPExcel->getActiveSheet()->mergeCells('D5:E5');
            $style = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );
            

            $styleRight = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );

            $styleLeft = array(
                            'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            )
                    );

            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($style);

            $row=7;
            foreach ($model as $foo) {  
                if($foo['sumAmountAwal'] == '0'){
                    $sumAmountAwal = '-';
                } else{
                    $sumAmountAwal = $foo['sumAmountAwal'];
                }
                if($foo['sumAmount'] == '0'){
                    $sumAmount = '-';
                } else{
                    $sumAmount = $foo['sumAmount'];
                }
                if($foo['movement'] == '0'){
                    $movement = '-';
                } else{
                    $movement = $foo['movement'];
                }
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['coaNo']); 
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['description']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$sumAmountAwal);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$movement);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$sumAmount);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleLeft);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleLeft);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleRight);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleRight);                   
                $row++ ;
            }

            header('Content-Type: application/vnd.ms-excel');
            $filename = "Trial_Balance_".date("d-m-Y-His").".xlsx";
            header('Content-Disposition: attachment;filename='.$filename .' ');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $objWriter->save('php://output');  
            die();
        }

        else if ($typeReport == 'Tax Recapitulation'){
            $yearArray = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            $yearCount = 1;

            $sql = "select date_format(c.journalDate,'%Y'),a.description,
                    CASE WHEN substr(b.coaNo,1,1)=1 THEN sum(b.drAmount-b.crAmount)
                        WHEN substr(b.coaNo,1,1)=2 THEN sum(b.crAmount-b.drAmount)
                        WHEN substr(b.coaNo,1,1)=5 THEN sum(b.drAmount-b.crAmount)
                    END as amount
                    from ms_coa a join tr_journaldetail b on a.coaNo=b.coaNo
                    join tr_journalhead c on b.journalHeadID=c.journalHeadID
                    where a.coaNo IN ('1122.0003','1112.0006','2115.0002','1122.0004','5110.0007','5110.0008')
                    group by b.coaNo, date_format(c.journalDate,'%Y')";

            $sqlYear = "select date_format(c.journalDate,'%Y') as year
                        from tr_journaldetail b join tr_journalhead c on b.journalHeadID=c.journalHeadID
                        where b.coaNo IN ('1122.0003','1112.0006','2115.0002','1122.0004','5110.0007','5110.0008')
                        group by date_format(c.journalDate,'%Y')";

            $command = $connection->createCommand($sql);
            $model = $command->queryAll();

            $commandYear = $connection->createCommand($sqlYear);
            $modelYear = $commandYear->queryAll();

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Jenis Pajak');
            foreach ($modelYear as $year) {  
                $objPHPExcel->getActiveSheet()->setCellValue($yearArray[$yearCount].'1', $modelYear['year']);
                $yearCount++;
            }

            $row=2;
            foreach ($model as $foo) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['description']); 
                    $year = $foo['year'];
                    
                    //$objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['2016']);
                    //$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['2017']);
                    
                    
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "TaxRecap_".date("Y").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output'); 
        die();
        }
    }
    
    
    
    public function actionTaxrecap()
    {
        $this->layout = false;
        $connection = MdlDb::getDbConnection();
        
        $alpha = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            $yearCount = 1;

            $sql = "select description, coaNo from ms_coa 
                    where coaNo IN ('1122.0003','1122.0006','2115.0002','1122.0004','5110.0007','5110.0008')
                    order by description";
            
            $sqlYear = "select date_format(c.journalDate,'%Y') as year
                        from tr_journaldetail b join tr_journalhead c on b.journalHeadID=c.journalHeadID
                        where b.coaNo IN ('1122.0003','1112.0006','2115.0002','1122.0004','5110.0007','5110.0008')
                        group by date_format(c.journalDate,'%Y')";

            $command = $connection->createCommand($sql);
            $model = $command->queryAll();

            $commandYear = $connection->createCommand($sqlYear);
            $modelYear = $commandYear->queryAll();
            
            $phpExcel = new \PHPExcel();
            $sheet=0;
            $phpExcel->setActiveSheetIndex($sheet);
            $xSheet = $phpExcel->getActiveSheet();
            $xSheet->getColumnDimension('B')->setWidth(70);

            $xDrawing = new \PHPExcel_Worksheet_Drawing();
            $xDrawing->setName('Thumb');
            $xDrawing->setDescription('Thumbnail Image');
            $xDrawing->setPath(Yii::$app->basePath . '/assets_b/images/logonew.png');
            $xDrawing->setHeight(80);
            $xDrawing->setWidth(120);
            $xDrawing->setCoordinates('B1');
            $xDrawing->setOffsetX(195);
            $xDrawing->setWorksheet($phpExcel->getActiveSheet());
            $xSheet->mergeCells('B10:B11');
            $xSheet->mergeCells('A10:A11');
            $counts = 2;
            foreach ($modelYear as $rowss) {
                              
                $xSheet->getColumnDimension($alpha[$counts])->setWidth(30); 
                $phpExcel->getActiveSheet()->setTitle('Tax Recap Report')
                    ->setCellValue('A10', 'No.')
                    ->setCellValue('C10', 'Year')
                    ->setCellValue('B10', 'Jenis Pajak')
                    ->setCellValue('B7', 'PT. Qwinjaya Aditama')
                    ->setCellValue('B8', 'Tax Payable')
                    ->setCellValue($alpha[$counts].'11', $rowss['year'])
                     ->setCellValue($alpha[$counts].'11', $rowss['year']);
                $xSheet->getStyle($alpha[$counts].'11')->applyFromArray(ExcelFormatter::$tableHeader);
                
                $no = 1;
                $rowx=12;
                $totalAll = 0;
                foreach ($model as $modelx)
                {
                    
                    $data = " select a.description, a.coaNo, 
                    CASE WHEN substr(b.coaNo,1,1)=1 THEN sum(b.drAmount-b.crAmount)
                        WHEN substr(b.coaNo,1,1)=2 THEN sum(b.crAmount-b.drAmount)
                        WHEN substr(b.coaNo,1,1)=5 THEN sum(b.drAmount-b.crAmount)
                    END as amount
                    from ms_coa a join tr_journaldetail b on a.coaNo=b.coaNo
                    join tr_journalhead c on b.journalHeadID=c.journalHeadID
                    where a.coaNo = '".$modelx['coaNo']."' AND date_format(c.journalDate,'%Y') = '".$rowss['year']."'
                    group by b.coaNo" ;
                    $commandData = $connection->createCommand($data);
                    $modelData= $commandData->queryAll();
                    
                    foreach ($modelData as $row ) {
                        $xSheet->setCellValue($alpha[$counts].$rowx, number_format($row['amount'],0,",","."));
                        $totalAll += $row['amount'];
                    }
                    $xSheet->setCellValue($alpha[$counts].'18', number_format($totalAll,0,",","."));
                    $xSheet->setCellValue('A'.$rowx, $no); 
                    $xSheet->setCellValue('B'.$rowx, $modelx['description']); 
                    $xSheet->getStyle(($alpha[$counts].'18'))->applyFromArray(ExcelFormatter::$alignRight);
                    $xSheet->getStyle('B'.$rowx)->applyFromArray(ExcelFormatter::$alignLeft);
                    $xSheet->getStyle($alpha[$counts].$rowx)->applyFromArray(ExcelFormatter::$alignRight);
                    $xSheet->getStyle('A'.$rowx)->applyFromArray(ExcelFormatter::$alignCenter);
                    $rowx++;
                    $no++;
                } 
                $xSheet->getStyle('A12:'.$alpha[$counts].($rowx-1))->applyFromArray(ExcelFormatter::$outerBorder);
                $counts ++;
            }
        $xSheet->mergeCells($alpha[$counts].'10:'.$alpha[$counts].'11');
        $xSheet->mergeCells('C10:'.$alpha[$counts-1].'10');
        
        $xSheet->getStyle($alpha[$counts].'10:'.$alpha[$counts].'11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('B10:B11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('A10:A11')->applyFromArray(ExcelFormatter::$tableHeader);
        $xSheet->getStyle('C10:'.$alpha[$counts-1].'10')->applyFromArray(ExcelFormatter::$tableHeader);
        
        $xSheet->getStyle('B7')->applyFromArray(ExcelFormatter::$companyTitle);
        $xSheet->getStyle('B8')->applyFromArray(ExcelFormatter::$title);
        $xSheet->getStyle('B9')->applyFromArray(ExcelFormatter::$title);
        $xSheet->getStyle('B11')->applyFromArray(ExcelFormatter::$tableHeader);
          //die();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $filename = "TaxRecap_".date("Y").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
      
        $xWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        ob_end_clean();
        $xWriter->save('php://output');
        exit();
    }
}
