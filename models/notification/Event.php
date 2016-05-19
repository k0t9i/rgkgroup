<?php

namespace app\models\notification;

use Yii;
use yii\base\InvalidCallException;

/**
 * This is the model class for table "{{%notification_event}}".
 *
 * @property string $name
 * @property string $model
 * @property string $description
 */
class Event extends \yii\db\ActiveRecord
{
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
}
