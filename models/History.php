<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int|null $id_ticket
 * @property int|null $id_operatore
 * @property int|null $id_cliente
 *
 * @property Personale $cliente
 * @property Personale $operatore
 * @property Ticket $ticket
 */
class History extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ticket', 'id_operatore', 'id_cliente'], 'default', 'value' => null],
            [['id_ticket', 'id_operatore', 'id_cliente'], 'integer'],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_cliente' => 'id']],
            [['id_operatore'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_operatore' => 'id']],
            [['id_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::class, 'targetAttribute' => ['id_ticket' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ticket' => 'Id Ticket',
            'id_operatore' => 'Id Operatore',
            'id_cliente' => 'Id Cliente',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(User::class, ['id' => 'id_cliente']);
    }

    /**
     * Gets query for [[Operatore]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperatore()
    {
        return $this->hasOne(User::class, ['id' => 'id_operatore']);
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::class, ['id' => 'id_ticket']);
    }

}
