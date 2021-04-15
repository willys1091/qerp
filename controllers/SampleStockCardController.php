<?php

namespace app\controllers;

use app\models\MsProduct;
use app\models\MsProductdetail;
use app\models\SampleStockCard;
use app\models\StockHpp;
use app\models\TrGoodsdeliverydetail;
use app\models\TrGoodsreceiptdetail;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * SampleStockCardController implements the CRUD actions for SampleStockCard model.
 */
class SampleStockCardController extends MainController
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
     * Lists all SampleStockCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new SampleStockCard();
        $detailModel = new SampleStockCard();
        $model->startDate = date('01-m-Y');
        $model->endDate = date('30-m-Y');
        $model->transactionDate = "$model->startDate -  $model->endDate";
            
        if (Yii::$app->request->queryParams) {
            $model->load(Yii::$app->request->queryParams);
            
            $downloadReport = Yii::$app->request->get("downloadReport", null);
        

            if ($downloadReport !== null) {
               
                $detailModel->search($model, 1);
                Yii::$app->end();
                return null;
            }
        }

        return $this->render('index', [
            'model' => $model,
            'detailModel' => $detailModel
        ]);
    }

    /**
     * Displays a single SampleStockCard model.
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
     * Creates a new SampleStockCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SampleStockCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SampleStockCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionBrowseAvailableStock($filter = null)
    {
        $this->view->params['browse'] = true;
        $model = new SampleStockCard();

        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => SampleStockCard::find()
                                        ->select(['stock_hpp.productID','ms_productdetail.uomID','ms_uom.uomName','stock_hpp.manufactureDate','stock_hpp.expiredDate','ms_product.productName','stock_hpp.HPP',new Expression('SUM(stock_hpp.qtyStock) as qtyStock')])
                                        ->leftJoin('ms_product', 'ms_product.productID = stock_hpp.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = stock_hpp.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('stock_hpp.warehouseID = :refNum',[':refNum' => $filter])
                                        ->groupBy('stock_hpp.productID')
                                        ->groupBy('stock_hpp.HPP')
                                        ->groupBy('stock_hpp.manufactureDate')
                                        ->groupBy('stock_hpp.expiredDate'),
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browse_stock', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    /**
     * Deletes an existing SampleStockCard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SampleStockCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SampleStockCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SampleStockCard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    //======================================================================================
    
    
    
    
//       public function actionIndex()
//    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => MsProduct::find(),
//        ]);
//		$model = new MsProduct();
//        $model->flagActive = 1;
//        $model->load(Yii::$app->request->queryParams);
//		
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//			'model' => $model
//        ]);
//    }

    /**
     * Displays a single MsProduct model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    public function actionBrowse($filter = null)
    {
        $this->view->params['browse'] = true;
        $model = new MsProduct();
        $model->flagActive = 1;       
        if ($filter <> -1){
            $model->productName = $filter;
        }
        $model->load(Yii::$app->request->queryParams);
        
        $this->layout = 'browseLayout';
        return $this->render('browse', [
            'model' => $model
        ]);
    }
    public function actionBrowseNonInventory($filter = null)
    {
        $this->view->params['browse'] = true;
        $model = new MsProduct();
        $model->load(Yii::$app->request->queryParams);
        $this->layout = 'browseLayout';
        return $this->render('browsenoninventory', [
            'model' => $model
        ]);
    }
    public function actionBrowsebysupplier($filter)
    {
        $this->view->params['browse'] = true;
        $model = new MsProduct();
        $model->flagActive = 1;
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => MsProduct::find()
                                        ->where('supplierID = :supplierID',[':supplierID' => $filter])
                                        ->andFilterWhere(['like', 'ms_product.productName', $model->productName]),
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browsebysupplier', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionBrowsebywarehouse($filter)
    {
        $this->view->params['browse'] = true;
        $model = new StockHpp();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => StockHpp::find()
                                        ->select(['tr_stockhpp.productID','ms_productdetail.uomID','ms_uom.uomName','tr_stockhpp.batchNumber','tr_stockhpp.manufactureDate','tr_stockhpp.expiredDate','tr_stockhpp.retestDate','ms_product.productName','tr_stockhpp.HPP',new Expression('SUM(tr_stockhpp.qtyStock) as qtyStock')])
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_stockhpp.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = tr_stockhpp.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('tr_stockhpp.warehouseID = :refNum',[':refNum' => $filter])
                                        ->groupBy('tr_stockhpp.productID')
                                        ->groupBy('tr_stockhpp.batchNumber')
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browsebywarehouse', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionBrowsebysample($filter)
    {
        $this->view->params['browse'] = true;
        $model = new SampleStockCard();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => SampleStockCard::find()
                                        ->select(['tr_stockcardsample.productID','ms_productdetail.uomID','ms_uom.uomName','tr_stockcardsample.batchNumber','tr_stockcardsample.manufactureDate','tr_stockcardsample.expiredDate','tr_stockcardsample.retestDate','ms_product.productName',new Expression('0 as HPP'),new Expression('SUM(tr_stockcardsample.inQty - tr_stockcardsample.outQty) as qtyStock')])
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_stockcardsample.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = tr_stockcardsample.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('tr_stockcardsample.warehouseID = :refNum',[':refNum' => $filter])
                                        ->groupBy('tr_stockcardsample.productID')
                                        ->groupBy('tr_stockcardsample.batchNumber')
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browsebywarehouse', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionBrowsebygr($filter)
    {
        $this->view->params['browse'] = true;
        $model = new TrGoodsreceiptdetail();

        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrGoodsreceiptdetail::find()
                                        ->select(['tr_stockhpp.productID','tr_goodsreceiptdetail.uomID','tr_stockhpp.qtyStock as qtyStock','tr_stockhpp.manufactureDate','tr_stockhpp.expiredDate','tr_stockhpp.retestDate','tr_stockhpp.batchNumber','ms_product.productName','tr_stockhpp.HPP'])
                                        ->leftJoin('tr_goodsreceipthead', 'tr_goodsreceipthead.goodsReceiptNum = tr_goodsreceiptdetail.goodsReceiptNum')
                                        ->leftJoin('tr_stockhpp', 'tr_stockhpp.refNum = tr_goodsreceiptdetail.goodsReceiptNum')
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_stockhpp.productID')
                                        ->where('tr_goodsreceiptdetail.goodsReceiptNum = :refNum',[':refNum' => $filter])
                                        ->groupBy('tr_stockhpp.productID'),
                        ]);
        $newModel = TrGoodsreceiptdetail::find()
                                        ->select(['tr_stockhpp.productID','tr_goodsreceiptdetail.uomID','tr_stockhpp.qtyStock as qtyStock','tr_stockhpp.manufactureDate','tr_stockhpp.expiredDate','tr_stockhpp.retestDate','tr_stockhpp.batchNumber','ms_product.productName','tr_stockhpp.HPP'])
                                        ->leftJoin('tr_goodsreceipthead', 'tr_goodsreceipthead.goodsReceiptNum = tr_goodsreceiptdetail.goodsReceiptNum')
                                        ->leftJoin('tr_stockhpp', 'tr_stockhpp.refNum = tr_goodsreceiptdetail.goodsReceiptNum')
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_stockhpp.productID')
                                        ->where('tr_goodsreceiptdetail.goodsReceiptNum = :refNum',[':refNum' => $filter])
                                        ->groupBy('tr_stockhpp.productID')
                                        ->all();
                        var_dump($newModel);
                        yii::$app->end();
        $this->layout = 'browseLayout';
        return $this->render('browsebygr', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionBrowsebygd($filter)
    {
        $this->view->params['browse'] = true;
        $model = new TrGoodsreceiptdetail();

        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => TrGoodsdeliverydetail::find()
                                        ->select(['tr_goodsdeliverydetail.productID','tr_goodsdeliverydetail.uomID as unitID','ms_uom.uomName','tr_goodsdeliverydetail.manufactureDate','tr_goodsdeliverydetail.expiredDate','ms_product.productName','tr_salesorderdetail.price as HPP',new Expression('SUM(tr_goodsdeliverydetail.qty) as qtyStock')])
                                        ->leftJoin('tr_goodsdeliveryhead', 'tr_goodsdeliveryhead.goodsDeliveryNum = tr_goodsdeliverydetail.goodsDeliveryNum')
                                        ->leftJoin('tr_salesorderdetail', 'tr_salesorderdetail.salesOrderNum = tr_goodsdeliveryhead.refNum')
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_goodsdeliverydetail.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = tr_goodsdeliverydetail.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('tr_goodsdeliverydetail.goodsDeliveryNum = :refNum',[':refNum' => $filter]),
                        ]);
        $newModel = TrGoodsdeliverydetail::find()
                                        ->select(['tr_goodsdeliverydetail.productID','tr_goodsdeliverydetail.uomID as unitID','ms_uom.uomName','tr_goodsdeliverydetail.manufactureDate','tr_goodsdeliverydetail.expiredDate','ms_product.productName','tr_salesorderdetail.price as HPP',new Expression('SUM(tr_goodsdeliverydetail.qty) as qtyStock')])
                                        ->leftJoin('tr_goodsdeliveryhead', 'tr_goodsdeliveryhead.goodsDeliveryNum = tr_goodsdeliverydetail.goodsDeliveryNum')
                                        ->leftJoin('tr_salesorderdetail', 'tr_salesorderdetail.salesOrderNum = tr_goodsdeliveryhead.refNum')
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_goodsdeliverydetail.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = tr_goodsdeliverydetail.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('tr_goodsdeliverydetail.goodsDeliveryNum = :refNum',[':refNum' => $filter])
                                        ->groupBy('tr_goodsdeliverydetail.goodsDeliveryNum')
                                        ->all();
//                        var_dump($newModel);
//                        yii::$app->end();
//        
        $this->layout = 'browseLayout';
        return $this->render('browsebygd', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionBrowsesample($filter = null)
    {
        $this->view->params['browse'] = true;
        $model = new MsProduct();
		$model->flagActive = 1;
        $model->load(Yii::$app->request->get());
        $this->layout = 'browseLayout';
        return $this->render('browsesample', [
            'model' => $model
        ]);
    }
    public function actionBrowsegoods($filter = null)
    {
        $this->view->params['browse'] = true;
        $model = new MsProduct();
        $model->flagActive = 1;
        $model->load(Yii::$app->request->queryParams);
        if ($filter <> -1){
            $model->productName = $filter;
        }
        $this->layout = 'browseLayout';
        return $this->render('browsegoods', [
            'model' => $model
        ]);
    }
    public function actionGet()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        if(Yii::$app->request->post() !== null){
            $data = Yii::$app->request->post();
            $productID = $data['productID'];
            $detailModel = MsProductdetail::findOne($productID);
            if ($detailModel !== null){
                $result['productName'] = $detailModel->product->productName;
                $result['uomName'] = $detailModel->uom->uomName;
                $result['buyPrice'] = $detailModel->buyPrice;
                $result['sellPrice'] = $detailModel->sellPrice;
            }
        }
        return Json::encode($result);
    }
    
    public function actionGetall()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $result = MsProduct::find()
                ->select(['ms_product.productName AS name'])
                ->asArray()
                ->all();
        
        return $result;
    }
    
    /**
     * Creates a new MsProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
 

    /**
     * Updates an existing MsProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
  
    /**
     * Deletes an existing MsProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
   
    /**
     * Finds the MsProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
//    protected function findModel($id)
//    {
//        if (($model = MsProduct::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }
    
}
