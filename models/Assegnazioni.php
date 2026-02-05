<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assegnazioni".
 *
 * @property int $id
 * @property string|null $codice_ticket
 * @property int|null $id_operatore
 * @property string|null $ambito
 *
 * @property Ticket $codiceTicket
 * @property History[] $histories
 * @property Personale $operatore
 */
class Assegnazioni extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assegnazioni';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codice_ticket', 'id_operatore', 'ambito'], 'default', 'value' => null],
            [['id_operatore'], 'integer'],
            [['codice_ticket', 'ambito'], 'string', 'max' => 255],
            [['codice_ticket'], 'unique'],
            [['id_operatore'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_operatore' => 'id']],
            [['codice_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::class, 'targetAttribute' => ['codice_ticket' => 'codice_ticket']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codice_ticket' => 'Codice Ticket',
            'id_operatore' => 'Id Operatore',
            'ambito' => 'Ambito',
        ];
    }

    /**
     * Gets query for [[CodiceTicket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodiceTicket()
    {
        return $this->hasOne(Ticket::class, ['codice_ticket' => 'codice_ticket']);
    }

    /**
     * Gets query for [[Histories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistories()
    {
        return $this->hasMany(History::class, ['id_operatore' => 'id_operatore']);
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

}
