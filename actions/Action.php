<?php

namespace app\actions;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class Action extends \yii\base\Action
{
    public $modelName;
    public $defaultReturnUrl = ['index'];

    public function init()
    {
        if (!$this->modelName) {
            throw new InvalidConfigException('Parameter modelName is required');
        }
    }

    protected function goBack($returnUrl)
    {
        if ($returnUrl) {
            return $this->controller->redirect($returnUrl);
        }
        return $this->controller->redirect($this->defaultReturnUrl);
    }

    /**
     * @param $id
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