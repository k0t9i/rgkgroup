<?php

namespace app\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

abstract class Controller extends \yii\web\Controller
{
    abstract public function getModelName();

    protected function processForm($id = null, $returnUrl = null)
    {
        if (!is_null(Yii::$app->request->post('cancel'))) {
            if ($returnUrl) {
                return $this->redirect($returnUrl);
            }
            return $this->redirect(['index']);
        }
        $model = $this->getModel($id);
        if ($validate = $this->performAjaxValidation($model)){
            return $validate;
        }
        if ($model->load(Yii::$app->request->post())) {
            $isNewRecord = $model->isNewRecord;
            if ($model->save()) {
                if (Yii::$app->request->post('apply', null) !== null) {
                    if ($isNewRecord) {
                        return $this->redirect(['update', 'id' => $model->id, 'returnUrl' => $returnUrl]);
                    }
                    return $this->refresh();
                } else {
                    if ($returnUrl) {
                        return $this->redirect($returnUrl);
                    }
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function getModel($id)
    {
        $modelName = $this->getModelName();
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

    protected function performAjaxValidation(ActiveRecord $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}