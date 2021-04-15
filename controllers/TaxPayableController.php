<?php

namespace app\controllers;

use Yii;
use app\models\TrTaxinhead;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * TaxPayableController implements the CRUD actions for TrTaxinhead model.
 */
class TaxPayableController extends MainController
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
     * Lists all TrTaxinhead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrTaxinhead();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrTaxinhead model.
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
     * Creates a new TrTaxinhead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrTaxinhead();
        $taxInModel = "select grh.taxInvoiceNum,poh.taxRate,grd.qty*pod.price as taxGrandTotal,s.supplierName as taxSource
                        from tr_goodsreceipthead grh
                        join tr_goodsreceiptdetail grd on grh.goodsReceiptNum=grd.goodsReceiptNum
                        join tr_purchaseorderhead poh on grh.refNum=poh.purchaseOrderNum
                        join tr_purchaseorderdetail pod on poh.purchaseOrderNum=pod.purchaseOrderNum and grd.productID=pod.productID
                        join ms_supplier s on poh.supplierID=s.supplierID
                        join tr_journalhead j on grh.goodsReceiptNum=j.refNum
                        where j.refNum is not null and j.transactionType='Goods Receipt'";
        $taxInCount = "select count(grh.taxInvoiceNum)
                        from tr_goodsreceipthead grh
                        join tr_goodsreceiptdetail grd on grh.goodsReceiptNum=grd.goodsReceiptNum
                        join tr_purchaseorderhead poh on grh.refNum=poh.purchaseOrderNum
                        join tr_purchaseorderdetail pod on poh.purchaseOrderNum=pod.purchaseOrderNum and grd.productID=pod.productID
                        join tr_journalhead j on grh.goodsReceiptNum=j.refNum
                        where j.refNum is not null and j.transactionType='Goods Receipt'";
        $count = Yii::$app->db->createCommand($taxInCount)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $taxInModel,
            'totalCount' => $count,
        ]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['index']);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing TrTaxinhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->taxInNum]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TrTaxinhead model.
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
     * Finds the TrTaxinhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrTaxinhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrTaxinhead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
