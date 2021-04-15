<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_supplier".
 *
 * @property integer $supplierID
 * @property string $supplierName
 * @property string $contactPerson
 * @property string $address
 * @property string $phone
 * @property string $fax
 * @property string $mobile
 * @property string $email
 * @property string $npwp
 * @property string $npwpAddress
 * @property string $npwpRegisteredDate
 * @property string $notes
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsSupplier extends \yii\db\ActiveRecord
{
    public $joinMsSupplierDetail;
    public $joinMsSupplierContactDetail;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplierName'], 'required'],
            [['npwpRegisteredDate', 'createdDate', 'editedDate', 'joinMsSupplierDetail', 'joinMsSupplierContactDetail'], 'safe'],
            [['isForwarder', 'flagActive'], 'boolean'],
            [['postalCode'], 'string', 'max' => 10],
            [['country', 'province','city', 'url', 'npwp', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['supplierName','email','npwpAddress', 'street', 'notes'], 'string', 'max' => 200],
            [['officeNumber', 'factoryNumber', 'mobile'], 'string', 'max' => 200],
            [['fax'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplierID' => 'Supplier ID',
            'supplierName' => 'Supplier Name',
            'isForwarder' => 'Is Forwarder (PPJK)',
            'officeNumber' => 'Office Number',
            'factoryNumber' => 'Factory Number',
            'fax' => 'Fax',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'street' => 'Street',
            'postalCode' => 'Postal Code',
            'url' => 'URL Address',
            'npwp' => 'NPWP',
            'npwpAddress' => 'NPWP Address',
            'npwpRegisteredDate' => 'NPWP Registered Date',
            'notes' => 'Notes',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date'
        ];
    }
    public function scopes()
    {
        return array(
            'supp' => array('order' => 'supplierName ASC'),
        );
    }

    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'supplierName', $this->supplierName]);

        if($this->flagActive != NULL){
            $query = self::find()
                ->andFilterWhere(['like', 'supplierName', $this->supplierName])
                ->andFilterWhere(['like', 'officeNumber', $this->officeNumber])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'supplierName', $this->supplierName])
                ->andFilterWhere(['like', 'officeNumber', $this->officeNumber])
                ->andFilterWhere(['like', 'email', $this->email]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['supplierName' => SORT_ASC],
                'attributes' => [
                    'supplierName',
                    'officeNumber',
                    'email',
                    'flagActive'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
    public function searchNonForwarder()
    {
        $query = self::find()
                ->where('flagActive = 1')
                ->andWhere('isForwarder = 0')
                ->andFilterWhere(['like', 'supplierName', $this->supplierName])
                ->andFilterWhere(['like', 'officeNumber', $this->officeNumber])
                ->andFilterWhere(['like', 'email', $this->email]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['supplierName' => SORT_ASC],
                'attributes' => [
                    'supplierName',
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
    public function getPicSupplier()
    {
        return $this->hasMany(MsSupplierdetail::className(), ['supplierID' => 'supplierID']);
    }
    public function getSupplierContact()
    {
        return $this->hasMany(MsSuppliercontactdetail::className(), ['supplierID' => 'supplierID']);
    }
    public function afterFind(){
        parent::afterFind();
        $this->joinMsSupplierContactDetail = [];
        $this->joinMsSupplierDetail = [];
        $i = 0;
        foreach ($this->getPicSupplier()->all() as $joinMsSupplierDetail) {
            $this->joinMsSupplierDetail[$i]["supplierDetailID"] = $joinMsSupplierDetail->supplierDetailID;
            $this->joinMsSupplierDetail[$i]["bankName"] = $joinMsSupplierDetail->bankName;
            $this->joinMsSupplierDetail[$i]["swiftCode"] = $joinMsSupplierDetail->swiftCode;
            $this->joinMsSupplierDetail[$i]["accountNo"] = $joinMsSupplierDetail->accountNo;
            $this->joinMsSupplierDetail[$i]["country"] = $joinMsSupplierDetail->country;
            $this->joinMsSupplierDetail[$i]["city"] = $joinMsSupplierDetail->city;
            $this->joinMsSupplierDetail[$i]["street"] = $joinMsSupplierDetail->street;
            $this->joinMsSupplierDetail[$i]["postalCode"] = $joinMsSupplierDetail->postalCode;
            $i += 1;
        }

        $j = 0;
        foreach ($this->getSupplierContact()->all() as $joinMsSupplierContactDetail) {
            $this->joinMsSupplierContactDetail[$j]["supplierContactID"] = $joinMsSupplierContactDetail->supplierContactID;
            $this->joinMsSupplierContactDetail[$j]["nickname"] = $joinMsSupplierContactDetail->nickname;
            $this->joinMsSupplierContactDetail[$j]["contactPerson"] = $joinMsSupplierContactDetail->contactPerson;
            $this->joinMsSupplierContactDetail[$j]["position"] = $joinMsSupplierContactDetail->position;
            $j += 1;
        }
    }
}
