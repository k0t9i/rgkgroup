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

        // todo Think about notification order
        foreach ($model::find()->orderBy(['createdAt' => SORT_DESC])->all() as $item) {
            Event::on($item->event->model, $item->event->name, [$this, 'onEvent'], [
                'notification' => $item
            ]);
        }
    }

    public function onEvent(NotificationEvent $event)
    {
        /** @var Notification $notification */
        $notification = $event->data['notification'];

        foreach ($notification->channels as $channel){
            $channel->process($notification, $event->model);
        }
    }
}