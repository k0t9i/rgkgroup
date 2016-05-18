<?php

namespace app\models\notification\channels;

use app\models\Message;
use app\models\notification\Notification;
use app\models\User;

class WebChannel extends Channel
{

    protected function doProcess(Notification $item, array $placeholders = [])
    {
        $recipients = [$item->recipient];
        if (!$item->recipient) {
            $recipients = User::find()->all();
        }

        $senderId = $item->sender ? $item->sender->id : null;
        $message = new Message([
            'senderId' => $senderId,
            'title' => $this->replacePlaceholders($item->title, $placeholders),
            'body' => $this->replacePlaceholders($item->body, $placeholders),
        ]);

        foreach ($recipients as $recipient) {
            $message->id = null;
            $message->isNewRecord = true;
            $message->userId = $recipient->id;

            $message->save();
        }
    }
}