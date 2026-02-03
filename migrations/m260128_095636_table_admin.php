<?php

use yii\db\Migration;

class m260128_095636_table_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('personale',
            [
                'id'=>$this->primaryKey(),
                'nome'=>$this->string(),
                'cognome'=>$this->string(),
                'username'=>$this->string()->unique(),
                'password'=>$this->string(),
                'auth_key'=>$this->string(),
                'access_token'=>$this->string(),
                'email'=>$this->string(),
                'ruolo'=>$this->string(),
                'tentativi'=>$this->integer(),
                'approvazione'=>$this->boolean(),
                'blocco'=>$this->boolean(),
                'partita_iva'=>$this->string(),
            ]
        );
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260128_095636_table_admin cannot be reverted.\n";

        return false;
    }
    */
}
