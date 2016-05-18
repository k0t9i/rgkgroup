<?php

namespace app\models\notification;

use Yii;

/**
 * This is the model class for table "{{%notification_event}}".
 *
 * @property string $name
 * @property string $model
 * @property string $description
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
}
