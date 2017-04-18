<?php

namespace app\models\notification;

use yii\base\InvalidCallException;

/**
 * This is the model class for table "{{%notification_event}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $model
 * @property string $description
 *
 * @property-read array $ownerEvents
 * @property-read string $uniqueName
 */
class Event extends \yii\db\ActiveRecord
{
    const OWNER_EVENT_TABLE = '{{%notification_event_owner_event}}';
    private $_placeholders = [];
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
        if (!$this->_placeholders) {
            $model = new $this->model();
            if (!($model instanceof NotificationModelInterface)) {
                throw new InvalidCallException('Parameter model should be instance of NotificationModelInterface');
            }
            $this->_placeholders = array_keys($model->getPlaceholders());
        }

        return $this->_placeholders;
    }

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

    public function getUniqueName()
    {
        return self::className() . '.' . $this->id;
    }
}
