<?php

namespace app\controllers;

use Yii;
use app\models\MsDocumenttype;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use kartik\form\ActiveForm;
use yii\web\response;

/**
 * DocumenttypeController implements the CRUD actions for MsDocumenttype model.
 */
class DocumenttypeController extends MainController
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
     * Lists all MsDocumenttype models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = new MsDocumenttype();
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
			'model' => $model,
        ]);
    }

    /**
     * Displays a single MsDocumenttype model.
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
     * Creates a new MsDocumenttype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsDocumenttype();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->flagActive = 1;
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            $reportDestinationStr = implode(",", $model->reportDestination);
            $model->reportDestination = $reportDestinationStr;
            
            if ($model->save())
                return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsDocumenttype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->flagActive = 1;
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

    /**
     * Deletes an existing MsDocumenttype model.
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
    public function actionCheck()
    {
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $refNum = $data['refNum'];
            $modelDetail = MsDocumenttype::find()
                            ->where('lkDocumentTypeID = :refNum',[
                                    ':refNum' => $refNum
                            ])
                            ->all();
          

            $i = 0;
            
            foreach ($modelDetail as $joinUploadDetail) {
                $result[$i]["documentTypeID"] = $joinUploadDetail->documentTypeID;
                $result[$i]["documentTypeName"] = $joinUploadDetail->documentTypeName;
                $result[$i]["flagMandatory"] = $joinUploadDetail->flagMandatory;
                $i += 1;
            } 
            
            return \yii\helpers\Json::encode($result);
        }
    }
    public function actionRestore($id)
    {
        $model = $this->findModel($id);

        $model->flagActive = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MsDocumenttype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsDocumenttype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsDocumenttype::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGetall()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $result = MsDocumenttype::find()
                ->select(['ms_documenttype.documentTypeName AS name'])
                ->asArray()
                ->all();
        
        return $result;
    }
    
}
