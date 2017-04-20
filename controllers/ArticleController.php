<?php

namespace app\controllers;

use app\actions\CreateAction;
use app\actions\DeleteAction;
use app\actions\UpdateAction;
use app\models\Article;
use app\models\ArticleSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ArticleController
 * Controller for Article model
 *
 * @package app\controllers
 */
class ArticleController extends Controller
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
                    ],
                    [
                        'actions' => ['view'],
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
                'modelName' => Article::className()
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelName' => Article::className()
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelName' => Article::className()
            ]
        ];
    }

    /**
     * Show article's list
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new ArticleSearch();

        return $this->render('index', [
            'dataProvider' => $model->search(Yii::$app->request->get()),
            'searchModel' => $model,
            'returnUrl' => Url::current(['_pjax' => null])
        ]);
    }

    /**
     * Show one article
     *
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Article::findOne((int) $id);
        if (!$model) {
            throw new NotFoundHttpException('Article not found');
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }
}
