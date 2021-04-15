<?php

namespace app\controllers;

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\ChangePasswordForm;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\MsDepot;
use app\models\TrCustomerreceivablehead;
use app\models\TrGoodsreceipthead;
use app\models\TrPurchaseorderhead;
use app\models\TrSupplierpayablehead;
use app\models\StockCard;
use Faker\Provider\zh_CN\DateTime;
use kartik\form\ActiveForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\response;

class SiteController extends Controller
{
    public static $dashboardList = [
        'actionIndexDefault' => 'Default Landing Page',
        'actionIndexPendingShipment' => 'Pending Shipment',
        'actionIndexPayableReceivable' => 'Payable Receivable' 
    ];
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

//    public function actionIndex()
//    {
//        $model = new TrPurchaseorderhead();
//        $model->load(Yii::$app->request->queryParams);
//        $dataProvider = new ActiveDataProvider([
//                            'query' => TrPurchaseorderhead::find()
//                                        ->select(['purchaseOrderNum','purchaseOrderDate', 'shipmentDate','tr_purchaseorderhead.supplierID','ms_supplier.supplierName'])
//                                        ->joinWith('goodsReceipt')
//                                        ->joinWith('supplier')
//                                        ->where('tr_goodsreceipthead.refNum is null')
//                                        ->andFilterWhere(['like', 'purchaseOrderNum', $model->purchaseOrderNum])
//                                        ->andFilterWhere(['=', "DATE_FORMAT(purchaseOrderDate, '%m-%Y')", $model->purchaseOrderDate])
//                                        ->andFilterWhere(['=', "DATE_FORMAT(shipmentDate, '%m-%Y')", $model->shipmentDate])
//                                        ->andFilterWhere(['=', 'tr_purchaseorderhead.supplierID', $model->supplierID])
//                        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//            'model' => $model,
//        ]);
//    }
    
    public function actionIndex()
    {
        $index = Yii::$app->user->identity->dashboard;
        if (!$index) $index = array_keys(self::$dashboardList)[0];
        
        return $this->$index();
    }
    
     public function actionIndexDefault()
    {
        return $this->render('index-default', [
            'user' => Yii::$app->user->identity,
        ]);
    }
    
    public function actionIndexPendingShipment()
    {
        $model = new TrGoodsreceipthead();
        //$model->startDate = date('01-01-Y');
        //$model->endDate = date('t-m-Y', strtotime(date('01-12-Y')));
        
        $model->load(Yii::$app->request->queryParams);

        return $this->render('/goods-receipt/index', [
            'model' => $model,
        ]);
    }
    
    public function actionIndexPayableReceivable()
    {
        $payable = new TrSupplierpayablehead();
        $payable->startDate  = date('1-m-Y');
        $payable->endDate = date('d-m-Y'); 
        $payable->load(Yii::$app->request->queryParams);

        $receivable = new TrCustomerreceivablehead();
//        $receivable->startDate  = date('1-m-Y');
//        $receivable->endDate = date('d-m-Y'); 
        $receivable->load(Yii::$app->request->queryParams);
        
        $ppjk = new TrGoodsreceipthead();
        $ppjk->load(Yii::$app->request->queryParams);

        $stock = new StockCard();
        $stock->load(Yii::$app->request->queryParams);
        
        return $this->render('index-accounting', [
            'payable' => $payable,
            'receivable' => $receivable,
            'ppjk' => $ppjk,
            'stock' => $stock
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'main-login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['site/index']);
        } else {
            Yii::getLogger()->log($model->errors, Logger::LEVEL_INFO, "SITE_CONTROLLER");
            return $this->render('change-password', [
                'model' => $model,
            ]);
        }
    }
}