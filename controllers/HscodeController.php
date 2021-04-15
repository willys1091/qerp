<?php

namespace app\controllers;

use Yii;
use app\models\MsHscode;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use kartik\form\ActiveForm;
use yii\web\response;

/**
 * HscodeController implements the CRUD actions for MsHscode model.
 */
class HscodeController extends MainController
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
     * Lists all MsHscode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new MsHscode();
        $model->flagActive = 1;
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single MsHscode model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionBrowse()
    {
        $this->view->params['browse'] = true;
        $model = new MsHscode();
        $model->load(Yii::$app->request->queryParams);
    
        $this->layout = 'browseLayout';
        return $this->render('browse', [
                'model' => $model
        ]);
    }
    /**
     * Creates a new MsHscode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsHscode();
        $model->taxPercentage = "0,00";

        if ($model->load(Yii::$app->request->post())) {
            $model->flagActive = 1;
            $model->taxPercentage = str_replace(",",".",str_replace(".","",$model->taxPercentage));
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if ($model->save())
                return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsHscode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->taxPercentage = str_replace(",",".",str_replace(".","",$model->taxPercentage));
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if ($model->save(false))
                return $this->redirect(['index']);
        }
		return $this->render('update', [
			'model' => $model,
		]);
    }

    /**
     * Deletes an existing MsHscode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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

    /**
     * Finds the MsHscode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsHscode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsHscode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGetall()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $result = MsHscode::find()
                ->select(['ms_hscode.hsCode AS name'])
                ->asArray()
                ->all();
        
        return $result;
    }
}
