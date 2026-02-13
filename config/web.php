<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

return [
    'id' => 'ticketing',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'Europe/Rome',

    'bootstrap' => ['log'],

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'components' => [

        /* ================= DATABASE ================= */
        'db' => $db,

        /* ================= CACHE ================= */
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        /* ================= REQUEST ================= */
        'request' => [
            'cookieValidationKey' => 't01WuOCqJYwM90-YE6WOdya_UuYUqNjO',
        ],

        /* ================= USER ================= */
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' => true,
        ],

        /* ================= ERROR HANDLER ================= */
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /* ================= MAILER (GMAIL SMTP) ================= */
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'useFileTransport' => false,
            'transport' => [
                'dsn' => 'smtp://macagninoriccardo85@gmail.com:atoyngbeugtmesrw@smtp.gmail.com:587?encryption=tls',
            ],
        ],

        /* ================= URL MANAGER ================= */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'site/visualizzato/<codice_ticket>' => 'site/visualizzato',
            ],
        ],

        /* ================= LOG (LEGGERO) ================= */
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
