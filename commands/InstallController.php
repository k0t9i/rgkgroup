<?php

namespace app\commands;

use app\models\Article;
use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\controllers\MigrateController;

class InstallController extends Controller
{
    public $force = false;

    public function actionIndex()
    {
        MigrateController::BASE_MIGRATION;
        if ($this->force) {
            Yii::$app->runAction('migrate/down', [
                'all',
                'interactive' => false
            ]);
        }
        Yii::$app->runAction('migrate', [
            'interactive' => false
        ]);
        Yii::$app->runAction('rbac', [
            'interactive' => false,
            'force' => $this->force
        ]);

        $user = new User([
            'username' => 'admin',
            'passwordHash' => Yii::$app->security->generatePasswordHash('admin'),
            'lastname' => 'Test',
            'firstname' => 'Test',
            'email' => 'k0t9i@yandex.ru'
        ]);
        $user->save();

        Yii::$app->authManager->assign(Yii::$app->authManager->getRole('admin'), $user->id);

        (new Article([
            'title' => 'test',
            'body' => 'huest'
        ]))->save();
    }

    public function options($actionID)
    {
        $options = parent::options($actionID);
        $options[] = 'force';
        return $options;
    }
}