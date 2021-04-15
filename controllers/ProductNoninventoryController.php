<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\ControllerUAC;
use app\components\MdlDb;
use app\models\MapProductsupplier;
use app\models\MsProduct;
use app\models\MsProductdetail;
use app\models\SampleStockCard;
use app\models\StockHpp;
use app\models\TrGoodsdeliverydetail;
use app\models\TrGoodsreceiptdetail;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for MsProduct model.
 */
class ProductNoninventoryController extends MainController
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
     * Lists all MsProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MsProduct::find(),
        ]);
		$model = new MsProduct();
        $model->flagActive = 1;
        $model->load(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'dataProvider' => $dataProvider,
			'model' => $model
        ]);
    }

    /**
     * Displays a single MsProduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

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
							'sort' => [
								'defaultOrder' => ['productName' => SORT_ASC],
								'attributes' => [
									'productName',
								]
							]
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
                                        ->select(['tr_stockhpp.productID','ms_productdetail.uomID','ms_uom.uomName',
                                            'tr_stockhpp.batchNumber','tr_stockhpp.manufactureDate','tr_stockhpp.expiredDate','tr_stockhpp.retestDate','ms_product.productName',
                                            'tr_stockhpp.HPP',new Expression('SUM(tr_stockhpp.qtyStock) as qtyStock')])
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_stockhpp.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = tr_stockhpp.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('tr_stockhpp.warehouseID = :warehouseID',[':warehouseID' => $filter])
                                        ->AndWhere('tr_stockhpp.qtyStock > 0')
                                        ->andFilterWhere(['like', 'ms_product.productName', $model->productName])
                                        ->andFilterWhere(['=', 'tr_stockhpp.batchNumber', $model->batchNumber])
                                        ->andFilterWhere(['=', 'tr_stockhpp.expiredDate',  AppHelper::convertDateTimeFormat($model->expiredDate, 'd-m-Y', 'Y-m-d')])
                                        ->andFilterWhere(['=', 'tr_stockhpp.manufactureDate',  AppHelper::convertDateTimeFormat($model->manufactureDate, 'd-m-Y', 'Y-m-d')])
                                        ->groupBy('tr_stockhpp.productID , tr_stockhpp.batchNumber'),
                                       
                                'sort' => [
								'defaultOrder' => ['productName' => SORT_ASC],
								'attributes' => [
									'productName',
                                    'batchNumber',
                                    'qtyStock',
                                    'HPP',
                                    'manufactureDate',
                                    'expiredDate'
								]
							]
                        ]);

        $this->layout = 'browseLayout';
        return $this->render('browsebywarehouse', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionBrowsebywarehouses($filter)
    {
        $this->view->params['browse'] = true;
        $model = new StockHpp();
        $model->load(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
                            'query' => StockHpp::find()
                                        ->select(['tr_stockhpp.productID','ms_productdetail.uomID','ms_uom.uomName',
                                            'tr_stockhpp.batchNumber','tr_stockhpp.manufactureDate','tr_stockhpp.expiredDate','tr_stockhpp.retestDate','ms_product.productName',
                                            'tr_stockhpp.HPP',new Expression('SUM(tr_stockhpp.qtyStock) as qtyStock')])
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_stockhpp.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = tr_stockhpp.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('tr_stockhpp.warehouseID = :warehouseID',[':warehouseID' => $filter])
                                        ->andFilterWhere(['like', 'ms_product.productName', $model->productName])
                                        ->andFilterWhere(['=', 'tr_stockhpp.batchNumber', $model->batchNumber])
                                        ->andFilterWhere(['=', 'tr_stockhpp.expiredDate',  AppHelper::convertDateTimeFormat($model->expiredDate, 'd-m-Y', 'Y-m-d')])
                                        ->andFilterWhere(['=', 'tr_stockhpp.manufactureDate',  AppHelper::convertDateTimeFormat($model->manufactureDate, 'd-m-Y', 'Y-m-d')])
                                        ->groupBy('tr_stockhpp.productID , tr_stockhpp.batchNumber'),
                                       
                                'sort' => [
								'defaultOrder' => ['productName' => SORT_ASC],
								'attributes' => [
									'productName',
                                    'batchNumber',
                                    'qtyStock',
                                    'HPP',
                                    'manufactureDate',
                                    'expiredDate'
								]
							]
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
                                        ->select(['ms_product.productName','tr_stockcardsample.productID','ms_productdetail.uomID','ms_uom.uomName','tr_stockcardsample.batchNumber','tr_stockcardsample.manufactureDate','tr_stockcardsample.expiredDate','tr_stockcardsample.retestDate','ms_product.productName',new Expression('0 as HPP'),new Expression('SUM(tr_stockcardsample.inQty - tr_stockcardsample.outQty) as qtyStock')])
                                        ->leftJoin('ms_product', 'ms_product.productID = tr_stockcardsample.productID')
                                        ->leftJoin('ms_productdetail', 'ms_productdetail.productID = tr_stockcardsample.productID')
                                        ->leftJoin('ms_uom', 'ms_uom.uomID = ms_productdetail.uomID')
                                        ->where('tr_stockcardsample.warehouseID = :refNum',[':refNum' => $filter])
                                        ->andFilterWhere(['like', 'ms_product.productName', $model->productName])
                                        ->andFilterWhere(['like', 'tr_stockcardsample.batchNumber', $model->batchNumber])
                                        ->andFilterWhere(['=', 'tr_stockcardsample.expiredDate',  AppHelper::convertDateTimeFormat($model->expiredDate, 'd-m-Y', 'Y-m-d')])
                                        ->andFilterWhere(['=', 'tr_stockcardsample.manufactureDate',  AppHelper::convertDateTimeFormat($model->manufactureDate, 'd-m-Y', 'Y-m-d')])
                                        ->groupBy('tr_stockcardsample.productID')
                                        ->groupBy('tr_stockcardsample.batchNumber'),
            
                                'sort' => [
								'defaultOrder' => ['productName' => SORT_ASC],
								'attributes' => [
									'productName',
                                    'batchNumber',
                                    'qtyStock',
                                    'HPP',
                                    'manufactureDate',
                                    'expiredDate'
								]
							]
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
                                        ->select(['ms_product.productName', 'tr_goodsdeliverydetail.productID','tr_goodsdeliverydetail.uomID as unitID','ms_uom.uomName','tr_goodsdeliverydetail.manufactureDate','tr_goodsdeliverydetail.expiredDate','ms_product.productName','tr_salesorderdetail.price as HPP',new Expression('SUM(tr_goodsdeliverydetail.qty) as qtyStock')])
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
            'model' => $model,
            
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
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
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
    public function actionCreate()
    {
        $model = new MsProduct();
        $model->buyPrice = "0,00";
        $model->sellPrice = "0,00";
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
            if ($this->saveModel($model)) {
                return $this->redirect(['index']);
            } 
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->productDetailID = $model->productDetails->productDetailID;
        $model->uomID = $model->productDetails->uomID;
        $model->packingTypeID = $model->productDetails->packingTypeID;
        $model->uomQty = $model->productDetails->uomQty;
        $model->buyPrice = $model->productDetails->buyPrice;
        $model->sellPrice = $model->productDetails->sellPrice;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
       if ($model->load(Yii::$app->request->post())) {
            $model->editedBy = Yii::$app->user->identity->username;
            $model->editedDate = new Expression('NOW()');
            if ($this->updateModel($model)) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MsProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->flagActive = 0;
        $model->save(false);

        return $this->redirect(['index']);

        
    }
    public function actionRestore($id)
    {
        $model = $this->findModel($id);

        $model->flagActive = 1;
        $model->save(false);

        return $this->redirect(['index']);
    }
    /**
     * Finds the MsProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function saveModel($model)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        $model->minQty = str_replace(",",".",str_replace(".","",$model->minQty));
        if (!$model->save()) {
            print_r($model->getErrors());
            Yii::$app->end();
            $transaction->rollBack();
            return false;
        } 
      
        $mapProductSupplierModel = new MapProductsupplier();
        $mapProductSupplierModel->supplierID = $model->supplierID;
        $mapProductSupplierModel->productID = $model->productID;
        if (!$mapProductSupplierModel->save()) {
            print_r($mapProductSupplierModel->getErrors());
            $transaction->rollBack();
            return false;
        } 

        MsProductdetail::deleteAll('productID = :productID', [":productID" => $model->productID]);
        
        $msProductDetailModel = new MsProductdetail();
        $msProductDetailModel->productID = $model->productID;
        $msProductDetailModel->uomID = $model->uomID;
        $msProductDetailModel->packingTypeID = $model->packingTypeID;
        $msProductDetailModel->uomQty = str_replace(",",".",str_replace(".","",$model->uomQty));
        $msProductDetailModel->buyPrice = $model->buyPrice;
        $msProductDetailModel->sellPrice = $model->sellPrice;
        $msProductDetailModel->buyPrice = str_replace(",",".",str_replace(".","",$msProductDetailModel->buyPrice));
        $msProductDetailModel->sellPrice = str_replace(",",".",str_replace(".","",$msProductDetailModel->sellPrice));
               
        if (!$msProductDetailModel->save()) {
            print_r($msProductDetailModel->getErrors());
            $transaction->rollBack();
            return false;
        }
                
        $transaction->commit(); 
        return true;
    }
    protected function updateModel($model)
    {
        $connection = MdlDb::getDbConnection();
        $transaction = $connection->beginTransaction();
        $model->minQty = str_replace(",",".",str_replace(".","",$model->minQty));
        if (!$model->save()) {
            print_r($model->getErrors());
            $transaction->rollBack();
            return false;
        }       
        
        $msProductDetailModel = MsProductdetail::findOne($model->productDetailID);
        $msProductDetailModel->productID = $model->productID;
        $msProductDetailModel->uomID = $model->uomID;
        $msProductDetailModel->packingTypeID = $model->packingTypeID;
        $msProductDetailModel->uomQty = str_replace(",",".",str_replace(".","",$model->uomQty));
        $msProductDetailModel->buyPrice = $model->buyPrice;
        $msProductDetailModel->sellPrice = $model->sellPrice;
        $msProductDetailModel->buyPrice = str_replace(",",".",str_replace(".","",$msProductDetailModel->buyPrice));
        $msProductDetailModel->sellPrice = str_replace(",",".",str_replace(".","",$msProductDetailModel->sellPrice));
        if (!$msProductDetailModel->save()) {
            print_r($msProductDetailModel->getErrors());
            $transaction->rollBack();
            return false;
        }
                
        $transaction->commit(); 
        return true;
    }
}
