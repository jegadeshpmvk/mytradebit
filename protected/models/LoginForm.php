<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{

    public $email;
    public $password;
    public $type;
    public $rememberMe = true;
    private $_user = false;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['type', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Username or Email Address',
            'password' => 'Password'
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            if ($this->type === 'admin') {
                return Yii::$app->admin->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            } else {
                $user = $this->getUser();
                if (Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0)) {
                    // ✅ Save session ID only after login
                  //  print_r(Yii::$app->session->id);exit;
                    $user->session_id = Yii::$app->session->id;
                    //print_r($user->session_id);exit;
                    $user->save(false);
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            if ($this->type === 'admin') {
                $this->_user = Admin::findByUsername($this->email);
            } else {
                $this->_user = Customer::findByUsername($this->email);
            }
        }
        return $this->_user;
    }
}
