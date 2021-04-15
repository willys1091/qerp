<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\AppHelper;

/**
 * This is the model class for table "ms_productcategory".
 *
 * @property integer $productCategoryID
 * @property string $ProductCategoryName
 * @property string $coaNo
 * @property string $notes
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsProductcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_productcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProductCategoryName','coaNo'], 'required'],
            [['flagActive', 'flagInventory'], 'boolean'],
            [['createdDate', 'editedDate'], 'safe'],
            [['ProductCategoryName', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['coaNo'], 'string', 'max' => 20],
            [['notes'], 'string', 'max' => 100],
            [['coaNo'], 'exist', 'skipOnError' => true, 'targetClass' => MsCoa::className(), 'targetAttribute' => ['coaNo' => 'coaNo']],
            [['ProductCategoryName','coaNo','notes','flagActive'], 'safe', 'on'=>'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productCategoryID' => 'Product Category ID',
            'ProductCategoryName' => 'Category Name',
            'coaNo' => 'COA Number',
            'flagInventory' => 'Is Inventory?',
            'notes' => 'Notes',
            'flagActive' => 'Status',
            'createdBy' => 'Created By',
            'createdDate' => 'Created Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
        ];
    }
	public function search()
    {
        if($this->flagActive != NULL){
            $query = self::find()
                ->andFilterWhere(['like', 'ProductCategoryName', $this->ProductCategoryName])
                ->andFilterWhere(['like', 'notes', $this->notes])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'ProductCategoryName', $this->ProductCategoryName])
                ->andFilterWhere(['like', 'notes', $this->notes]);
        }
         
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['ProductCategoryName' => SORT_ASC],
                'attributes' => ['ProductCategoryName']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
		
        return $dataProvider;
    }
    public function getCoaNos(){
        return $this->hasOne(MsCoa::className(), ['coaNo' => 'coaNo']);
    }
}
