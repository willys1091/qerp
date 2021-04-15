<?php

namespace app\controllers;

use app\models\MsProduct;
use app\models\SampleReceiptForm;
use app\models\SampleReceiptHead;
use kartik\form\ActiveForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */

class SampleReceiptController extends MainController {
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
        $model = new SampleReceiptHead();
        $model->dateSearchStart = date('1-m-Y');
        $model->dateSearchEnd = date('d-m-Y');
        $model->sampleReceiptDate = "$model->dateSearchStart to $model->dateSearchEnd";
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
                'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new SampleReceiptForm();
        $model->sampleReceiptDate = date('Y-m-d H:i:s');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->saveModel($model)) {
                Yii::$app->session->setFlash('success', $model->sampleReceiptNum.' created successfully');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', "Failed to create sample receipt");
            }
        }

        return $this->render('create', [
                'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id, 1);
        
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveModel()) {
                Yii::$app->session->setFlash('success', $model->sampleReceiptNum.' updated successfully');
                return $this->redirect(['index']);
            } else {                
                Yii::$app->session->setFlash('error', "Failed to update sample receipt");
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

      public function actionBrowsebysupplier($filter)
    {
        $this->view->params['browse'] = true;
        $model = new MsProduct();
        $model->flagActive = 1;
        $model->load(Yii::$app->request->queryParams);
//        $dataProvider = new ActiveDataProvider([
//                            'query' => MsProduct::find()
//                                        ->where('supplierID = :supplierID',[':supplierID' => $filter])
//                                        ->andFilterWhere(['like', 'ms_product.productName', $model->productName]),
//                        ]);
        
        
        $dataProvider = new ActiveDataProvider([
            
                         'query' =>MsProduct::find()
                 ->where('ms_product.supplierID = :supplierID',[':supplierID' => $filter])
                 ->joinWith('productDetails')
				 ->joinWith('supplier')
                 ->andFilterWhere(['like', 'ms_productDetail.buyPrice', $model->buyPrice])
                 ->andFilterWhere(['like', 'ms_product.productName', $model->productName])
                 ->andFilterWhere(['=', 'ms_product.flagActive', $model->flagActive]),
                'sort' => [
                    'defaultOrder' => ['productName' => SORT_ASC],
                    'attributes' => [
                        'productName',
                        'buyPrice' => [
                            'asc' => ['ms_productDetail.buyPrice' => SORT_ASC],
                            'desc' => ['ms_productDetail.buyPrice' => SORT_DESC],
                        ],
                    ]
                ],
                'pagination' => [
                    'pageSize' => 10
                ]
        ]);
        
       

        $this->layout = 'browseLayout';
        return $this->render('browsebysupplier', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionBrowse($filter = null){
        $this->view->params['browsebysupplier'] = true;
        $model = new MsProduct();
        $model->flagActive = 1;       
        $model->load(Yii::$app->request->queryParams);
        
        $this->layout = 'browseLayout';
        return $this->render('browsebysupplier', [
            'model' => $model,
            'filter' => $filter
        ]);
        
    }
    public function actionDelete($id) {
        $model = $this->findModel($id);
        
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', $model->sampleReceiptNum .' deleted successfully');
        } else {
            Yii::$app->session->setFlash('error', "Failed to delete sample receipt");
        }

        return $this->redirect(['index']);
    }
    
    protected function findModel($id, $isForm = 0) {
        if (($model = $isForm == 1 ? SampleReceiptForm::findOne($id) : SampleReceiptHead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}