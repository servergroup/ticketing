<?php

use yii\db\Migration;

class m260213_083816_table_tempi_lavorazione extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tempi_ticket',[
            'id'=>$this->primaryKey(),
            'id_ticket'=>$this->integer(),
            'id_operatore'=>$this->integer(),
            'ora_inizio'=>$this->time(),
            'ora_fine'=>$this->time(),
            'tempo_lavorazione'=>$this->integer(),
            'pause_effettuate'=>$this->integer(),
            'tempi_pause'=>$this->json(),
            'ora_pause'=>$this->json(),
            'chiuso_il'=>$this->dateTime(),
            'stato'=>$this->string(),
            'tempo_sospensione'=>$this->time()


        ]);

        $this->addForeignKey(
            'fk_id_ticket',
            'tempi_ticket',
            'id_ticket',
            'ticket',
            'id',
            $delete=null,
            $update=null
        );


        $this->addForeignKey(
            'fk_id_operator',
            'tempi_ticket',
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
       $this->dropForeignKey('fk_id_ticket','tempi_ticket');
       $this->dropForeignKey('fk_id_operator','tempi_ticket');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260212_083816_table_tempi_lavorazione cannot be reverted.\n";

        return false;
    }
    */
}
