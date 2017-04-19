<?php

namespace app\models;

use app\components\EventResolver;
use app\models\notification\Event;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

/**
 * Class EventAttachBehavior
 * @package app\models
 */
class EventAttachBehavior extends Behavior
{
    /**
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_INIT => [$this, 'attachEvent']
        ];
    }

    /**
     * Attach EventTriggerBehavior with specific events
     */
    public function attachEvent()
    {
        $ownerClass = $this->owner->className();
        $events = Event::find()
            ->where(['model' => $ownerClass])
            ->all();

        if ($events) {
            $this->owner->attachBehavior('triggerEvent', new EventTriggerBehavior([
                'events' => $events
            ]));
        }
    }
}