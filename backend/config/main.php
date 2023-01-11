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
            'errorAction' => 'error/index',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/site', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/categoria', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/user', 'pluralize' => false],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/item',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET user/{user_id}' => 'itensuser',
                    ],
                    'tokens' => [
                        '{user_id}' => '<user_id:\\d+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/pedidoalocacao', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/grupoitens', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/sysinfo'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/login'],
                // Isto tem de ficar aqui em baixo porque o Yii2 é estúpido
                ['pattern' => '<controller:\w+>/<id:\d+>', 'route' => '<controller>/view'],
                ['pattern' => '<controller:\w+>/<action:\w+>/<id:\d+>', 'route' => '<controller>/<action>'],
                ['pattern' => '<controller:\w+>/<action:\w+>', 'route' => '<controller>/<action>'],
            ],
        ],
    ],
    'params' => $params,
    'defaultRoute' => 'login/index',
];
