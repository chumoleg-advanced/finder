<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-frontend',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', 'thumbnail'],
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => [
                'yandex'    => [
                    'class' => 'yii\authclient\clients\YandexOpenId'
                ],
                'google'    => [
                    'class' => 'yii\authclient\clients\GoogleOpenId'
                ],
                'facebook'  => [
                    'class'        => 'yii\authclient\clients\Facebook',
                    'clientId'     => 'facebook_client_id',
                    'clientSecret' => 'facebook_client_secret',
                ],
                'vkontakte' => [
                    'class'        => 'yii\authclient\clients\VKontakte',
                    'clientId'     => 'vkontakte_client_id',
                    'clientSecret' => 'vkontakte_client_secret',
                ],
                'linkedin'  => [
                    'class'        => 'yii\authclient\clients\LinkedIn',
                    'clientId'     => 'linkedin_client_id',
                    'clientSecret' => 'linkedin_client_secret',
                ],
            ],
        ],
        'urlManager'           => [
            'rules' => [
                '<module:\w+><controller:\w+>/<action:\w+>/<id:\d+>' => '<module><controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'             => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                      => '<controller>/<action>',
            ]
        ],
        'user'                 => [
            'identityClass'   => 'common\models\user\User',
            'enableAutoLogin' => true,
        ],
        'log'                  => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler'         => [
            'errorAction' => 'site/error',
        ],
    ],
    'params'              => $params,
];
