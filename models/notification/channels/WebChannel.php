<?php

namespace app\models\notification\channels;

use app\models\notification\Notification;

class WebChannel extends Channel
{

    protected function doProcess(Notification $item, array $placeholders = [])
    {
        var_dump($this->replacePlaceholders($item->title, $placeholders));
        die();
    }
}