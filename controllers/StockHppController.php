<?php

namespace app\controllers;

use Yii;
use app\models\StockHpp;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StockHppController implements the CRUD actions for StockHpp model.
 */
class StockHppController extends MainController
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
     * Lists all StockHpp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new StockHpp();
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionView($id,$id2)
    {
        $warehouseID = $id;
        $id2 = explode("?",$id2);
        $productID = $id2[0];

        // echo "<pre>";
        // var_dump($modelStock);
        // echo "</pre>";
        // yii::$app->end();
        $this->view->params['browse'] = true;
        $model = new StockHpp();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => StockHpp::find()
                                        ->where('warehouseID = :warehouseID',[':warehouseID' => $warehouseID])
                                        ->andWhere('productID = :productID',[':productID' => $productID]),
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    /**
     * Creates a new StockHpp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StockHpp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StockHpp model.
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
     * Deletes an existing StockHpp model.
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
     * Finds the StockHpp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return StockHpp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockHpp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
