<?php

namespace app\models\notification;

use yii\base\InvalidCallException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%notification_event}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $model
 * @property string $description
 * @property-read array $ownerEvents
 * @property-read string $uniqueName
 * @package app\models\notification
 */
class Event extends ActiveRecord
{
    const OWNER_EVENT_TABLE = '{{%notification_event_owner_event}}';
    private $placeholders_ = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification_event}}';
    }

    /**
     * Get placeholders keys from related model
     *
     * @return array
     */
    public function getPlaceholdersKeys()
    {
        if (!$this->placeholders_) {
            $model = new $this->model();
            if (!($model instanceof NotificationModelInterface)) {
                throw new InvalidCallException('Parameter model should be instance of NotificationModelInterface');
            }
            $this->placeholders_ = array_keys($model->getPlaceholders());
        }

        return $this->placeholders_;
    }

    /**
     * Find related events of the owner model
     *
     * @return array
     */
    public function getOwnerEvents()
    {
        return self::find()
            ->select([
                self::OWNER_EVENT_TABLE . '.name'
            ])
            ->leftJoin(
                self::OWNER_EVENT_TABLE,
                self::OWNER_EVENT_TABLE . '.eventId = ' . self::tableName() . '.id'
            )
            ->column();
    }

    /**
     * Get unique event name
     *
     * @return string
     */
    public function getUniqueName()
    {
        return self::className() . '.' . $this->id;
    }
}
