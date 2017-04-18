<?php

namespace app\models;

use app\models\notification\NotificationModelInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property string $createdAt
 * @property string $updatedAt
 */
class Article extends ActiveRecord implements NotificationModelInterface
{
    const EVENT_AFTER_CREATE = 'article.afterCreate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['body', 'string'],
            ['title', 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
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
                    ActiveRecord::EVENT_BEFORE_INSERT => 'createdAt',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updatedAt'
                ]
            ],
            EventAttachBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function getPlaceholders()
    {
        return [
            'title' => function($model) {
                return $model->title;
            },
            'brief' => function ($model) {
                return mb_substr($model->body, 0, 256);
            },
            'link' => function ($model) {
                return Url::to(['article/view', 'id' => $model->id], true);
            }
        ];
    }
}
