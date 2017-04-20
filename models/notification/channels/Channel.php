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
 * Abstract base class of notification channel
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @package app\models\notification\channels
 */
abstract class Channel extends ActiveRecord
{
    /**
     * Method for processing a single notification recipient
     *
     * @param Notification $item
     * @param array $placeholders
     */
    abstract protected function doProcess(Notification $item, array $placeholders = []);

    /**
     * Prepares placeholders, looking for notification recipients
     * and invoke concrete channel for notification processing
     *
     * @param Notification $item
     * @param NotificationModelInterface $eventModel
     */
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
            $fullPlaceholders = ArrayHelper::merge(
                $globalPlaceholders,
                self::preparePlaceholders($item, $item->getPlaceholders()),
                $placeholders
            );

            // save old values
            $title = $item->title;
            $body = $item->body;

            $item->title = $this->replacePlaceholders($item->title, $fullPlaceholders);
            $item->body = $this->replacePlaceholders($item->body, $fullPlaceholders);
            $this->doProcess($item, $fullPlaceholders);

            $item->title = $title;
            $item->body = $body;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification_channel}}';
    }

    /**
     * Creates concrete channel from name attribute
     *
     * @param array $row
     * @return Channel
     */
    public static function instantiate($row)
    {
        $channelClass = __NAMESPACE__ . '\\' . ucfirst($row['name']) . 'Channel';

        $ret = new $channelClass();

        if (!($ret instanceof Channel)) {
            throw new \LogicException('Notification channel class should be instance of Channel');
        }

        return $ret;
    }

    /**
     * Formats string with placeholders
     *
     * @param string $str
     * @param array $placeholders
     * @return string
     */
    protected function replacePlaceholders($str, array $placeholders)
    {
        return Yii::$app->I18n->format($str, $placeholders, Yii::$app->language);
    }

    /**
     * Prepares placeholders values
     *
     * @param object $model
     * @param array $placeholders
     * @return array
     */
    protected static function preparePlaceholders($model, array $placeholders)
    {
        $ret = [];
        foreach ($placeholders as $key => $value) {
            $ret[$key] = is_callable($value) ? call_user_func($value, $model) : $value;
        }
        return $ret;
    }
}
