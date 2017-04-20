<?php

namespace app\models\notification\channels;

use Yii;
use app\models\notification\Notification;

/**
 * Email notification channel
 *
 * @package app\models\notification\channels
 */
class MailChannel extends Channel
{
    /**
     * @inheritdoc
     */
    protected function doProcess(Notification $item, array $placeholders = [])
    {
        $recipient = $item->recipient;

        Yii::$app->mailer
            ->compose(['html' => 'notification/html'], [
                'body' => $item->body
            ])
            ->setTo([
                $recipient->email => $recipient->lastname . ' ' . $recipient->firstname
            ])
            ->setFrom(Yii::$app->params['fromEmail'])
            ->setSubject($item->title)
            ->send();
    }
}
