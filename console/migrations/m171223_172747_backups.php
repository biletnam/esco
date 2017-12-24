<?php

use yii\db\Migration;

/**
 * Class m171223_172747_backups
 */
class m171223_172747_backups extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('backup', [
            'id' => $this->primaryKey(),
            'site_id' => $this->integer(),
            'type' => $this->integer(),
            'date' => $this->dateTime(),
            'file' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('backup');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171223_172747_backups cannot be reverted.\n";

        return false;
    }
    */
}
