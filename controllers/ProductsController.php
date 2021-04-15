<?php

namespace app\controllers;

use app\models\Product;
use app\models\Stock;
use kartik\form\ActiveForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ProductsController extends MainController {
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
       
        $model = new Product();
        $model->flagActive = 1;

        $model->load(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }    
    
    public function actionBrowse($supplierID = 0) {
        $model = new Product();
        $model->flagActive = true;
        
        $model->load(Yii::$app->request->queryParams);
        
        return $this->renderAjax('browse', [
            'model' => $model,
            'supplierID' => $supplierID,
        ]);
    }
        
    public function actionBrowseStockSample($warehouseID = 0) {
        $model = new Stock();
        $model->warehouseID = $warehouseID;
        
        $model->load(Yii::$app->request->queryParams);
        
        return $this->renderAjax('browse-stock-sample', [
            'model' => $model,
            'warehouseID' => $warehouseID
        ]);
    }

    public function actionCreate() {
        $model = new Product();
        $model->minQty = 0;
        $model->uomPackingTypeQty = 0;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            Yii::info($model);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', $model->productName.' created successfully');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', "Failed to create product");
            }
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', $model->productName.' updated successfully');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', "Failed to update product");
            }
        } 
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);

        $model->flagActive = 0;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', $model->productName .' deleted successfully');
        } else {
            Yii::$app->session->setFlash('error', "Failed to delete product");
        }

        return $this->redirect(['index']);
    }

    public function actionRestore($id) {
        $model = $this->findModel($id);

        $model->flagActive = 1;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', $model->productName.' restored successfully');
        } else {
            Yii::$app->session->setFlash('error', "Failed to restore product");
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}