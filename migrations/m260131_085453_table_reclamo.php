<?php

use yii\db\Migration;

class m260131_085453_table_reclamo extends Migration
{
    /**
     * {@inheritdoc}
     */
    


    /*
    <?php

use yii\db\Migration;

class m260129_165507_table_reclamo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reclamo',[
        'id'=>$this->primaryKey(),    
        'problema'=>$this->string(),
        'azienda'=>$this->string(),
        'id_cliente'=>$this->integer(),
        'codice_ticket'=>$this->string(),
            
        ]);

       $this->addForeignKey(
    'fk_reclamo_cliente',
    'reclamo',
    'id_cliente',
    'personale',
    'id',
    'CASCADE',
    'CASCADE'
);

$this->addForeignKey(
    'fk_code',
    'reclamo',
    'codice_ticket',
    'ticket',
    'codice_ticket',
    'CASCADE',
    'CASCADE'
);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropForeignKey('fk_reclamo_cliente','reclamo');
       $this->dropForeignKey('fk_code','reclamo');
       $this->dropTable('reclamo');
    }

  

    /**
     * {@inheritdoc}
     */
 

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260130_085453_table_reclamo cannot be reverted.\n";

        return false;
    }
    */
}
