<?php

namespace app\controllers;

use Yii;
use app\models\TrJournalHead;
use app\models\TrJournaldetail;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\data\ArrayDataProvider;
use app\components\AppHelper;
use kartik\widgets\ActiveForm;

/**
 * JournalController implements the CRUD actions for TrJournaldetail model.
 */
class JournalController extends MainController
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
     * Lists all TrJournaldetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$model = new TrJournalDetail();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->journalDate = $model->startDate.' to '.$model->endDate;
        $model->load(Yii::$app->request->post());*/
        
        $model = new TrJournalHead();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->journalDate = $model->startDate.' to '.$model->endDate;
        $model->load(Yii::$app->request->post());
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    
    protected function findModel($id)
    {
        if (($model = TrJournaldetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
