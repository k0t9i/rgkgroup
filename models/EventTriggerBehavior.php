<?php

namespace app\models;

use app\models\notification\NotificationEvent;
use yii\base\Behavior;

/**
 * Trigger nested events for owner model
 *
 * @package app\models
 */
class EventTriggerBehavior extends Behavior
{
    /**
     * @var \app\models\notification\Event[]
     */
    public $events = [];

    /**
     * @inheritdoc
     */
    public function events()
    {
        $result = [];
        foreach ($this->events as $event) {
            foreach ($event->ownerEvents as $ownerEvent) {
                $result[$ownerEvent] = function () use ($event) {
                    $this->owner->trigger($event->uniqueName, new NotificationEvent([
                        'model' => $this->owner
                    ]));
                };
            }
        }
        return $result;
    }
}
