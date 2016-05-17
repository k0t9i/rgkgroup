<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$base = require(__DIR__ . '/base.php');

$config = [
    'id' => 'basic-console',
    'controllerNamespace' => 'app\commands',
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

return \yii\helpers\ArrayHelper::merge($base, $config);
