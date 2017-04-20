<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $senderId
 * @property string $title
 * @property string $body
 * @property string $createdAt
 * @property string $readedAt
 * @property-read User $user
 * @property-read User $sender
 * @package app\models
 */
class Message extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'createdAt'
                ]
            ]
        ];
    }

    /**
     * Get related user
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), [
            'id' => 'userId'
        ]);
    }

    /**
     * Get sender of the message
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), [
            'id' => 'senderId'
        ]);
    }

    /**
     * Get count of the unread messages for the user
     *
     * @param integer $userId
     * @return integer
     */
    public static function getUnreadCountForUser($userId)
    {
        return self::find()
            ->where(['readedAt' => null])
            ->andWhere(['userId' => (int) $userId])
            ->count();
    }
}
