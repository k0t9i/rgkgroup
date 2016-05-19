<?php

namespace app\models\notification\channels;

use Yii;
use app\models\notification\Notification;

/**
 * Email notification channel
 */
class MailChannel extends Channel
{

    protected function doProcess(Notification $item, array $placeholders = [])
    {
        $recipient = $item->recipient;

        Yii::$app->mailer
            ->compose(['html' => 'notification/html'], [
                'body' => $this->replacePlaceholders($item->body, $placeholders)
            ])
            ->setTo([
                $recipient->email => $recipient->lastname . ' ' . $recipient->firstname
            ])
            ->setFrom(Yii::$app->params['fromEmail'])
            ->setSubject($this->replacePlaceholders($item->title, $placeholders))
            ->send();
    }
}