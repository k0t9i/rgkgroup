<?php

namespace app\components;

use app\models\notification\Notification;
use app\models\notification\NotificationEvent;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\helpers\ArrayHelper;

/**
 *
 */
class Notifier extends Component implements BootstrapInterface
{
    /**
     * Class of notification model
     *
     * @var string
     */
    public $notificationModel = 'app\models\notification\Notification';

    /**
     * Array of global placeholders in following format:
     * [
     *     'placeholder1' => 'value',
     *     'placeholder2' => function(Notifier $model){
     *          return $model->attribute;
     *      }
     * ]
     *
     * @var array
     */
    public $placeholders = [];

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $model = $this->notificationModel;

        // todo Think about notification order
        /** @var Notification $item */
        foreach ($model::find()->orderBy(['createdAt' => SORT_DESC])->all() as $item) {
            Event::on($item->event->model, $item->event->uniqueName, [$this, 'onEvent'], [
                'notification' => $item
            ]);
        }
    }

    /**
     * Method that is called when an event is received
     *
     * @param NotificationEvent $event
     */
    public function onEvent(NotificationEvent $event)
    {
        /** @var Notification $notification */
        $notification = $event->data['notification'];

        foreach ($notification->channels as $channel) {
            $channel->process($notification, $event->model);
        }
    }

    /**
     * Get all placeholders keys: model, notification and globals
     *
     * @param Notification $notification
     * @return array
     */
    public function getPlaceholdersKeys(Notification $notification)
    {
        return ArrayHelper::merge(array_keys($this->placeholders), $notification->getPlaceholdersKeys());
    }
}