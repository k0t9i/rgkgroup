<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\controllers\MigrateController;

/**
 * Class InstallController
 * Initial installation of the application
 * The following steps will be performed:
 *  - Migrate db
 *  - Create RBAC permissions and roles
 *  - Create two test users: admin/admin and user/user
 *
 * @package app\commands
 */
class InstallController extends Controller
{
    public $force = false;

    /**
     * Perform install steps
     */
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
            'lastname' => 'Ivanov',
            'firstname' => 'Ivan',
            'email' => 'k0t9i@yandex.ru'
        ]);
        $user->save();
        Yii::$app->authManager->assign(Yii::$app->authManager->getRole('admin'), $user->id);

        $user = new User([
            'username' => 'user',
            'passwordHash' => Yii::$app->security->generatePasswordHash('user'),
            'lastname' => 'Petrov',
            'firstname' => 'Petr',
            'email' => 'k0t9i@ya.ru'
        ]);
        $user->save();
    }

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        $options = parent::options($actionID);
        $options[] = 'force';
        return $options;
    }
}
