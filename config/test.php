<?php

$web = require(__DIR__ . '/web.php');

$config = [
    'id' => 'basic-test',
    'components' => [
        'db' => require(__DIR__ . '/test_db.php'),
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
];

return \yii\helpers\ArrayHelper::merge($web, $config);
