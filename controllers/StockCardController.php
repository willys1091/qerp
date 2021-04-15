<?php

namespace app\controllers;

use app\models\MsSetting;
use app\models\StockCard;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use mPDF;

/**
 * StockCardController implements the CRUD actions for StockCard model.
 */
class StockCardController extends MainController
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
     * Lists all StockCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new StockCard();
        $detailModel = new StockCard();
        $model->load(Yii::$app->request->queryParams);
        $model->startDate = date('01-m-Y');
        $model->endDate = date('30-m-Y');
        $model->transactionDate = "$model->startDate -  $model->endDate";
        
         if (Yii::$app->request->queryParams) {
            $model->load(Yii::$app->request->queryParams);
            
            $downloadReport = Yii::$app->request->get("downloadReport", null);
        
            if ($downloadReport !== null) {
               
                $detailModel->search($model, 1);
                Yii::$app->end();
                return null;
            }
            
            $downloadReportPdf = Yii::$app->request->get("downloadReportPdf", null);
        
            if ($downloadReportPdf !== null) {
               
                $model = $detailModel->search($model, 0, 1);
                $this->printPdf($model);
                Yii::$app->end();
                return null;
            }
        }
        
        return $this->render('index', [
            'model' => $model,
            'detailModel' => $detailModel
        ]);
    }

    /**
     * Displays a single StockCard model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StockCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StockCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StockCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StockCard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StockCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return StockCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockCard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function printPdf($model)
    {
        $this->layout = false;
     
        $content = $this->render('print_pdf',[
            'model' => $model,
        ]);
        $imageCompany = Html::img('assets_b/images/office_building.png',['height' => '12px', 'width' => '12px']);
        $imagePhone = Html::img('assets_b/images/canva-call-icon-MACQYneSATM.png',['height' => '12px', 'width' => '12px']);
        $imageFax = Html::img('assets_b/images/fax_machine.png',['height' => '12px', 'width' => '12px']); 
        $phone1 = MsSetting::findOne(['key1' => 'Phone1']);
        $phone2 = MsSetting::findOne(['key1' => 'Phone2']);
        $phone3 = MsSetting::findOne(['key1' => 'Phone3']);
        $phone4 = MsSetting::findOne(['key1' => 'Phone4']);
        $fax = MsSetting::findOne(['key1' => 'Fax']);
        $address = strtok(MsSetting::findOne(['key1' => 'OfficeAddress'])->value1, "\n");
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
        $mpdf->SetHTMLFooter($footer);
        $mpdf->Output('report.pdf','I');
        
    }
}
