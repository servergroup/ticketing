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
            [['nome','cognome','username','password','email','ruolo'], 'required'],
            ['username','unique'],
            ['email','email'],
            [['approvazione','blocco'], 'boolean'],
            ['tentativi', 'integer'],
            [['partita_iva','recapito_telefonico','azienda'], 'string'],
            [
                ['immagine'],
                'file',
                'extensions' => ['jpg','jpeg','png','webp'],
                'skipOnEmpty' => true
            ],
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

public static function findByUsername($value)
{
    return static::find()
        ->where(['username' => $value])
        ->orWhere(['email' => $value])
        ->one();
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
