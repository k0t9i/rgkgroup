<?php

namespace app\commands;

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
    }

    public function options($actionID)
    {
        $options = parent::options($actionID);
        $options[] = 'force';
        return $options;
    }
}