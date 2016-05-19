<?php

namespace app\controllers;

use app\models\Message;
use Yii;
use app\models\MessageSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class MessageController extends Controller
{
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

    public function actionIndex()
    {
        $model = new MessageSearch([
            'userId' => Yii::$app->user->id
        ]);

        return $this->render('index', [
            'dataProvider' => $model->search(Yii::$app->request->get()),
            'searchModel' => $model,
            'returnUrl' => Url::current(['_pjax' => null])
        ]);
    }

    public function actionRead($id, $returnUrl = null) {
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