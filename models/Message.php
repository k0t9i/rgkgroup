<?php

namespace app\models;

use Yii;
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
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

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

    public function getUser()
    {
        return $this->hasOne(User::className(), [
            'id' => 'userId'
        ]);
    }

    public function getSender()
    {
        return $this->hasOne(User::className(), [
            'id' => 'senderId'
        ]);
    }
}
