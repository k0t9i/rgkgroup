<?php

namespace app\models\notification;

use app\models\notification\channels\Channel;
use app\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id
 * @property string $eventName
 * @property integer $recipientId
 * @property integer $senderId
 * @property string $title
 * @property string $body
 *
 * @property-read Channel[] $channels
 * @property-read Event $event
 * @property-read User $recipient
 * @property-read User $sender
 */
class Notification extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eventName', 'title', 'body'], 'required'],
            [['recipientId', 'senderId'], 'integer'],
            [['body'], 'string'],
            [['eventName'], 'string', 'max' => 256],
            [['title'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eventName' => 'Event Name',
            'recipientId' => 'Recipient ID',
            'senderId' => 'Sender ID',
            'title' => 'Title',
            'body' => 'Body',
        ];
    }

    public function getChannels()
    {
        return $this->hasMany(Channel::className(), [
            'id' => 'channelId'
        ])->viaTable('{{%j_notification_notification_channel}}', [
            'notificationId' => 'id'
        ]);
    }

    public function getEvent()
    {
        return $this->hasOne(Event::className(), [
            'name' => 'eventName'
        ]);
    }

    public function getRecipient()
    {
        return $this->hasOne(User::className(), [
            'id' => 'recipientId'
        ]);
    }

    public function getSender()
    {
        return $this->hasOne(User::className(), [
            'id' => 'senderId'
        ]);
    }
}
