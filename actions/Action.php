<?php

namespace app\actions;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Base action class
 *
 * @package app\actions
 */
abstract class Action extends \yii\base\Action
{
    /**
     * Name of action model
     *
     * @var string
     */
    public $modelName;

    /**
     * Redirect after action to this url if returnUrl is undefined
     *
     * @var array
     */
    public $defaultReturnUrl = ['index'];

    /**
     * @inheritdoc
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->modelName) {
            throw new InvalidConfigException('Parameter modelName is required');
        }
    }

    /**
     * Return to $returnUrl if not empty
     *
     * @param string $returnUrl
     * @return \yii\web\Response
     */
    protected function goBack($returnUrl)
    {
        if ($returnUrl) {
            return $this->controller->redirect($returnUrl);
        }
        return $this->controller->redirect($this->defaultReturnUrl);
    }

    /**
     * Find or create action model
     *
     * @param integer $id
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function getModel($id)
    {
        $modelName = $this->modelName;
        if (!is_null($id)) {
            $model = $modelName::findOne($id);
            if (!$model) {
                throw new NotFoundHttpException();
            }
        } else {
            $model = new $modelName();
        }
        return $model;
    }
}
