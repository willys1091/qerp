<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsCoasetting;
use app\models\TrGoodsreceiptcost;
use app\models\TrGoodsreceiptdetail;
use app\models\TrGoodsreceiptheadapproval;
use app\models\TrImportduty;
use app\models\TrJournaldetail;
use app\models\TrJournalhead;
use app\models\TrPurchaseorderhead;
use app\models\TrSupplierpayablehead;
use app\models\TrSupplierpaymentdetail;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class ImportDutyController extends MainController
{
    public function actionIndex()
    {
    	$model = new TrImportduty();        
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->importDutyStatus = 'Pending';
        $model->goodsReceiptDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);
        
        $query = TrGoodsreceiptheadapproval::find()
                    ->select(['goodsReceiptDate',
                        'goodsReceiptNum',
                        'tr_goodsreceipthead.refNum',
                        'tr_purchaseorderhead.supplierID',
                        new Expression("CASE WHEN ISNULL(pibDate) THEN 'Pending' ELSE 'Done' END as importDutyStatus")
                        ])
                    ->joinWith('purchaseOrder')
                    ->joinWith('purchaseOrder.supplier')
                    ->andWhere('transType = "Purchase Order"')
                    ->andWhere('tr_purchaseorderhead.isImport = true')
                    ->andFilterWhere(['like', 'goodsReceiptNum', $model->goodsReceiptNum])
                    ->andFilterWhere(['like', 'tr_purchaseorderhead.purchaseOrderNum', $model->refNum])
                    ->andFilterWhere(['=', 'tr_purchaseorderhead.supplierId', $model->supplierID])
                    ->andFilterWhere(['=', "CASE WHEN ISNULL(pibDate) THEN 'Pending' ELSE 'Done' END", $model->importDutyStatus]);
        
        
        if($model->startDate && $model->endDate)
        {
            $start = date('Y-m-d',strtotime($model->startDate));
            $end = date('Y-m-d',strtotime($model->endDate. ' +1 day'));
            
            $query->andFilterWhere(['>=', 'goodsReceiptDate', $start]);
            $query->andFilterWhere(['<=', 'goodsReceiptDate', $end]);
        }
        
    	$dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => [
                                'defaultOrder' => ['goodsReceiptDate' => SORT_DESC],
                                'attributes' => [
                                    'goodsReceiptDate',
                                    'goodsReceiptNum',
                                    'refNum',
                                    'supplierID' => [
                                        'asc' => ['ms_supplier.supplierName' => SORT_ASC],
                                        'desc' => ['ms_supplier.supplierName' => SORT_DESC],
                                    ],
                                    'importDutyStatus'
                                ]
                                    
                        ]
                    ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->goodsReceiptDateHidden = $model->goodsReceiptDate;
        
        return $this->render('view', [
            'model' => $model
        ]);
    }
    
    public function actionUpdate($id, $done)
    {
        $model = $this->findModel($id);
       
        $model->goodsReceiptDateHidden = $model->goodsReceiptDate;
        $model->scenario = 'scenarioImport';
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            
            
            if ($this->saveModel($model, $id, $done)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model
        ]);
    }
    
  
    protected function findModel($id)
    {
        if (($model = TrGoodsreceiptheadapproval::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function saveModel($model, $id, $isUpdatedone) {
        
       
        $connection = AppHelper::getDbConnection();
        $transaction = $connection->beginTransaction();
        
        $modelGR = TrGoodsreceiptheadapproval::findOne($model->goodsReceiptNum);
        
        $modelGR->goodsReceiptDate = AppHelper::convertDateAndTimeFormat($model->goodsReceiptDateHidden . ' ' . $model->goodsReceiptTime, 'd-m-Y H:i', 'Y-m-d H:i');
        $modelGR->pibDate = AppHelper::convertDateTimeFormat($model->pibDate, 'd-m-Y', 'Y-m-d');
        $modelGR->pibRate = str_replace(",", ".", str_replace(".", "", $model->pibRate));
        $modelGR->pibNumber = $model->pibNumber;
        $modelGR->pibSubmitCode = $model->pibSubmitCode;
        $modelGR->pibAmount = str_replace(",", ".", str_replace(".", "", $model->pibAmount));
        $modelGR->scenario = 'scenarioImport';
        
        
        if (!$modelGR->save()) {
            print_r($modelGR->getErrors());
            $transaction->rollBack();
            return false;
        }

        foreach ($model->joinGoodsReceiptDetail as $goodsDetail) {
            $goodsDetailModel = TrGoodsreceiptdetail::findOne(['goodsReceiptNum' => $model->goodsReceiptNum, 'productID' => $goodsDetail['productID']]);
            $goodsDetailModel->hsCodeTax = str_replace(",", ".", str_replace(".", "", $goodsDetail['hsCodeTax']));

            if (!$goodsDetailModel->save()) {
                $transaction->rollBack();
                return false;
            }
        }

        
        
        $modelCost = TrGoodsreceiptcost::findOne(['goodsReceiptNum' => $model->goodsReceiptNum]);
        if ($modelCost == null) {
            TrGoodsreceiptcost::deleteAll('goodsReceiptNum = :goodsReceiptNum ', [":goodsReceiptNum" => $id]);
            $modelCost = new TrGoodsreceiptcost();
            $modelCost->goodsReceiptNum = str_replace(",", ".", str_replace(".", "", $model->goodsReceiptNum));
        }
        $modelCost->importDutyAmount = str_replace(",", ".", str_replace(".", "", $model->importDutyAmount));
        $modelCost->PPNImportAmount = str_replace(",", ".", str_replace(".", "", $model->PPNImportAmount));
        $modelCost->PPHImportAmount = str_replace(",", ".", str_replace(".", "", $model->PPHImportAmount));
        
        $modelCost->CIF = str_replace(",", ".", str_replace(".", "", $model->CIF));
        $modelCost->FOB = str_replace(",", ".", str_replace(".", "", $model->FOB));
        $modelCost->CNF = str_replace(",", ".", str_replace(".", "", $model->CNF));
        
        $modelCost->otherCostAmount = str_replace(",", ".", str_replace(".", "", $model->otherCostAmount));
        $modelCost->taxInvoiceAmount = str_replace(",", ".", str_replace(".", "", $model->taxInvoiceAmount));
        
        
        $modelCost->lsDate = AppHelper::convertDateTimeFormat($model->lsDate, 'd-m-Y', 'Y-m-d');
        $modelCost->lsNo = $model->lsNo;
        $totalCost = floatval($modelCost->importDutyAmount) + floatval($modelCost->PPNImportAmount) + floatval($modelCost->PPHImportAmount) ;
        
        if (!$modelCost->save(false)) {
            $transaction->rollBack();
            return false;
        }
                    
        $po = TrPurchaseorderhead::find()->where(['purchaseOrderNum'=>$model->refNum])->one();
        
        //delete from journal
        if($isUpdatedone){
         
//            $connection = MdlDb::getDbConnection();
//            $sql = "DELETE a
//            FROM tr_journaldetail a
//            JOIN tr_journalhead b on a.journalHeadID = b.journalHeadID
//            WHERE b.refNum = '" . $id ."' AND b.transactionType = 'Import Duty'";
//            $command= $connection->createCommand($sql);
//            $command->execute();

            TrJournalHead::deleteAll('refNum = :refNum AND transactionType = :transactionType', [":refNum" => $id,":transactionType" => "Import Duty"]);
            
            $connection = MdlDb::getDbConnection();
            $sqls = "DELETE a, b
            FROM tr_supplierpayabledetail a
            JOIN tr_supplierpayablehead b on a.payableNum = b.payableNum
            WHERE a.refNum = '" . $id ."' ";
            $command= $connection->createCommand($sqls);
            $command->execute();
            
            $dataSUPP =  TrSupplierpaymentdetail::find()
                    ->where(['refNum' => $id])
                    ->andWhere(['=', 'SUBSTR(supplierPaymentNum, 5, 2) ', 'FP'])
                    ->one();
            if($dataSUPP){
                
                $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
                $mode = 'import duty'; //goods receipt
                $command->bindValue(':refNum', $id);
                $command->bindValue(':mode', $mode);
                $command->queryAll();
            }
            
        }
       
        
//        $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
//        $mode = 'import duty'; //goods delivery
//        $command->bindValue(':refNum', $model->goodsReceiptNum);
//        $command->bindValue(':mode', $mode);
//        $command->queryAll();
        
        if($model->transType == "Purchase Order" && $isUpdatedone){
                $command = $connection->createCommand('call sp_insert_payablereceivable(:refNum, :mode)');
                $mode = 1; //goods receipt

                $command->bindParam(':refNum', $id);
                $command->bindParam(':mode', $mode);
                $command->execute();
        }
        
        /*
        $journalHeadID = '';
        if (!TrJournalhead::newData($journalHeadID, $modelGR->pibDate, 'Import Duty', $modelGR->goodsReceiptNum, '')) {
            $transaction->rollBack();
            return false;
        }
        
        if (floatval($modelCost->importDutyAmount) > 0) {
            if (!TrJournaldetail::newData($journalHeadID, MsCoasetting::findCOA('BeaImpor'), $po->currencyID, $modelGR->pibRate, floatval($modelCost->importDutyAmount)/floatval($modelGR->pibRate), 0)) {
                $transaction->rollBack();
                return false;
            }     
        }
        
        if (floatval($modelCost->PPNImportAmount) > 0) {
            if (!TrJournaldetail::newData($journalHeadID, MsCoasetting::findCOA('PPNImpor'), $po->currencyID, $modelGR->pibRate, floatval($modelCost->PPNImportAmount) / floatval($modelGR->pibRate), 0)) {
                $transaction->rollBack();
                return false;
            }     
        }
        
        if (floatval($modelCost->PPHImportAmount) > 0) {
            if (!TrJournaldetail::newData($journalHeadID, MsCoasetting::findCOA('PPH22Impor'), $po->currencyID, $modelGR->pibRate, floatval($modelCost->PPHImportAmount) / floatval($modelGR->pibRate), 0)) {
                $transaction->rollBack();
                return false;
            }
        }
                
        if (floatval($totalCost) > 0) {
            if (!TrJournaldetail::newData($journalHeadID, MsCoasetting::findCOA('HutangPPJK'), $po->currencyID, $modelGR->pibRate, 0, floatval($totalCost) / floatval($modelGR->pibRate))) {
                $transaction->rollBack();
                return false;
            }
        }
        
        if (!TrSupplierpayablehead::newData($model->goodsReceiptNum, $modelGR->PPJK, $modelGR->pibDate, $po->currencyID, $modelGR->pibRate, floatval($totalCost))) {
            $transaction->rollBack();
            return false;
        }
        */
                        
        $transaction->commit();

        return true;
    }
}