<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Initialize RBAC system
 *
 * @package app\commands
 */
class RbacController extends Controller
{
    public $force = false;

    /**
     * Create roles and permissions
     */
    public function actionIndex()
    {
        $manager = Yii::$app->authManager;

        if ($this->force) {
            $manager->removeAll();
        }

        $this->stdout("Init rbac system\n\n", Console::FG_YELLOW);
        $articleViewList = $manager->createPermission('article.viewList');
        $articleViewList->description = 'View articles list';
        $manager->add($articleViewList);

        $articleCreate = $manager->createPermission('article.create');
        $articleCreate->description = 'Create article';
        $manager->add($articleCreate);

        $articleUpdate = $manager->createPermission('article.update');
        $articleUpdate->description = 'Update article';
        $manager->add($articleUpdate);

        $articleDelete = $manager->createPermission('article.delete');
        $articleDelete->description = 'Delete article';
        $manager->add($articleDelete);

        $notificationViewList = $manager->createPermission('notification.viewList');
        $notificationViewList->description = 'View notifications list';
        $manager->add($notificationViewList);

        $notificationCreate = $manager->createPermission('notification.create');
        $notificationCreate->description = 'Create notification';
        $manager->add($notificationCreate);

        $notificationUpdate = $manager->createPermission('notification.update');
        $notificationUpdate->description = 'Update notification';
        $manager->add($notificationUpdate);

        $notificationDelete = $manager->createPermission('notification.delete');
        $notificationDelete->description = 'Delete notification';
        $manager->add($notificationDelete);

        $admin = $manager->createRole('admin');
        $manager->add($admin);
        $manager->addChild($admin, $articleViewList);
        $manager->addChild($admin, $articleCreate);
        $manager->addChild($admin, $articleUpdate);
        $manager->addChild($admin, $articleDelete);
        $manager->addChild($admin, $notificationViewList);
        $manager->addChild($admin, $notificationCreate);
        $manager->addChild($admin, $notificationUpdate);
        $manager->addChild($admin, $notificationDelete);

        $this->stdout("Rbac system successfully initialized\n", Console::FG_GREEN);
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
