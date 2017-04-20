<?php

namespace app\controllers;

use app\models\Message;
use Yii;
use app\models\MessageSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class MessageController
 * Controller for Message model
 *
 * @package app\controllers
 */
class MessageController extends Controller
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Show message's list
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new MessageSearch([
            'userId' => Yii::$app->user->id
        ]);

        return $this->render('index', [
            'dataProvider' => $model->search(),
            'searchModel' => $model,
            'returnUrl' => Url::current(['_pjax' => null])
        ]);
    }

    /**
     * Mark message as read
     *
     * @param integer $id
     * @param null|string $returnUrl
     * @throws NotFoundHttpException
     */
    public function actionRead($id, $returnUrl = null)
    {
        $model = Message::findOne((int) $id);
        if (!$model) {
            throw new NotFoundHttpException('Message not found');
        }

        $model->touch('readedAt');
        $model->save();

        if ($returnUrl) {
            $this->redirect($returnUrl);
        } else {
            $this->redirect(['index']);
        }
    }
}
