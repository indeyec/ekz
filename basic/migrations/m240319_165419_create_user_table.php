<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240319_165419_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(length:50)->notNull(),
            'username' => $this->string(length:30)->notNull(),
            'email' => $this->string(length:30)->notNull(),
            'password' => $this->string(length:100)->notNull(),
            'role' => $this->integer()->defaultValue(default:0)->notNull(),
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
