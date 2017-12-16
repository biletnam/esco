<?php

use yii\db\Migration;

/**
 * Class m171216_162636_modify_sites
 */
class m171216_162636_modify_sites extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('site', 'db_name', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
       $this->dropColumn('site', 'db_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171216_162636_modify_sites cannot be reverted.\n";

        return false;
    }
    */
}
