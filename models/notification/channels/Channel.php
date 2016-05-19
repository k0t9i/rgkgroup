<?php

namespace app\models\notification\channels;

use app\models\notification\NotificationModelInterface;
use app\models\User;
use Yii;
use app\models\notification\Notification;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%notification_channel}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 */
abstract class Channel extends ActiveRecord
{
    abstract protected function doProcess(Notification $item, array $placeholders = []);

    public function process(Notification $item, NotificationModelInterface $eventModel)
    {
        $recipients = [$item->recipient];
        if (!$item->recipient) {
            $recipients = User::find()->all();
        }
        $placeholders = self::preparePlaceholders($eventModel, $eventModel->getPlaceholders());
        $globalPlaceholders = self::preparePlaceholders(Yii::$app->notifier, Yii::$app->notifier->placeholders);

        foreach ($recipients as $recipient) {
            unset($item->recipient);
            $item->recipientId = $recipient->id;
            $fullPlaceholders = ArrayHelper::merge($globalPlaceholders, self::preparePlaceholders($item, $item->getPlaceholders()), $placeholders);

            $this->doProcess($item, $fullPlaceholders);
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification_channel}}';
    }

    public static function instantiate($row)
    {
        $channelClass = __NAMESPACE__ . '\\' . ucfirst($row['name']) . 'Channel';

        return new $channelClass();
    }

    protected function replacePlaceholders($str, array $placeholders)
    {
        return Yii::$app->I18n->format($str, $placeholders, Yii::$app->language);
    }

    protected static function preparePlaceholders($model, $placeholders)
    {
        $ret = [];
        foreach ($placeholders as $key => $value) {
            $ret[$key] = is_callable($value) ? call_user_func($value, $model) : $value;
        }
        return $ret;
    }
}