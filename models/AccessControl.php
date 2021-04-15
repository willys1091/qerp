<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lk_accesscontrol".
 *
 * @property string $accessID Access ID
 * @property string $description Description
 * @property string $node Controller
 * @property string $icon Icon
 * @property int $ordinal
 * @property int $level
 */
class AccessControl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lk_accesscontrol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accessID', 'description'], 'required'],
            [['ordinal', 'level'], 'integer'],
            [['accessID'], 'string', 'max' => 10],
            [['description', 'node', 'icon'], 'string', 'max' => 50],
            [['accessID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'accessID' => 'Access ID',
            'description' => 'Description',
            'node' => 'Node',
            'icon' => 'Icon',
            'ordinal' => 'Ordinal',
            'level' => 'Level',
        ];
    }
            
    public static function getMenus($userRole) {
        $menus = AccessControl::find()
                ->select(['lk_accesscontrol.accessID','lk_accesscontrol.description','lk_accesscontrol.icon','lk_accesscontrol.ordinal'])
                ->from('lk_useraccess')
                ->innerJoin('lk_accesscontrol', 'LEFT(lk_useraccess.accessID,1) = lk_accesscontrol.accessID')
                ->where(['and',['userRole' => $userRole,'level' => 1]])
                ->distinct()
                ->orderBy('lk_accesscontrol.ordinal')
                ->all();
                
        return $menus;
    }  
    
    public static function getSubMenus($userRole, $parentAccessID) {
        $menus = AccessControl::find()
                ->select(['lk_accesscontrol.accessID','lk_accesscontrol.description','lk_accesscontrol.icon','lk_accesscontrol.ordinal','lk_accesscontrol.node'])
                ->from('lk_useraccess')
                ->innerJoin('lk_accesscontrol', 'lk_useraccess.accessID = lk_accesscontrol.accessID')
                ->where(['and', ['userRole' => $userRole, 'level' => 2]])
                ->andWhere(['like', 'lk_useraccess.accessID',  $parentAccessID.'%', false])
                ->distinct()
                ->orderBy('lk_accesscontrol.ordinal')
                ->all();
                
        return $menus;
    }
}
