<?php

namespace app\controllers;

use Yii;
use app\models\TrSampledeliverydetail;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\data\ArrayDataProvider;
use app\components\AppHelper;
use kartik\widgets\ActiveForm;

/**
 * SampleDeliveryStatusController implements the CRUD actions for TrSampledeliveryhead model.
 */
class SampleDeliveryStatusController extends MainController
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
     * Lists all TrSampledeliveryhead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrSampledeliverydetail();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->transactionDate = "$model->startDate to $model->endDate";
        $model->load(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable')) {
            $sampleID = Yii::$app->request->post('editableKey');
            $modelSample = TrSampledeliverydetail::findOne($sampleID);
            $posted = current($_POST['TrSampledeliverydetail']);
            $statusID = $posted['statusID'];
            $modelSample->statusID = $statusID;
            $modelSample->save();

            $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
