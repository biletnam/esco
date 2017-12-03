<?php

use yii\db\Migration;

/**
 * Class m171203_151425_create_unix_user
 */
class m171203_151425_create_unix_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('unix_user', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'db_user' => $this->string(),
            'db_pass' => $this->string(),
            'db_host' => $this->string(),
            'name' => $this->string(),
            'home_path' => $this->string()
        ]);

        $this->renameColumn('site', 'client_id', 'unix_user_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('unix_user');

        $this->renameColumn('site', 'unix_user_id', 'client_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171203_151425_create_unix_user cannot be reverted.\n";

        return false;
    }
    */
}
