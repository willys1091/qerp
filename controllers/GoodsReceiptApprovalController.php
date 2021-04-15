<?php

namespace app\controllers;

use Yii;
use app\models\TrGoodsreceiptheadapproval;
use app\models\TrGoodsreceiptdetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AppHelper;
use yii\db\Expression;
use kartik\form\ActiveForm;

class GoodsReceiptApprovalController extends MainController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new TrGoodsreceiptheadapproval();
        $model->startDate  = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->goodsReceiptDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if ($this->saveModel($model, false)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = TrGoodsreceiptheadapproval::findOne($id)) !== null) {
            $model->taxInvoiceNum = $model->currency != 'IDR' ? '-' : null;
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelDetail($id)
    {
        if (($model = TrGoodsreceiptheadapproval::find()
                                        ->leftJoin('tr_supplieradvancepayment', 'tr_goodsreceipthead.refNum = tr_supplieradvancepayment.refNum')
                                        ->where(['tr_goodsreceipthead.goodsReceiptNum' => $id])
                                        ->one()
            ) !== null) {
            return $model;
        } else {
            $model = TrGoodsreceiptheadapproval::findOne($id);
            $model->advancePaymentNum = "0,00";
            return $model;
        }
    }
    
    protected function saveModel($model)
    {
        if($model->isImport == 1) $model->scenario = 'scenarioImport';
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        if(strlen($model->SKIDate) > 0) {
            $model->SKIDate = AppHelper::convertDateTimeFormat($model->SKIDate, 'd-m-Y', 'Y-m-d');
        }
        
        if(strlen($model->invoiceDate) > 0) {
            $model->invoiceDate = AppHelper::convertDateTimeFormat($model->invoiceDate, 'd-m-Y', 'Y-m-d');
        }
        
        if(strlen($model->pibDate) > 0) {
            $model->pibDate = AppHelper::convertDateTimeFormat($model->pibDate, 'd-m-Y', 'Y-m-d');
        }
       
        $model->pibRate = str_replace(",",".",str_replace(".","",$model->pibRate));
        
       
        $model->pibAmount = str_replace(",",".",str_replace(".","",$model->pibAmount));
        $model->goodsReceiptDate = AppHelper::convertDateAndTimeFormat($model->goodsReceiptDate.' '.$model->goodsReceiptTime, 'd-m-Y H:i', 'Y-m-d H:i');

        if (!$model->save()) {
            $transaction->rollBack();
            return false;
        }
        $goodsReceiptNum = $model->goodsReceiptNum;
        $transactionDate = $model->goodsReceiptDate;
        foreach ($model->joinGoodsReceiptDetail as $goodsDetail) {
            $detailModel = TrGoodsreceiptdetail::findOne($goodsDetail['detailID']);
            $detailModel->hsCodeTax = str_replace(",",".",str_replace(".","",$goodsDetail['hsCodeTax']));

            if (!$detailModel->save()) {
                $transaction->rollBack();
                return false;
            }

            $productID = $goodsDetail['productID'];
            $nettprice = $goodsDetail['price'] * (100-$goodsDetail['discount']) / 100;
            $price = $nettprice*$model->pibRate;
            $qty = $goodsDetail['qty'];
            $mode = 1; //goods receipt

            $command = $connection->createCommand('call sp_insert_stockhpp(:refNum,:productID,:HPP,:mode)');
            $goodsReceiptNum = $model->goodsReceiptNum;
            $command->bindParam(':refNum', $goodsReceiptNum);
            $command->bindParam(':productID', $productID);
            $command->bindParam(':HPP', $price);
            $command->bindParam(':mode', $mode);
            $command->execute();
        }  
        

        if($model->transType == "Purchase Order" || $model->transType == "Sales Return"){
            //input to journal
            $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
            $mode = 'goods receipt'; //goods receipt

            $command->bindParam(':refNum', $goodsReceiptNum);
            $command->bindParam(':mode', $mode);
            $command->queryAll();
           // $command->execute();
        }
        
        
        $mode = 1;
        $command = $connection->createCommand('call sp_insert_stockcard(:refNum,:transactionDates,:mode)');
        $command->bindParam(':refNum', $goodsReceiptNum);
        $command->bindParam(':transactionDates', $transactionDate);
        $command->bindParam(':mode', $mode);
        $command->execute(); 

        if($model->transType == "Purchase Order"){
            //input to payable
            $command = $connection->createCommand('call sp_insert_payablereceivable(:refNum, :mode)');
            $mode = 1; //goods receipt

            $command->bindParam(':refNum', $goodsReceiptNum);
            $command->bindParam(':mode', $mode);
            $command->execute();
        }
        
        $transaction->commit();
        return true;
    }
}
