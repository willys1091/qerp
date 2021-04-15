<?php

namespace app\controllers;

use Yii;
use app\models\TrCashinouthead;
use app\models\TrCashin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\Response;
use app\components\MdlDb;
use app\components\AppHelper;
use yii\helpers\Json;
use mPDF;


class CashinoutController extends MainController
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
     * List all Cash/Bank In/Out
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrCashinouthead(['scenario'=>'search']);
        
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->cashInOutDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model
        ]);
    }
    
    public function actionCreate()
    {
        $model = new TrCashinouthead();
        
        $model->cashInOutDate = date('d-m-Y');
        $model->rate = "1,00";
        $model->createdBy = Yii::$app->user->identity->username;
        $model->createdDate = new Expression('NOW()');
        $model->editedBy = Yii::$app->user->identity->username;
        $model->editedDate = new Expression('NOW()');
         
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()))
        {
            $existing = TrCashinouthead::find()
                    ->where(['voucherNum' => $model->voucherNum])
                    ->one();
            if ($existing)
            {
                $model->errorMessages = [
                    "Voucher Number has already been used in transaction number $existing->cashInOutNum"
                ];
                return $this->render('create', [
                    'model' => $model
                ]);
            }
            if($model->save(false)){
                return $this->redirect(['index']);
            }
        }
        
        return $this->render('create', [
            'model' => $model
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = TrCashinouthead::find()->where(['cashInOutNum' => $id])->one();
        
        $model->cashInOutDate = date('d-m-Y', strtotime($model->cashInOutDate));
        $model->editedBy = Yii::$app->user->identity->username;
        $model->editedDate = new Expression('NOW()');
        if($model->checkOrGiroDate != null)
            $model->checkOrGiroDate = date('d-m-Y', strtotime($model->checkOrGiroDate));
        
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()))
        {
            $existing = TrCashinouthead::find()
                    ->where(['voucherNum' => $model->voucherNum])
                    ->andWhere(['<>', 'cashInOutNum', $model->cashInOutNum])
                    ->one();
            if ($existing)
            {
                $model->errorMessages = [
                    "Voucher Number has already been used in transaction number $existing->cashInOutNum"
                ];
                return $this->render('create', [
                    'model' => $model
                ]);
            }
            if($model->save(false)){
                return $this->redirect(['index']);
            }
        }
        
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionPrint($id = null)
    {
        $this->layout = 'reportLayout';
        $connection = MdlDb::getDbConnection();
        $sql = 'SELECT *
                FROM tr_cashinouthead a 
                JOIN tr_cashinoutdetail b ON b.cashInOutNum = a.cashInOutNum
                WHERE a.cashInOutNum = "'.$id.'"';
        
        $command = $connection->createCommand($sql);        
        $model = $command->queryAll();

        $view = 'report_voucher';
        $content = $this->renderPartial($view, [
            'model' => $model,
        ]);         

        $mpdf = new mPDF('',    // mode - default ''
                        'A4',    // format - A4, default ''
                        0,     // font size - default 0
                        '',    // default font family
                        '20',    // margin_left
                        '20',    // margin right
                        '5',     // margin top
                        '15',    // margin bottom
                        '0',     // margin header
                        '5',     // margin footer
                        'P'     // P = portrait, L = landscape
                );
        $mpdf->WriteHTML($content);
        $mpdf->Output('report.pdf','I');
        exit;
    }
    
    public function actionDelete($id)
    {
        $model = TrCashinouthead::find()->where(['cashInOutNum' => $id])->one();
        $model->delete();
        
        return $this->redirect(['index']);
    }
}