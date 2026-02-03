<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reclamo".
 *
 * @property int $id
 * @property string|null $problema
 * @property string|null $azienda
 * @property int|null $id_cliente
 *
 * @property Personale $cliente
 */
class Reclami extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reclamo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['problema', 'azienda', 'id_cliente'], 'default', 'value' => null],
            [['id_cliente'], 'integer'],
            [['problema', 'azienda'], 'string', 'max' => 255],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' =>User::class, 'targetAttribute' => ['id_cliente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'problema' => 'Problema',
            'azienda' => 'Azienda',
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

}
