<?php

namespace app\actions;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UpdateAction extends Action
{
    public $view = 'update';
    public $applyView = 'update';
    public $cancelParam = 'cancel';
    public $applyParam = 'apply';

    public function run($id, $returnUrl = null)
    {
        return $this->processForm($id, $returnUrl);
    }

    protected function processForm($id = null, $returnUrl = null)
    {
        if (Yii::$app->request->post($this->cancelParam)) {
            return $this->goBack($returnUrl);
        }
        $model = $this->getModel($id);
        if ($validate = $this->performAjaxValidation($model)){
            return $validate;
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if (Yii::$app->request->post($this->applyParam)) {
                    return $this->controller->redirect([$this->applyView, 'id' => $model->id, 'returnUrl' => $returnUrl]);
                } else {
                    return $this->goBack($returnUrl);
                }
            }
        }
        return $this->controller->render($this->view, [
            'model' => $model
        ]);
    }

    protected function performAjaxValidation(ActiveRecord $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return null;
    }
}