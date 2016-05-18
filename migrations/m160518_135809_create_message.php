<?php

use yii\db\Migration;

/**
 * Handles the creation for table `message`.
 */
class m160518_135809_create_message extends Migration
{
    const TABLE = '{{%message}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'senderId' => $this->integer(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text(),
            'createdAt' => $this->dateTime()->notNull(),
            'readedAt' => $this->dateTime()
        ]);

        $this->addForeignKey('fk-message-user', self::TABLE, 'userId', '{{%user}}', 'id');
        $this->addForeignKey('fk-message-sender', self::TABLE, 'senderId', '{{%user}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
