<?php

namespace app\models\notification;
use yii\base\InvalidConfigException;

/**
 * @property NotificationModelInterface $model
 */
class NotificationEvent extends \yii\base\Event
{
    /**
     * @var NotificationModelInterface
     */
    private $_model;

    public function init()
    {
        if (!$this->model) {
            throw new InvalidConfigException('Parameter model is required');
        }
    }

    /**
     * @return NotificationModelInterface
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param NotificationModelInterface $value
     */
    public function setModel($value)
    {
        $this->_model = $value;
    }
}