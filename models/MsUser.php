<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "ms_user".
 *
 * @property string $username
 * @property string $fullName
 * @property string $password
 * @property string $salt
 * @property string $userRole
 * @property boolean $flagActive
 * @property string $createdBy
 * @property string $createdDate
 * @property string $editedBy
 * @property string $editedDate
 */
class MsUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'fullName', 'userRole'], 'required'],
            [['flagActive'], 'boolean'],
            [['createdDate', 'editedDate','dashboard'], 'safe'],
            [['username', 'email', 'phoneNumber', 'createdBy', 'editedBy'], 'string', 'max' => 50],
            [['fullName'], 'string', 'max' => 200],
            [['password'], 'string', 'max' => 255],
            [['salt'], 'string', 'max' => 45],
            [['userRole'], 'string', 'max' => 100],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'User Name',
            'fullName' => 'Full Name',
            'password' => 'Password',
            'salt' => 'Salt Password',
            'userRole' => 'User Role',
            'flagActive' => 'Status',
            'createdBy' => 'Create By',
            'createdDate' => 'Create Date',
            'editedBy' => 'Edited By',
            'editedDate' => 'Edited Date',
            'email' => 'E-mail',
            'phoneNumber' => 'Phone Number',
            'dasboard' => 'Dasboard',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public static function findByUsername($username)
    {
        $user = MsUser::findOne([
            'username'=>$username,
            'flagActive'=>1,
        ]);

        return $user;
    }

    public function validatePassword($password)
    {
        if (md5($password.$this->salt) === $this->password)
            return true;
        else
            return false; 
    }


    public function search()
    {
        if($this->flagActive != NULL){
            $query = self::find()
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'fullName', $this->fullName])
                ->andFilterWhere(['=', 'flagActive', $this->flagActive]);
        }else{
            $query = self::find()
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'fullName', $this->fullName]);
        }

        if (strlen($this->userRole) > 0)
            $query = $query->andFilterWhere(['=', 'userRole', $this->userRole]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['username' => SORT_ASC],
                'attributes' => [
                    'username', 
                    'userRole', 
                    'fullName'
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $dataProvider;
    }
    public static function findIdentity($id)
    {   
        return MsUser::findOne($id);
    }
    
    public function getId()
    {
        return $this->username;
    }
    
    public function getAuthKey()
    {
        return null;
    }
    
    public function validateAuthKey($authKey)
    {
        return null;
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
}
