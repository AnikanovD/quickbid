<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m230310_095255_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'balance' => $this->decimal(10, 2)->notNull()->defaultValue(1000.00),
        ]);

        // Создаём супер пользователя
        $this->insert('{{%user}}', [
            'username' => 'quickbid',
            'balance' => 0.00,
        ]);
        // Создаём демо пользователей
        $this->insert('{{%user}}', [
            'username' => 'luckystrike',
            'balance' => 777.00,
        ]);
        $this->insert('{{%user}}', [
            'username' => 'yoursmile',
            'balance' => 500.00,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
