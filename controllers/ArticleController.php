<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;

class ArticleController extends Controller
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
                        'roles' => ['article.viewList'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['article.create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['article.update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['article.create'],
                    ]
                ],
            ]
        ];
    }

    public function getModelName()
    {
        return Article::className();
    }

    public function actionIndex()
    {
        $model = new ArticleSearch();

        return $this->render('index', [
            'dataProvider' => $model->search(Yii::$app->request->get()),
            'searchModel' => $model,
            'returnUrl' => Url::current(['_pjax' => null])
        ]);
    }

    public function actionCreate($returnUrl = null)
    {
        return $this->processForm(null, $returnUrl);
    }

    public function actionUpdate($id, $returnUrl = null)
    {
        return $this->processForm($id, $returnUrl);
    }

    public function actionDelete($id, $returnUrl = null)
    {
        $this->getModel($id)->delete();

        if ($returnUrl) {
            return $this->redirect($returnUrl);
        }
        return $this->redirect(['index']);
    }
}