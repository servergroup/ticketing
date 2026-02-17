<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'ticketing',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'Europe/Rome',

    'bootstrap' => ['log'],

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'components' => [

        'db' => $db,

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'request' => [
            'cookieValidationKey' => 't01WuOCqJYwM90-YE6WOdya_UuYUqNjO',
        ],

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' => true,
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'useFileTransport' => false,
            'transport' => [
                'dsn' => 'smtp://macagninoriccardo85@gmail.com:atoyngbeugtmesrw@smtp.gmail.com:587?encryption=tls',
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'site/visualizzato/<codice_ticket>' => 'site/visualizzato',
            ],
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],

    'params' => $params,
];

/* ================= GII (solo in ambiente DEV) ================= */
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'], // permette accesso da ovunque
    ];
}


return $config;
