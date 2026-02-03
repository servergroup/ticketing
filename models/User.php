<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'personale';
    }

    public function rules()
    {
        return [
            [['nome','cognome','username','password','email','ruolo','auth_key','access_token'], 'required'],
            ['username','unique'],
            [['approvazione','blocco'], 'boolean'],
            ['tentativi', 'integer'],
            ['partita_iva','string']
        ];
    }

    public function isApproved()
    {
        return (bool) $this->approvazione;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

 

}
