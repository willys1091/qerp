<?php

namespace app\controllers;

use Yii;
use app\models\MsSubcategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\form\ActiveForm;
use yii\web\response;
use yii\db\Expression;

/**
 * SubcategoryController implements the CRUD actions for MsSubcategory model.
 */
class SubcategoryController extends MainController
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
     * Lists all MsSubcategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new MsSubcategory();
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single MsSubcategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MsSubcategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsSubcategory();

        if ($model->load(Yii::$app->request->post())) {
            $model->flagActive = 1;
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
     * Updates an existing MsSubcategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MsSubcategory model.
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
     * Finds the MsSubcategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsSubcategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsSubcategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGetall()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $result = MsSubcategory::find()
                ->select(['ms_subcategory.subcategoryName AS name'])
                ->asArray()
                ->all();
        
        return $result;
    }
}
