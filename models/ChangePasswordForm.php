<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{

    public $currentPassword;
    public $newPassword;
    public $repeatPassword;

    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'repeatPassword'], 'required'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'newPassword'],
            ['currentPassword', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'currentPassword' => 'Current Password',
            'newPassword' => 'New Password',
            'repeatPassword' => 'Re-enter New Password'
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;
            if (!$user->validatePassword($this->currentPassword)) {
                $this->addError($attribute, Yii::t('app', 'Current Password doesn\'t match'));
            }
        }
    }

    public function save()
    {
        if ($this->validate()) {
            $user = MsUser::findOne(Yii::$app->user->identity->getId());
            $user->password = md5($this->newPassword.$user->salt);
            return $user->save();
        }
        return false;
    }
}
