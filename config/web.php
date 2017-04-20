<?php

$base = require(__DIR__ . '/base.php');

$config = [
    'id' => 'basic',
    'bootstrap' => ['notifier'],
    'defaultRoute' => 'message/index',
    'components' => [
        'request' => [
            'cookieValidationKey' => '_xRd4NdSmxWBBXgC5X37BN7NYrsCpD2T',
            'enableCsrfValidation' => true,
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
        ],
        'notifier' => [
            'class' => 'app\components\Notifier',
            'placeholders' => [
                'site_name' => 'RGK Group',
                'site_link' => function () {
                    return \yii\helpers\Url::to('/', true);
                }
            ]
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*']
    ];
}

return \yii\helpers\ArrayHelper::merge($base, $config);
