<?php

namespace app\models\notification\channels;

use app\components\Notifier;
use app\models\User;
use Yii;
use app\models\notification\Notification;
use yii\db\ActiveRecord;

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

    public function process(Notification $item, array $placeholders = [])
    {
        return $this->doProcess($item, $placeholders);
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

    protected function getNotificationPlaceholders(Notification $model, User $recipient)
    {
        $model->refresh();
        $model->recipientId = $recipient->id;
        return Notifier::preparePlaceholders($model, $model->getPlaceholders());
    }
}