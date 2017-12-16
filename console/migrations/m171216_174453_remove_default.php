<?php

use yii\db\Migration;

/**
 * Class m171216_174453_remove_default
 */
class m171216_174453_remove_default extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropTable('user');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171216_174453_remove_default cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171216_174453_remove_default cannot be reverted.\n";

        return false;
    }
    */
}
