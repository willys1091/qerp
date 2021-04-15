<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;
use app\components\MdlDb;
use app\components\AppHelper;
use yii\data\SqlDataProvider;
use yii\helpers\Json;

/**
 * This is the model class for table "tr_documentcontrolhead".
 *
 * @property integer $docControlHeadID
 * @property integer $lkDocumentTypeID
 * @property string $refNum
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class TrDocumentcontrolhead extends \yii\db\ActiveRecord
{
    public $documentType;
    public $documentID;
    public $documentFiles;
    public $documentAmount;
    public $joinDocumentDetail;
    public $refID;
    public $refNumber;
    public $refDate;
    public $refSupplier;
    public $status;
    public $documentTypeName;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tr_documentcontrolhead';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['docControlHeadID', 'lkDocumentTypeID'], 'integer'],
            [['createdDate', 'editedDate'], 'safe'],
            [['refNum', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['documentFiles'], 'file', 'extensions' => 'pdf', 'maxFiles' => 5],
            [['refNumber','refDate'], 'safe', 'on'=>'search'],
            [['joinDocumentDetail','documentID'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'docControlHeadID' => 'Document Control Head ID',
            'lkDocumentTypeID' => 'Document Type',
            'refNum' => 'Reference Number',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'documentFiles' => 'Document',
            'refNumber' => 'Reference Number',
            'refDate' => 'Date',
            'refSupplier' => 'Supplier',
            'status' => 'Status'
        ];
    }
    public function search()
    {
        $sql = "SELECT a.purchaseOrderNum as refID, a.purchaseOrderNum as refNumber,a.purchaseOrderDate as refDate, 
        (SELECT COUNT(*) FROM tr_documentcontroldetail AS dd WHERE dd.docControlHeadID = docHead.docControlHeadID AND dd.documentTypeID IN(SELECT documentTypeID FROM ms_documenttype AS dt WHERE dt.lkDocumentTypeID = docHead.lkDocumentTypeID AND dt.flagMandatory = 1))
         - (select count(docType2.documentTypeID) from ms_documenttype docType2 where docType2.flagMandatory=1 and docType2.lkDocumentTypeID=1) as status, (select dt.lkDocumentTypeName from lk_documenttype dt where dt.lkDocumentTypeID=1) as documentTypeName
        from tr_purchaseorderhead a left join tr_documentcontrolhead docHead
        on a.purchaseOrderNum=docHead.refNum
        left join tr_documentcontroldetail docDetail
        on docHead.docControlHeadID=docDetail.docControlHeadID
        left join ms_documenttype docType
        on docDetail.documentTypeID=docType.documentTypeID
        group by a.purchaseOrderNum
        union
        SELECT a.salesOrderNum as refID, a.salesOrderNum as refNumber,a.salesOrderDate as refDate, 
        (SELECT COUNT(*) FROM tr_documentcontroldetail AS dd WHERE dd.docControlHeadID = docHead.docControlHeadID AND dd.documentTypeID IN(SELECT documentTypeID FROM ms_documenttype AS dt WHERE dt.lkDocumentTypeID = docHead.lkDocumentTypeID AND dt.flagMandatory = 1))
        - (select count(docType2.documentTypeID) from ms_documenttype docType2 where docType2.flagMandatory=1 and docType2.lkDocumentTypeID=2) as status, (select dt.lkDocumentTypeName from lk_documenttype dt where dt.lkDocumentTypeID=2) as documentTypeName
        from tr_salesorderhead a left join tr_documentcontrolhead docHead
        on a.salesOrderNum=docHead.refNum
        left join tr_documentcontroldetail docDetail
        on docHead.docControlHeadID=docDetail.docControlHeadID
        left join ms_documenttype docType
        on docDetail.documentTypeID=docType.documentTypeID
        group by a.salesOrderNum
        union
        select b.productID as refID, b.productName as refNumber,b.createdDate as refDate, 
        (SELECT COUNT(*) FROM tr_documentcontroldetail AS dd WHERE dd.docControlHeadID = docHead2.docControlHeadID AND dd.documentTypeID IN(SELECT documentTypeID FROM ms_documenttype AS dt WHERE dt.lkDocumentTypeID = docHead2.lkDocumentTypeID AND dt.flagMandatory = 1))
         - (select count(docType3.documentTypeID) from ms_documenttype docType3 where docType3.flagMandatory=1 and docType3.lkDocumentTypeID=3) as status, (select dt.lkDocumentTypeName from lk_documenttype dt where dt.lkDocumentTypeID=3) as documentTypeName
        from ms_product b left join tr_documentcontrolhead docHead2
        on b.productName = docHead2.refNum
        left join tr_documentcontroldetail docDetail2
        on docHead2.docControlHeadID=docDetail2.docControlHeadID
        left join ms_documenttype docType2
        on docDetail2.documentTypeID=docType2.documentTypeID
        group by b.productID
        union
        select c.supplierID as refID, c.supplierName as refNumber,c.createdDate as refDate, 
        (SELECT COUNT(*) FROM tr_documentcontroldetail AS dd WHERE dd.docControlHeadID = docHead3.docControlHeadID AND dd.documentTypeID IN(SELECT documentTypeID FROM ms_documenttype AS dt WHERE dt.lkDocumentTypeID = docHead3.lkDocumentTypeID AND dt.flagMandatory = 1))
         - (select count(docType4.documentTypeID) from ms_documenttype docType4 where docType4.flagMandatory=1 and docType4.lkDocumentTypeID=3) as status, (select dt.lkDocumentTypeName from lk_documenttype dt where dt.lkDocumentTypeID=3) as documentTypeName
        from ms_supplier c left join tr_documentcontrolhead docHead3
        on c.supplierID = docHead3.refNum
        left join tr_documentcontroldetail docDetail3
        on docHead3.docControlHeadID=docDetail3.docControlHeadID
        left join ms_documenttype docType3
        on docDetail3.documentTypeID=docType3.documentTypeID
        group by c.supplierID";
        
        $sqlCount = "SELECT count(*) from (
                    SELECT purchaseOrderNum 
                    from tr_purchaseorderhead 
                    union
                    SELECT salesOrderNum
                    from tr_salesorderhead 
                    union
                    select productID
                    from ms_product 
                    union
                    select supplierID
                    from ms_supplier) a";
        $count = Yii::$app->db->createCommand($sqlCount)->queryScalar();
        
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount'=> $count,
            'key' => 'refID',
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        $dataProvider->sort->attributes['refNum'] = [
            'asc' => ['refNum' => SORT_ASC],
            'desc' => ['refNum' => SORT_DESC],
        ];
        
        return $dataProvider;
    }

    public function searchpembelian()
    {
        $sql = "SELECT a.purchaseOrderNum as refID, a.purchaseOrderNum as refNumber,a.purchaseOrderDate as refDate, 
        (SELECT COUNT(*) FROM tr_documentcontroldetail AS dd WHERE dd.docControlHeadID = docHead.docControlHeadID AND dd.documentTypeID IN(SELECT documentTypeID FROM ms_documenttype AS dt WHERE dt.lkDocumentTypeID = docHead.lkDocumentTypeID AND dt.flagMandatory = 1))
         - (select count(docType2.documentTypeID) from ms_documenttype docType2 where docType2.flagMandatory=1 and docType2.lkDocumentTypeID=1) as status, (select dt.lkDocumentTypeName from lk_documenttype dt where dt.lkDocumentTypeID=1) as documentTypeName
        from tr_purchaseorderhead a left join tr_documentcontrolhead docHead
        on a.purchaseOrderNum=docHead.refNum
        left join tr_documentcontroldetail docDetail
        on docHead.docControlHeadID=docDetail.docControlHeadID
        left join ms_documenttype docType
        on docDetail.documentTypeID=docType.documentTypeID
        group by a.purchaseOrderNum";
       
        $sqlCount = "SELECT count(*) from (
                    SELECT purchaseOrderNum 
                    from tr_purchaseorderhead 
                    union
                    SELECT salesOrderNum
                    from tr_salesorderhead 
                    union
                    select productID
                    from ms_product 
                    union
                    select supplierID
                    from ms_supplier) a";
        $count = Yii::$app->db->createCommand($sqlCount)->queryScalar();
        
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount'=> $count,
            'key' => 'refID',
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        $dataProvider->sort->attributes['refNum'] = [
            'asc' => ['refNum' => SORT_ASC],
            'desc' => ['refNum' => SORT_DESC],
        ];
        
        return $dataProvider;
    }

    public function searchpenjualan()
    {
        $sql = "SELECT a.salesOrderNum as refID, a.salesOrderNum as refNumber,a.salesOrderDate as refDate, 
        (SELECT COUNT(*) FROM tr_documentcontroldetail AS dd WHERE dd.docControlHeadID = docHead.docControlHeadID AND dd.documentTypeID IN(SELECT documentTypeID FROM ms_documenttype AS dt WHERE dt.lkDocumentTypeID = docHead.lkDocumentTypeID AND dt.flagMandatory = 1))
        - (select count(docType2.documentTypeID) from ms_documenttype docType2 where docType2.flagMandatory=1 and docType2.lkDocumentTypeID=2) as status, (select dt.lkDocumentTypeName from lk_documenttype dt where dt.lkDocumentTypeID=2) as documentTypeName
        from tr_salesorderhead a left join tr_documentcontrolhead docHead
        on a.salesOrderNum=docHead.refNum
        left join tr_documentcontroldetail docDetail
        on docHead.docControlHeadID=docDetail.docControlHeadID
        left join ms_documenttype docType
        on docDetail.documentTypeID=docType.documentTypeID
        group by a.salesOrderNum
       ";
        
        $sqlCount = "SELECT count(*) from (
                    SELECT purchaseOrderNum 
                    from tr_purchaseorderhead 
                    union
                    SELECT salesOrderNum
                    from tr_salesorderhead 
                    union
                    select productID
                    from ms_product 
                    union
                    select supplierID
                    from ms_supplier) a";
        $count = Yii::$app->db->createCommand($sqlCount)->queryScalar();
        
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount'=> $count,
            'key' => 'refID',
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        $dataProvider->sort->attributes['refNum'] = [
            'asc' => ['refNum' => SORT_ASC],
            'desc' => ['refNum' => SORT_DESC],
        ];
        
        return $dataProvider;
    }

    public function searchlain()
    {
        $sql = "select b.productID as refID, b.productName as refNumber,b.createdDate as refDate, 
        (SELECT COUNT(*) FROM tr_documentcontroldetail AS dd WHERE dd.docControlHeadID = docHead2.docControlHeadID AND dd.documentTypeID IN(SELECT documentTypeID FROM ms_documenttype AS dt WHERE dt.lkDocumentTypeID = docHead2.lkDocumentTypeID AND dt.flagMandatory = 1))
         - (select count(docType3.documentTypeID) from ms_documenttype docType3 where docType3.flagMandatory=1 and docType3.lkDocumentTypeID=3) as status, (select dt.lkDocumentTypeName from lk_documenttype dt where dt.lkDocumentTypeID=3) as documentTypeName
        from ms_product b left join tr_documentcontrolhead docHead2
        on b.productName = docHead2.refNum
        left join tr_documentcontroldetail docDetail2
        on docHead2.docControlHeadID=docDetail2.docControlHeadID
        left join ms_documenttype docType2
        on docDetail2.documentTypeID=docType2.documentTypeID
        group by b.productID
        union
        select c.supplierID as refID, c.supplierName as refNumber,c.createdDate as refDate, 
        (SELECT COUNT(*) FROM tr_documentcontroldetail AS dd WHERE dd.docControlHeadID = docHead3.docControlHeadID AND dd.documentTypeID IN(SELECT documentTypeID FROM ms_documenttype AS dt WHERE dt.lkDocumentTypeID = docHead3.lkDocumentTypeID AND dt.flagMandatory = 1))
         - (select count(docType4.documentTypeID) from ms_documenttype docType4 where docType4.flagMandatory=1 and docType4.lkDocumentTypeID=3) as status, (select dt.lkDocumentTypeName from lk_documenttype dt where dt.lkDocumentTypeID=3) as documentTypeName
        from ms_supplier c left join tr_documentcontrolhead docHead3
        on c.supplierID = docHead3.refNum
        left join tr_documentcontroldetail docDetail3
        on docHead3.docControlHeadID=docDetail3.docControlHeadID
        left join ms_documenttype docType3
        on docDetail3.documentTypeID=docType3.documentTypeID
        group by c.supplierID";
        
        $sqlCount = "SELECT count(*) from (
                    SELECT purchaseOrderNum 
                    from tr_purchaseorderhead 
                    union
                    SELECT salesOrderNum
                    from tr_salesorderhead 
                    union
                    select productID
                    from ms_product 
                    union
                    select supplierID
                    from ms_supplier) a";
        $count = Yii::$app->db->createCommand($sqlCount)->queryScalar();
        
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount'=> $count,
            'key' => 'refID',
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        $dataProvider->sort->attributes['refNum'] = [
            'asc' => ['refNum' => SORT_ASC],
            'desc' => ['refNum' => SORT_DESC],
        ];
        
        return $dataProvider;
    }

    public function getDocumenttype(){
        return $this->hasMany(LkDocumenttype::className(), ['lkDocumentTypeID' => 'lkDocumentTypeID']);
    }
    public function getMasterDocument()
    {
        return $this->hasMany(MsDocumenttype::className(), ['lkDocumentTypeID' => 'lkDocumentTypeID']);
    }
    public function getParentSupplier(){
        return $this->hasOne(MsSupplier::className(), ['supplierID' => 'supplierID']);
    }
    public function getDocumentDetail()
    {
        return $this->hasMany(TrDocumentcontroldetail::className(), ['docControlHeadID' => 'docControlHeadID']);
    }
    public function getUploadProductDirectory($isBasePath = true)
    {
        if ($isBasePath) {
            return Yii::$app->basePath . '/web/uploads/document/' . $this->docControlHeadID . "/";
        } else {
            return Yii::$app->urlManager->baseUrl . '/uploads/document/' . $this->docControlHeadID . "/";
        }
    }
    public function getPhotosInitialPreview()
    {
        $files = FileHelper::findFiles($this->getUploadProductDirectory(), ['recursive' => false]);
        $image = [];
        if (isset($files[0])) {
            foreach ($files as $index => $file) {
                $file = explode("/", $file);
                $file = end($file);
                $file = explode("\\", $file);
                $file = end($file);
                if(StringHelper::startsWith($file, $this->productID, false)){
                    $file = $this->getUploadProductDirectory(false) . $file;
                    $image[] = '<img src="' . $file . '" class="file-preview-image">';
                }
            }
        }
        return $image;
    }
    
    public function getPhotosInitialPreviewConfig()
    {
        $files = FileHelper::findFiles($this->getUploadProductDirectory(), ['recursive' => false]);
        $image = [];
        if (isset($files[0])) {
            foreach ($files as $index => $file) {
                $file = explode("/", $file);
                $file = end($file);
                $file = explode("\\", $file);
                $file = end($file);
//                $file = end(explode("/", $file));
//                $file = end(explode("\\", $file));
                if(StringHelper::startsWith($file, $this->docControlHeadID, false)){
                    $image[] = [
                        'url' => Yii::$app->urlManager->createUrl(['product/remove-image', 'id' => $this->docControlHeadID]),
                        'key' => $file,
                        'extra' => ['key' => $file]
                    ];
                }
            }
        }
        return $image;
    }
    
    public function removeImage($imageID)
    {
        $filePath = $this->getUploadProductDirectory() . $imageID;
        unlink($filePath);
    }

    public function viewData(){
        $connection = MdlDb::getDbConnection();
        $sql = "SELECT a.purchaseOrderNum as refNum,a.purchaseOrderDate as date
                from tr_purchaseorderhead a
                union
                select b.productName as refNum,'' as date
                from ms_product b
                union
                select c.supplierName as refNum,'' as date
                from ms_supplier c";
        $temp = $connection->createCommand($sql);
        $headResult = $temp->queryAll();

        $i = 0;
        foreach ($headResult as $detailMenu) {
            $this->refNum[$i] = $detailMenu['refNum'];
            if($detailMenu['refDate'] != '')
                $this->refDate[$i] = AppHelper::convertDateTimeFormat($detailMenu['date'], 'Y-m-d H:i:s', 'd-m-Y');
            else
                $this->refDate[$i] = '';

            $i += 1;
        }
    }

    public function afterFind(){        
        parent::afterFind();

        if (strpos($this->refNumber, 'PO') !== false){
            $this->lkDocumentTypeID = 2;
        }
        else{
            $this->lkDocumentTypeID = 3;
        }
        if($this->status <=0)
            $this->status = 'Incomplete';
        else
            $this->status = 'Complete';
    }
}
