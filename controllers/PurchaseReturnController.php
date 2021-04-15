<?php
namespace app\controllers;

use Yii;
use app\models\TrPurchasereturnhead;
use app\models\TrPurchasereturndetail;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Json;
use Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\Response;
use app\components\MdlDb;
use app\components\AppHelper;
use mPDF;

/**
 * PurchaseReturnController implements the CRUD actions for TrPurchasereturnhead model.
 */
class PurchaseReturnController extends MainController
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
     * Lists all TrPurchasereturnhead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TrPurchasereturnhead();
        $model->startDate = date('1-m-Y');
        $model->endDate = date('d-m-Y');
        $model->load(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single TrPurchasereturnhead model.
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
     * Creates a new TrPurchasereturnhead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrPurchasereturnhead();
        $model->purchaseReturnDate = date('d-m-Y');
        $model->grandTotal = "0,00";
        $model->rate = "0,00";
        $model->joinPurchaseReturnDetail = [];

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->createdBy = Yii::$app->user->identity->username;
            $model->createdDate = new Expression('NOW()');
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');

            if($this->saveModel($model, true)){
                $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing TrPurchasereturnhead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');           
            
            if ($this->saveModel($model, false)) {
                $model->save();
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TrPurchasereturnhead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        TrPurchasereturndetail::deleteAll('purchaseReturnNum = :purchaseReturnNum', [":purchaseReturnNum" => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPrint($id)
    {
        $this->layout = false;
        $connection =  MdlDb::getDbConnection();
        $sql = 'SELECT f.fullName, a.purchaseReturnNum, year(a.purchaseReturnDate) as year, month(a.purchaseReturnDate) as month, 
                day(a.purchaseReturnDate) as day, b.supplierName, b.street, b.npwp, d.productName, c.qty, e.uomName, c.HPP, (floor(c.qty) * c.HPP) as subtotal, a.additionalInfo
                FROM tr_purchasereturnhead a
                LEFT JOIN ms_supplier b ON b.supplierID = a.supplierID
                LEFT JOIN tr_purchasereturndetail c ON c.purchaseReturnNum = a.purchaseReturnNum
                LEFT JOIN ms_product d ON d.productID = c.productID
                LEFT JOIN ms_uom e ON e.uomID = c.uomID
                LEFT JOIN ms_user f ON f.username = a.createdBy
                WHERE a.purchaseReturnNum = "'.$id.'"';
        $model = $connection->createCommand($sql)->queryAll();
        $content = $this->render('report_view',[
            'model' => $model,
        ]);

        $mpdf = new mPDF;
        $mpdf->WriteHTML($content);
        $mpdf->Output('report.pdf','I');
    }

    /**
     * Finds the TrPurchasereturnhead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TrPurchasereturnhead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrPurchasereturnhead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function saveModel($model, $newTrans)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        $month = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $modelMonth = date("m",strtotime($model->purchaseReturnDate)) - 1;
       
        if ($newTrans){
            $tempModel = TrPurchasereturnhead::find()
            ->where('YEAR(purchaseReturnDate) LIKE :purchaseReturnDate',[
                    ':purchaseReturnDate' => date("Y",strtotime($model->purchaseReturnDate))
            ])
            ->orderBy('purchaseReturnNum DESC')
            ->one();
            $tempTransNum = "";
            
            if (empty($tempModel)){
                $tempTransNum = "QJA/PR/".substr(date("Y",strtotime($model->purchaseReturnDate)), -2)."/".$month[$modelMonth]."/001";
            }
            else{
                $temp = substr($tempModel->purchaseReturnNum,-3,3)+1;
                $temp = str_pad($temp,3,"0",STR_PAD_LEFT);
                $tempTransNum = "QJA/PR/".substr(date("Y",strtotime($model->purchaseReturnDate)), -2)."/".$month[$modelMonth]."/".$temp;
            }            
            $model->purchaseReturnNum = $tempTransNum;
        }
        $model->purchaseReturnDate = AppHelper::convertDateTimeFormat($model->purchaseReturnDate, 'd-m-Y', 'Y-m-d');
        $model->rate = str_replace(",",".",str_replace(".","",$model->rate));
        $model->grandTotal = str_replace(",",".",str_replace(".","",$model->grandTotal));
        
        if (!$model->save()) {
            print_r($model->getErrors());
             $arrayInfo = json::encode($model->getErrors());
                throw new Exception("Gagal Menyimpan engan error: $arrayInfo");
            $transaction->rollBack();
            
            return false;
        }

        TrPurchasereturndetail::deleteAll('purchaseReturnNum = :purchaseReturnNum', [":purchaseReturnNum" => $model->purchaseReturnNum]);
        foreach ($model->joinPurchaseReturnDetail as $purchaseDetail) {
            $purchaseDetailModel = new TrPurchasereturndetail();
            $purchaseDetailModel->purchaseReturnNum = $model->purchaseReturnNum;
            $purchaseDetailModel->productID = $purchaseDetail['productID'];
            $purchaseDetailModel->uomID = $purchaseDetail['uomID'];
            $purchaseDetailModel->qty = str_replace(",",".",str_replace(".","",$purchaseDetail['returnedQty']));
            $purchaseDetailModel->HPP = str_replace(",",".",str_replace(".","",$purchaseDetail['Price']));
            $purchaseDetailModel->VAT = $purchaseDetail['taxValue'];
            $purchaseDetailModel->totalAmount = str_replace(",",".",str_replace(".","",$purchaseDetail['subtotal']));
            $purchaseDetailModel->notes = $purchaseDetail['notes'];

            if (!$purchaseDetailModel->save()) {
                 $arrayInfo = json::encode($purchaseDetailModel->getErrors());
                throw new Exception("Gagal Menyimpan Dengan error: $arrayInfo");
                $transaction->rollBack();
                return false;
            }
            
        }
        $transaction->commit();
        return true;
    }
}
