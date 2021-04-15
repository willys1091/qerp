<?php

namespace app\controllers;

use app\components\AppHelper;
use app\models\ChangePasswordForm;
use app\models\MsUser;
use kartik\form\ActiveForm;
use Yii;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\response;


/**
 * UserController implements the CRUD actions for MsUser model.
 */
class UserController extends MainController
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
     * Lists all MsUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new MsUser();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    
    public function actionChangepassword()
    {
        $model = new ChangePasswordForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                //AppHelper::insertTransactionLog('Change Password', null, $model);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully change password'));
                return $this->redirect(['index']);
            } else {
                //AppHelper::insertErrorLog($model);
                Yii::$app->session->setFlash('error', Yii::t('app', 'Failed to change password'));
            }
        }

        return $this->render('changepassword', [
                'model' => $model,
        ]);
    }
    /**
     * Displays a single MsUser model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new MsUser();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->salt = Yii::$app->security->generateRandomString(20);
            $model->password = md5($model->password.$model->salt);
            $model->flagActive = 1;
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');

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
        $oldPassword = $model->password;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ((MsUser::find()->where("password = :password", [':password' => $model->password])->andWhere("username = :username", [':username' => $id])->one()) !== null) {
                $model->password = $oldPassword;
            } else {
                $model->password = md5($model->password.$model->salt);
            } 
            
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

    public function actionReset($id)
    {
        $model = $this->findModel($id);
        $model->password = md5('abc.123'.$model->salt);
        $model->save();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = MsUser::find()->where("username = :username", [':username' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findPassword($id)
    {
        if (($model = MsUser::find()->where("password = :password", [':password' => $id])->one()) !== null) {
            return true;
        } else {
            throw false;
        }
    }
}
