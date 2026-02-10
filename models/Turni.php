<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "turni".
 *
 * @property int $id
 * @property int|null $id_operatore
 * @property string|null $entrata
 * @property string|null $uscita
 * @property string|null $pausa
 *
 * @property Personale $operatore
 */
class Turni extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'turni';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_operatore', 'entrata', 'uscita', 'pausa'], 'default', 'value' => null],
            [['id_operatore'], 'integer'],
            [['entrata', 'uscita', 'pausa'], 'safe'],
            [['id_operatore'], 'unique'],
            [['id_operatore'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_operatore' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_operatore' => 'Id Operatore',
            'entrata' => 'Entrata',
            'uscita' => 'Uscita',
            'pausa' => 'Pausa',
        ];
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
