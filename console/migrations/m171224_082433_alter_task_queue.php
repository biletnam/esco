<?php

use yii\db\Migration;

/**
 * Class m171224_082433_alter_task_queue
 */
class m171224_082433_alter_task_queue extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('backup', 'params', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('backup', 'params');
    }
}
