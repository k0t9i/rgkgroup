<?php

namespace app\models\notification;

use app\models\notification\channels\Channel;
use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id
 * @property string $eventName
 * @property integer $recipientId
 * @property integer $senderId
 * @property string $title
 * @property string $body
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property-read Channel[] $channels
 * @property-read Event $event
 * @property-read User $recipient
 * @property-read User $sender
 * @property array|null $channelsAttr
 */
class Notification extends ActiveRecord
{
    const JUNCTION_TABLE_CHANNEL = '{{%j_notification_notification_channel}}';

    /**
     * @var array|null
     */
    private $_channels;

    /**
     * @var array
     */
    private $_oldChannels = [];

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
            [['eventName', 'title', 'body', 'channelsAttr'], 'required'],
            [['recipientId', 'senderId'], 'integer'],
            ['body', 'string'],
            ['eventName', 'string', 'max' => 256],
            ['title', 'string', 'max' => 512],
            ['eventName', 'exist', 'targetClass' => Event::className(), 'targetAttribute' => 'name'],
            [['senderId', 'recipientId'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            ['channelsAttr', 'exist', 'targetClass' => Channel::className(), 'targetAttribute' => 'id', 'allowArray' => true],
            [['senderId', 'recipientId'], 'default', 'value' => null]
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
            'recipientId' => 'Recipient',
            'senderId' => 'Sender',
            'title' => 'Title',
            'body' => 'Body',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'channelsAttr' => 'Channels'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'createdAt',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updatedAt'
                ]
            ]
        ];
    }

    public function getChannels()
    {
        return $this->hasMany(Channel::className(), [
            'id' => 'channelId'
        ])->viaTable(self::JUNCTION_TABLE_CHANNEL, [
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

    /**
     * Set channels id for saving
     *
     * @param array|integer $value
     */
    public function setChannelsAttr($value)
    {
        if (!is_array($value)) {
            $value = [];
        }
        $this->_channels = $value;
    }

    /**
     * Get Notification::$_channels
     * Get it from Channel relation If not set
     *
     * @return array
     */
    public function getChannelsAttr()
    {
        if (is_null($this->_channels)) {
            $this->_channels = ArrayHelper::getColumn($this->getChannels()->asArray()->all(), 'id');
        }
        return $this->_channels;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        /**
         * Update channels from create/update actions
         */
        $insertIds = array_diff($this->channelsAttr, $this->_oldChannels);
        if ($insertIds) {
            $rows = [];
            foreach ($insertIds as $id) {
                $rows[] = [$this->id, $id];
            }
            static::getDb()
                ->createCommand()
                ->batchInsert(static::JUNCTION_TABLE_CHANNEL, ['notificationId', 'channelId'], $rows)
                ->execute();
        }
        $deleteIds = array_diff($this->_oldChannels, $this->channelsAttr);
        if ($deleteIds) {
            static::getDb()
                ->createCommand()
                ->delete(static::JUNCTION_TABLE_CHANNEL, [
                    'channelId' => $deleteIds,
                    'notificationId'      => $this->id
                ])
                ->execute();
        }
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->_oldChannels = $this->channelsAttr;
    }
    
    public function getPlaceholders()
    {
        return [
            'recipient_username' => function(Notification $model){
                return $model->recipient ? $model->recipient->username : '';
            },
            'recipient_lastname' => function(Notification $model){
                return $model->recipient ? $model->recipient->lastname : '';
            },
            'recipient_firstname' => function(Notification $model){
                return $model->recipient ? $model->recipient->firstname : '';
            },
            'recipient_email' => function(Notification $model){
                return $model->recipient ? $model->recipient->email : '';
            }
        ];
    }

    public function getPlaceholdersKeys()
    {
        $eventPlaceholders = $this->event ? $this->event->getPlaceholdersKeys() : [];
        return ArrayHelper::merge(array_keys($this->getPlaceholders()), $eventPlaceholders);
    }
}
