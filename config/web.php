<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'listener'],
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
		'view' => [
			'theme' => [
				'pathMap' => [
					'@dektrium/user/views' => '@app/views/user'
				],
			],
		],
		'listener' => [
			'class' => 'app\components\Listener',
		],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dcd5FtHuuPFRN_ChE2-Xbag2117-k8_A',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
/*        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
 */       'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
		'authManager' => [
			'class' => 'dektrium\rbac\components\DbManager',
		],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
	'modules' => [
		'user' => [
			'class' => 'dektrium\user\Module',
//			'admins' => ['mega'],
			'adminPermission' => 'adminPermission',
			'modelMap' => [
				'User' => [
					'class' => 'app\models\User',
					'on ' . dektrium\user\models\User::AFTER_CREATE => ['app\models\User', 'setDefaultRole'],
					'on ' . dektrium\user\models\User::AFTER_REGISTER => ['app\models\User', 'setDefaultRole'],
				],
			],
			'controllerMap' => [
				'settings' => 'app\controllers\user\SettingsController',
				'admin' => 'app\controllers\user\AdminController',
			],
		],
		'rbac' => [
			'class' => 'dektrium\rbac\Module',
		],
		'notifications' => [
			'class' => 'app\modules\notifications\Module',
			'notificationClass' => 'app\models\Notification',
			'userId' => function() {
				return \Yii::$app->user->identity->getId();
				}
			],
		],
    'params' => $params,
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
    ];
}

return $config;
