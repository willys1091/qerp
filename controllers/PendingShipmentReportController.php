<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\TrGoodsreceipthead;
use app\models\TrPurchaseorderhead;
use kartik\form\ActiveForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\response;

class PendingShipmentReportController extends MainController
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
        $model = new TrGoodsreceipthead();
        $model->load(Yii::$app->request->queryParams);

        return $this->render('/pending-shipment-report/index', [
            'model' => $model,
        ]);
    }
	
	public function actionUpdate($id)
    {
      Yii::$app->runAction('GoodsReceipt/create', $id);
    }

}
