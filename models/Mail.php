<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mail".
 *
 * @property int $id
 * @property string|null $mittente
 * @property string|null $destinatario
 * @property string|null $oggetto
 * @property string|null $messagio
 * @property string|null $codice_ticket
 *
 * @property Ticket $codiceTicket
 */
class Mail extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mittente', 'destinatario', 'oggetto', 'messagio', 'codice_ticket'], 'default', 'value' => null],
            [['mittente', 'destinatario', 'oggetto', 'messagio', 'codice_ticket'], 'string', 'max' => 255],
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
            'mittente' => 'Mittente',
            'destinatario' => 'Destinatario',
            'oggetto' => 'Oggetto',
            'messagio' => 'Messagio',
            'codice_ticket' => 'Codice Ticket',
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

}
