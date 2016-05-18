<?php

namespace app\models;

use app\models\notification\NotificationEvent;
use app\models\notification\NotificationModelInterface;
use Yii;
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            self::trigger(self::EVENT_AFTER_CREATE, new NotificationEvent([
                'model' => $this
            ]));
        }
    }

    public function getPlaceholders()
    {
        return [
            'title' => 'title',
            'brief' => function ($model) {
                return mb_substr($model->body, 0, 256);
            },
            'link' => function ($model) {
                return Url::to(['article/update', 'id' => $model->id], true);
            }
        ];
    }
}
