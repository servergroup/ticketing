<?php

use yii\db\Migration;

class m260130_090013_table_assegnazioni extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assegnazioni',[
            'id'=>$this->primaryKey(),
            'codice_ticket'=>$this->string()->unique(),
            'id_operatore'=>$this->integer(),
            'ambito'=>$this->string()

        ]);

        $this->addForeignKey(
            'fk_id_operatore',
            'assegnazioni',
            'id_operatore',
            'personale',
            'id',
            $delete=null,
            $update=null
        );

                $this->addForeignKey(
            'fk_codice_ticket',
            'assegnazioni',
            'codice_ticket',
            'ticket',
            'codice_ticket',
            $delete=null,
            $update=null
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropForeignKey('fk_id_cliente','assegnazioni');
       $this->dropForeignKey('fk_codice_ticket','assegnazioni');
       $this->dropTable('assegnazioni');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260130_090013_table_assegnazioni cannot be reverted.\n";

        return false;
    }
    */
}
