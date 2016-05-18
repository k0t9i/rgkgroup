<?php

use yii\db\Migration;

class m160518_112227_add_notifications extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%notification_event}}', [
            'name' => $this->string(128)->notNull(),
            'model' => $this->string(128)->notNull(),
            'description' => $this->string(2048)
        ]);
        $this->addPrimaryKey('pk-notification_event', '{{%notification_event}}', ['name', 'model']);
        $this->insert('{{%notification_event}}', [
            'name' => 'article.afterCreate',
            'model' => 'app\models\Article',
        ]);

        $this->createTable('{{%notification_channel}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(256)->notNull(),
            'name' => $this->string(256)->notNull()
        ]);
        $this->insert('{{%notification_channel}}', [
            'title' => 'Browser',
            'name' => 'web'
        ]);
        $this->insert('{{%notification_channel}}', [
            'title' => 'Email',
            'name' => 'mail'
        ]);

        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'eventName' => $this->string(256)->notNull(),
            'recipientId' => $this->integer(),
            'senderId' => $this->integer(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text()->notNull()
        ]);
        $this->addForeignKey('fk-notification-event', '{{%notification}}', 'eventName', '{{%notification_event}}', 'name');
        $this->addForeignKey('fk-notification-recipient', '{{%notification}}', 'recipientId', '{{%user}}', 'id');
        $this->addForeignKey('fk-notification-sender', '{{%notification}}', 'senderId', '{{%user}}', 'id');

        $this->createTable('{{%j_notification_notification_channel}}', [
            'notificationId' => $this->integer()->notNull(),
            'channelId' => $this->integer()->notNull()
        ]);
        $this->addPrimaryKey('pk-j_notification_notification_channel', '{{%j_notification_notification_channel}}', ['notificationId', 'channelId']);
        $this->createIndex('idx-j_notification_notification_channel-channel_id', '{{%j_notification_notification_channel}}', 'channelId');
        $this->addForeignKey('fk-j_notification_notification_channel-channel', '{{%j_notification_notification_channel}}', 'channelId', '{{%notification_channel}}', 'id', 'cascade');
        $this->addForeignKey('fk-j_notification_notification_channel-notification', '{{%j_notification_notification_channel}}', 'notificationId', '{{%notification}}', 'id', 'cascade');
    }

    public function safeDown()
    {
        $this->dropTable('{{%notification_event}}');
        $this->dropTable('{{%notification_channel}}');
        $this->dropTable('{{%notification}}');
        $this->dropTable('{{%j_notification_notification_channel}}');
    }
}
