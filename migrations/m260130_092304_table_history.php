<?php

use yii\db\Migration;

class m260130_092304_table_history extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('history',[
            'id'=>$this->primaryKey(),
            'id_ticket'=>$this->integer(),
            'id_operatore'=>$this->integer(),
            'id_cliente'=>$this->integer(),
            'stato'=>$this->string()
            
        ]);

   
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('history');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260130_092304_table_history cannot be reverted.\n";

        return false;
    }
    */
}
