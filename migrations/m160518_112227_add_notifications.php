<?php

use yii\db\Migration;

class m160518_112227_add_notifications extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%notification_event}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'model' => $this->string(128)->notNull(),
            'description' => $this->string(2048)
        ]);
        $this->insert('{{%notification_event}}', [
            'name' => 'After article creation',
            'model' => 'app\models\Article',
        ]);
        $this->createTable('{{%notification_event_owner_event}}', [
            'eventId' => $this->integer()->notNull(),
            'name' => $this->string(256)->notNull()
        ]);
        $this->addPrimaryKey('pk-notification_event_owner_event', '{{%notification_event_owner_event}}', ['eventId', 'name']);
        $this->addForeignKey('fk-notification_event_owner_event-notification_event', '{{%notification_event_owner_event}}', 'eventId', '{{%notification_event}}', 'id', 'cascade');
        $this->insert('{{%notification_event_owner_event}}', [
            'eventId' => '1',
            'name' => 'afterInsert',
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
            'eventId' => $this->integer()->notNull(),
            'recipientId' => $this->integer(),
            'senderId' => $this->integer(),
            'name' => $this->string(256)->notNull(),
            'title' => $this->string(512)->notNull(),
            'body' => $this->text()->notNull(),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()
        ]);
        $this->addForeignKey('fk-notification-event', '{{%notification}}', 'eventId', '{{%notification_event}}', 'id');
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
        $this->dropTable('{{%j_notification_notification_channel}}');
        $this->dropTable('{{%notification_channel}}');
        $this->dropTable('{{%notification}}');
        $this->dropTable('{{%notification_event_owner_event}}');
        $this->dropTable('{{%notification_event}}');
    }
}
