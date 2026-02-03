<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $cognome
 * @property string|null $username
 * @property string|null $password
 * @property string|null $nome_azienda
 *
 * @property Ticket[] $tickets
 */
class Cliente extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'cognome', 'username', 'password', 'nome_azienda'], 'default', 'value' => null],
            [['nome', 'cognome', 'username', 'password', 'nome_azienda'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'username' => 'Username',
            'password' => 'Password',
            'nome_azienda' => 'Nome Azienda',
        ];
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::class, ['id_cliente' => 'id']);
    }

}
