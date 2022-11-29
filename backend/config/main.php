<?php

use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
               'application\json' => 'yii\web\JsonParser'
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/login/index'],
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['pattern' => '<controller:\w+>/<id:\d+>', 'route' => '<controller>/view'],
                ['pattern' => '<controller:\w+>/<action:\w+>/<id:\d+>', 'route' => '<controller>/<action>'],
                ['pattern' => '<controller:\w+>/<action:\w+>', 'route' => '<controller>/<action>'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/sysinfo'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/login'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/user'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/item'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/categoria'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/verifytoken'],
            ],
        ],
    ],
    'params' => $params,
    'defaultRoute' => 'login/index',
];
