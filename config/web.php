<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'timeZone' => 'Europe/Rome',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),

    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'components' => [

        'request' => [
            'cookieValidationKey' => 't01WuOCqJYwM90-YE6WOdya_UuYUqNjO',
        ],

        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/views'
                ],
            ],
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /* -------------- MAILER CORRETTO (SYMFONY MAILER) -------------- */
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'useFileTransport' => false, // invia davvero
            'transport' => [
                'dsn' => 'smtp://macagninoriccardo85@gmail.com:atoyngbeugtmesrw@smtp.gmail.com:587?encryption=tls',
            ],
        ],
        /* ---------------------------------------------------------------- */

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '*'],
    ];
}

return $config;
