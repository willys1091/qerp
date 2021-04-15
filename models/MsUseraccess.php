<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\LkFilteraccess;

/**
 * This is the model class for table "ms_useraccess".
 *
 * @property integer $ID
 * @property string $userRole
 * @property string $accessID
 * @property boolean $indexAcc
 * @property boolean $viewAcc
 * @property boolean $insertAcc
 * @property boolean $updateAcc
 * @property boolean $deleteAcc
 */
class MsUseraccess extends \yii\db\ActiveRecord
{
    public $joinMsUserAccess;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_useraccess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userRole'], 'required'],
            [['indexAcc', 'viewAcc', 'insertAcc', 'updateAcc', 'deleteAcc'], 'boolean'],
            [['userRole'], 'string', 'max' => 100],
            [['accessID'], 'string', 'max' => 10],
            [['ID'], 'integer'],
            [['accessID'], 'exist', 'skipOnError' => true, 'targetClass' => LkFilteraccess::className(), 'targetAttribute' => ['accessID' => 'accessID']],
            [['joinMsUserAccess'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'userRole' => 'User Role',
            'accessID' => 'Access ID',
            'indexAcc' => 'Index Access',
            'viewAcc' => 'View Access',
            'insertAcc' => 'Insert Access',
            'updateAcc' => 'Update Access',
            'deleteAcc' => 'Delete Access',
        ];
    }

    public function search()
    {
        $query = self::find()
            ->select(['userRole','flagActive'])->distinct()
            ->andFilterWhere(['like', 'userRole', $this->userRole]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['userRole' => SORT_ASC],
                'attributes' => ['userRole']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
}
