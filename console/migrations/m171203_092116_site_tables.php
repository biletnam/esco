<?php

use yii\db\Migration;

/**
 * Создает таблицы доменов и сайтов
 *
 * Class m171203_092116_site_tables
 */
class m171203_092116_site_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('site', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'client_id' => $this->integer()
        ]);

        $this->createTable('domain', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'site_id' => $this->integer(),
            'is_main' => $this->boolean()
        ]);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('site');
        $this->dropTable('domain');
    }

}
