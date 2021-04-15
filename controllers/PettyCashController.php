<?php

namespace app\controllers;

use app\components\AppHelper;
use app\models\TrPettyCash;
use mPDF;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * PettyCashController implements the CRUD actions for TrPettyCash model.
 */
class PettyCashController extends MainController
{
    /**
     * {@inheritdoc}
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
     * Lists all TrPettyCash models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrPettyCash();
        $detailModel = new TrPettyCash();
        $model->startDate = date('1-m-Y'); //'01-01-2017'
        $model->endDate = date('d-m-Y');
        $model->pettyCashDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);
        $errMsg = "";
        $counter = 0;
        if ($model->load(Yii::$app->request->post())) {
            $model->fileUpload = UploadedFile::getInstance($model, 'fileUpload');

            if ($model->fileUpload != NULL) {
                $extExtension = end(explode(".", $model->fileUpload->name));
                $extExtension = strtoupper($extExtension);
                
                if ($extExtension == "XLS" || $extExtension == "XLSX") {
                    $filename = date("Y-m-d H:i:s") . '.' . $model->fileUpload->extension;
                    $filename = str_replace('-', '', $filename);
                    $filename = str_replace(':', '', $filename);
                    $filename = str_replace(' ', '', $filename);
                    $inputFileName = Yii::$app->basePath . '/assets_b/uploads/excel/' . $filename;
                    $result = $model->fileUpload->saveAs($inputFileName);

                    if ($result) {
                        $model->saveUpload($inputFileName, $counter, $errMsg);
                    }
                } else {
                    $errMsg = "Only excel file that can be uploaded";
                }
                
                $successMsg = "";
                if ($counter > 0) {
                    $successMsg = $counter . " Data successfuly uploaded. ";
                }

                if ($errMsg != "") {
                    Yii::$app->session->setFlash('error', $errMsg);
                } else {
                    if ($successMsg != "") {
                        Yii::$app->session->setFlash('success', $successMsg);
                    }
                }
            } else {
                $errMsg = "Please select excel file to upload";
            }
        }
        
        if (Yii::$app->request->queryParams) {
           $downloadReport = Yii::$app->request->get("downloadReport", null);
            if ($downloadReport !== null) {
                $this->layout = false;
                $convertedDateFrom = AppHelper::convertDateTimeFormat($model->startDate, 'd-m-Y', 'Y-m-d');
                $convertedDateTo = AppHelper::convertDateTimeFormat($model->endDate, 'd-m-Y', 'Y-m-d'); 
                
                $startDate = AppHelper::convertDateTimeFormat($model->startDate, 'd-m-Y', 'd-M-y');
                $endDate = AppHelper::convertDateTimeFormat($model->endDate, 'd-m-Y', 'd-M-y'); 
                
                $query1 = $detailModel::find()
                    ->select(['pettyCashNum',
                        new Expression("'' AS voucher"),
                        'pettyCashDate' => new Expression("'" . $filter->startDate . "'"),
                        'notes' => new Expression("'-- Previous Balance -- '"),
                        'drAmount' => new Expression('IFNULL(SUM(drAmount),0)'),
                        'crAmount' => new Expression('IFNULL(SUM(crAmount),0)'),
                        'balance' => new Expression('IFNULL(SUM(IFNULL((drAmount),0) - IFNULL((crAmount),0)),0)')])
                    ->where(['<', "pettyCashDate", $convertedDateFrom]);
                
                $query2 = $detailModel::find()
                ->select(['pettyCashNum',
                    'voucher',
                    'DATE_FORMAT(pettyCashDate, "%d-%m-%Y") AS pettyCashDate',
                    'notes',
                    'drAmount' => new Expression('IFNULL((drAmount),0)'),
                    'crAmount'=> new Expression('IFNULL((crAmount),0)'),
                    'balance'=> new Expression('IFNULL(SUM((drAmount - crAmount )),0)')])
                ->where(['>=', "DATE(pettyCashDate)", $convertedDateFrom])
                ->andFilterWhere(['<=', "DATE(pettyCashDate)", $convertedDateTo])
                ->groupBy(['pettyCashDate','voucher']);
                
                $unions = $query1->orderBy(['pettyCashDate' => SORT_DESC])->union($query2)->orderBy(['pettyCashDate' => SORT_DESC]);
                $content = $this->render('report_petty',[
                    'model' => $unions,
                    'model2' => $query1,
                    'startDate' => $startDate,
                    'endDate' =>  $endDate 
                ]);
                $mpdf = new mPDF('',    // mode - default ''
                        'A4',    // format - A4, default ''
                        0,     // font size - default 0
                        '',    // default font family
                        '13',    // margin_left
                        '13',    // margin right
                        '5',     // margin top
                        '10',    // margin bottom
                        '0',     // margin header
                        '5',     // margin footer
                        'L'     // P = portrait, L = landscape
                );
                $mpdf->AddPage('L');
                $mpdf->WriteHTML($content);
                $mpdf->Output('report.pdf','I');
                exit;

            }
        }
        return $this->render('index', [
            'model' => $model,
            'detailModel' => $detailModel
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TrPettyCash model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrPettyCash();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pettyCashNum]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TrPettyCash model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->pettyCashDate = AppHelper::convertDateTimeFormat( $model->pettyCashDate, 'Y-m-d', 'd-m-Y');
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->pettyCashDate = AppHelper::convertDateTimeFormat( $model->pettyCashDate, 'd-m-Y', 'Y-m-d');
            $model->drAmount =  str_replace(",",".",str_replace(".","",$model->drAmount));
            $model->crAmount =  str_replace(",",".",str_replace(".","",$model->crAmount));
            
            if($model->save()){
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Successfully update'));
            return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Failed to update'));
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TrPettyCash model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if($model->delete()){
        Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Successfully update'));
        return $this->redirect(['index']);
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Failed to update'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrPettyCash model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrPettyCash the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrPettyCash::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
