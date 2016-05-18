<?php

namespace app\controllers;

use Yii;
use app\models\MessageSearch;
use yii\filters\AccessControl;
use yii\web\Controller;

class MessageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
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
            'searchModel' => $model
        ]);
    }
}