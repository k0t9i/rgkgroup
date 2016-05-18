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
     * Value can be callable object or string name of attribute
     *
     * @return array
     */
    public function getPlaceholders();
}