<?php

namespace app\controllers;

use Yii;
use app\models\CashBankTransfer;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\Response;
use app\components\AppHelper;
use app\components\MdlDb;

/**
 * CashBankTransferController implements the CRUD actions for CashBankTransfer model.
 */
class CashBankTransferController extends MainController
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all CashBankTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new CashBankTransfer();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->transferDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * Displays a single CashBankTransfer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CashBankTransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CashBankTransfer();
        $model->transferDate = date('d-m-Y');
        $model->sourceRate = "1,00";
        $model->destinationRate = "1,00";
        $model->sourceAmount = "0,00";
        $model->destinationAmount = "0,00";

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $existing = CashBankTransfer::find()
                    ->where(['voucherNum' => $model->voucherNum])
                    ->one();
            
            if ($existing)
            {
                $model->errorMessages = [
                    "Voucher Number has already been used in transfer number $existing->transferID"
                ];
                return $this->render('create', [
                    'model' => $model
                ]);
            }
            
            if($this->saveModel($model, true)){
                return $this->redirect(['index']);
            }
        }
        
        return $this->render('create', [
               'model' => $model
           ]);
    }

    /**
     * Updates an existing CashBankTransfer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->transferDate = AppHelper::convertDateTimeFormat($model->transferDate, 'Y-m-d H:i:s', 'd-m-Y');
        $model->destinationAmount = $model->sourceRate * $model->sourceAmount / $model->destinationRate;

        if ($model->load(Yii::$app->request->post())) {
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if($this->saveModel($model, false)){
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CashBankTransfer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CashBankTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CashBankTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CashBankTransfer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function saveModel($model, $newTrans){
        $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $modelMonth = date("m",strtotime($model->transferDate)) - 1;

        $tempModel = CashBankTransfer::find()
        ->where('SUBSTRING(transferID, 8, 2) LIKE :transferDate',[
                ':transferDate' => date("y",strtotime($model->transferDate))
        ])
        ->orderBy([new Expression("CAST(SUBSTRING(transferID, -3, 3) AS UNSIGNED) DESC")])
        ->one();
        $tempTransNum = "";
        
        if (empty($tempModel)){
            $tempTransNum = "QJA/BT/".date("y",strtotime($model->transferDate))."/".$month[$modelMonth]."/001";
        }
        else{
            $temp = substr($tempModel->transferID,-3,3)+1;
            $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
            $tempTransNum = "QJA/BT/".date("y",strtotime($model->transferDate))."/".$month[$modelMonth]."/".$temp;
        }
        $model->transferID = $tempTransNum;

        $model->transferDate = AppHelper::convertDateTimeFormat($model->transferDate, 'd-m-Y', 'Y-m-d');
        $model->sourceRate = str_replace(",",".",str_replace(".","",$model->sourceRate));
        $model->destinationRate = str_replace(",",".",str_replace(".","",$model->destinationRate));
        $model->sourceAmount = str_replace(",",".",str_replace(".","",$model->sourceAmount));
        $model->createdBy = Yii::$app->user->identity->username;
        $model->createdDate = new Expression('NOW()');
        $model->editedBy = Yii::$app->user->identity->username;
        $model->editedDate = new Expression('NOW()');

        if (!$model->save()) {
            $transaction->rollBack();
            return false;
        }

        $connection = MdlDb::getDbConnection();
        $command = $connection->createCommand('call insert_journal(:refNum, :mode)');
        $journalRefNum = $model->transferID;
        $mode = 12; 

        $command->bindParam(':refNum', $journalRefNum);
        $command->bindParam(':mode', $mode);
        $command->execute();

        return true;
    }
}
