<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\MsSetting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\form\ActiveForm;
use yii\web\response;

/**
 * SettingsController implements the CRUD actions for MsSetting model.
 */
class SettingsController extends MainController
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
     * Lists all MsSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = MsSetting::find()->all();

        if (Model::loadMultiple($models, Yii::$app->request->post())) {
            foreach ($models as $model){
                if(!$model->save()){
                    print_r($model->getErrors());
                    yii::$app->end();
                }
            }
            return $this->render('index', [
                'models' => $models,
            ]);
        } else {
            return $this->render('index', [
                'models' => $models,
            ]);
        }
    }

    /**
     * Finds the MsSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
