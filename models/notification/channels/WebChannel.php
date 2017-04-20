<?php

namespace app\models\notification\channels;

use app\models\Message;
use app\models\notification\Notification;

/**
 * Web notification channel
 *
 * @package app\models\notification\channels
 */
class WebChannel extends Channel
{
    /**
     * @inheritdoc
     */
    protected function doProcess(Notification $item, array $placeholders = [])
    {
        $senderId = $item->sender ? $item->sender->id : null;

        $message = new Message([
            'senderId' => $senderId,
            'title' => $item->title,
            'body' => $item->body,
            'userId' => $item->recipient->id
        ]);

        $message->save();
    }
}
