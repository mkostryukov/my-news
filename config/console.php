<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'notificationTransportCollection' => [
            'class' => 'app\modules\notifications\Collection',
            'transports' => [
                'mail' => [
                    'class' => 'app\modules\notifications\transports\Mail',
                ],
                'browser' => [
                    'class' => 'app\modules\notifications\transports\Browser',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
		'authManager' => [
			'class' => 'dektrium\rbac\components\DbManager',
		],
    ],
	'modules' => [
		'user' => [
			'class' => 'dektrium\user\Module',
            'modelMap' => [
                'User' => [
                    'class' => 'app\models\User',
                    'on ' . dektrium\user\models\User::AFTER_CREATE => ['app\models\User', 'setDefaultRole'],
                    'on ' . dektrium\user\models\User::AFTER_REGISTER => ['app\models\User', 'setDefaultRole'],
                ],
            ],
		],
        'notifications' => [
            'class' => 'app\modules\notifications\Module',
            'notificationClass' => 'app\models\Notification',
        ],
	],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
