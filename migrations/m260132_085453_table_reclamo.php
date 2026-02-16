<?php

use yii\db\Migration;

class m260132_085453_table_reclamo extends Migration
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
        $this->createTable('mail',[
            'id'=>$this->primaryKey(),
	       'mittente'=>$this->string(),
	'destinatario'=>$this->string(),
	'oggetto'=>$this->string(),
	'messagio'=>$this->string(),
    'codice_ticket'=>$this->string()
            
        ]);

      

$this->addForeignKey(
    'fk_code',
    'mail',
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
       
       $this->dropForeignKey('fk_code','mail');
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
