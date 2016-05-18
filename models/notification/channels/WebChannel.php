<?php

namespace app\models\notification\channels;

use app\components\Notifier;
use app\models\Message;
use app\models\notification\Notification;
use app\models\User;

class WebChannel extends Channel
{
    protected function doProcess(Notification $item, array $placeholders = [])
    {
        $senderId = $item->sender ? $item->sender->id : null;

        $message = new Message([
            'senderId' => $senderId,
            'title' => $this->replacePlaceholders($item->title, $placeholders),
            'body' => $this->replacePlaceholders($item->body, $placeholders),
            'userId' => $item->recipient->id
        ]);

        $message->save();
    }
}