<?php

namespace app\actions;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class UpdateAction
 *
 * @package app\actions
 */
class UpdateAction extends Action
{
    /**
     * Action main view
     *
     * @var string
     */
    public $view = 'update';

    /**
     * Route where redirected if pressed apply button
     *
     * @var string|array
     */
    public $applyRoute = 'update';

    /**
     * Post param which shows that is being pressed cancel button
     *
     * @var string
     */
    public $cancelParam = 'cancel';

    /**
     * Post param which shows that is being pressed apply button
     *
     * @var string
     */
    public $applyParam = 'apply';

    /**
     * Run action
     *
     * @param integer $id Id of updated model
     * @param string $returnUrl
     * @return array|string
     */
    public function run($id, $returnUrl = null)
    {
        return $this->processForm($id, $returnUrl);
    }


    /**
     * Process action form and save model
     *
     * @param integer $id
     * @param string $returnUrl
     * @return string|array
     * @throws \yii\web\NotFoundHttpException
     */
    protected function processForm($id = null, $returnUrl = null)
    {
        if (Yii::$app->request->post($this->cancelParam)) {
            return $this->goBack($returnUrl);
        }
        $model = $this->getModel($id);
        if ($validate = $this->performAjaxValidation($model)) {
            return $validate;
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if (Yii::$app->request->post($this->applyParam)) {
                    return $this->controller->redirect(
                        [$this->applyRoute, 'id' => $model->id, 'returnUrl' => $returnUrl]
                    );
                } else {
                    return $this->goBack($returnUrl);
                }
            }
        }
        return $this->controller->render($this->view, [
            'model' => $model
        ]);
    }

    /**
     * Validate model via ajax
     *
     * @param ActiveRecord $model
     * @return array|null
     */
    protected function performAjaxValidation(ActiveRecord $model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return null;
    }
}
