<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auction}}`.
 */
class m230310_095322_create_auction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auction}}', [
            'id'           => $this->primaryKey(),
            'name'         => $this->string()->notNull()->comment('Name of the auction'),
            'photo'        => $this->string()->notNull()->comment('Lot image'),
            'description'  => $this->text()->notNull()->comment('Description of the auction'),
            'start_time'   => $this->integer()->notNull()->comment('Timestamp when the auction starts'),
            'end_time'     => $this->integer()->notNull()->comment('Timestamp when the auction ends'),
            'bid_step'     => $this->decimal(10, 2)->notNull(1.00)->comment('Auction bid step'),
            'starting_bid' => $this->decimal(10, 2)->notNull(1.00)->comment('Starting bid for the auction'),
            'current_bid'  => $this->decimal(10, 2)->defaultValue(1.00)->comment('Current highest bid for the auction'),
            'state'        => $this->smallInteger()->notNull()->defaultValue(0)->comment('State of the auction (0 = new, 1 = started, 2 = finished)'),
            'created_at'   => $this->integer()->notNull()->comment('Timestamp when the auction was created'),
            'updated_at'   => $this->integer()->notNull()->comment('Timestamp when the auction was last updated'),
        ]);

        // Демонстрационные аукционы ( три  разных состояния )
        $this->insert('{{%auction}}', [
            'name'         => 'GoPro HERO10 BLACK',
            'description'  => 'Экшн камера',
            'photo'        => '/photo/goprohero10black.jpg',
            'start_time'   => time() - 3900,
            'end_time'     => time() + 3300,
            'bid_step'     => 100.00,
            'starting_bid' => 20000.00,
            'current_bid'  => 24500.00,
            'state'        => 2, // Завершён
            'created_at'   => time(),
            'updated_at'   => time(),
        ]);
        $this->insert('{{%auction}}', [
            'name'         => 'iPhone 13 mini',
            'description'  => 'Новый оригинальный iPhone 13 mini с памятью 256 GB',
            'photo'        => '/photo/iphone13mini.jpg',
            'start_time'   => time(),
            'end_time'     => time() + (24 * 3600),
            'bid_step'     => 10.00,
            'starting_bid' => 13000.00,
            'current_bid'  => 13000.00,
            'state'        => 1, // Уже начался
            'created_at'   => time(),
            'updated_at'   => time(),
        ]);
        $this->insert('{{%auction}}', [
            'name'         => 'Сертификат OZON / 50%',
            'description'  => 'Заказ на сумму до 10 000 ₽',
            'photo'        => '/photo/ozoncertdigital.png',
            'start_time'   => time() + 600,
            'end_time'     => time() + 600 + (24 * 3600),
            'bid_step'     => 10.00,
            'starting_bid' => 5000.00,
            'current_bid'  => 5000.00,
            'state'        => 0, // Стартует через 10 минут
            'created_at'   => time(),
            'updated_at'   => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auction}}');
    }
}
