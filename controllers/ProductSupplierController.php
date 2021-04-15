<?php

namespace app\controllers;
use Yii;
use app\models\MapProductsupplier;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use kartik\form\ActiveForm;
use yii\web\response;

class ProductSupplierController extends MainController
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
     * Lists all MsProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MapProductsupplier::find(),
        ]);
		$model = new MapProductsupplier();
        $model->load(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'dataProvider' => $dataProvider,
			'model' => $model
        ]);
    }

    public function actionBrowse($supplierID = 0) {
        $model = new MapProductsupplier();
        $model->flagActive = true;
        
        $model->load(Yii::$app->request->queryParams);
        
        return $this->renderAjax('browse', [
            'model' => $model,
            'supplierID' => $supplierID,
        ]);
    }

    public function actionCreate()
    {
        $model = new MapProductsupplier();

        if ($model->load(Yii::$app->request->post())) {
            $model->flagActive = 1;

            if ($model->save())
                return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->flagActive = 1;

            if ($model->save())
                return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->flagActive = 0;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionGetall()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $result = MapProductsupplier::find()
                ->select(['ms_productsupplier.productID AS name'])
                ->asArray()
                ->all();
        
        return $result;
    }

    protected function findModel($id)
    {
        if (($model = MapProductsupplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
