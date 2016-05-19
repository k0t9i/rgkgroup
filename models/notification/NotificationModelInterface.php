<?php

namespace app\models\notification;

interface NotificationModelInterface
{
    /**
     * Should return array in following format:
     * [
     *     placeholder => value
     * ]
     *
     * Value can be callable object or plain values
     *
     * @return array
     */
    public function getPlaceholders();
}