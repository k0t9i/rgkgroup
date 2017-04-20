<?php

namespace app\controllers;

use app\actions\CreateAction;
use app\actions\DeleteAction;
use app\actions\UpdateAction;
use app\models\notification\Notification;
use app\models\NotificationSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Class NotificationController
 * Controller for Notification model
 *
 * @package app\controllers
 */
class NotificationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['notification.viewList'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['notification.create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['notification.update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['notification.create'],
                    ],
                    [
                        'actions' => ['event-placeholders'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'create' => [
                'class' => CreateAction::className(),
                'modelName' => Notification::className()
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelName' => Notification::className()
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelName' => Notification::className()
            ]
        ];
    }

    /**
     * Show notification's list
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new NotificationSearch();

        return $this->render('index', [
            'dataProvider' => $model->search(Yii::$app->request->get()),
            'searchModel' => $model,
            'returnUrl' => Url::current(['_pjax' => null])
        ]);
    }

    /**
     * Render list of notification' placeholders
     *
     * @param integer $id
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionEventPlaceholders($id)
    {
        if (!Yii::$app->request->isAjax || !YII_ENV_DEV) {
            throw new BadRequestHttpException();
        }

        $notification = new Notification([
            'eventId' => $id
        ]);

        return $this->renderPartial('_placeholders', [
            'items' => Yii::$app->notifier->getPlaceholdersKeys($notification)
        ]);
    }
}
