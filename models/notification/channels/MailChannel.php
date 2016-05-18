<?php

namespace app\models\notification\channels;

use app\models\notification\Notification;

class MailChannel extends Channel
{

    protected function doProcess(Notification $item, array $placeholders = [])
    {
        // TODO: Implement doProcess() method.
    }
}