<?php

namespace app\controllers;

use Yii;
use app\models\MsCurrency;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\Response;
use kartik\form\ActiveForm;

/**
 * CurrencyController implements the CRUD actions for MsCurrency model.
 */
class CurrencyController extends MainController
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
     * Lists all MsCurrency models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new MsCurrency();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single MsCurrency model.
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
     * Creates a new MsCurrency model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsCurrency(['scenario' => 'create']);
        $model->rate = "0,00";
        $model->flagActive = 1;
        $model->createdBy = Yii::$app->user->identity->username;
        $model->createdDate = new Expression('NOW()');
        $model->editedBy = Yii::$app->user->identity->username;
        $model->editedDate = new Expression('NOW()');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->rate = str_replace(",",".",str_replace(".","",$model->rate));
            if($model->save()){
                return $this->redirect(['index']);
            }       
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MsCurrency model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->rate = str_replace(",",".",str_replace(".","",$model->rate));
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if ($model->save())
                return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionCheck()
    {
        $currencyRate = 0;
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $currencyArray = $data['currencyID'];
            $currencyID = explode(" ",$currencyArray);
            $detailModel = MsCurrency::findOne($currencyID[0]);
            if ($detailModel !== null){
                $currencyRate = $detailModel->rate;
            }
        }

        return \yii\helpers\Json::encode($currencyRate);
    }
    
    public function actionChecks($currencyID)
    {
        $currencyRate = 0;
        $currencyArray = $currencyID;
        $currencyID = explode(" ",$currencyArray);
        $detailModel = MsCurrency::findOne($currencyID[0]);
        if ($detailModel !== null){
            $currencyRate = $detailModel->rate;
        }
       
           return Json::encode($currencyRate);
       
    }

    /**
     * Deletes an existing MsCurrency model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->flagActive = 0;
        $model->save();

        return $this->redirect(['index']);
    }
    public function actionRestore($id)
    {
        $model = $this->findModel($id);

        $model->flagActive = 1;
        $model->save();

        return $this->redirect(['index']);
    }
    
    public function actionGetall()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $result = MsCurrency::find()
                ->select(['ms_currency.currencyName AS name'])
                ->asArray()
                ->all();
        
        return $result;
    }
    
    /**
     * Finds the MsCurrency model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsCurrency the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsCurrency::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
