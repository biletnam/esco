<?php

use yii\db\Migration;

/**
 * Class m171216_151001_task_manager
 */
class m171216_151001_task_manager extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('task_queue', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'raw_task' => $this->text(),
            'class' => $this->text(),
            'action' => $this->text(),
            'status' => $this->integer(),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('task_queue');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171216_151001_task_manager cannot be reverted.\n";

        return false;
    }
    */
}
