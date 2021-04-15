<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\TrSalesorderhead;
use yii\filters\VerbFilter;


/**
 * SalesOrderPendingController implements the CRUD actions for TrSalesorderheads model.
 */
class SalesOrderPendingController extends MainController
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
     * Lists all TrSalesorderhead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrSalesorderhead();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('d-m-Y');
        $model->salesOrderDate = "$model->startDate to $model->endDate";
        //$model->salesOrderDate = $model->startDate.' - '.$model->endDate;
        $model->load(Yii::$app->request->queryParams);
       // var_dump('wkwk');

        return $this->render('index', [
            'model' => $model,
        ]);
    }
    
}
