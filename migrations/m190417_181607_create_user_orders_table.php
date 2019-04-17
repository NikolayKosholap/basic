<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_orders}}`.
 */
class m190417_181607_create_user_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_orders}}', [
            'id' => $this->primaryKey(),
            'from_id' => $this->integer(11),
            'to_id' => $this->integer(11),
            'amount' => $this->double(2),
            'balance_before' => $this->double(2),
            'time_create' => $this->integer(11),
            'description' => $this->string(100),
        ]);

        $this->createIndex('from','user_orders','from_id');

        $this->addForeignKey('fk-from-id','user_orders','from_id','user','id','CASCADE');

        $this->createIndex('to','user_orders','to_id');

        $this->addForeignKey('fk-to-id','user_orders','to_id','user','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_orders}}');
    }
}
