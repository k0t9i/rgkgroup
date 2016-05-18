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
 * @property-read array $placeholders
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification_event}}';
    }

    public function getPlaceholders()
    {
        $model = new $this->model();
        if (!($model instanceof NotificationModelInterface)) {
            throw new InvalidCallException('Parameter model should be instance of NotificationModelInterface');
        }

        return array_map(function($el){
            return '{' . $el . '}';
        }, array_keys($model->getPlaceholders()));
    }
}
