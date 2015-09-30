<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package app\models
 *
 * @property \app\models\User $user
 */
class ResetPasswordForm extends Model
{
    /**
     * @var String $new_password
     */
    public $password;

    /**
     * @var String $confirm_new_password
     */
    public $password_repeat;

    /**
     * @var \app\models\User $_user
     */
    private $_user;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => 'New Password',
            'password_repeat' => 'Confirm Password',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password'], 'compare', 'message' => 'Passwords must match'],
        ];
    }

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @return bool
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $this->user->password = $this->password;
            $this->user->removePasswordResetToken();
            return $this->user->save();
        }

        return false;
    }
}
