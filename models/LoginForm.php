<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Cookie;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $tentativi;
    public $rememberMe = false;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['tentativi', 'required'],
            ['approvazione','required'],
            ['blocco','required']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Credenziali errate.');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    public function login()
    {
        $user = $this->getUser();
        $this->tentativi = $user->tentativi;
        if (
            $this->username == $user->username && Yii::$app->security->validatePassword($this->password, $user->password) && $user->ruolo == 'amministratore' && $user->tentativi > 0 && !$user->blocco ||
            $this->username == $user->username && Yii::$app->security->validatePassword($this->password, $user->password) && $user->ruolo == 'itc'  && $user->tentativi > 0  && !$user->blocco ||
            $this->username == $user->username && Yii::$app->security->validatePassword($this->password, $user->password) && $user->ruolo == 'cliente' && $user->tentativi > 0 && !$user->blocco ||
            $this->username == $user->username && Yii::$app->security->validatePassword($this->password, $user->password) && $user->ruolo == 'developer' && $user->tentativi > 0  && !$user->blocco
        ) {
           


            return Yii::$app->user->login(
                $this->getUser(),
                $this->rememberMe ? 3600 * 24 * 30 : 0
            );
        } else {
            $user->tentativi -= 1;
            $user->save();

            if ($user->tentativi < 0) {
                $user->tentativi = 0;
                $this->bloccaTutto();
            }
            return false;
        }
    }

    public function bloccaTutto()
    {
        $user = $this->getUser();

        if ($user->tentativi == 0) {
            $user->tentativi = 0;

            $user->blocco = true;

            $user->save();
        } else {
            $user->blocco = false;
            $user->save();
        }
    }
}
