<?php

namespace app\models\notification;

use yii\base\InvalidConfigException;

/**
 * Class NotificationEvent
 *
 * @property NotificationModelInterface $model
 * @package app\models\notification
 */
class NotificationEvent extends \yii\base\Event
{
    /**
     * @var NotificationModelInterface
     */
    private $model_;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->model) {
            throw new InvalidConfigException('Parameter model is required');
        }
    }

    /**
     * Get event's model
     *
     * @return NotificationModelInterface
     */
    public function getModel()
    {
        return $this->model_;
    }

    /**
     * Set event's model
     *
     * @param NotificationModelInterface $value
     */
    public function setModel($value)
    {
        $this->model_ = $value;
    }
}
