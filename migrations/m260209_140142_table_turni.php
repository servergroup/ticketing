<?php

use yii\db\Migration;

class m260209_140142_table_turni extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('turni',[
            'id'=>$this->primaryKey(),
            'id_operatore'=>$this->integer()->unique(),
            'entrata'=>$this->time(),
            'uscita'=>$this->time(),
            'pausa'=>$this->time()

        ]);

        $this->addForeignKey(
            'fk_id_dipendente',
            'turni',
            'id_operatore',
            'personale',
            'id',
            $delete=null,
            $update=null
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     $this->dropForeignKey('fk_id_operatori','turni');
    $this->dropTable('turni');
     }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260209_140142_table_turni cannot be reverted.\n";

        return false;
    }
    */
}
