<?php

namespace app\components;

use app\models\notification\Notification;
use app\models\notification\NotificationEvent;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;

class Notifier extends Component implements BootstrapInterface
{
    public $notificationModel = 'app\models\notification\Notification';

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $model = $this->notificationModel;

        foreach ($model::find()->all() as $item) {
            Event::on($item->event->model, $item->event->name, [$this, 'onEvent'], [
                'notification' => $item
            ]);
        }
    }

    public function onEvent(NotificationEvent $event)
    {
        /** @var Notification $notification */
        $notification = $event->data['notification'];

        $placeholders = self::preparePlaceholders($event->model, $event->model->getPlaceholders());

        foreach ($notification->channels as $channel){
            $channel->process($notification, $placeholders);
        }
    }

    public static function preparePlaceholders($model, $placeholders)
    {
        $ret = [];
        foreach ($placeholders as $key => $value) {
            $ret[$key] = is_callable($value) ? call_user_func($value, $model) : $model->$value;
        }
        return $ret;
    }
}