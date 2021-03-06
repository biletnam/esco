<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
    require __DIR__ . '/../../common/config/esco.php',
    require __DIR__ . '/../../common/config/esco-local.php',
    require __DIR__ . '/../../common/config/backend-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'class' => 'common\exceptions\RestException',
            'errorAction' => 'site/error',
        ],
        'request' => [
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'user',
                        'domain',
                        'unix-user'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        'site',
                    ],
                    'extraPatterns' => [
                        'POST download-archive' => 'download-archive',
                        'POST download-db' => 'download-db',
                        'POST import-archive' => 'import-archive',
                        'POST import-db' => 'import-db',
                        'POST create-dirs' => 'create-dirs',
                        'POST remove-dirs' => 'remove-dirs'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        'nginx',
                        'fpm',
                    ],
                    'extraPatterns' => [
                        'POST create-config' => 'create-config',
                        'POST remove-config' => 'remove-config',
                        'POST rebuild-config' => 'rebuild-config',
                        'POST restart-service' => 'reload',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        'unix-user'
                    ],
                    'extraPatterns' => [
                        'POST create-config' => 'create',
                        'POST remove-config' => 'db-user-create'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        'backup',
                    ],
                    'extraPatterns' => [
                        'POST create' => 'create',
                        'POST restore' => 'restore'
                    ],
                ],
            ],
        ],
    ],
    'on beforeRequest' => function () {
        $handler = new \common\exceptions\RestException();
        \Yii::$app->set('errorHandler', $handler);
        //необходимо вызывать register, это обязательный метод для регистрации обработчика
        $handler->register();
    },
    'params' => $params,
];
