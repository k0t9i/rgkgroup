<?php

$base = require(__DIR__ . '/base.php');

$config = [
    'id' => 'basic',
    'components' => [
        'defaultRoute' => 'message/index',
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_xRd4NdSmxWBBXgC5X37BN7NYrsCpD2T',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => 'default/login'
        ],
        'errorHandler' => [
            'errorAction' => 'default/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '192.168.0.*']
    ];
}

return \yii\helpers\ArrayHelper::merge($base, $config);
