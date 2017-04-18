<?php

namespace app\models;

use app\models\notification\NotificationEvent;
use yii\base\Behavior;

/**
 * Class EventTriggerBehavior
 * @package app\models
 */
class EventTriggerBehavior extends Behavior
{
    /**
     * @var \app\models\notification\Event[]
     */
    public $events = [];

    /**
     * @return array
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
