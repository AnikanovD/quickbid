<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bid}}`.
 */
class m230310_095344_create_bid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bid}}', [
            'id' => $this->primaryKey(),
            'auction_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-bid-auction_id',
            '{{%bid}}',
            'auction_id',
            '{{%auction}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-bid-user_id',
            '{{%bid}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-bid-auction_id', '{{%bid}}');
        $this->dropForeignKey('fk-bid-user_id', '{{%bid}}');
        $this->dropTable('{{%bid}}');
    }
}